@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-line-chart"></i>
        {{$titulo}}
        <a href="{{url('monitoreo')}}" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-arrow-left"></i> Volver a lista</a>
    </h3>
    <div class="row">
        <div class="col-12">                                      
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        <div class="alert alert-info">Click sobre un marcador para ver mas opciones</div>
                        <div id="mapa-monitoreo"></div>            
                    </div>
                </div>
                <!-- fin card  -->
        </div>
    </div>
</div>




<script type="text/javascript">
$(function(){
    const API_KEY = 'IFWPFRb7HshsHlf8VAUYFbjvCTQxPyAB'; 
    const DATA_FIELD = 'precipitationIntensity';
    const TIMESTAMP = (new Date()).toISOString(); 
    
	var map = L.map('mapa-monitoreo').setView([-16.5580771, -67.9532047], 14);
    @foreach($modulos as $item)
	var marker = L.marker([{{$item->mol_lat}}, {{$item->mol_lon}}])
    .bindPopup('<span class="text-info">Módulo: </span><br>{{$item->mol_descripcion}}<br><a style="color:#fff;" class="btn btn-sm btn-info" href="modulo_lectura/{{$item->mol_id}}"><i class="fa fa-eye"></i> Monitorear</a>')
	.addTo(map).openPopup();
    @endforeach

	L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

    L.tileLayer(`https://api.tomorrow.io/v4/map/tile/{z}/{x}/{y}/${DATA_FIELD}/${TIMESTAMP}.png?apikey=${API_KEY}`, {
        attribution: '&copy; <a href="https://www.tomorrow.io/weather-api">Powered by Tomorrow.io</a>',
    }).addTo(map);

});


</script>




@endsection
