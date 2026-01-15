@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-id-card"></i>
        {{$titulo}}
        <a href="{{url('monitoreo')}}" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-arrow-left"></i> ATRÁS</a>
    </h3>
    <div class="row">
        <div class="col-12">
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="box-well">
                                    <div class="row">
                                        <div class="col-md-4 text-info">MODULO DE LECTURA:</div>
                                        <div class="col-md-8">{{$modulo->mol_id}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-info">DESCRIPCION:</div>
                                        <div class="col-md-8">{{$modulo->mol_descripcion}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-info">UBICACIÓN:</div>
                                        <div class="col-md-8">{{$modulo->mol_lat}}, {{$modulo->mol_lon}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-primary"><i class="fa fa-line-chart"></i> Caudal en tiempo real (hoy)</h3>
                                <hr>
                                <div id="box-chart-caudal">
                                    <div class="spin-loader">
                                        <div class="spinner-grow spin-lg" role="status">
                                            <span class="sr-only">Cargando...</span>
                                        </div>
                                        <p>
                                            Conectando
                                        </p>
                                    </div>
                                    <canvas id="chart_caudal"></canvas>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h3 class="text-primary"><i class="fa fa-line-chart"></i> Nivel en tiempo real (hoy)</h3>
                                <hr>
                                <div id="box-chart-nivel">
                                    <div class="spin-loader">
                                        <div class="spinner-grow spin-lg" role="status" >
                                            <span class="sr-only">Cargando...</span>
                                        </div>
                                        <p>
                                            Conectando
                                        </p>
                                    </div>
                                    <canvas id="chart_nivel"></canvas>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-primary"><i class="fa fa-list"></i> Historial del caudal y nivel (no tiempo real)</h3>
                                <hr>
                                @if($modulo->lecturas->count() == 0)
                                <div class="alert alert-info">
                                    <div class="media">
                                        <img src="{{secure_asset('img/alert-info.png')}}" class="align-self-center mr-3" alt="...">
                                        <div class="media-body">
                                            <h5 class="mt-0">Nota.-</h5>
                                            <p>
                                                No se tienen registros hasta el momento.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <table class="table table-bordered tabla-datos-caudales">
                                    <thead>
                                    <tr>
                                        <th>FECHA HORA</th>
                                        <th>CAUDAL (L/min)</th>
                                        <th>NIVEL (cm)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($modulo->lecturas as $item)
                                    <tr>
                                        <td>
                                            {{$item->lec_fecha_hora}}
                                        </td>
                                        <td class="text-right">
                                            {{round($item->lec_caudal,5)}}
                                        </td>
                                        <td class="text-right">
                                            {{round($item->lec_nivel,5)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @endif

                            </div>

                        </div>
                        <hr>
    
                    </div>
                </div>
                <!-- fin card  -->

        </div>
    </div>
</div>




<script type="text/javascript">
$(function(){
    //inicializacion de elementos
    //algo   
    /*
    -------------------------------------------------------------
    * CONFIGURACION DATA TABLES
    -------------------------------------------------------------
    */
    $('.tabla-datos-caudales').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "pageLength": 5, "order": [[ 0, "desc" ]]});
    $('.tabla-datos-lecturas').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "pageLength": 5, "order": [[ 0, "desc" ]]});
    // $('.tabla-datos').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "order": [[ 5, "desc" ]]});

    //Conf popover
    $('[data-toggle="popover"]').popover()
    //conversion fecha y hora
    function padTo2Digits(t){return t.toString().padStart(2,"0")}function formatDate(t){return[t.getFullYear(),padTo2Digits(t.getMonth()+1),padTo2Digits(t.getDate())].join("-")+" "+[padTo2Digits(t.getHours()),padTo2Digits(t.getMinutes()),padTo2Digits(t.getSeconds())].join(":")}

    /*
    ----------------------------------------------------------------------- 
    CONSULTAS EN TIEMPO REAL
    -----------------------------------------------------------------------
    */

    //consulta para el caudal y nivel
    const interval = setInterval(function() {
        let mol_id = {{$modulo->mol_id}};
        $.ajax({
    			type: "POST",
			url: '{{url('lecturas/get_lecturas')}}',
			data: {
					mol_id: mol_id
			},
			dataType: 'json',
			beforeSend: function(){
                console.log("Enviando consulta");
			},
			success: function(respuesta){
                let etiquetas = [];
                let datos_caudal = [];
                let datos_nivel = [];

                $.each(respuesta.lecturas, function(index, item){
                    etiquetas.push(item.lec_fecha_hora.substring(10,19));
                    datos_caudal.push(item.lec_caudal);
                    datos_nivel.push(item.lec_nivel);
                })


                let data_caudal = {
                    labels: etiquetas,
                    datasets: [{
                    label: 'Caudal [L]',
                    backgroundColor: 'rgb(24, 159, 237)',
                    borderColor: 'rgb(24, 159, 237)',
                    data: datos_caudal,
                    }]
                };
                let data_nivel = {
                    labels: etiquetas,
                    datasets: [{
                    label: 'Nivel [cm]',
                    backgroundColor: 'rgb(244, 159, 237)',
                    borderColor: 'rgb(244, 159, 237)',
                    data: datos_nivel,
                    }]
                };


                const config_caudal = {
                    type: 'line',
                    data: data_caudal,
                    options: {}
                };

                const config_nivel = {
                    type: 'line',
                    data: data_nivel,
                    options: {}
                };

                if(typeof grafico_caudal != 'undefined' || typeof grafico_nivel != 'undefined'){
                    grafico_caudal.destroy();
                    grafico_nivel.destroy();
                }else{
                    //grafico caudal realtime
                    $('.spin-loader').fadeOut();
                    $('#chart_caudal').remove();
                    $('#box-chart-caudal').append('<canvas id="chart_caudal"></canvas>');                    
                    //grafico nivel realtime
                    $('#chart_nivel').remove();
                    $('#box-chart-nivel').append('<canvas id="chart_nivel"></canvas>');                    
                }
                
                var grafico_caudal = new Chart(
                    document.getElementById('chart_caudal'),
                    config_caudal
                );

                var grafico_nivel = new Chart(
                    document.getElementById('chart_nivel'),
                    config_nivel
                );

                
			},
			error: function(data){
				console.log("Error de consulta");
			}
		});

        
    }, 10000);
    // clearInterval(interval);

    //REGISTRO DE CAUDALES Y NIVELES SIMULADO
    //NO OLVIDAR COMENTAR ESTO AL CONECTAR EL ESP32
    // console.log('REGISTRO DE CAUDALES Y NIVELES SIMULADO');
    // const interval_set_caudal_medidor = setInterval(function() {
    //     let mol_id = {{$modulo->mol_id}};
    //     let rnd_caudal = Math.random();
    //     let rnd_nivel = Math.random();
    //     let rnd_nivel_boya = parseInt(Math.random() * 10);
    //     console.log("NIVEL BOYA: "+rnd_nivel_boya);
    //     if(rnd_nivel_boya > 8){
    //         console.log("BOYA ALERTA");
    //         rnd_nivel_boya = 1;
    //     }else{
    //         console.log("BOYA NORMAL");
    //         rnd_nivel_boya = 0;
    //     }

    //     $.ajax({
   	// 		type: "POST", dataType: 'json', url: '{{url('lecturas/nueva_lectura_simulada')}}',
	// 		data: {mol_id: mol_id, caudal: (rnd_caudal*10), nivel: (rnd_nivel*20)/10, nivel_boya: rnd_nivel_boya},
	// 		success: function(respuesta){
    //             if(respuesta.status != 1){console.log(respuesta.error);}
	// 		},
	// 		error: function(data){console.log("Error de consulta (registro simulado)");}
	// 	});        
    // }, 5000);


});


</script>




@endsection
