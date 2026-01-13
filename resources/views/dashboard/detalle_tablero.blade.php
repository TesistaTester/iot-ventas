@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-home"></i>
        {{$titulo}}
        <a href="{{url('clientes')}}" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-arrow-left"></i> ATRÁS</a>
    </h3>
    <div class="row">
        <div class="col-12">
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="title-dash col">
                                    INFORMACIÓN VENTAS 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{$ventas->count()}}</h1>
                                            <small>VENTAS DEL DIA</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{$ventas->count()}}</h1>
                                            <small>VENTAS DEL MES</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{$ventas->count()}}</h1>
                                            <small>DESPACHOS DIA</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-result">
                                            <h1>{{$usuarios->count()}}</h1>
                                            <small>CLIENTES NUEVOS</small>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="box-result-numbers">
                                            <h1>{{$total_ventas_dia}}</h1>
                                            <small>VENTAS DEL DIA</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="box-result-numbers">
                                            <h1>{{$total_ventas_mes}}</h1>
                                            <small>VENTAS DEL MES</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="box-result-numbers">
                                            <h1>{{$total_ventas_anio}}</h1>
                                            <small>VENTAS DEL AÑO (Bs)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                        <h3 class="text-primary"><i class="fa fa-signal"></i> Ventas por mes</h3>
                                        <canvas id="chart_consumo_mensual"></canvas>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
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
                                        <canvas id="chart_inventario_mensual"></canvas>
                                    </div>
                                </div>

                            </div>
                        </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                {{-- <h3 class="text-primary"><i class="fa fa-signal"></i> Ventas por mes</h3>
                                <canvas id="chart_consumo_mensual"></canvas> --}}
                                <hr>
                            </div>
                            {{-- <div class="col-md-6">
                                <h3 class="text-primary"><i class="fa fa-list"></i> Consumo mensual global</h3>
                                <hr>
                                @if($lecturas->count() == 0)
                                <canvas id="chart_consumo_mensual"></canvas>
                                <div class="alert alert-info">
                                    <div class="media">
                                        <img src="{{asset('img/alert-info.png')}}" class="align-self-center mr-3" alt="...">
                                        <div class="media-body">
                                            <h5 class="mt-0">Nota.-</h5>
                                            <p>
                                                Dispositivo sin conexión.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @else

                                @endif
                            </div> --}}
                        </div>

                    </div>
                </div>
                <!-- fin card  -->



        </div>
    </div>
</div>




<script type="text/javascript">
$(function(){
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
 const labels1 = [
     'Lunes',
     'Martes',
     'Miercoles',
     'Jueves',
     'Viernes',
     'Sabado',
   ];
 const labels2 = [
     'Junio',
     'Julio',
     'Agosto',
     'Septiembre',
     'Octubre',
     'Noviembre',
   ];
 const data1 = {
     labels: labels1,
     datasets: [{
       label: 'Consumo',
       backgroundColor: 'rgb(134, 99, 132)',
       borderColor: 'rgb(134, 99, 132)',
       data: [0, 10, 15, 2, 20, 300, 45],
     }]
   };
   const data2 = {
     labels: labels2,
     datasets: [{
       label: 'Ventas por mes',
       backgroundColor: 'rgb(5, 99, 132)',
       borderColor: 'rgb(5, 99, 132)',
       data: [10, 15, 5, 12, 22, 30, 45],
     }]
   };
   const data3 = {
     labels: labels2,
     datasets: [{
       label: 'Ingresos por mes',
       backgroundColor: 'rgb(255, 99, 132)',
       borderColor: 'rgb(255, 99, 132)',
       data: [12, 6, 15, 2, 5, 21, 24],
     }]
   };


   const config_caudal = {
     type: 'line',
     data: data2,
     options: {}
   };
   const config_diario = {
     type: 'bar',
     data: data1,
     options: {}
   };
   const config_mensual = {
     type: 'bar',
     data: data2,
     options: {}
   };

   const config_mensual_inventario = {
     type: 'bar',
     data: data3,
     options: {}
   };


// // const grafico_caudal = new Chart(
// //     document.getElementById('chart_caudal'),
// //     config_caudal
// //   );

    const grafico_consumo_mensual = new Chart(
        document.getElementById('chart_consumo_mensual'),
        config_mensual
      );

    const grafico_inventario_mensual = new Chart(
        document.getElementById('chart_inventario_mensual'),
        config_mensual_inventario
      );

// const grafico_consumo_diario = new Chart(
//     document.getElementById('chart_consumo_diario'),
//     config_diario
//   );

</script>




@endsection
