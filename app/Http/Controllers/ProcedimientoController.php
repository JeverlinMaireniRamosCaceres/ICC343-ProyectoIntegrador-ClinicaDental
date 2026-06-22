<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedimiento;
use App\Models\Producto;
use App\Models\ProductoProcedimiento;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProcedimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $procedimientos = Procedimiento::when($buscar, function ($query, $buscar) {
            $query->where('nombre', 'like', "%{$buscar}%");
        })
            ->orderBy('idProcedimiento')
            ->paginate(6)
            ->withQueryString();

        if ($request->ajax()) {
            return view('procedimientos.partials.tabla', compact('procedimientos'));
        }

        return view('procedimientos.index', compact('procedimientos'));
    }

    public function show($id)
    {
        $procedimiento = Procedimiento::with('productos.producto')->findOrFail($id);

        return view('procedimientos.show', compact('procedimiento'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::select('idProducto', 'nombre', 'unidadMedida')
            ->orderBy('idProducto')
            ->get();

        return view('procedimientos.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validarProcedimiento($request);

        DB::transaction(function () use ($request, $data) {
            
            $procedimiento = Procedimiento::create([
                'nombre' => $data['nombre'],
                'precio' => $data['precio']
            ]);

            $this->guardarProductos($request, $procedimiento);
        });

        return redirect()
            ->route('procedimientos.index')
            ->with('success', 'Procedimiento creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $procedimiento = Procedimiento::with('productos.producto')->findOrFail($id);
        
        $productos = Producto::select('idProducto', 'nombre', 'unidadMedida')
            ->orderBy('idProducto')
            ->get();

        return view('procedimientos.edit', compact('procedimiento', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $procedimiento = Procedimiento::findOrFail($id);
        $data = $this->validarProcedimiento($request, $procedimiento->idProcedimiento);

        DB::transaction(function () use ($request, $data, $procedimiento) {
            
            $procedimiento->update([
                'nombre' => $data['nombre'],
                'precio' => $data['precio']
            ]);

            ProductoProcedimiento::where('idProcedimiento', $procedimiento->idProcedimiento)->delete();

            $this->guardarProductos($request, $procedimiento);
        });

        return redirect()
            ->route('procedimientos.index')
            ->with('success', 'Procedimiento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $procedimiento = Procedimiento::findOrFail($id);

        $estaVinculadoAProducto = ProductoProcedimiento::where('idProcedimiento', $id)
            ->whereHas('producto')
            ->exists();

        if ($estaVinculadoAProducto) {
            return redirect()
                ->route('procedimientos.index')
                ->with('error', "No se puede eliminar el procedimiento '{$procedimiento->nombre}' porque está vinculado a uno o más productos de consumo.");
        }

        $procedimiento->delete();

        return redirect()
            ->route('procedimientos.index')
            ->with('success', 'Procedimiento eliminado correctamente');
    }

    private function guardarProductos(Request $request, Procedimiento $procedimiento)
    {
        if ($request->has('idProducto')) {
            foreach ($request->idProducto as $i => $idProducto) {
                if (!empty($idProducto)) {
                    ProductoProcedimiento::create([
                        'idProcedimiento' => $procedimiento->idProcedimiento,
                        'idProducto' => $idProducto,
                        'cantidad' => (int) $request->cantidad[$i]
                    ]);
                }
            }
        }
    }

    private function validarProcedimiento(Request $request, ?int $idProcedimiento = null): array
    {
        return $request->validate(
            [
                'nombre' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('procedimientos', 'nombre')
                        ->ignore($idProcedimiento, 'idProcedimiento')
                ],
                'precio' => 'required|numeric|gt:0',
                
                'idProducto' => 'nullable|array',
                'idProducto.*' => 'exists:productos,idProducto',
                'cantidad' => 'required_with:idProducto|array',
                'cantidad.*' => 'required|integer|min:1'
            ],
            [
                'nombre.required' => 'El nombre del procedimiento es obligatorio.',
                'nombre.unique' => 'Ya existe un procedimiento con este nombre.',
                'nombre.max' => 'El nombre del procedimiento no puede exceder los 100 caracteres.',
                'precio.required' => 'El precio es obligatorio.',
                'precio.numeric' => 'El precio debe ser un valor numérico.',
                'precio.gt' => 'El precio debe ser mayor que 0.',
                'cantidad.*.min' => 'La cantidad debe ser al menos 1.'
            ]
        );
    }
}