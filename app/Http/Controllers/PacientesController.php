<?php

namespace App\Http\Controllers;

use App\Models\Alergia;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Persona;
use Illuminate\Validation\Rule;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $porPagina = $request->input('porPagina', 10);

        $pacientes = Paciente::query()
            ->with('persona')
            ->when($buscar, function ($query, $buscar) {
                $query->whereHas('persona', function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%")
                        ->orWhere('cedula', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('idPaciente', 'asc')
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view('pacientes.partials.tabla', compact('pacientes', 'porPagina'))->render();
        }
        return view('pacientes.index', compact('pacientes', 'buscar', 'porPagina'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alergias = Alergia::orderBy('nombre')->get();
        return view('pacientes.create', compact('alergias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $this->validarPaciente($request);

        $persona = null;

        if (!empty($datos['cedula'])) {
            $persona = Persona::where('cedula', $datos['cedula'])->first();
        }

        if ($persona) {

            $persona->update([
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'fechaNacimiento' => $datos['fechaNacimiento'],
                'sexo' => $datos['sexo'],
                'telefono' => $datos['telefono'] ?? null,
                'correo' => $datos['correo'] ?? null,
            ]);
        } else {

            $persona = Persona::create([
                'cedula' => $datos['cedula'] ?? null,
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'fechaNacimiento' => $datos['fechaNacimiento'],
                'sexo' => $datos['sexo'],
                'telefono' => $datos['telefono'] ?? null,
                'correo' => $datos['correo'] ?? null,
            ]);
        }

        $paciente = Paciente::create([
            'idPersona' => $persona->idPersona,
            'antecedentes' => $datos['antecedentesMedicos'] ?? null,
        ]);

        $paciente->alergias()->sync(
            $datos['alergias'] ?? []
        );

        return redirect($request->return ?: route('pacientes.index'))
            ->with('success', 'Paciente registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paciente = Paciente::with([
            'persona',
            'alergias',
            'tratamientos.detalles.procedimiento',
            'consultas.odontologo.persona'
        ])->findOrFail($id);

        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paciente = Paciente::with([
            'persona',
            'alergias'
        ])->findOrFail($id);

        $alergias = Alergia::orderBy('nombre')->get();

        return view('pacientes.edit', compact('paciente', 'alergias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paciente = Paciente::with('persona')->findOrFail($id);

        $datos = $this->validarPaciente($request, $paciente);

        $paciente->persona->update([
            'cedula' => $datos['cedula'] ?? null,
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'fechaNacimiento' => $datos['fechaNacimiento'],
            'sexo' => $datos['sexo'],
            'telefono' => $datos['telefono'],
            'correo' => $datos['correo'] ?? null,
        ]);

        $paciente->update([
            'antecedentes' => $datos['antecedentesMedicos'] ?? null,
        ]);

        $paciente->alergias()->sync(
            $datos['alergias'] ?? []
        );

        return redirect($request->return ?: route('pacientes.index'))
            ->with('success', 'Paciente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function validarPaciente(Request $request, ?Paciente $paciente = null): array
    {
        return $request->validate(
            [
                'cedula' => [
                    'nullable',
                    function ($attribute, $value, $fail) use ($paciente) {

                        if (blank($value)) {
                            return;
                        }

                        $persona = Persona::where('cedula', $value)->first();

                        if (!$persona) {
                            return;
                        }

                        if ($paciente && $persona->idPersona === $paciente->idPersona) {
                            return;
                        }

                        if ($persona->paciente) {
                            $fail('Ya existe un paciente registrado con esta cédula.');
                            return;
                        }

                        if ($persona->odontologo) {
                            return;
                        }

                        $fail('Ya existe una persona registrada con esta cédula.');
                    }
                ],

                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',

                'fechaNacimiento' => 'required|date',

                'sexo' => [
                    'required',
                    Rule::in(['Masculino', 'Femenino'])
                ],

                'telefono' => [
                    'required',
                    'regex:/^(809|829|849)-\d{3}-\d{4}$/'
                ],

                'correo' => 'nullable|email|max:100',

                'antecedentesMedicos' => 'nullable|string',

                'alergias' => 'nullable|array',
                'alergias.*' => 'exists:alergias,idAlergia',
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max' => 'El nombre no puede exceder 100 caracteres.',

                'apellido.required' => 'El apellido es obligatorio.',
                'apellido.max' => 'El apellido no puede exceder 100 caracteres.',

                'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
                'fechaNacimiento.date' => 'La fecha de nacimiento no es válida.',

                'sexo.required' => 'Debe seleccionar un sexo.',

                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.regex' => 'El teléfono debe tener el formato 809-555-1234.',

                'correo.email' => 'El correo electrónico no es válido.',

                'alergias.array' => 'Las alergias seleccionadas no son válidas.',
                'alergias.*.exists' => 'Una de las alergias seleccionadas no existe.',
            ]
        );
    }

    public function buscarPersona(Request $request)
    {
        $persona = Persona::where('cedula', $request->cedula)
            ->first();

        if (!$persona) {
            return response()->json([
                'existe' => false
            ]);
        }

        return response()->json([
            'existe' => true,
            'persona' => [
                'idPersona' => $persona->idPersona,
                'nombre' => $persona->nombre,
                'apellido' => $persona->apellido,
                'fechaNacimiento' => $persona->fechaNacimiento,
                'sexo' => $persona->sexo,
                'telefono' => $persona->telefono,
                'correo' => $persona->correo,
            ]
        ]);
    }
}
