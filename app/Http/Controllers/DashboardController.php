<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\InventarioLog;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistroCaudal;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $modulo = "dashboard";

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //verificar si esta logueado el usuario
        if(!Auth::check()){return redirect('/');}

        $usuario = Auth::user();
        $ventas = Venta::all();
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $usuarios = Usuario::all();
        $titulo = "Panel General";

        $fecha_hoy = date('Y-m-d');
        $mes = date('m');
        $anio = date('Y');
        $ventas_anio = Venta::whereYear('ven_fecha_venta', $anio)->get();
        $ventas_mes = Venta::whereMonth('ven_fecha_venta', $mes)->get();
        $ventas_dia = Venta::whereDate('ven_fecha_venta', $fecha_hoy)->get();
        $clientes = Cliente::all();

        $total_ventas_dia = 0;
        $total_ventas_mes = 0;
        $total_ventas_anio = 0;
        foreach($ventas_dia as $item){
            $total_ventas_dia = $total_ventas_dia + $item->ven_total;
        }
        foreach($ventas_mes as $item){
            $total_ventas_mes = $total_ventas_mes + $item->ven_total;
        }
        foreach($ventas_anio as $item){
            $total_ventas_anio = $total_ventas_anio + $item->ven_total;
        }

        //obtener la salidas de inventario_log del mes actual
        $salidas = InventarioLog::where('ilo_tipo_movimiento', 'salida')
                        ->whereMonth('created_at', $mes)
                        ->whereYear('created_at', $anio)
                        ->count();
        //obtener la entradas de inventario_log del mes actual
        $entradas = InventarioLog::where('ilo_tipo_movimiento', 'entrada')
                        ->whereMonth('created_at', $mes)
                        ->whereYear('created_at', $anio)
                        ->count();

        //ventas ultimos 6 meses (muestra el nombre del mes y el total de ventas)
    $ventas_ultimos_6_meses = Venta::selectRaw('
            YEAR(ven_fecha_venta) as anio,
            MONTH(ven_fecha_venta) as mes_num,
            SUM(ven_total) as total_ventas
        ')
        ->whereBetween('ven_fecha_venta', [
            Carbon::now()->subMonths(5)->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])
        ->groupByRaw('YEAR(ven_fecha_venta), MONTH(ven_fecha_venta)')
        ->orderByRaw('YEAR(ven_fecha_venta) ASC, MONTH(ven_fecha_venta) ASC')
        ->get()
        ->map(function ($item) {
            $item->mes = Carbon::create()
                ->month($item->mes_num)
                ->locale('es')
                ->monthName;
            return $item;
        });

        //ventas ultimos 7 dias (muestra el nombre del dia y el total de ventas)
        $ventas_ultimos_7_dias = Venta::selectRaw('
                DATE(ven_fecha_venta) as fecha,
                SUM(ven_total) as total_ventas
            ')
            ->whereBetween('ven_fecha_venta', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->groupByRaw('DATE(ven_fecha_venta)')
            ->orderBy('fecha')
            ->get()
            ->map(function ($item) {
                $item->dia = Carbon::parse($item->fecha)
                    ->locale('es')
                    ->dayName;
                return $item;
            });            

        //obtener los entradas de inventario_log de los ultimos 6 meses
        $entradas_ultimos_6_meses = InventarioLog::selectRaw('
                YEAR(created_at) as anio,
                MONTH(created_at) as mes_num,
                COUNT(*) as total_entradas
            ')
            ->where('ilo_tipo_movimiento', 'entrada')
            ->whereBetween('created_at', [
                Carbon::now()->subMonths(5)->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at) ASC, MONTH(created_at) ASC')
            ->get()
            ->map(function ($item) {
                $item->mes = Carbon::create()
                    ->month($item->mes_num)
                    ->locale('es')
                    ->monthName;
                return $item;
            });

        //obtener las salidas de inventario_log de los ultimos 6 meses
        $salidas_ultimos_6_meses = InventarioLog::selectRaw('
                YEAR(created_at) as anio,
                MONTH(created_at) as mes_num,
                COUNT(*) as total_salidas
            ')
            ->where('ilo_tipo_movimiento', 'salida')
            ->whereBetween('created_at', [
                Carbon::now()->subMonths(5)->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at) ASC, MONTH(created_at) ASC')
            ->get()
            ->map(function ($item) {
                $item->mes = Carbon::create()
                    ->month($item->mes_num)
                    ->locale('es')
                    ->monthName;
                return $item;
            });


        return view('dashboard.detalle_tablero', [
                                                    'usuario'=>$usuario, 
                                                    'titulo'=>$titulo, 
                                                    'ventas'=>$ventas, 
                                                    'ventas_dia'=>$ventas_dia, 
                                                    'ventas_mes'=>$ventas_mes, 
                                                    'ventas_anio'=>$ventas_anio,
                                                    'ventas_6_meses'=>$ventas_ultimos_6_meses,
                                                    'ventas_7_dias'=>$ventas_ultimos_7_dias,
                                                    'clientes'=>$clientes,  
                                                    'entradas'=>$entradas, 
                                                    'salidas'=>$salidas, 
                                                    'entradas_6_meses'=>$entradas_ultimos_6_meses,
                                                    'salidas_6_meses'=>$salidas_ultimos_6_meses,
                                                    'total_ventas_dia'=>$total_ventas_dia,
                                                    'total_ventas_mes'=>$total_ventas_mes,
                                                    'total_ventas_anio'=>$total_ventas_anio,
                                                    'productos'=>$productos, 
                                                    'proveedores'=>$proveedores,
                                                    'usuarios'=>$usuarios,
                                                    'modulo_activo' => $this->modulo
                                                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
