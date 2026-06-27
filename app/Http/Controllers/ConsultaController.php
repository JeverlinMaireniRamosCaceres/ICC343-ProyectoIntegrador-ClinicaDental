<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Odontologo;
use App\Models\Paciente;
use App\Models\Procedimiento;
use Illuminate\Support\Facades\Auth;

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

        $odontologo = Odontologo::with('persona')
            ->where('idPersona', Auth::user()->idPersona)
            ->firstOrFail();

        $procedimientos = Procedimiento::orderBy('nombre')->get();

        return view('consultas.create', compact('odontologo', 'procedimientos'));

    }

    public function store(Request $request)
    {
        return redirect()->route('consultas.index');
    }

    public function buscarOdontologos(Request $request)
    {
        $texto = $request->texto;

        $odontologos = Odontologo::with('persona')
            ->whereHas('persona', function ($q) use ($texto) {

                $q->where('nombre', 'like', "%{$texto}%")
                    ->orWhere('apellido', 'like', "%{$texto}%");

            })
            ->limit(10)
            ->get();

        return response()->json($odontologos);
    }

    public function buscarPacientes(Request $request)
    {

        $texto = $request->texto;

        $pacientes = Paciente::with('persona')
            ->join('personas', 'personas.idPersona', '=', 'pacientes.idPersona')
            ->where(function ($q) use ($texto) {
                $q->where('personas.nombre', 'like', "%{$texto}%")
                    ->orWhere('personas.apellido', 'like', "%{$texto}%");
            })
            ->select('pacientes.*')
            ->limit(10)
            ->get();

        return response()->json($pacientes);

    }

    public function alergiasPaciente($id)
    {
        $paciente = Paciente::with('alergias')->findOrFail($id);
        return response()->json([
            'alergias' => $paciente->alergias,
            'antecedentes' => $paciente->antecedentes,
        ]);
    }

}