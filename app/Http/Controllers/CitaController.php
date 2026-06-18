<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Odontologo;

class CitaController extends Controller
{

    public function index()
    {
        $odontologos = Odontologo::with('persona')->get();

        // citas agrupadas por fecha para el calendario
        $citas = Cita::with('odontologo.persona')
            ->whereYear('fecha', now()->year)
            ->whereMonth('fecha', now()->month)
            ->get()
            ->groupBy('fecha');

        return view('citas.index', compact('odontologos', 'citas'));

    }

    public function create()
    {
        return view('citas.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'idOdontologo' => 'required|exists:odontologos,idOdontologo',
            'fecha' => 'required|date',
            'hora' => 'required',
            'nombrePersona' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100',
        ]);

        Cita::create([
            'idUsuarioRegistro' => auth()->user()->idUsuario,
            'idOdontologo' => $request->idOdontologo,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'nombrePersona' => $request->nombrePersona,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'estado' => 'Pendiente',
        ]);

        return redirect()->route('citas.index')
            ->with('success', 'Cita registrada correctamente.');


    }

    public function show($id)
    {
        $cita = Cita::with('odontologo.persona')->findOrFail($id);
        return view('citas.show', compact('cita'));
    }

    public function citasPorFecha(Request $request)
    {
        $fecha = $request->get('fecha');

        $citas = Cita::with('odontologo.persona')
            ->where('fecha', $fecha)
            ->orderBy('hora')
            ->get();

        return response()->json($citas);
    }

    public function citasPorMes(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $citas = Cita::with('odontologo.persona')
            ->whereYear('fecha', $year)
            ->whereMonth('fecha', $month)
            ->get()
            ->groupBy('fecha');

        // devolver solo fechas y cantidad de citas por dia
        $resultado = $citas->map(fn($citasDia) => $citasDia->count());

        return response()->json($resultado);
    }



    public function edit($id)
    {
        return view('citas.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('citas.index');
    }

    public function destroy($id)
    {
        return redirect()->route('citas.index');
    }
}