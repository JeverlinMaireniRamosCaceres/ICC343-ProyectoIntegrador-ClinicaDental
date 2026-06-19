<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Odontologo;
use App\Models\Especialidad;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $data = $this->validarOdontologo($request);

        DB::transaction(function () use ($data) {

            $persona = Persona::create([
                'cedula' => $data['cedula'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'fechaNacimiento' => $data['fechaNacimiento'],
                'sexo' => $data['sexo'],
                'telefono' => $data['telefono'],
                'correo' => $data['correo']
            ]);

            $odontologo = Odontologo::create([
                'idPersona' => $persona->idPersona,
                'exequatur' => $data['exequatur']
            ]);

            $odontologo->especialidades()->sync(
                $data['especialidades']
            );
        });

        return redirect()
            ->route('odontologos.index')
            ->with('success', 'Odontólogo registrado correctamente.');
    }

    public function show($id)
    {
        $odontologo = Odontologo::with(['persona', 'especialidades'])->findOrFail($id);

        return view('odontologos.show', compact('odontologo'));
    }

    public function edit($id)
    {
        $odontologo = Odontologo::with([
            'persona',
            'especialidades'
        ])->findOrFail($id);

        $especialidades = Especialidad::orderBy('nombre')->get();

        return view(
            'odontologos.edit',
            compact('odontologo', 'especialidades')
        );
    }

    public function update(Request $request, $id)
    {
        $odontologo = Odontologo::with('persona')->findOrFail($id);

        $data = $this->validarOdontologo($request, $odontologo->idPersona);

        DB::transaction(function () use ($odontologo, $data) {

            $odontologo->persona->update([
                'cedula' => $data['cedula'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'fechaNacimiento' => $data['fechaNacimiento'],
                'sexo' => $data['sexo'],
                'telefono' => $data['telefono'],
                'correo' => $data['correo']
            ]);

            $odontologo->update([
                'exequatur' => $data['exequatur']
            ]);

            $odontologo->especialidades()->sync(
                $data['especialidades']
            );
        });

        return redirect()
            ->route('odontologos.index')
            ->with('success', 'Odontólogo actualizado correctamente.');
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

    private function validarOdontologo(Request $request, ?int $idPersona = null): array
    {
        return $request->validate(
            [
                'cedula' => [
                    'required',
                    Rule::unique('personas', 'cedula')->ignore($idPersona, 'idPersona')
                ],

                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',

                'fechaNacimiento' => [
                    'required',
                    'date',
                    'before_or_equal:' . now()->subYears(18)->format('Y-m-d')
                ],

                'sexo' => [
                    'required',
                    Rule::in(['Masculino', 'Femenino'])
                ],

                'telefono' => [
                    'required',
                    'regex:/^(809|829|849)-\d{3}-\d{4}$/'
                ],

                'correo' => [
                    'nullable',
                    'email',
                    Rule::unique('personas', 'correo')->ignore($idPersona, 'idPersona')
                ],

                'exequatur' => 'required|string|max:50',

                'especialidades' => 'required|array|min:1',
                'especialidades.*' => 'exists:especialidades,idEspecialidad'
            ],
            [
                'cedula.required' => 'La cédula es obligatoria.',
                'cedula.unique' => 'Ya existe una persona con esta cédula.',

                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',

                'apellido.required' => 'El apellido es obligatorio.',
                'apellido.max' => 'El apellido no puede exceder los 100 caracteres.',

                'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
                'fechaNacimiento.date' => 'La fecha de nacimiento no es válida.',
                'fechaNacimiento.before_or_equal' => 'El odontólogo debe ser mayor de edad.',

                'sexo.required' => 'Debes seleccionar un sexo.',
                'sexo.in' => 'El sexo seleccionado no es válido.',

                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.regex' => 'El teléfono debe tener un prefijo válido (809, 829 o 849).',

                'correo.email' => 'El correo electrónico no es válido.',
                'correo.unique' => 'Ya existe una persona con este correo electrónico.',

                'exequatur.required' => 'El exequátur es obligatorio.',
                'exequatur.max' => 'El exequátur no puede exceder los 50 caracteres.',

                'especialidades.required' => 'Debes seleccionar al menos una especialidad.',
                'especialidades.array' => 'Las especialidades seleccionadas no son válidas.',
                'especialidades.*.exists' => 'Una de las especialidades seleccionadas no existe.'
            ]
        );
    }
}
