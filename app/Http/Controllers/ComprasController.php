<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\DetalleCompra;
use Illuminate\Support\Facades\DB;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $estado = $request->input('estado');
        $fecha = $request->input('fecha');

        $compras = Compra::query()
            ->when($buscar, function ($query) use ($buscar) {
                $query->whereHas('proveedor', function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%");
                });
            })
            ->when($estado, function ($query) use ($estado) {
                $query->where('estado', $estado);
            })
            ->when($fecha, function ($query) use ($fecha) {
                $query->where('fecha', $fecha);
            })
            ->orderBy('idCompras', 'desc')
            ->paginate(6)
            ->withQueryString();

        if ($request->ajax()) {
            return view('compras.partials.tabla', compact('compras'))->render();
        }
        return view('compras.index', compact('compras', 'buscar', 'estado', 'fecha'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::orderBy('idProveedor')->get();
        $productos = Producto::select(
            'idProducto',
            'nombre',
            'unidadMedida'
        )->orderBy('idProducto')->get();
        return view('compras.create', compact('proveedores', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validarCompra($request);

        DB::transaction(function () use ($request) {

            $compra = Compra::create([
                'idProveedor' => $request->idProveedor,
                'fecha' => $request->fecha,
                'monto' => 0,
                'estado' => $request->estado
            ]);

            $montoTotal = $this->guardarDetalles(
                $request,
                $compra
            );

            $compra->update([
                'monto' => $montoTotal
            ]);
        });

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('compras.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('compras.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    private function validarCompra(Request $request)
    {
        $request->validate(
            [
                'idProveedor' => 'required',
                'fecha' => 'required|date',
                'estado' => 'required',

                'idProducto' => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (collect($value)->filter()->isEmpty()) {
                            $fail('Debe agregar al menos un producto.');
                        }
                    }
                ],

                'idProducto.*' => 'exists:productos,idProducto',

                'cantidad' => 'required|array|min:1',
                'cantidad.*' => 'required|integer|min:1',

                'costoTotal' => 'required|array|min:1',
                'costoTotal.*' => 'required|numeric|gt:0'
            ],
            [
                'idProveedor.required' => 'Debe seleccionar un proveedor.',
                'fecha.required' => 'La fecha es obligatoria.',
                'estado.required' => 'Debe seleccionar un estado.',
                'idProducto.required' => 'Debe agregar al menos un producto.',
                'costoTotal.*.gt' => 'El costo total debe ser mayor que cero.'
            ]
        );
    }

    private function guardarDetalles(Request $request, Compra $compra)
    {
        $montoTotal = 0;

        foreach ($request->idProducto as $i => $idProducto) {

            $cantidad = (int) $request->cantidad[$i];
            $costoTotal = (float) $request->costoTotal[$i];

            DetalleCompra::create([
                'idCompras' => $compra->idCompras,
                'idProducto' => $idProducto,
                'cantidad' => $cantidad,
                'costoTotal' => $costoTotal,
                'fechaVencimiento' => $request->fechaVencimiento[$i] ?? null
            ]);

            $this->actualizarStock($idProducto, $cantidad);

            $montoTotal += $costoTotal;
        }

        if ($request->has('aplicarItbis')) {
            $montoTotal *= 1.18;
        }

        return round($montoTotal, 2);
    }

    private function actualizarStock(int $idProducto, int $cantidad)
    {
        $producto = Producto::findOrFail($idProducto);
        $producto->stockActual += $cantidad;
        $producto->save();
    }
}
