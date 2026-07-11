<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Odontologo;
use App\Services\WhatsAppService;

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
            'medioRecordatorio' => 'required|in:correo,whatsapp,ambos',

            'telefono' => 'required_if:medioRecordatorio,whatsapp,ambos|nullable|string|max:20',
            'correo' => 'required_if:medioRecordatorio,correo,ambos|nullable|email|max:100',
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
            'medioRecordatorio' => $request->medioRecordatorio,
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

        $query = Cita::with('odontologo.persona')
            ->where('fecha', $fecha);

        if (auth()->user()->rol->nombre === 'Doctor') {

            $odontologo = Odontologo::where('idPersona', auth()->user()->idPersona)
                ->first();

            if ($odontologo) {
                $query->where('idOdontologo', $odontologo->idOdontologo);
            } else {
                return response()->json([]);
            }
        }

        $citas = $query
            ->orderBy('hora')
            ->get();

        return response()->json($citas);
    }

    public function citasPorMes(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $query = Cita::with('odontologo.persona')
            ->whereYear('fecha', $year)
            ->whereMonth('fecha', $month);

        if (auth()->user()->rol->nombre === 'Doctor') {

            $odontologo = Odontologo::where('idPersona', auth()->user()->idPersona)
                ->first();

            if ($odontologo) {
                $query->where('idOdontologo', $odontologo->idOdontologo);
            } else {
                return response()->json([]);
            }
        }

        $citas = $query
            ->get()
            ->groupBy('fecha');

        // devolver solo fechas y cantidad de citas por día
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
            'medioRecordatorio' => 'required|in:correo,whatsapp,ambos',

            'telefono' => 'required_if:medioRecordatorio,whatsapp,ambos|nullable|string|max:20',
            'correo' => 'required_if:medioRecordatorio,correo,ambos|nullable|email|max:100',
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
            'medioRecordatorio' => $request->medioRecordatorio,
        ]);

        return redirect()->route('citas.index')
            ->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);

        $cita->update([
            'estado' => 'Cancelada'
        ]);

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

    public function confirmarPublico(Cita $cita)
    {
        if ($cita->estado === 'Pendiente') {
            $cita->update(['estado' => 'Confirmada']);
            $mensaje = 'Tu cita ha sido confirmada correctamente.';
        } else {
            $mensaje = 'Esta cita ya no puede confirmarse (estado actual: ' . $cita->estado . ').';
        }

        return view('citas.respuesta-publica', compact('mensaje'));
    }

    public function cancelarPublico(Cita $cita)
    {
        if ($cita->estado !== 'Cancelada') {
            $cita->update(['estado' => 'Cancelada']);
            $mensaje = 'Tu cita ha sido cancelada correctamente.';
        } else {
            $mensaje = 'Esta cita ya estaba cancelada.';
        }

        return view('citas.respuesta-publica', compact('mensaje'));
    }
    
}
