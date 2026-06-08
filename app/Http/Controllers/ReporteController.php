<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\InventarioLog;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
//DB
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    private $modulo = "reportes";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //verificar si esta logueado el usuario
        // if(!Auth::check()){return redirect('/');}

        return view('reportes.lista_reportes', ['titulo'=>'Reportes',
                                                          'modulo_activo' => $this->modulo
                                                         ]);
    }

    //reporte de ventas mensual (VERSION PostgreSQL)
    public function rentabilidad(){
        $compras = DB::table('inventario_log as il')
            ->join('producto as p', 'il.pro_id', '=', 'p.pro_id')
            ->select(
                'il.pro_id',
                DB::raw('SUM(il.ilo_cantidad) as total_comprado'),
                DB::raw('SUM(il.ilo_cantidad * p.pro_precio_compra) as costo_total')
            )
            ->where('il.ilo_tipo_movimiento', 'entrada')
            // ->where('il.ilo_fuente', 'iot')
            ->groupBy('il.pro_id');

        $ventas = DB::table('detalle_venta as dv')
            ->join('producto as p', 'dv.pro_id', '=', 'p.pro_id')
            ->select(
                'dv.pro_id',
                DB::raw('SUM(dv.dve_cantidad::numeric) as total_vendido'),
                DB::raw('SUM(dv.dve_cantidad::numeric * p.pro_precio_venta::numeric) as ingresos'),
                DB::raw('SUM(dv.dve_cantidad::numeric * p.pro_precio_compra::numeric) as costo_ventas')
            )
            ->groupBy('dv.pro_id');

        $reporte = DB::table('producto as p')
            ->leftJoinSub($compras, 'c', 'p.pro_id', '=', 'c.pro_id')
            ->leftJoinSub($ventas, 'v', 'p.pro_id', '=', 'v.pro_id')
            ->select(
                'p.pro_nombre',
                'p.pro_precio_compra',
                'p.pro_precio_venta',
                // Compras
                DB::raw('COALESCE(c.total_comprado, 0) as total_comprado'),
                DB::raw('COALESCE(c.costo_total, 0) as costo_total_compras'),

                // Ventas
                DB::raw('COALESCE(v.total_vendido, 0) as total_vendido'),
                DB::raw('COALESCE(v.ingresos, 0) as ingresos'),

                // Costos y utilidad
                DB::raw('COALESCE(v.costo_ventas, 0) as costo_ventas'),
                DB::raw('COALESCE(v.ingresos - v.costo_ventas, 0) as utilidad')
            )
            ->get();        
        /* ======================================
        TOTALES GENERALES
        ====================================== */
        $total_comprado  = $reporte->sum('total_comprado');
        $total_vendido   = $reporte->sum('total_vendido');
        $total_ingresos  = $reporte->sum('ingresos');
        $total_costos    = $reporte->sum('costo_ventas');
        $total_utilidad  = $reporte->sum('utilidad');

        /* ======================================
        INDICADOR DE RENTABILIDAD
        ====================================== */
        $margen_utilidad = ($total_ingresos > 0)
            ? ($total_utilidad / $total_ingresos) * 100
            : 0;

    
        return view('reportes.reporte_rentabilidad', ['titulo'=>'Reporte de Rentabilidad',
                                                      'modulo_activo' => $this->modulo,
                                                      'reporte' => $reporte,
            // Totales
            'total_comprado' => $total_comprado,
            'total_vendido' => $total_vendido,
            'total_ingresos' => $total_ingresos,
            'total_costos' => $total_costos,
            'total_utilidad' => $total_utilidad,

            // Indicador
            'margen_utilidad' => $margen_utilidad
        ]);
    }

    // // //reporte de ventas mensual (VERSION MySQL)
    // public function rentabilidad()
    // {
    //     // Compras
    //     $compras = DB::table('inventario_log as il')
    //         ->join('producto as p', 'il.pro_id', '=', 'p.pro_id')
    //         ->select(
    //             'il.pro_id',
    //             DB::raw('SUM(il.ilo_cantidad) as total_comprado'),
    //             DB::raw('SUM(il.ilo_cantidad * p.pro_precio_compra) as costo_total')
    //         )
    //         ->where('il.ilo_tipo_movimiento', 'entrada')
    //         // ->where('il.ilo_fuente', 'iot')
    //         ->groupBy('il.pro_id');

    //     // Ventas (corregido para MySQL)
    //     $ventas = DB::table('detalle_venta as dv')
    //         ->join('producto as p', 'dv.pro_id', '=', 'p.pro_id')
    //         ->select(
    //             'dv.pro_id',
    //             DB::raw('SUM(dv.dve_cantidad) as total_vendido'),
    //             DB::raw('SUM(dv.dve_cantidad * p.pro_precio_venta) as ingresos'),
    //             DB::raw('SUM(dv.dve_cantidad * p.pro_precio_compra) as costo_ventas')
    //         )
    //         ->groupBy('dv.pro_id');

    //     // Reporte final
    //     $reporte = DB::table('producto as p')
    //         ->leftJoinSub($compras, 'c', function ($join) {
    //             $join->on('p.pro_id', '=', 'c.pro_id');
    //         })
    //         ->leftJoinSub($ventas, 'v', function ($join) {
    //             $join->on('p.pro_id', '=', 'v.pro_id');
    //         })
    //         ->select(
    //             'p.pro_nombre',
    //             'p.pro_precio_compra',
    //             'p.pro_precio_venta',

    //             // Compras
    //             DB::raw('COALESCE(c.total_comprado, 0) as total_comprado'),
    //             DB::raw('COALESCE(c.costo_total, 0) as costo_total_compras'),

    //             // Ventas
    //             DB::raw('COALESCE(v.total_vendido, 0) as total_vendido'),
    //             DB::raw('COALESCE(v.ingresos, 0) as ingresos'),

    //             // Costos y utilidad (corregido)
    //             DB::raw('COALESCE(v.costo_ventas, 0) as costo_ventas'),
    //             DB::raw('(COALESCE(v.ingresos, 0) - COALESCE(v.costo_ventas, 0)) as utilidad')
    //         )
    //         ->get();

    //     /* ======================================
    //     TOTALES GENERALES
    //     ====================================== */
    //     $total_comprado  = $reporte->sum('total_comprado');
    //     $total_vendido   = $reporte->sum('total_vendido');
    //     $total_ingresos  = $reporte->sum('ingresos');
    //     $total_costos    = $reporte->sum('costo_ventas');
    //     $total_utilidad  = $reporte->sum('utilidad');

    //     /* ======================================
    //     INDICADOR DE RENTABILIDAD
    //     ====================================== */
    //     $margen_utilidad = ($total_ingresos > 0)
    //         ? ($total_utilidad / $total_ingresos) * 100
    //         : 0;

    //     /* ======================================
    //     RETORNAR A LA VISTA
    //     ====================================== */
    //     return view('reportes.reporte_rentabilidad', [
    //         'titulo' => 'Reporte de Rentabilidad',
    //         'modulo_activo' => $this->modulo,
    //         'reporte' => $reporte,

    //         // Totales
    //         'total_comprado' => $total_comprado,
    //         'total_vendido' => $total_vendido,
    //         'total_ingresos' => $total_ingresos,
    //         'total_costos' => $total_costos,
    //         'total_utilidad' => $total_utilidad,

    //         // Indicador
    //         'margen_utilidad' => $margen_utilidad
    //     ]);

    // }

    //inventario actual
    public function inventarioActual()
    {
        //verificar si esta logueado el usuario
        if(!Auth::check()){return redirect('/');}
        $inventario = Inventario::all();
        return view('reportes.reporte_inventario_actual', ['titulo'=>'Reporte de Inventario Actual',
                                                          'modulo_activo' => $this->modulo,
                                                          'inventario' => $inventario
                                                         ]);
    }   

    // //reporte de ventas mensual (VERSION MYSQL)
    // public function ventasMensual()
    // {
    //     //verificar si esta logueado el usuario
    //     if(!Auth::check()){return redirect('/');}
    //     //obtener las ventas agrupadas por mes
    //     $ventas = Venta::selectRaw('
    //             YEAR(ven_fecha_venta) as anio,
    //             MONTH(ven_fecha_venta) as mes_num,
    //             COUNT(*) as cantidad_compras,
    //             SUM(ven_total) as total_ventas
    //         ')
    //         ->groupByRaw('YEAR(ven_fecha_venta), MONTH(ven_fecha_venta)')
    //         ->orderByRaw('YEAR(ven_fecha_venta) ASC, MONTH(ven_fecha_venta) ASC')
    //         ->get()
    //         ->map(function ($item) {
    //             $item->mes = Carbon::create()
    //                 ->month($item->mes_num)
    //                 ->locale('es')
    //                 ->monthName;
    //             return $item;
    //         });

    //    return view('reportes.reporte_ventas_mensual', ['titulo'=>'Reporte de Ventas Mensuales',
    //                                                       'modulo_activo' => $this->modulo,
    //                                                       'ventas' => $ventas
    //                                                      ]);
       
    // }

    // reporte de ventas mensual (VERSION POSTGRESQL)
    public function ventasMensual()
    {
        // verificar si esta logueado el usuario
        if (!Auth::check()) {
            return redirect('/');
        }

        // obtener las ventas agrupadas por mes
        $ventas = Venta::selectRaw('
                EXTRACT(YEAR FROM ven_fecha_venta) as anio,
                EXTRACT(MONTH FROM ven_fecha_venta) as mes_num,
                COUNT(*) as cantidad_compras,
                SUM(ven_total::numeric) as total_ventas
            ')
            ->groupByRaw('
                EXTRACT(YEAR FROM ven_fecha_venta),
                EXTRACT(MONTH FROM ven_fecha_venta)
            ')
            ->orderByRaw('
                EXTRACT(YEAR FROM ven_fecha_venta) ASC,
                EXTRACT(MONTH FROM ven_fecha_venta) ASC
            ')
            ->get()
            ->map(function ($item) {
                $item->mes = Carbon::create()
                    ->month((int)$item->mes_num)
                    ->locale('es')
                    ->monthName;

                return $item;
            });

        return view('reportes.reporte_ventas_mensual', [
            'titulo' => 'Reporte de Ventas Mensuales',
            'modulo_activo' => $this->modulo,
            'ventas' => $ventas
        ]);
    }    

    //stock critico
    public function stockCritico()
    {
        //verificar si esta logueado el usuario
        if(!Auth::check()){return redirect('/');}
        $inventario = Inventario::all();
        return view('reportes.reporte_stock_critico', ['titulo'=>'Reporte de Stock Crítico',
                                                          'modulo_activo' => $this->modulo,
                                                          'inventario' => $inventario
                                                         ]);
    }   

    //movimiento de inventario
    public function inventarioLog()
    {
        //verificar si esta logueado el usuario
        if(!Auth::check()){return redirect('/');}
        $log_inventario = InventarioLog::all();

        return view('reportes.reporte_inventario_log', ['titulo'=>'Reporte de Movimientos de Inventario',
                                                          'modulo_activo' => $this->modulo,
                                                          'log_inventario' => $log_inventario
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
