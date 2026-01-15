@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-home"></i>
        {{$titulo}}
    </h3>
    <div class="row">
        <div class="col-12">
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        @if (Auth::user()->usu_rol != 2)

                        <div class="row">
                        @if (Auth::user()->usu_rol == 1 || Auth::user()->usu_rol == 4)
                            <div class="col-md-6">
                        @endif
                        @if (Auth::user()->usu_rol == 3)
                            <div class="col-md-12">
                        @endif
                                <div class="row">
                                    <div class="title-dash col">
                                    INFORMACIÓN VENTAS 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{count($ventas_dia)}}</h1>
                                            <small># VENTAS DEL DIA</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{count($ventas_mes)}}</h1>
                                            <small># VENTAS DEL MES</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{count($ventas_anio)}}</h1>
                                            <small># VENTAS DEL AÑO</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{count($clientes)}}</h1>
                                            <small>CLIENTES NUEVOS</small>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="box-result-numbers">
                                            <h1 class="decimal-number">{{$total_ventas_dia}}</h1>
                                            <small>VENTAS DEL DIA (Bs)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="box-result-numbers">
                                            <h1 class="decimal-number">{{$total_ventas_mes}}</h1>
                                            <small>VENTAS DEL MES (Bs)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="box-result-numbers">
                                            <h1 class="decimal-number">{{$total_ventas_anio}}</h1>
                                            <small>VENTAS DEL AÑO (Bs)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                        <h3 class="text-primary"><i class="fa fa-signal"></i> Ventas últimos 7 días</h3>
                                        <canvas id="chart_ventas_diarias"></canvas>
                                    </div>
                                    <div class="col-md-12">
                                    <hr>
                                        <h3 class="text-primary"><i class="fa fa-signal"></i> Ventas últimos 6 meses</h3>
                                        <canvas id="chart_ventas_mensual"></canvas>
                                    </div>
                                </div>
                            </div>

                        @endif

                        @if (Auth::user()->usu_rol != 3)

                        @if (Auth::user()->usu_rol == 1 || Auth::user()->usu_rol == 4)
                            <div class="col-md-6">
                        @endif
                        @if (Auth::user()->usu_rol == 2)
                            <div class="col-md-12">
                        @endif
                                <div class="row">
                                    <div class="title-dash col">
                                    INFORMACIÓN ALMACEN
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{$entradas}}</h1>
                                            <small>INGRESOS DEL DIA</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{$salidas}}</h1>
                                            <small>SALIDAS DEL DIA</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{$proveedores->count()}}</h1>
                                            <small>INGRESOS DEL MES</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{$usuarios->count()}}</h1>
                                            <small>SALIDAS DEL MES</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                        <h3 class="text-primary"><i class="fa fa-signal"></i> Ingresos del mes</h3>
                                        <canvas id="chart_entradas_mensual"></canvas>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <h3 class="text-primary"><i class="fa fa-signal"></i> Salidas del mes</h3>
                                        <canvas id="chart_salidas_mensual"></canvas>
                                    </div>
                                </div>

                            </div>
                        </div>

                        @endif
                            

                    </div>
                </div>
                <!-- fin card  -->



        </div>
    </div>
</div>




<script type="text/javascript">
$(function(){

    //formateo de numeros
    $('.decimal-number').each(function () {
        let valor = parseFloat($(this).text());

        if (!isNaN(valor)) {
            $(this).text(
                valor.toLocaleString('es-BO', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );
        }
    });


    //inicializacion de elementos
    $('#alarma-estado-conectado').hide();
    /*
    -------------------------------------------------------------
    * CONFIGURACION DATA TABLES
    -------------------------------------------------------------
    */
    $('.tabla-datos').DataTable({"language":{url: '{{asset('js/datatables-lang-es.json')}}'}, "order": [[ 5, "desc" ]]});

    //Conf popover
    $('[data-toggle="popover"]').popover()


});

/*CHART CONFIGURACION EXAMPLE*/
 const labelsDias = [
    //iteramos con blade la variable venta_7_dias
    @foreach ($ventas_7_dias as $venta)
        '{{ $venta->dia }}',
    @endforeach
    
   ];
 const labelsMeses = [
    //iteramos con blade la variable venta_6_meses
    @foreach ($ventas_6_meses as $venta)
        '{{ $venta->mes }}',
    @endforeach
   ];
   const data2 = {
     labels: labelsMeses,
     datasets: [{
       label: 'Ventas por mes',
       backgroundColor: 'rgb(5, 99, 132)',
       borderColor: 'rgb(5, 99, 132)',
       data: [
    @foreach ($ventas_6_meses as $venta)
        '{{ $venta->total_ventas }}',
    @endforeach

       ],
     }]
   };

    const dataDiario = {
      labels: labelsDias,
      datasets: [{
         label: 'Ventas por día',
         backgroundColor: 'rgb(54, 162, 235)',
         borderColor: 'rgb(54, 162, 235)',
         data: [
     @foreach ($ventas_7_dias as $venta)
          '{{ $venta->total_ventas }}',
     @endforeach
         ],
      }]
    };

   const data3 = {
     labels: [
        @foreach ($entradas_6_meses as $entrada)
            '{{ $entrada->mes }}',   
        @endforeach
     ],
     datasets: [{
       label: 'Entradas por mes',
       backgroundColor: 'rgb(4, 189, 72)',
       borderColor: 'rgb(4, 189, 72)',
       data: [
        @foreach ($entradas_6_meses as $entrada)
            '{{ $entrada->total_entradas }}',   
        @endforeach
       ],
     }]
   };

   const data4 = {
     labels: [
        @foreach ($salidas_6_meses as $salida)
            '{{ $salida->mes }}',   
        @endforeach
     ],
     datasets: [{
       label: 'Salidas por mes',
       backgroundColor: 'rgb(4, 189, 72)',
       borderColor: 'rgb(4, 189, 72)',
       data: [
        @foreach ($salidas_6_meses as $salida)
            '{{ $salida->total_salidas }}',   
        @endforeach
       ],
     }]
   };


    const config_diario = {
      type: 'bar',
      data: dataDiario,
      options: {}
    };

   const config_mensual = {
     type: 'bar',
     data: data2,
     options: {}
   };

   const config_entradas_mensual = {
     type: 'bar',
     data: data3,
     options: {}
   };

   const config_salidas_mensual = {
     type: 'bar',
     data: data4,
     options: {}
   };

    @if(Auth::user()->usu_rol != 2) 
    const grafico_ventas_mensual = new Chart(
        document.getElementById('chart_ventas_mensual'),
        config_mensual
      );

    const grafico_ventas_diarias = new Chart(
        document.getElementById('chart_ventas_diarias'),
        config_diario
    );
    @endif

    @if(Auth::user()->usu_rol != 3) 
    const grafico_entradas_mensual = new Chart(
        document.getElementById('chart_entradas_mensual'),
        config_entradas_mensual
      );

    const grafico_salidas_mensual = new Chart(
        document.getElementById('chart_salidas_mensual'),
        config_salidas_mensual
      );
      @endif
      

</script>




@endsection
