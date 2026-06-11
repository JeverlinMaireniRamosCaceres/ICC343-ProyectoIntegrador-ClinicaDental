<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Odontologo;
use App\Models\Especialidad;
use App\Models\Usuario;

class OdontologoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $odontologos = Odontologo::query()
            ->withTrashed()
            ->with(['persona', 'especialidades'])
            ->when($buscar, function ($query, $buscar) {
                $query->whereHas('persona', function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%")
                        ->orWhere('cedula', 'like', "%{$buscar}%");
                })
                    ->orWhere('exequatur', 'like', "%{$buscar}%");
            })
            ->orderBy('idOdontologo', 'asc')
            ->paginate(6)
            ->withQueryString();

        if ($request->ajax()) {
            return view('odontologos.partials.tabla', compact('odontologos'))->render();
        }

        return view('odontologos.index', compact('odontologos', 'buscar'));
    }

    public function create()
    {
        $especialidades = Especialidad::orderBy('nombre')->get();
        return view('odontologos.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        return redirect()->route('odontologos.index');
    }

    public function show($id)
    {
        return view('odontologos.show', compact('id'));
    }

    public function edit($id)
    {
        return view('odontologos.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('odontologos.index');
    }

    public function destroy($id)
    {
        $odontologo = Odontologo::findOrFail($id);
        $odontologo->delete();

        if ($odontologo->usuario) {
            $odontologo->usuario->delete();
        }

        return redirect()
            ->route('odontologos.index')
            ->with('success', 'Odontólogo desactivado correctamente.');
    }

    public function activar($id)
    {
        $odontologo = Odontologo::withTrashed()->findOrFail($id);
        $odontologo->restore();

        $usuario = Usuario::withTrashed()
            ->where('idPersona', $odontologo->idPersona)
            ->first();

        if ($usuario) {
            $usuario->restore();
        }

        return redirect()
            ->route('odontologos.index')
            ->with('success', 'Odontólogo activado correctamente.');
    }
}
