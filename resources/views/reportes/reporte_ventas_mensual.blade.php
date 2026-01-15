@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-line-chart"></i>
        {{$titulo}}
        <a href="#" id="btn-imprimir" class="btn btn-sm btn-primary float-right" style="margin-left:10px;"><i class="fa fa-print"></i> IMPRIMIR</a>
        <a href="{{url('reportes/')}}" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-arrow-left"></i> ATRAS</a>
    </h3>
    <div class="row">
        <div class="col-12">              
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        @if($ventas->count() == 0)
                        <div class="alert alert-info">
                            <div class="media">
                                <img src="{{secure_asset('img/alert-info.png')}}" class="align-self-center mr-3" alt="...">
                                <div class="media-body">
                                    <h5 class="mt-0">Nota.-</h5>
                                    <p>
                                        NO se tienen items registrados hasta el momento.
                                    </p>
                                </div>
                            </div>
                        </div>
                        @else
                        <h4 class="text-info text-bold text-center">
                            {{ $titulo }}
                            <br>
                            <small>Fecha: {{date('d/m/Y H:i:s')}}</small>
                        </h4>
                        <table class="table table-bordered tabla-datos">
                            <thead>
                            <tr>
                                <th>AÑO</th>
                                <th>MES</th>
                                <th># VENTAS</th>
                                <th>TOTAL VENTAS (Bs)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ventas as $item)
                            <tr>
                                <td class="text-center">
                                    {{$item->anio}}
                                </td>
                                <td class="text-center">
                                    {{$item->mes}}
                                </td>
                                <td class="text-center">
                                    {{$item->cantidad_compras}}
                                </td>
                                <td class="text-center decimal-number">
                                    {{$item->total_ventas}}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif

                    </div>
                </div>
                <!-- fin card  -->



        </div>
    </div>
</div>


<script type="text/javascript">
$(function(){
    /*
    -------------------------------------------------------------
    * CONFIGURACION DATA TABLES
    -------------------------------------------------------------
    */
    $('.tabla-datos').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "order": [[ 0, "desc" ]]});

    //Conf popover
    $('[data-toggle="popover"]').popover()

    //boton para imprimir
    $('#btn-imprimir').on('click', function () {
        window.print();
    });

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


});


</script>




@endsection
