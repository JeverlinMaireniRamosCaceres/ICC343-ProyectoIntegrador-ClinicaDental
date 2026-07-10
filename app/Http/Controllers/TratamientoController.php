<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tratamiento;
use App\Models\DetalleTratamiento;


class TratamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function procedimientos($id)
    {
        $procedimientos = DetalleTratamiento::with('procedimiento')
            ->where('idTratamiento', $id)
            ->get();

        return response()->json($procedimientos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idPaciente' => 'required|exists:pacientes,idPaciente',
            'nombre' => 'required|string|max:100',
            'fechaInicio' => 'required|date',
            'estado' => 'required|string',

            'procedimientos' => 'array',
            'procedimientos.*.idProcedimiento' => 'required|exists:procedimientos,idProcedimiento',
            'procedimientos.*.cantidad' => 'required|integer|min:1',
        ]);

        $tratamiento = Tratamiento::create([
            'idPaciente' => $request->idPaciente,
            'nombre' => $request->nombre,
            'fechaInicio' => $request->fechaInicio,
            'estado' => $request->estado,
        ]);

        foreach ($request->procedimientos ?? [] as $procedimiento) {

            DetalleTratamiento::create([
                'idTratamiento' => $tratamiento->idTratamiento,
                'idProcedimiento' => $procedimiento['idProcedimiento'],
                'cantidadProcedimiento' => $procedimiento['cantidad'],
                'observacion' => $procedimiento['observacion'] ?? null,
                'estado' => 'Pendiente',
                'idConsulta' => null,
            ]);

        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'tratamiento' => $tratamiento,
            ]);
        }

        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento creado correctamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tratamiento = Tratamiento::with(['paciente.persona', 'detalles.procedimiento'])
            ->findOrFail($id);

        return view('tratamientos.show', compact('tratamiento'));
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
