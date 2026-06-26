<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $porPagina = $request->porPagina ?? 10;

        $consultas = Consulta::with(['paciente.persona', 'odontologo.persona'])
            ->when($buscar, function ($query) use ($buscar) {
                $query->whereHas('paciente.persona', function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('fecha', 'desc')
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view('consultas.partials.tabla', compact('consultas', 'porPagina'))->render();
        }

        return view('consultas.index', compact('consultas', 'porPagina'));

    }

    public function create()
    {
        return view('consultas.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('consultas.index');
    }
}