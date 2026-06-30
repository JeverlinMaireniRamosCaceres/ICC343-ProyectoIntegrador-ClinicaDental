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

        $citaExistente = Cita::where('idOdontologo', $request->idOdontologo)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->whereNotIn('estado', ['Cancelada'])
            ->first();

        if ($citaExistente) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora' => 'El odontólogo ya tiene una cita programada para esa fecha y hora.'
                ]);
        }

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
        $cita = Cita::with('odontologo.persona')->findOrFail($id);
        $odontologos = Odontologo::with('persona')->get();

        return view('citas.edit', compact('cita', 'odontologos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idOdontologo' => 'required|exists:odontologos,idOdontologo',
            'fecha' => 'required|date',
            'hora' => 'required',
            'nombrePersona' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100',
            'estado' => 'required|string',
        ]);

        $citaExistente = Cita::where('idOdontologo', $request->idOdontologo)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('idCita', '!=', $id)
            ->whereNotIn('estado', ['Cancelada'])
            ->first();

        if ($citaExistente) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora' => 'El odontólogo ya tiene una cita programada para esa fecha y hora.'
                ]);
        }

        $cita = Cita::findOrFail($id);
        $cita->update([
            'idOdontologo' => $request->idOdontologo,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'nombrePersona' => $request->nombrePersona,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'estado' => $request->estado,
        ]);

        return redirect()->route('citas.index')
            ->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->update(['estado' => 'Cancelada']);
        $cita->delete();

        return redirect()->route('citas.index')
            ->with('success', 'Cita cancelada correctamente.');
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

}
