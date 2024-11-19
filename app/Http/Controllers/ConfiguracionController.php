<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Exportcliente;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function updateExportCliente()
    {
        set_time_limit(300);
        $totalCount = Cliente::count();
        Cliente::orderBy('id')->limit(2000)->get()->each(function ($value) {
            // Cliente::orderBy('id')->skip(2000)->take(2000)->get()->each(function ($value) {
            // Cliente::orderBy('id')->skip(4000)->take(2000)->get()->each(function ($value) {
            // Cliente::orderBy('id')->skip(6000)->take(2000)->get()->each(function ($value) {
            // Cliente::orderBy('id')->skip(8000)->take(2000)->get()->each(function ($value) {
            // if ($totalCount > 10000) {
            // Cliente::orderBy('id')->skip(10000)->take($totalCount - 10000)->get()->each(function ($value) {
            // Ventas
            $ventas = $value->ventas->last();
            $m_cant = 0;
            $m_carf = 0;
            $f_cant = 0;
            $f_carf = 0;
            $a_cant = 0;
            $a_carf = 0;
            if ($ventas) {
                // 2 = movil, 3 = fija, 4 = avanzada
                foreach ($ventas->productos as $item) {
                    if ($item->categoria_id === 2) {
                        $m_cant += $item->pivot->cantidad;
                        $m_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 3) {
                        $f_cant += $item->pivot->cantidad;
                        $f_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 4) {
                        $a_cant += $item->pivot->cantidad;
                        $a_carf += $item->pivot->total;
                    }
                }
            }

            // productos
            $ingresos = 0;
            $precio = 0;
            $qLinea = 0;
            $producto = '';
            $tipo = '';
            if (isset($value->ventas->last()->productos)) {
                $venta = $value->ventas->last();
                $ingresos = $venta->total;
                $producto = $venta->productos->first()->categoria->nombre ?? '';
                $tipo = $venta->productos->first()->nombre ?? '';
                foreach ($venta->productos as $item_produc) {
                    $precio += $item_produc->pivot->precio;
                    $qLinea += $item_produc->pivot->cantidad;
                }
            }

            // Comentarios
            $comentarios = $value->comentarios()->latest()->take(5)->get();
            $comentariosArray = $comentarios->toArray();
            $textoPredeterminado = '';
            while (count($comentariosArray) < 5) {
                $comentariosArray[] = ['comentario' => $textoPredeterminado];
            }

            $exportCliente = new Exportcliente;
            $exportCliente->ruc = $value->ruc;
            $exportCliente->razon_social = $value->razon_social;
            $exportCliente->ciudad = $value->ciudad;
            $exportCliente->fecha_creacion = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_blindaje = now()->format('Y-m-d');
            $exportCliente->fecha_primer_contacto = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_ultimo_contacto = date('Y-m-d', strtotime($value->fecha_gestion));
            $exportCliente->fecha_proximo_contacto = now()->format('Y-m-d');
            $exportCliente->direccion_instalacion = '';
            $exportCliente->producto = $tipo;
            $exportCliente->producto_ultimo_registro = $tipo;
            $exportCliente->producto_categoria = $producto;
            $exportCliente->producto_total_cantidad = $qLinea;
            $exportCliente->producto_total_precio = $precio;
            $exportCliente->producto_total_total = $ingresos;
            $exportCliente->producto_categoria_1 = $m_cant;
            $exportCliente->producto_categoria_1_total = $m_carf;
            $exportCliente->producto_categoria_2 = $f_cant;
            $exportCliente->producto_categoria_2_total = $f_carf;
            $exportCliente->producto_categoria_3 = $a_cant;
            $exportCliente->producto_categoria_3_total = $a_carf;
            $exportCliente->producto_categoria_4 = '0';
            $exportCliente->producto_categoria_4_total = '0';
            $exportCliente->contacto = $value->contactos->last()->nombre ?? '';
            $exportCliente->contacto_dni = $value->contactos->last()->dni ?? '';
            $exportCliente->contacto_cargo = $value->contactos->last()->cargo ?? '';
            $exportCliente->contacto_email = $value->contactos->last()->correo ?? '';
            $exportCliente->contacto_celular = $value->contactos->last()->celular ?? '';
            $exportCliente->ejecutivo = $value->user->name;
            $exportCliente->ejecutivo_equipo = $value->equipo->nombre;
            $exportCliente->ejecutivo_sede = $value->sede->nombre;
            $exportCliente->etapa = $value->etapa->nombre;
            $exportCliente->etapa_blindaje = $value->etapa->blindaje;
            $exportCliente->etapa_avance = $value->etapa->avance;
            $exportCliente->etapa_probabilidad = $value->etapa->probabilidad;
            $exportCliente->comentario_5 = $comentariosArray[0]['comentario'];
            $exportCliente->comentario_4 = $comentariosArray[1]['comentario'];
            $exportCliente->comentario_3 = $comentariosArray[2]['comentario'];
            $exportCliente->comentario_2 = $comentariosArray[3]['comentario'];
            $exportCliente->comentario_1 = $comentariosArray[4]['comentario'];
            $exportCliente->estado_wick = $value->movistars->last()->estadowick->nombre ?? '';
            $exportCliente->estado_dito = $value->movistars->last()->estadodito->nombre ?? '';
            $exportCliente->lineas_claro = $value->movistars->last()->linea_claro ?? '0';
            $exportCliente->lineas_entel = $value->movistars->last()->linea_entel ?? '0';
            $exportCliente->lineas_bitel = $value->movistars->last()->linea_bitel ?? '0';
            $exportCliente->lineas_movistar = $value->movistars->last()->linea_movistar ?? '0';
            $exportCliente->cliente_tipo = $value->movistars->last()->clientetipo->nombre ?? '';
            $exportCliente->agencia = $value->movistars->last()->agencia->nombre ?? '';
            $exportCliente->cliente_id = $value->id;
            $exportCliente->save();
        });
        // }
        dd('Se ha actualizado correctamente');
    }

    public function updateUno()
    {
        set_time_limit(300);
        Cliente::orderBy('id')->limit(2000)->get()->each(function ($value) {
            $ventas = $value->ventas->last();
            $m_cant = 0;
            $m_carf = 0;
            $f_cant = 0;
            $f_carf = 0;
            $a_cant = 0;
            $a_carf = 0;
            if ($ventas) {
                // 2 = movil, 3 = fija, 4 = avanzada
                foreach ($ventas->productos as $item) {
                    if ($item->categoria_id === 2) {
                        $m_cant += $item->pivot->cantidad;
                        $m_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 3) {
                        $f_cant += $item->pivot->cantidad;
                        $f_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 4) {
                        $a_cant += $item->pivot->cantidad;
                        $a_carf += $item->pivot->total;
                    }
                }
            }

            // productos
            $ingresos = 0;
            $precio = 0;
            $qLinea = 0;
            $producto = '';
            $tipo = '';
            $venta_id = 0;
            if (isset($value->ventas->last()->productos)) {
                $venta = $value->ventas->last();
                $venta_id = $venta->id;
                $ingresos = $venta->total;
                $producto = $venta->productos->first()->categoria->nombre ?? '';
                $tipo = $venta->productos->first()->nombre ?? '';
                foreach ($venta->productos as $item_produc) {
                    $precio += $item_produc->pivot->precio;
                    $qLinea += $item_produc->pivot->cantidad;
                }
            }

            // Comentarios
            $comentarios = $value->comentarios()->latest()->take(5)->get();
            $comentariosArray = $comentarios->toArray();
            $textoPredeterminado = '';
            while (count($comentariosArray) < 5) {
                $comentariosArray[] = ['comentario' => $textoPredeterminado];
            }

            $exportCliente = new Exportcliente;
            $exportCliente->ruc = $value->ruc;
            $exportCliente->razon_social = $value->razon_social;
            $exportCliente->ciudad = $value->ciudad;
            $exportCliente->fecha_creacion = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_blindaje = now()->format('Y-m-d');
            $exportCliente->fecha_primer_contacto = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_ultimo_contacto = date('Y-m-d', strtotime($value->fecha_gestion));
            $exportCliente->fecha_proximo_contacto = now()->format('Y-m-d');
            $exportCliente->direccion_instalacion = '';
            $exportCliente->producto = $tipo;
            $exportCliente->producto_ultimo_registro = $tipo;
            $exportCliente->producto_categoria = $producto;
            $exportCliente->producto_total_cantidad = $qLinea;
            $exportCliente->producto_total_precio = $precio;
            $exportCliente->producto_total_total = $ingresos;
            $exportCliente->producto_categoria_1 = $m_cant;
            $exportCliente->producto_categoria_1_total = $m_carf;
            $exportCliente->producto_categoria_2 = $f_cant;
            $exportCliente->producto_categoria_2_total = $f_carf;
            $exportCliente->producto_categoria_3 = $a_cant;
            $exportCliente->producto_categoria_3_total = $a_carf;
            $exportCliente->producto_categoria_4 = '0';
            $exportCliente->producto_categoria_4_total = '0';
            $exportCliente->contacto = $value->contactos->last()->nombre ?? '';
            $exportCliente->contacto_dni = $value->contactos->last()->dni ?? '';
            $exportCliente->contacto_cargo = $value->contactos->last()->cargo ?? '';
            $exportCliente->contacto_email = $value->contactos->last()->correo ?? '';
            $exportCliente->contacto_celular = $value->contactos->last()->celular ?? '';
            $exportCliente->ejecutivo = $value->user->name;
            $exportCliente->ejecutivo_equipo = $value->equipo->nombre;
            $exportCliente->ejecutivo_sede = $value->sede->nombre;
            $exportCliente->etapa = $value->etapa->nombre;
            $exportCliente->etapa_blindaje = $value->etapa->blindaje;
            $exportCliente->etapa_avance = $value->etapa->avance;
            $exportCliente->etapa_probabilidad = $value->etapa->probabilidad;
            $exportCliente->comentario_5 = $comentariosArray[0]['comentario'];
            $exportCliente->comentario_4 = $comentariosArray[1]['comentario'];
            $exportCliente->comentario_3 = $comentariosArray[2]['comentario'];
            $exportCliente->comentario_2 = $comentariosArray[3]['comentario'];
            $exportCliente->comentario_1 = $comentariosArray[4]['comentario'];
            $exportCliente->estado_wick = $value->movistars->last()->estadowick->nombre ?? '';
            $exportCliente->estado_dito = $value->movistars->last()->estadodito->nombre ?? '';
            $exportCliente->lineas_claro = $value->movistars->last()->linea_claro ?? '0';
            $exportCliente->lineas_entel = $value->movistars->last()->linea_entel ?? '0';
            $exportCliente->lineas_bitel = $value->movistars->last()->linea_bitel ?? '0';
            $exportCliente->lineas_movistar = $value->movistars->last()->linea_movistar ?? '0';
            $exportCliente->cliente_tipo = $value->movistars->last()->clientetipo->nombre ?? '';
            $exportCliente->agencia = $value->movistars->last()->agencia->nombre ?? '';
            $exportCliente->cliente_id = $value->id;
            $exportCliente->venta_id = $venta_id;
            $exportCliente->ejecutivo_id = $value->user->id;
            $exportCliente->ejecutivo_equipo_id = $value->equipo->id;
            $exportCliente->ejecutivo_sede_id = $value->sede->id;
            $exportCliente->etapa_id = $value->etapa->id;
            $exportCliente->save();
        });
        dd('Se ha actualizado 1');
    }

    public function updateDos()
    {
        set_time_limit(300);
        Cliente::orderBy('id')->skip(2000)->take(2000)->get()->each(function ($value) {
            $ventas = $value->ventas->last();
            $m_cant = 0;
            $m_carf = 0;
            $f_cant = 0;
            $f_carf = 0;
            $a_cant = 0;
            $a_carf = 0;
            if ($ventas) {
                // 2 = movil, 3 = fija, 4 = avanzada
                foreach ($ventas->productos as $item) {
                    if ($item->categoria_id === 2) {
                        $m_cant += $item->pivot->cantidad;
                        $m_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 3) {
                        $f_cant += $item->pivot->cantidad;
                        $f_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 4) {
                        $a_cant += $item->pivot->cantidad;
                        $a_carf += $item->pivot->total;
                    }
                }
            }

            // productos
            $ingresos = 0;
            $precio = 0;
            $qLinea = 0;
            $producto = '';
            $tipo = '';
            $venta_id = 0;
            if (isset($value->ventas->last()->productos)) {
                $venta = $value->ventas->last();
                $venta_id = $venta->id;
                $ingresos = $venta->total;
                $producto = $venta->productos->first()->categoria->nombre ?? '';
                $tipo = $venta->productos->first()->nombre ?? '';
                foreach ($venta->productos as $item_produc) {
                    $precio += $item_produc->pivot->precio;
                    $qLinea += $item_produc->pivot->cantidad;
                }
            }

            // Comentarios
            $comentarios = $value->comentarios()->latest()->take(5)->get();
            $comentariosArray = $comentarios->toArray();
            $textoPredeterminado = '';
            while (count($comentariosArray) < 5) {
                $comentariosArray[] = ['comentario' => $textoPredeterminado];
            }

            $exportCliente = new Exportcliente;
            $exportCliente->ruc = $value->ruc;
            $exportCliente->razon_social = $value->razon_social;
            $exportCliente->ciudad = $value->ciudad;
            $exportCliente->fecha_creacion = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_blindaje = now()->format('Y-m-d');
            $exportCliente->fecha_primer_contacto = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_ultimo_contacto = date('Y-m-d', strtotime($value->fecha_gestion));
            $exportCliente->fecha_proximo_contacto = now()->format('Y-m-d');
            $exportCliente->direccion_instalacion = '';
            $exportCliente->producto = $tipo;
            $exportCliente->producto_ultimo_registro = $tipo;
            $exportCliente->producto_categoria = $producto;
            $exportCliente->producto_total_cantidad = $qLinea;
            $exportCliente->producto_total_precio = $precio;
            $exportCliente->producto_total_total = $ingresos;
            $exportCliente->producto_categoria_1 = $m_cant;
            $exportCliente->producto_categoria_1_total = $m_carf;
            $exportCliente->producto_categoria_2 = $f_cant;
            $exportCliente->producto_categoria_2_total = $f_carf;
            $exportCliente->producto_categoria_3 = $a_cant;
            $exportCliente->producto_categoria_3_total = $a_carf;
            $exportCliente->producto_categoria_4 = '0';
            $exportCliente->producto_categoria_4_total = '0';
            $exportCliente->contacto = $value->contactos->last()->nombre ?? '';
            $exportCliente->contacto_dni = $value->contactos->last()->dni ?? '';
            $exportCliente->contacto_cargo = $value->contactos->last()->cargo ?? '';
            $exportCliente->contacto_email = $value->contactos->last()->correo ?? '';
            $exportCliente->contacto_celular = $value->contactos->last()->celular ?? '';
            $exportCliente->ejecutivo = $value->user->name;
            $exportCliente->ejecutivo_equipo = $value->equipo->nombre;
            $exportCliente->ejecutivo_sede = $value->sede->nombre;
            $exportCliente->etapa = $value->etapa->nombre;
            $exportCliente->etapa_blindaje = $value->etapa->blindaje;
            $exportCliente->etapa_avance = $value->etapa->avance;
            $exportCliente->etapa_probabilidad = $value->etapa->probabilidad;
            $exportCliente->comentario_5 = $comentariosArray[0]['comentario'];
            $exportCliente->comentario_4 = $comentariosArray[1]['comentario'];
            $exportCliente->comentario_3 = $comentariosArray[2]['comentario'];
            $exportCliente->comentario_2 = $comentariosArray[3]['comentario'];
            $exportCliente->comentario_1 = $comentariosArray[4]['comentario'];
            $exportCliente->estado_wick = $value->movistars->last()->estadowick->nombre ?? '';
            $exportCliente->estado_dito = $value->movistars->last()->estadodito->nombre ?? '';
            $exportCliente->lineas_claro = $value->movistars->last()->linea_claro ?? '0';
            $exportCliente->lineas_entel = $value->movistars->last()->linea_entel ?? '0';
            $exportCliente->lineas_bitel = $value->movistars->last()->linea_bitel ?? '0';
            $exportCliente->lineas_movistar = $value->movistars->last()->linea_movistar ?? '0';
            $exportCliente->cliente_tipo = $value->movistars->last()->clientetipo->nombre ?? '';
            $exportCliente->agencia = $value->movistars->last()->agencia->nombre ?? '';
            $exportCliente->cliente_id = $value->id;
            $exportCliente->venta_id = $venta_id;
            $exportCliente->ejecutivo_id = $value->user->id;
            $exportCliente->ejecutivo_equipo_id = $value->equipo->id;
            $exportCliente->ejecutivo_sede_id = $value->sede->id;
            $exportCliente->etapa_id = $value->etapa->id;
            $exportCliente->save();
        });
        dd('Se ha actualizado 2');
    }

    public function updateTres()
    {
        set_time_limit(300);
        Cliente::orderBy('id')->skip(4000)->take(2000)->get()->each(function ($value) {
            $ventas = $value->ventas->last();
            $m_cant = 0;
            $m_carf = 0;
            $f_cant = 0;
            $f_carf = 0;
            $a_cant = 0;
            $a_carf = 0;
            if ($ventas) {
                // 2 = movil, 3 = fija, 4 = avanzada
                foreach ($ventas->productos as $item) {
                    if ($item->categoria_id === 2) {
                        $m_cant += $item->pivot->cantidad;
                        $m_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 3) {
                        $f_cant += $item->pivot->cantidad;
                        $f_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 4) {
                        $a_cant += $item->pivot->cantidad;
                        $a_carf += $item->pivot->total;
                    }
                }
            }

            // productos
            $ingresos = 0;
            $precio = 0;
            $qLinea = 0;
            $producto = '';
            $tipo = '';
            $venta_id = 0;
            if (isset($value->ventas->last()->productos)) {
                $venta = $value->ventas->last();
                $venta_id = $venta->id;
                $ingresos = $venta->total;
                $producto = $venta->productos->first()->categoria->nombre ?? '';
                $tipo = $venta->productos->first()->nombre ?? '';
                foreach ($venta->productos as $item_produc) {
                    $precio += $item_produc->pivot->precio;
                    $qLinea += $item_produc->pivot->cantidad;
                }
            }

            // Comentarios
            $comentarios = $value->comentarios()->latest()->take(5)->get();
            $comentariosArray = $comentarios->toArray();
            $textoPredeterminado = '';
            while (count($comentariosArray) < 5) {
                $comentariosArray[] = ['comentario' => $textoPredeterminado];
            }

            $exportCliente = new Exportcliente;
            $exportCliente->ruc = $value->ruc;
            $exportCliente->razon_social = $value->razon_social;
            $exportCliente->ciudad = $value->ciudad;
            $exportCliente->fecha_creacion = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_blindaje = now()->format('Y-m-d');
            $exportCliente->fecha_primer_contacto = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_ultimo_contacto = date('Y-m-d', strtotime($value->fecha_gestion));
            $exportCliente->fecha_proximo_contacto = now()->format('Y-m-d');
            $exportCliente->direccion_instalacion = '';
            $exportCliente->producto = $tipo;
            $exportCliente->producto_ultimo_registro = $tipo;
            $exportCliente->producto_categoria = $producto;
            $exportCliente->producto_total_cantidad = $qLinea;
            $exportCliente->producto_total_precio = $precio;
            $exportCliente->producto_total_total = $ingresos;
            $exportCliente->producto_categoria_1 = $m_cant;
            $exportCliente->producto_categoria_1_total = $m_carf;
            $exportCliente->producto_categoria_2 = $f_cant;
            $exportCliente->producto_categoria_2_total = $f_carf;
            $exportCliente->producto_categoria_3 = $a_cant;
            $exportCliente->producto_categoria_3_total = $a_carf;
            $exportCliente->producto_categoria_4 = '0';
            $exportCliente->producto_categoria_4_total = '0';
            $exportCliente->contacto = $value->contactos->last()->nombre ?? '';
            $exportCliente->contacto_dni = $value->contactos->last()->dni ?? '';
            $exportCliente->contacto_cargo = $value->contactos->last()->cargo ?? '';
            $exportCliente->contacto_email = $value->contactos->last()->correo ?? '';
            $exportCliente->contacto_celular = $value->contactos->last()->celular ?? '';
            $exportCliente->ejecutivo = $value->user->name;
            $exportCliente->ejecutivo_equipo = $value->equipo->nombre;
            $exportCliente->ejecutivo_sede = $value->sede->nombre;
            $exportCliente->etapa = $value->etapa->nombre;
            $exportCliente->etapa_blindaje = $value->etapa->blindaje;
            $exportCliente->etapa_avance = $value->etapa->avance;
            $exportCliente->etapa_probabilidad = $value->etapa->probabilidad;
            $exportCliente->comentario_5 = $comentariosArray[0]['comentario'];
            $exportCliente->comentario_4 = $comentariosArray[1]['comentario'];
            $exportCliente->comentario_3 = $comentariosArray[2]['comentario'];
            $exportCliente->comentario_2 = $comentariosArray[3]['comentario'];
            $exportCliente->comentario_1 = $comentariosArray[4]['comentario'];
            $exportCliente->estado_wick = $value->movistars->last()->estadowick->nombre ?? '';
            $exportCliente->estado_dito = $value->movistars->last()->estadodito->nombre ?? '';
            $exportCliente->lineas_claro = $value->movistars->last()->linea_claro ?? '0';
            $exportCliente->lineas_entel = $value->movistars->last()->linea_entel ?? '0';
            $exportCliente->lineas_bitel = $value->movistars->last()->linea_bitel ?? '0';
            $exportCliente->lineas_movistar = $value->movistars->last()->linea_movistar ?? '0';
            $exportCliente->cliente_tipo = $value->movistars->last()->clientetipo->nombre ?? '';
            $exportCliente->agencia = $value->movistars->last()->agencia->nombre ?? '';
            $exportCliente->cliente_id = $value->id;
            $exportCliente->venta_id = $venta_id;
            $exportCliente->ejecutivo_id = $value->user->id;
            $exportCliente->ejecutivo_equipo_id = $value->equipo->id;
            $exportCliente->ejecutivo_sede_id = $value->sede->id;
            $exportCliente->etapa_id = $value->etapa->id;
            $exportCliente->save();
        });
        dd('Se ha actualizado 3');
    }

    public function updateCuatro()
    {
        set_time_limit(300);
        Cliente::orderBy('id')->skip(6000)->take(2000)->get()->each(function ($value) {
            $ventas = $value->ventas->last();
            $m_cant = 0;
            $m_carf = 0;
            $f_cant = 0;
            $f_carf = 0;
            $a_cant = 0;
            $a_carf = 0;
            if ($ventas) {
                // 2 = movil, 3 = fija, 4 = avanzada
                foreach ($ventas->productos as $item) {
                    if ($item->categoria_id === 2) {
                        $m_cant += $item->pivot->cantidad;
                        $m_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 3) {
                        $f_cant += $item->pivot->cantidad;
                        $f_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 4) {
                        $a_cant += $item->pivot->cantidad;
                        $a_carf += $item->pivot->total;
                    }
                }
            }

            // productos
            $ingresos = 0;
            $precio = 0;
            $qLinea = 0;
            $producto = '';
            $tipo = '';
            $venta_id = 0;
            if (isset($value->ventas->last()->productos)) {
                $venta = $value->ventas->last();
                $venta_id = $venta->id;
                $ingresos = $venta->total;
                $producto = $venta->productos->first()->categoria->nombre ?? '';
                $tipo = $venta->productos->first()->nombre ?? '';
                foreach ($venta->productos as $item_produc) {
                    $precio += $item_produc->pivot->precio;
                    $qLinea += $item_produc->pivot->cantidad;
                }
            }

            // Comentarios
            $comentarios = $value->comentarios()->latest()->take(5)->get();
            $comentariosArray = $comentarios->toArray();
            $textoPredeterminado = '';
            while (count($comentariosArray) < 5) {
                $comentariosArray[] = ['comentario' => $textoPredeterminado];
            }

            $exportCliente = new Exportcliente;
            $exportCliente->ruc = $value->ruc;
            $exportCliente->razon_social = $value->razon_social;
            $exportCliente->ciudad = $value->ciudad;
            $exportCliente->fecha_creacion = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_blindaje = now()->format('Y-m-d');
            $exportCliente->fecha_primer_contacto = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_ultimo_contacto = date('Y-m-d', strtotime($value->fecha_gestion));
            $exportCliente->fecha_proximo_contacto = now()->format('Y-m-d');
            $exportCliente->direccion_instalacion = '';
            $exportCliente->producto = $tipo;
            $exportCliente->producto_ultimo_registro = $tipo;
            $exportCliente->producto_categoria = $producto;
            $exportCliente->producto_total_cantidad = $qLinea;
            $exportCliente->producto_total_precio = $precio;
            $exportCliente->producto_total_total = $ingresos;
            $exportCliente->producto_categoria_1 = $m_cant;
            $exportCliente->producto_categoria_1_total = $m_carf;
            $exportCliente->producto_categoria_2 = $f_cant;
            $exportCliente->producto_categoria_2_total = $f_carf;
            $exportCliente->producto_categoria_3 = $a_cant;
            $exportCliente->producto_categoria_3_total = $a_carf;
            $exportCliente->producto_categoria_4 = '0';
            $exportCliente->producto_categoria_4_total = '0';
            $exportCliente->contacto = $value->contactos->last()->nombre ?? '';
            $exportCliente->contacto_dni = $value->contactos->last()->dni ?? '';
            $exportCliente->contacto_cargo = $value->contactos->last()->cargo ?? '';
            $exportCliente->contacto_email = $value->contactos->last()->correo ?? '';
            $exportCliente->contacto_celular = $value->contactos->last()->celular ?? '';
            $exportCliente->ejecutivo = $value->user->name;
            $exportCliente->ejecutivo_equipo = $value->equipo->nombre;
            $exportCliente->ejecutivo_sede = $value->sede->nombre;
            $exportCliente->etapa = $value->etapa->nombre;
            $exportCliente->etapa_blindaje = $value->etapa->blindaje;
            $exportCliente->etapa_avance = $value->etapa->avance;
            $exportCliente->etapa_probabilidad = $value->etapa->probabilidad;
            $exportCliente->comentario_5 = $comentariosArray[0]['comentario'];
            $exportCliente->comentario_4 = $comentariosArray[1]['comentario'];
            $exportCliente->comentario_3 = $comentariosArray[2]['comentario'];
            $exportCliente->comentario_2 = $comentariosArray[3]['comentario'];
            $exportCliente->comentario_1 = $comentariosArray[4]['comentario'];
            $exportCliente->estado_wick = $value->movistars->last()->estadowick->nombre ?? '';
            $exportCliente->estado_dito = $value->movistars->last()->estadodito->nombre ?? '';
            $exportCliente->lineas_claro = $value->movistars->last()->linea_claro ?? '0';
            $exportCliente->lineas_entel = $value->movistars->last()->linea_entel ?? '0';
            $exportCliente->lineas_bitel = $value->movistars->last()->linea_bitel ?? '0';
            $exportCliente->lineas_movistar = $value->movistars->last()->linea_movistar ?? '0';
            $exportCliente->cliente_tipo = $value->movistars->last()->clientetipo->nombre ?? '';
            $exportCliente->agencia = $value->movistars->last()->agencia->nombre ?? '';
            $exportCliente->cliente_id = $value->id;
            $exportCliente->venta_id = $venta_id;
            $exportCliente->ejecutivo_id = $value->user->id;
            $exportCliente->ejecutivo_equipo_id = $value->equipo->id;
            $exportCliente->ejecutivo_sede_id = $value->sede->id;
            $exportCliente->etapa_id = $value->etapa->id;
            $exportCliente->save();
        });
        dd('Se ha actualizado 4');
    }

    public function updateCinco()
    {
        set_time_limit(300);
        Cliente::orderBy('id')->skip(8000)->take(2000)->get()->each(function ($value) {
            $ventas = $value->ventas->last();
            $m_cant = 0;
            $m_carf = 0;
            $f_cant = 0;
            $f_carf = 0;
            $a_cant = 0;
            $a_carf = 0;
            if ($ventas) {
                // 2 = movil, 3 = fija, 4 = avanzada
                foreach ($ventas->productos as $item) {
                    if ($item->categoria_id === 2) {
                        $m_cant += $item->pivot->cantidad;
                        $m_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 3) {
                        $f_cant += $item->pivot->cantidad;
                        $f_carf += $item->pivot->total;
                    } elseif ($item->categoria_id === 4) {
                        $a_cant += $item->pivot->cantidad;
                        $a_carf += $item->pivot->total;
                    }
                }
            }

            // productos
            $ingresos = 0;
            $precio = 0;
            $qLinea = 0;
            $producto = '';
            $tipo = '';
            $venta_id = 0;
            if (isset($value->ventas->last()->productos)) {
                $venta = $value->ventas->last();
                $venta_id = $venta->id;
                $ingresos = $venta->total;
                $producto = $venta->productos->first()->categoria->nombre ?? '';
                $tipo = $venta->productos->first()->nombre ?? '';
                foreach ($venta->productos as $item_produc) {
                    $precio += $item_produc->pivot->precio;
                    $qLinea += $item_produc->pivot->cantidad;
                }
            }

            // Comentarios
            $comentarios = $value->comentarios()->latest()->take(5)->get();
            $comentariosArray = $comentarios->toArray();
            $textoPredeterminado = '';
            while (count($comentariosArray) < 5) {
                $comentariosArray[] = ['comentario' => $textoPredeterminado];
            }

            $exportCliente = new Exportcliente;
            $exportCliente->ruc = $value->ruc;
            $exportCliente->razon_social = $value->razon_social;
            $exportCliente->ciudad = $value->ciudad;
            $exportCliente->fecha_creacion = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_blindaje = now()->format('Y-m-d');
            $exportCliente->fecha_primer_contacto = $value->created_at->format('Y-m-d');
            $exportCliente->fecha_ultimo_contacto = date('Y-m-d', strtotime($value->fecha_gestion));
            $exportCliente->fecha_proximo_contacto = now()->format('Y-m-d');
            $exportCliente->direccion_instalacion = '';
            $exportCliente->producto = $tipo;
            $exportCliente->producto_ultimo_registro = $tipo;
            $exportCliente->producto_categoria = $producto;
            $exportCliente->producto_total_cantidad = $qLinea;
            $exportCliente->producto_total_precio = $precio;
            $exportCliente->producto_total_total = $ingresos;
            $exportCliente->producto_categoria_1 = $m_cant;
            $exportCliente->producto_categoria_1_total = $m_carf;
            $exportCliente->producto_categoria_2 = $f_cant;
            $exportCliente->producto_categoria_2_total = $f_carf;
            $exportCliente->producto_categoria_3 = $a_cant;
            $exportCliente->producto_categoria_3_total = $a_carf;
            $exportCliente->producto_categoria_4 = '0';
            $exportCliente->producto_categoria_4_total = '0';
            $exportCliente->contacto = $value->contactos->last()->nombre ?? '';
            $exportCliente->contacto_dni = $value->contactos->last()->dni ?? '';
            $exportCliente->contacto_cargo = $value->contactos->last()->cargo ?? '';
            $exportCliente->contacto_email = $value->contactos->last()->correo ?? '';
            $exportCliente->contacto_celular = $value->contactos->last()->celular ?? '';
            $exportCliente->ejecutivo = $value->user->name;
            $exportCliente->ejecutivo_equipo = $value->equipo->nombre;
            $exportCliente->ejecutivo_sede = $value->sede->nombre;
            $exportCliente->etapa = $value->etapa->nombre;
            $exportCliente->etapa_blindaje = $value->etapa->blindaje;
            $exportCliente->etapa_avance = $value->etapa->avance;
            $exportCliente->etapa_probabilidad = $value->etapa->probabilidad;
            $exportCliente->comentario_5 = $comentariosArray[0]['comentario'];
            $exportCliente->comentario_4 = $comentariosArray[1]['comentario'];
            $exportCliente->comentario_3 = $comentariosArray[2]['comentario'];
            $exportCliente->comentario_2 = $comentariosArray[3]['comentario'];
            $exportCliente->comentario_1 = $comentariosArray[4]['comentario'];
            $exportCliente->estado_wick = $value->movistars->last()->estadowick->nombre ?? '';
            $exportCliente->estado_dito = $value->movistars->last()->estadodito->nombre ?? '';
            $exportCliente->lineas_claro = $value->movistars->last()->linea_claro ?? '0';
            $exportCliente->lineas_entel = $value->movistars->last()->linea_entel ?? '0';
            $exportCliente->lineas_bitel = $value->movistars->last()->linea_bitel ?? '0';
            $exportCliente->lineas_movistar = $value->movistars->last()->linea_movistar ?? '0';
            $exportCliente->cliente_tipo = $value->movistars->last()->clientetipo->nombre ?? '';
            $exportCliente->agencia = $value->movistars->last()->agencia->nombre ?? '';
            $exportCliente->cliente_id = $value->id;
            $exportCliente->venta_id = $venta_id;
            $exportCliente->ejecutivo_id = $value->user->id;
            $exportCliente->ejecutivo_equipo_id = $value->equipo->id;
            $exportCliente->ejecutivo_sede_id = $value->sede->id;
            $exportCliente->etapa_id = $value->etapa->id;
            $exportCliente->save();
        });
        dd('Se ha actualizado 5');
    }

    public function updateSeis()
    {
        set_time_limit(300);
        $totalCount = Cliente::count();
        if ($totalCount > 10000) {
            Cliente::orderBy('id')->skip(10000)->take($totalCount - 10000)->get()->each(function ($value) {
                $ventas = $value->ventas->last();
                $m_cant = 0;
                $m_carf = 0;
                $f_cant = 0;
                $f_carf = 0;
                $a_cant = 0;
                $a_carf = 0;
                if ($ventas) {
                    // 2 = movil, 3 = fija, 4 = avanzada
                    foreach ($ventas->productos as $item) {
                        if ($item->categoria_id === 2) {
                            $m_cant += $item->pivot->cantidad;
                            $m_carf += $item->pivot->total;
                        } elseif ($item->categoria_id === 3) {
                            $f_cant += $item->pivot->cantidad;
                            $f_carf += $item->pivot->total;
                        } elseif ($item->categoria_id === 4) {
                            $a_cant += $item->pivot->cantidad;
                            $a_carf += $item->pivot->total;
                        }
                    }
                }

                // productos
                $ingresos = 0;
                $precio = 0;
                $qLinea = 0;
                $producto = '';
                $tipo = '';
                $venta_id = 0;
                if (isset($value->ventas->last()->productos)) {
                    $venta = $value->ventas->last();
                    $venta_id = $venta->id;
                    $ingresos = $venta->total;
                    $producto = $venta->productos->first()->categoria->nombre ?? '';
                    $tipo = $venta->productos->first()->nombre ?? '';
                    foreach ($venta->productos as $item_produc) {
                        $precio += $item_produc->pivot->precio;
                        $qLinea += $item_produc->pivot->cantidad;
                    }
                }

                // Comentarios
                $comentarios = $value->comentarios()->latest()->take(5)->get();
                $comentariosArray = $comentarios->toArray();
                $textoPredeterminado = '';
                while (count($comentariosArray) < 5) {
                    $comentariosArray[] = ['comentario' => $textoPredeterminado];
                }

                $exportCliente = new Exportcliente;
                $exportCliente->ruc = $value->ruc;
                $exportCliente->razon_social = $value->razon_social;
                $exportCliente->ciudad = $value->ciudad;
                $exportCliente->fecha_creacion = $value->created_at->format('Y-m-d');
                $exportCliente->fecha_blindaje = now()->format('Y-m-d');
                $exportCliente->fecha_primer_contacto = $value->created_at->format('Y-m-d');
                $exportCliente->fecha_ultimo_contacto = date('Y-m-d', strtotime($value->fecha_gestion));
                $exportCliente->fecha_proximo_contacto = now()->format('Y-m-d');
                $exportCliente->direccion_instalacion = '';
                $exportCliente->producto = $tipo;
                $exportCliente->producto_ultimo_registro = $tipo;
                $exportCliente->producto_categoria = $producto;
                $exportCliente->producto_total_cantidad = $qLinea;
                $exportCliente->producto_total_precio = $precio;
                $exportCliente->producto_total_total = $ingresos;
                $exportCliente->producto_categoria_1 = $m_cant;
                $exportCliente->producto_categoria_1_total = $m_carf;
                $exportCliente->producto_categoria_2 = $f_cant;
                $exportCliente->producto_categoria_2_total = $f_carf;
                $exportCliente->producto_categoria_3 = $a_cant;
                $exportCliente->producto_categoria_3_total = $a_carf;
                $exportCliente->producto_categoria_4 = '0';
                $exportCliente->producto_categoria_4_total = '0';
                $exportCliente->contacto = $value->contactos->last()->nombre ?? '';
                $exportCliente->contacto_dni = $value->contactos->last()->dni ?? '';
                $exportCliente->contacto_cargo = $value->contactos->last()->cargo ?? '';
                $exportCliente->contacto_email = $value->contactos->last()->correo ?? '';
                $exportCliente->contacto_celular = $value->contactos->last()->celular ?? '';
                $exportCliente->ejecutivo = $value->user->name;
                $exportCliente->ejecutivo_equipo = $value->equipo->nombre;
                $exportCliente->ejecutivo_sede = $value->sede->nombre;
                $exportCliente->etapa = $value->etapa->nombre;
                $exportCliente->etapa_blindaje = $value->etapa->blindaje;
                $exportCliente->etapa_avance = $value->etapa->avance;
                $exportCliente->etapa_probabilidad = $value->etapa->probabilidad;
                $exportCliente->comentario_5 = $comentariosArray[0]['comentario'];
                $exportCliente->comentario_4 = $comentariosArray[1]['comentario'];
                $exportCliente->comentario_3 = $comentariosArray[2]['comentario'];
                $exportCliente->comentario_2 = $comentariosArray[3]['comentario'];
                $exportCliente->comentario_1 = $comentariosArray[4]['comentario'];
                $exportCliente->estado_wick = $value->movistars->last()->estadowick->nombre ?? '';
                $exportCliente->estado_dito = $value->movistars->last()->estadodito->nombre ?? '';
                $exportCliente->lineas_claro = $value->movistars->last()->linea_claro ?? '0';
                $exportCliente->lineas_entel = $value->movistars->last()->linea_entel ?? '0';
                $exportCliente->lineas_bitel = $value->movistars->last()->linea_bitel ?? '0';
                $exportCliente->lineas_movistar = $value->movistars->last()->linea_movistar ?? '0';
                $exportCliente->cliente_tipo = $value->movistars->last()->clientetipo->nombre ?? '';
                $exportCliente->agencia = $value->movistars->last()->agencia->nombre ?? '';
                $exportCliente->cliente_id = $value->id;
                $exportCliente->venta_id = $venta_id;
                $exportCliente->ejecutivo_id = $value->user->id;
                $exportCliente->ejecutivo_equipo_id = $value->equipo->id;
                $exportCliente->ejecutivo_sede_id = $value->sede->id;
                $exportCliente->etapa_id = $value->etapa->id;
                $exportCliente->save();
            });
        }
        dd('Se ha actualizado 6');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = [
            [
                'title' => 'Sistema',
                'icon' => '<i class="fa-solid fa-planet-moon"></i>',
                'link' => 'configuracion-sistema',
            ],
            [
                'title' => 'Etapas',
                'icon' => '<i class="fa-solid fa-arrow-progress"></i>',
                'link' => 'configuracion-etapa',
            ],
            [
                'title' => 'Categorias',
                'icon' => '<i class="fa-solid fa-layer-group"></i>',
                'link' => 'configuracion-categoria',
            ],
            [
                'title' => 'Productos',
                'icon' => '<i class="fa-solid fa-cart-shopping"></i>',
                'link' => 'configuracion-producto',
            ],
            [
                'title' => 'Excel',
                'icon' => '<i class="fa-solid fa-file-excel"></i>',
                'link' => 'configuracion-excel',
            ],
            [
                'title' => 'Ficha del Cliente',
                'icon' => '<i class="fa-solid fa-database"></i>',
                'link' => 'configuracion-ficha-cliente',
            ],
        ];

        return view('sistema.configuracion.index', compact('links'));
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
    public function show(string $id)
    {
        //
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
