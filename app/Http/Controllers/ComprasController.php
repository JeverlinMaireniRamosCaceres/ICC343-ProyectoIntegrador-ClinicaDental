<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\DetalleCompra;
use App\Models\MovimientoInventario;
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

        $porPagina = (int) $request->input('porPagina', 6);

        if (!in_array($porPagina, [10, 25, 50, 100])) {
            $porPagina = 10;
        }

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
            ->orderBy('fecha', 'desc')
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view('compras.partials.tabla', compact('compras', 'porPagina'))->render();
        }

        return view('compras.index', compact(
            'compras',
            'buscar',
            'estado',
            'fecha',
            'porPagina'
        ));
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
                'estado' => $request->estado,
                'aplicaItbis' => $request->has('aplicarItbis')
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
        $compra = Compra::with([
            'proveedor',
            'detalles.producto'
        ])->findOrFail($id);

        return view('compras.show', compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $compra = Compra::with([
            'proveedor',
            'detalles.producto'
        ])->findOrFail($id);

        $proveedores = Proveedor::orderBy('idProveedor')->get();

        $productos = Producto::select(
            'idProducto',
            'nombre',
            'unidadMedida'
        )->orderBy('idProducto')->get();

        return view(
            'compras.edit',
            compact(
                'compra',
                'proveedores',
                'productos'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validarCompra($request);
        DB::transaction(function () use ($request, $id) {
            $compra = Compra::with('detalles')->findOrFail($id);
            $this->revertirStockYEliminarDetalles($compra);
            $this->actualizarCabeceraCompra($request, $compra);
            $montoTotal = $this->guardarDetalles($request, $compra);
            $compra->update([
                'monto' => $montoTotal
            ]);
        });
        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function anular($id)
    {
        DB::transaction(function () use ($id) {
            $compra = Compra::with('detalles')->findOrFail($id);
            $this->revertirStockCompra($compra);
            $compra->update([
                'estado' => 'Anulada'
            ]);
        });

        return redirect()->route('compras.index')->with('success', 'Compra anulada correctamente.');
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

                        foreach ($value as $idProducto) {

                            if (empty($idProducto)) {

                                $fail('Debe completar o eliminar las filas vacías.');
                                return;
                            }
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

        MovimientoInventario::create([
            'idProducto' => $producto->idProducto,
            'tipo' => 'ENTRADA',
            'cantidad' => $cantidad,
            'motivo' => 'Compra',
        ]);
    }

    private function actualizarCabeceraCompra(Request $request, Compra $compra)
    {
        $compra->update([
            'idProveedor' => $request->idProveedor,
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'aplicaItbis' => $request->has('aplicarItbis')
        ]);
    }

    private function revertirStockYEliminarDetalles(Compra $compra)
    {
        foreach ($compra->detalles as $detalle) {
            $producto = Producto::find($detalle->idProducto);
            if ($producto) {
                $producto->stockActual -= $detalle->cantidad;
                $producto->save();
                MovimientoInventario::create([
                    'idProducto' => $producto->idProducto,
                    'tipo' => 'SALIDA',
                    'cantidad' => $detalle->cantidad,
                    'motivo' => 'Edición de compra',
                ]);
            }
        }
        DetalleCompra::where('idCompras', $compra->idCompras)->delete();
    }

    private function revertirStockCompra(Compra $compra)
    {
        foreach ($compra->detalles as $detalle) {
            $producto = Producto::findOrFail($detalle->idProducto);
            $producto->stockActual -= $detalle->cantidad;
            $producto->save();
            MovimientoInventario::create([
                'idProducto' => $producto->idProducto,
                'tipo' => 'SALIDA',
                'cantidad' => $detalle->cantidad,
                'motivo' => 'Compra anulada',
            ]);
        }
    }

    public function marcarCompraPagada(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);

        if ($compra->estado === 'Anulada') {
            return redirect()->route('compras.index')->with('error', 'No se puede marcar como pagada una compra anulada.');
        }

        $compra->update([
            'estado' => 'Pagada'
        ]);
        return redirect()->route('compras.index')->with('success', 'Compra marcada como pagada correctamente.');
    }
}
