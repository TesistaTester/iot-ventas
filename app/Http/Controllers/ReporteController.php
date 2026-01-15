<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\InventarioLog;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    //reporte de ventas mensual
    public function ventasMensual()
    {
        //verificar si esta logueado el usuario
        if(!Auth::check()){return redirect('/');}
        //obtener las ventas agrupadas por mes
        $ventas = Venta::selectRaw('
                YEAR(ven_fecha_venta) as anio,
                MONTH(ven_fecha_venta) as mes_num,
                COUNT(*) as cantidad_compras,
                SUM(ven_total) as total_ventas
            ')
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

        return view('reportes.reporte_ventas_mensual', ['titulo'=>'Reporte de Ventas Mensuales',
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
