<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = trim($request->buscar);
        $estado = $request->estado;
        $fechaDesde = $request->fecha_desde;
        $fechaHasta = $request->fecha_hasta;
        $porPagina = $request->get('porPagina', 10);

        $facturas = Factura::with([
            'consulta.paciente.persona'
        ])

            ->when($buscar, function ($query) use ($buscar) {

                $numeroFactura = preg_replace('/\D/', '', $buscar);

                $query->where(function ($q) use ($buscar, $numeroFactura) {

                    if ($numeroFactura !== '') {
                        $q->orWhere('idFactura', (int) $numeroFactura);
                    }

                    $q->orWhereHas('consulta.paciente.persona', function ($persona) use ($buscar) {
                        $persona->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    });
                });
            })

            ->when($estado, function ($query) use ($estado) {
                $query->where('estado', ucfirst($estado));
            })

            ->when($fechaDesde, function ($query) use ($fechaDesde) {
                $query->whereDate('created_at', '>=', $fechaDesde);
            })

            ->when($fechaHasta, function ($query) use ($fechaHasta) {
                $query->whereDate('created_at', '<=', $fechaHasta);
            })

            ->latest()
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view('facturacion.partials.tabla', compact('facturas', 'porPagina'))->render();
        }

        return view('facturacion.index', compact('facturas', 'porPagina'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facturacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('facturacion.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
