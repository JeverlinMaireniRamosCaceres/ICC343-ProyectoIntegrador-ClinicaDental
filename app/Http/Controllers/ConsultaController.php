<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Odontologo;
use App\Models\Paciente;
use App\Models\Procedimiento;
use App\Models\Tratamiento;
use App\Models\DetalleConsulta;
use App\Models\DetalleTratamiento;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\MovimientoInventario;
use App\Models\ProductoProcedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $porPagina = $request->porPagina ?? 10;
        $fechaDesde = $request->fecha_desde;
        $fechaHasta = $request->fecha_hasta;

        $query = Consulta::with(['paciente.persona', 'odontologo.persona']);

        if (auth()->user()->rol->nombre === 'Doctor') {

            $odontologo = Odontologo::where('idPersona', auth()->user()->idPersona)
                ->first();

            if ($odontologo) {
                $query->where('idOdontologo', $odontologo->idOdontologo);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $consultas = $query
            ->when($buscar, function ($query) use ($buscar) {
                $query->whereHas('paciente.persona', function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%");
                });
            })

            ->when($fechaDesde, function ($query) use ($fechaDesde) {
                $query->whereDate('fecha', '>=', $fechaDesde);
            })

            ->when($fechaHasta, function ($query) use ($fechaHasta) {
                $query->whereDate('fecha', '<=', $fechaHasta);
            })

            ->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view('consultas.partials.tabla', compact('consultas', 'porPagina'))->render();
        }

        return view('consultas.index', compact('consultas', 'porPagina'));
    }

    public function create(Request $request)
    {
        $odontologo = Odontologo::with('persona')
            ->where('idPersona', Auth::user()->idPersona)
            ->firstOrFail();

        $procedimientos = Procedimiento::orderBy('nombre')->get();

        $paciente = null;

        if ($request->filled('paciente')) {
            $paciente = Paciente::with('persona')
                ->find($request->paciente);
        }

        return view('consultas.create', compact(
            'odontologo',
            'procedimientos',
            'paciente'
        ));
    }

    private function descontarStock(int $idProcedimiento, int $cantidadProcedimiento, int $idConsulta): void
    {
        $productosProcedimiento = ProductoProcedimiento::with('producto')
            ->where('idProcedimiento', $idProcedimiento)
            ->get();

        foreach ($productosProcedimiento as $pp) {
            $producto = $pp->producto;

            if (!$producto) {
                continue;
            }

            $cantidadADescontar = $pp->cantidad * $cantidadProcedimiento;

            $this->descontarDeLotes($producto, $cantidadADescontar, $idConsulta, $idProcedimiento);
        }
    }

    private function descontarDeLotes(
        Producto $producto,
        int $cantidadADescontar,
        int $idConsulta,
        int $idProcedimiento
    ): void {
        $restante = $cantidadADescontar;

        $lotes = DetalleCompra::where('idProducto', $producto->idProducto)
            ->where('cantidadDisponible', '>', 0)
            ->orderByRaw('fechaVencimiento IS NULL')
            ->orderBy('fechaVencimiento', 'asc')
            ->lockForUpdate()
            ->get();

        foreach ($lotes as $lote) {
            if ($restante <= 0) {
                break;
            }

            $tomarDeEsteLote = min($lote->cantidadDisponible, $restante);

            $lote->cantidadDisponible -= $tomarDeEsteLote;
            $lote->save();

            MovimientoInventario::create([
                'idProducto' => $producto->idProducto,
                'idDetalleCompra' => $lote->idDetalleCompra,
                'tipo' => 'SALIDA',
                'cantidad' => $tomarDeEsteLote,
                'motivo' => 'Procedimiento',
                'idConsulta' => $idConsulta,
                'idProcedimiento' => $idProcedimiento,
            ]);

            $restante -= $tomarDeEsteLote;
        }

        if ($restante > 0) {
            MovimientoInventario::create([
                'idProducto' => $producto->idProducto,
                'idDetalleCompra' => null,
                'tipo' => 'SALIDA',
                'cantidad' => $restante,
                'motivo' => 'Procedimiento (sin lote - stock inconsistente)',
                'idConsulta' => $idConsulta,
                'idProcedimiento' => $idProcedimiento,
            ]);
        }

        $producto->stockActual = max(0, $producto->stockActual - $cantidadADescontar);
        $producto->save();
    }

    public function store(Request $request)
    {
        $request->validate([
            'idPaciente' => 'required|exists:pacientes,idPaciente',
            'idOdontologo' => 'required|exists:odontologos,idOdontologo',
            'fecha' => 'required|date',
            'estado' => 'required|string',
            'motivo' => 'required|string',
            'diagnostico' => 'required|string',
            'receta' => 'nullable|string',
            'idProcedimiento' => [
                'required_without:procedimientos_realizados',
                'array',
            ],
            'procedimientos_realizados' => [
                'required_without:idProcedimiento',
                'array',
            ],
        ], [
            'idProcedimiento.required_without' => 'Debe agregar al menos un procedimiento a la consulta.',
            'procedimientos_realizados.required_without' => 'Debe agregar al menos un procedimiento a la consulta.',
        ]);

        DB::transaction(function () use ($request) {

            // crear la consulta
            $consulta = Consulta::create([
                'idPaciente' => $request->idPaciente,
                'idOdontologo' => $request->idOdontologo,
                'fecha' => $request->fecha,
                'motivo' => $request->motivo,
                'diagnostico' => $request->diagnostico,
                'receta' => $request->receta,
                'estado' => $request->estado,
            ]);

            // guardar procedimientos independientes
            if ($request->has('idProcedimiento')) {
                foreach ($request->idProcedimiento as $i => $idProc) {

                    $cantidad = $request->cantidadProcedimiento[$i] ?? 1;
                    $precio = Procedimiento::find($idProc)?->precio ?? 0;
                    $subtotal = $cantidad * $precio;

                    $consulta->detalles()->create([
                        'idProcedimiento' => $idProc,
                        'cantidadProcedimiento' => $cantidad,
                        'subtotal' => $subtotal,
                    ]);

                    $this->descontarStock($idProc, $cantidad, $consulta->idConsulta);
                }
            }

            // guardar procedimientos realizados del tratamiento
            if ($request->filled('procedimientos_realizados')) {

                foreach ($request->procedimientos_realizados as $idDetalle) {

                    $detalle = DetalleTratamiento::find($idDetalle);

                    if (!$detalle) {
                        continue;
                    }

                    if ($detalle->estado === 'Realizado') {
                        continue;
                    }

                    $precio = Procedimiento::find($detalle->idProcedimiento)?->precio ?? 0;
                    $subtotal = $detalle->cantidadProcedimiento * $precio;

                    $detalle->update([
                        'idConsulta' => $consulta->idConsulta,
                        'estado' => 'Realizado',
                    ]);

                    $consulta->detalles()->create([
                        'idProcedimiento' => $detalle->idProcedimiento,
                        'idDetalleTratamiento' => $detalle->idDetalleTratamiento,
                        'cantidadProcedimiento' => $detalle->cantidadProcedimiento,
                        'subtotal' => $subtotal,
                    ]);

                    $this->descontarStock(
                        $detalle->idProcedimiento,
                        $detalle->cantidadProcedimiento,
                        $consulta->idConsulta
                    );
                }
            }
        });

        if ($request->filled('return')) {
            return redirect($request->return)
                ->with('success', 'Consulta registrada correctamente.');
        }

        return redirect()->route('consultas.index')
            ->with('success', 'Consulta registrada correctamente.');
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

    public function tratamientosPaciente($id)
    {
        $tratamientos = Tratamiento::where('idPaciente', $id)
            ->whereIn('estado', ['Activo', 'En proceso'])
            ->orderBy('fechaInicio', 'desc')
            ->get();

        return response()->json($tratamientos);
    }

    public function show($id)
    {
        $query = Consulta::with([
            'paciente.persona',
            'paciente.alergias',
            'odontologo.persona',
            'detalles.procedimiento',
            'detalles.detalleTratamiento.tratamiento'
        ]);

        if (auth()->user()->rol->nombre === 'Doctor') {

            $odontologo = Odontologo::where('idPersona', auth()->user()->idPersona)
                ->first();

            if ($odontologo) {
                $query->where('idOdontologo', $odontologo->idOdontologo);
            } else {
                abort(403);
            }
        }

        $consulta = $query->findOrFail($id);


        $detallesTratamiento = $consulta->detalles
            ->whereNotNull('idDetalleTratamiento');


        $detallesIndependientes = $consulta->detalles
            ->whereNull('idDetalleTratamiento');


        $subtotalTratamiento = $detallesTratamiento->sum(function ($detalle) {
            return $detalle->cantidadProcedimiento *
                $detalle->procedimiento->precio;
        });


        $subtotalIndependientes = $detallesIndependientes->sum(function ($detalle) {
            return $detalle->cantidadProcedimiento *
                $detalle->procedimiento->precio;
        });


        return view('consultas.show', compact(
            'consulta',
            'detallesTratamiento',
            'detallesIndependientes',
            'subtotalTratamiento',
            'subtotalIndependientes'
        ));
    }
}
