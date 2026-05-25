<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Persona;
use App\Models\Odontologo;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $usuarios = Usuario::query()
            ->when($buscar, function ($query, $buscar) {
                $query->where('username', 'like', "%{$buscar}%");
            })
            ->orderBy('idUsuario', 'asc')
            ->withTrashed()
            ->paginate(6)
            ->withQueryString();

        if ($request->ajax()) {
            return view('usuarios.partials.tabla', compact('usuarios'))->render();
        }

        return view('usuarios.index', compact('usuarios', 'buscar'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'username' => 'required|max:50|unique:usuarios,username',
                'password' => 'required|confirmed',
                'idRol' => 'required',
                'idPersona' => 'required_if:idRol,3'
            ],
            [
                'username.required' => 'El usuario es obligatorio.',
                'username.unique' => 'Ese usuario ya existe.',

                'password.required' => 'La contraseña es obligatoria.',
                'password.confirmed' => 'Las contraseñas no coinciden.',

                'idRol.required' => 'Debe seleccionar un rol.',

                'idPersona.required_if' => 'Debe seleccionar una persona para el odontólogo.'
            ]
        );

        Usuario::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'idRol' => $request->idRol,
            'idPersona' => $request->idPersona
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    public function buscarPersonas(Request $request)
    {
        $texto = $request->texto;

        $odontologos = Odontologo::with('persona')

            ->whereHas('persona', function ($query) use ($texto) {

                $query->where('nombre', 'LIKE', "%{$texto}%")
                    ->orWhere('apellido', 'LIKE', "%{$texto}%");
            })

            ->limit(10)

            ->get();

        return response()->json($odontologos);
    }

    public function show($id)
    {
        return view('usuarios.show', compact('id'));
    }

public function edit($id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);
        
        $roles = Rol::all();

        $personaAsociada = null;
        if ($usuario->idPersona) {
            $personaAsociada = Persona::find($usuario->idPersona);
        }

        return view('usuarios.edit', compact('usuario', 'roles', 'personaAsociada'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);

        $request->validate(
            [
                'username' => 'required|max:50|unique:usuarios,username,' . $id . ',idUsuario',
                'password' => 'nullable|confirmed',
                'idRol' => 'required',
                'idPersona' => 'required_if:idRol,3'
            ],
            [
                'username.required' => 'El usuario es obligatorio.',
                'username.unique' => 'Ese usuario ya existe.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'idRol.required' => 'Debe seleccionar un rol.',
                'idPersona.required_if' => 'Debe seleccionar una persona para el odontólogo.'
            ]
        );

        $usuario->username = $request->username;
        $usuario->idRol = $request->idRol;

        $usuario->idPersona = ($request->idRol == 3) ? $request->idPersona : null;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

}