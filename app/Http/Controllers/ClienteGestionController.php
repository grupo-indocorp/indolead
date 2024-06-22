<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Cliente;
use App\Models\Comentario;
use App\Models\Contacto;
use App\Models\Equipo;
use App\Models\Etapa;
use App\Models\Movistar;
use App\Models\Sede;
use App\Models\User;
use App\Models\Venta;
use App\Services\ClienteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteGestionController extends Controller
{
    protected $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Filtros
        $filtro_ruc = request('filtro_ruc');
        $filtro_etapa_id = request('filtro_etapa_id') * 1;
        $filtro_user_id = request('filtro_user_id') * 1;
        $filtro_equipo_id = request('filtro_equipo_id') * 1;
        $filtro_sede_id = request('filtro_sede_id') * 1;
        $filtro_fecha_desde = request('filtro_fecha_desde');
        $filtro_fecha_hasta = request('filtro_fecha_hasta');
        $filtro = [
            'filtro_ruc' => $filtro_ruc,
            'filtro_etapa_id' => $filtro_etapa_id,
            'filtro_equipo_id' => $filtro_equipo_id,
            'filtro_user_id' => $filtro_user_id,
            'filtro_sede_id' => $filtro_sede_id,
            'filtro_fecha_desde' => $filtro_fecha_desde,
            'filtro_fecha_hasta' => $filtro_fecha_hasta,
        ];

        // Listando data en los selects
        $sede_id = request('filtro_sede_id');
        $equipo_id = request('filtro_equipo_id');
        $user_id = request('filtro_user_id');
        $sedes = Sede::all();
        if ($sede_id) {
            $equipos = Equipo::where('sede_id', $sede_id)->get();
            if ($equipo_id) {
                $users = Equipo::find($equipo_id)->users;
            } else {
                $users = User::role('ejecutivo')->where('sede_id', $sede_id)->get();
            }
        } else {
            if ($user->hasRole('gerente comercial') || $user->hasRole('supervisor')) {
                $equipos = Equipo::where('sede_id', $user->sede_id)->get();
                if ($user->hasRole('supervisor')) {
                    $users = Equipo::find($user->equipo->id)->users;
                } else {
                    if ($equipo_id) {
                        $users = Equipo::find($equipo_id)->users;
                    } else {
                        $users = User::role('ejecutivo')->where('sede_id', $user->sede_id)->get();
                    }
                }
            } else {
                $equipos = Equipo::all();
                if ($equipo_id) {
                    $users = Equipo::find($equipo_id)->users;
                } else {
                    $users = User::role('ejecutivo')->get();
                }
            }
        }

        $etapas = Etapa::all();

        $where = [];
        $where[] = ['ruc', 'LIKE', $filtro_ruc . '%'];
        if ($filtro_etapa_id != 0) {
            $where[] = ['etapa_id', $filtro_etapa_id];
        }
        if ($user->hasRole('ejecutivo')) {
            $where[] = ['user_id', $user->id];
        } else {
            if ($filtro_user_id != 0) {
                $where[] = ['user_id', $filtro_user_id];
            }
        }
        if ($user->hasRole('supervisor')) {
            $where[] = ['equipo_id', $user->equipo->id];
        } else {
            if ($filtro_equipo_id != 0) {
                $where[] = ['equipo_id', $filtro_equipo_id];
            }
        }
        if (isset($filtro_fecha_desde)) {
            $where[] = ['fecha_gestion', '>=', $filtro_fecha_desde . ' 00:00:00'];
        }
        if (isset($filtro_fecha_hasta)) {
            $where[] = ['fecha_gestion', '<=', $filtro_fecha_hasta . ' 23:59:59'];
        }
        if ($user->hasRole('gerente comercial') || $user->hasRole('supervisor') || $user->hasRole('ejecutivo')) {
            $where[] = ['sede_id', $user->sede_id];
        } else { // administrador, sistema
            if ($filtro_sede_id != 0) {
                $where[] = ['sede_id', $filtro_sede_id];
            }
        }
        $clientes = Cliente::with(['user', 'equipo', 'sede', 'etapa', 'comentarios'])
        ->where($where)
            ->orderByDesc('fecha_gestion')
            ->paginate(50);
        $data_etapas = $this->clienteService->etapasConConteo()['data_etapas'];
        $count_total = $this->clienteService->etapasConConteo()['count_total'];

        $config = Helpers::configuracionExcelJsonGet();

        $countClienteNuevo = 0;
        $countClienteGestionado = 0;
        if ($user->hasRole('ejecutivo')) {
            // Conteo de Clientes Nuevos por Ejecutivo
            $countClienteNuevo = Cliente::where('user_id', $user->id)->whereDate('fecha_nuevo', Carbon::today())->count();
            // Conteo de Clientes Gestionados por Ejecutivo
            $cltGestionados = Cliente::where('user_id', $user->id)->whereDate('fecha_gestion', Carbon::today())->get();
            foreach ($cltGestionados as $value) {
                if ($value->etiqueta_id != 2) { //asignado
                    $countClienteGestionado++;
                }
            }
        }

        return view('sistema.cliente.gestion.index', compact(
            'clientes',
            'data_etapas',
            'count_total',
            'filtro',
            'sedes',
            'equipos',
            'users',
            'config',
            'countClienteNuevo',
            'countClienteGestionado'
        ));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $view = request('view');
        if ($view == 'show-validar-ruc') {
            $request->validate(
                [
                    'ruc' => 'numeric|digits:11|starts_with:20|unique:clientes,ruc|bail',
                ],
                [
                    'ruc.numeric' => 'El "Ruc" debe ser numérico.',
                    'ruc.digits' => 'El "Ruc" debe tener exactamente 11 dígitos.',
                    'ruc.starts_with' => 'El "Ruc" debe iniciar con 20.',
                    'ruc.unique' => 'El "Ruc" ya se encuentra registrado.',
                ]
            );
        } elseif ($view == 'show-validar-ruc-secodi') {
            $request->validate(
                [
                    'ruc' => 'numeric|digits:11|starts_with:20,10|unique:clientes,ruc|bail',
                ],
                [
                    'ruc.numeric' => 'El "Ruc" debe ser numérico.',
                    'ruc.digits' => 'El "Ruc" debe tener exactamente 11 dígitos.',
                    'ruc.starts_with' => 'El "Ruc" debe iniciar con 20 o 10.',
                    'ruc.unique' => 'El "Ruc" ya se encuentra registrado.',
                ]
            );
        } elseif ($view === 'show-editar-venta') {
            $venta = Venta::find($id);
            $productos = $venta->productos;
            return $productos;
        } elseif ($view === 'show-ultima-venta') {
            $cliente = Cliente::find($id);
            $productos = false;
            if (isset($cliente)) {
                $productos = isset($cliente->ventas->last()->productos) ? $cliente->ventas->last()->productos : false;
            }
            return $productos;
        } elseif ($view === 'show-select-sede') {
            $sede = Sede::find($id);
            if ($sede) {
                $equipos = Equipo::where('sede_id', $sede->id)->get();
                $users = User::role('ejecutivo')->where('sede_id', $sede->id)->get();
            } else {
                $equipos = Equipo::all();
                $users = User::role('ejecutivo')->get();
            }
            return response()->json([
                'equipos' => $equipos,
                'users' => $users,
            ]);
        } elseif ($view === 'show-select-equipo') {
            $equipo = Equipo::find($id);
            $users = $equipo->users;
            return response()->json([
                'users' => $users,
            ]);
        } elseif ($view === 'show-select-user') {
            $sede_id = request('sede_id');
            if ($sede_id) {
                $users = User::role('ejecutivo')->where('sede_id', $sede_id)->get();
            } else {
                $users = User::role('ejecutivo')->get();
            }
            return response()->json([
                'users' => $users,
            ]);
        } elseif ($view === 'show-data-select') {
            $sedes = Sede::all();
            $equipos = Equipo::all();
            $users = User::role('ejecutivo')->get();
            return response()->json([
                'sedes' => $sedes,
                'equipos' => $equipos,
                'users' => $users,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $view = request('view');
        if ($view === 'edit-asignar') {
            $equipos = Equipo::all();
            if (auth()->user()->hasRole('supervisor')) {
                $equipo = Equipo::find(auth()->user()->equipo->id);
                $ejecutivos = $equipo->users;
            } else {
                $ejecutivos = User::role('ejecutivo')->get();
            }
            $clients = request('clients');
            $etapas = Etapa::all();
            return view('sistema.cliente.gestion.asignar', compact(
                'equipos',
                'ejecutivos',
                'clients',
                'etapas',
            ));
        } elseif ($view === 'edit-detalle') {
            $cliente_id = $id;
            $user = auth()->user();
            $data = $this->clienteService->obtenerClienteDetalle($user, $cliente_id);
            return view('sistema.cliente.gestion.detalle', compact('data'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $view = request('view');
        $cliente = Cliente::find($id);
        if ($view === 'update-cliente') {
            $request->validate(
                [
                    'ruc' => 'required|numeric|digits:11|starts_with:20,10|unique:clientes,ruc,' . $id . '|bail',
                    'razon_social' => 'required|bail',
                    'ciudad' => 'required|bail',
                ],
                [
                    'ruc.required' => 'El "Ruc" es obligatorio.',
                    'ruc.numeric' => 'El "Ruc" debe ser numérico.',
                    'ruc.digits' => 'El "Ruc" debe tener exactamente 11 dígitos.',
                    'ruc.starts_with' => 'El "Ruc" debe iniciar con 20 o 10.',
                    'ruc.unique' => 'El "Ruc" ya se encuentra registrado.',
                    'razon_social.required' => 'La "Razón Social" es obligatorio.',
                    'ciudad.required' => 'La "Ciudad" es obligatorio.',
                ]
            );
            $cliente->ruc = request('ruc');
            $cliente->razon_social = request('razon_social');
            $cliente->ciudad = request('ciudad');
            $cliente->save();
            $this->clienteService->exportclienteStore($cliente->id);
            return response()->json($cliente);
        } elseif ($view === 'update-contacto') {
            $request->validate(
                [
                    'nombre' => 'required|bail',
                    'dni' => 'required|numeric|digits:8|bail',
                    'celular' => 'required|bail',
                    'cargo' => 'required|bail',
                ],
                [
                    'nombre.required' => 'El "Nombre" es obligatorio.',
                    'dni.required' => 'El "DNI" es obligatorio.',
                    'dni.numeric' => 'El "DNI" debe ser numérico.',
                    'dni.digits' => 'El "DNI" debe tener exactamente 8 dígitos.',
                    'celular.required' => 'El "Celular" es obligatorio.',
                    'cargo.required' => 'El "Cargo" es obligatorio.',
                ]
            );
            $contacto = new Contacto();
            $contacto->dni = request('dni');
            $contacto->nombre = request('nombre');
            $contacto->celular = request('celular');
            $contacto->cargo = request('cargo');
            $contacto->correo = request('correo') ?? '';
            $contacto->fecha_ultimo = now();
            $contacto->fecha_proximo = now();
            $contacto->cliente_id = $cliente->id;
            $contacto->save();

            $data_contactos = $cliente->contactos()->orderBy('contactos.id', 'desc')->limit(8)->get();
            $contactos = [];
            foreach ($data_contactos as $value) {
                $contactos[] = [
                    'id' => $value->id,
                    'dni' => $value->dni,
                    'nombre' => $value->nombre,
                    'celular' => $value->celular,
                    'cargo' => $value->cargo,
                    'correo' => $value->correo,
                ];
            }
            $this->clienteService->exportclienteStore($cliente->id);
            return response()->json($contactos);
        } elseif ($view === 'update-comentario') {
            $request->validate(
                [
                    'comentario' => 'required|bail',
                ],
                [
                    'comentario.required' => 'El "Comentario" es obligatorio.',
                ]
            );
            $etapa = Etapa::find($cliente->etapa_id);
            $comentario = new Comentario();
            $comentario->comentario = request('comentario');
            $comentario->detalle = $etapa->nombre;
            $comentario->user_id = auth()->user()->id;
            $comentario->cliente_id = $cliente->id;
            $comentario->etiqueta_id = 4; // etiqueta_id, 4=gestionado;
            $comentario->save();

            $data_comentarios = $cliente->comentarios()->where('user_id', auth()->user()->id)->orderBy('comentarios.id', 'desc')->limit(5)->get();
            $comentarios = [];
            foreach ($data_comentarios as $value) {
                $comentarios[] = [
                    'id' => $value->id,
                    'comentario' => $value->comentario,
                    'usuario' => $value->user->name,
                    'fecha' => $value->created_at->format('d-m-Y h:i:s A'),
                    'etiqueta' => $value->etiqueta->nombre,
                    'detalle' => $value->detalle,
                ];
            }
            // cliente
            $cliente->fecha_gestion = now();
            $cliente->etiqueta_id = 4; // gestionado
            $cliente->save();
            $this->clienteService->exportclienteStore($cliente->id);
            return response()->json($comentarios);
        } elseif ($view === 'update-movistar') {
            $request->validate(
                [
                    'estadowick_id' => 'required|bail',
                    'estadodito_id' => 'required|bail',
                    'linea_claro' => 'required|bail',
                    'linea_entel' => 'required|bail',
                    'linea_bitel' => 'required|bail',
                    'linea_movistar' => 'required|bail',
                    'clientetipo_id' => 'required|bail',
                    'agencia_id' => 'required|bail',
                ],
                [
                    'estadowick_id.required' => 'El "Estado Wick" es obligatorio.',
                    'estadodito_id.required' => 'El "Estado Dito" es obligatorio.',
                    'linea_claro.required' => 'La "Línea Claro" es obligatorio.',
                    'linea_entel.required' => 'La "Línea Entel" es obligatorio.',
                    'linea_bitel.required' => 'La "Línea Bitel" es obligatorio.',
                    'linea_movistar.required' => 'La "Línea Movistar" es obligatorio.',
                    'clientetipo_id.required' => 'El "Tipo de Cliente" es obligatorio.',
                    'agencia_id.required' => 'La "Agencia" es obligatorio.',
                ]
            );
            $movistar = new Movistar();
            $movistar->linea_claro = request('linea_claro');
            $movistar->linea_entel = request('linea_entel');
            $movistar->linea_bitel = request('linea_bitel');
            $movistar->linea_movistar = request('linea_movistar');
            $movistar->estadowick_id = request('estadowick_id');
            $movistar->estadodito_id = request('estadodito_id');
            $movistar->clientetipo_id = request('clientetipo_id');
            $movistar->ejecutivo_salesforce = request('ejecutivo_salesforce') ?? '';
            $movistar->agencia_id = request('agencia_id');
            $movistar->cliente_id = $cliente->id;
            $movistar->save();
            $this->clienteService->exportclienteStore($cliente->id);
        } elseif ($view === 'update-etapa') {
            $request->validate(
                [
                    'etapa_id' => 'required|bail',
                    'comentario' => 'required|bail',
                ],
                [
                    'etapa_id.required' => 'La "Etapa" es obligatorio.',
                    'comentario.required' => 'El "Comentario" es obligatorio.',
                ]
            );
            // cliente
            $cliente->etapas()->attach(request('etapa_id'));
            $cliente->fecha_gestion = now();
            $cliente->etiqueta_id = 4; // gestionado
            $cliente->etapa_id = request('etapa_id');
            $cliente->save();

            $etapa = Etapa::find(request('etapa_id'));
            $comentario = new Comentario();
            $comentario->comentario = request('comentario');
            $comentario->detalle = 'Cambio de etapa a '.$etapa->nombre;
            $comentario->user_id = auth()->user()->id;
            $comentario->cliente_id = $cliente->id;
            $comentario->save();

            $data_comentarios = $cliente->comentarios()->where('user_id', auth()->user()->id)->orderBy('comentarios.id', 'desc')->limit(5)->get();
            $comentarios = [];
            foreach ($data_comentarios as $value) {
                $comentarios[] = [
                    'id' => $value->id,
                    'comentario' => $value->comentario,
                    'usuario' => $value->user->name,
                    'fecha' => $value->created_at->format('d-m-Y h:i:s A'),
                    'etiqueta' => $value->etiqueta->nombre,
                    'detalle' => $value->detalle,
                ];
            }
            $this->clienteService->exportclienteStore($cliente->id);
            return response()->json($comentarios);
        } elseif ($view === 'update-cargo') {
            $ventas = Venta::find(request('venta_id'));
            if (isset($ventas)) {
                foreach ($ventas->productos as $value) {
                    DB::table('producto_venta')->where('venta_id', $value->pivot->venta_id)->delete();
                }
            }
            if (!is_null(request('dataCargo'))) {
                $venta_total = 0;
                $venta = new Venta();
                $venta->cliente_id = $cliente->id;
                $venta->user_id = auth()->user()->id;
                $venta->save();
                foreach (request('dataCargo') as $row) {
                    $venta->productos()->attach($row['producto_id'], [
                        'producto_nombre' => $row['producto_nombre'],
                        'detalle' => $row['detalle'] ?? '',
                        'cantidad' => $row['cantidad'],
                        'precio' => $row['precio'],
                        'total' => $row['total'],
                    ]);
                    $venta_total += $row['total'];
                }
                $venta->total = $venta_total;
                $venta->save();
            }
            $this->clienteService->exportclienteStore($cliente->id);
            return $venta->productos;
        } elseif ($view === 'update-asignar') {
            $request->validate(
                [
                    'user_id' => 'required|bail',
                    'etapa_id' => 'required|bail',
                ],
                [
                    'user_id.required' => 'El "Ejecutivo" es obligatorio.',
                    'etapa_id.required' => 'La "Etapa" es obligatorio.',
                ]
            );
            // cliente
            $executive = User::find(request('user_id'));
            $clients = request('clients');
            foreach ($clients as $value) {
                $client = Cliente::find($value);
                $client->fecha_gestion = now();
                $client->fecha_nuevo = now();
                $client->etiqueta_id = 2; // asignado
                $client->user_id = $executive->id;
                $client->equipo_id = $executive->equipos->last()->id;
                $client->sede_id = $executive->sede_id;
                $client->etapa_id = request('etapa_id');
                $client->save();
                $client->usersHistorial()->attach($executive->id);
                $client->etapas()->attach(1);
                // comentario
                $etapa = Etapa::find(request('etapa_id'));
                $comentario = new Comentario();
                $comentario->comentario = 'Cliente asignado.';
                $comentario->detalle = 'Cambio de etapa a ' . $etapa->nombre;
                $comentario->cliente_id = $client->id;
                $comentario->user_id = auth()->user()->id;
                $comentario->etiqueta_id = 2; // etiqueta_id, 2=asignado;
                $comentario->save();
                $this->clienteService->exportclienteStore($client->id);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
