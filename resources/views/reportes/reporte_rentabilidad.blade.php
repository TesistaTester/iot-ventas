@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')


<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-line-chart"></i>
        {{$titulo}}
        <a href="#" id="btn-imprimir" class="btn btn-sm btn-primary float-right" style="margin-left:10px;"><i class="fa fa-print"></i> IMPRIMIR</a>
        <a href="{{secure_url('reportes/')}}" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-arrow-left"></i> ATRAS</a>
    </h3>
    
    <div class="row">
        <div class="col-12">              
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        
                        @if($reporte->count() == 0)
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
                            REPORTE: ESTADO DE RESULTADOS (RENTABILIDAD)
                            <br>
                            <small>Fecha: {{date('d/m/Y H:i:s')}}</small>
                        </h4>
                        <!--  RESUMEN FINANCIERO -->
                    <div class="row text-center mb-3">

                        <!--<div class="col-md-3">
                            <div class="card bg-success text-white card-resumen">
                                <div class="card-body">
                                    <h6>INGRESOS</h6>
                                    <h4>{{ number_format($total_ingresos,2) }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card bg-danger text-white card-resumen">
                                <div class="card-body">
                                    <h6>COSTOS</h6>
                                    <h4>{{ number_format($total_costos,2) }}</h4>
                                </div>
                            </div>
                        </div> 

                        <div class="col-md-3">
                            <div class="card bg-primary text-white card-resumen">
                                <div class="card-body">
                                    <h6>UTILIDAD</h6>
                                    <h4>{{ number_format($total_utilidad,2) }}</h4>
                                </div>
                            </div>
                        </div>--> 

                        <div class="col-md-3">
                            <div class="card bg-white text-black card-resumen">
                                <div class="card-body">
                                    <h6>MARGEN</h6>
                                    <h4>{{ number_format($margen_utilidad ?? 0, 2) }}%</h4>
                                </div>
                            </div>
                        </div> 

                     </div>
                        
                         <table class="table table-bordered tabla-datos">
                            <thead>
                            <tr>
                                <th>PRODUCTO</th>
                                <th>PRECIO COMPRA</th>
                                <th>PRECIO VENTA</th>
                                <th>COMPRADO</th>
                                <th>VENDIDO</th>
                                <th>INGRESOS</th>
                                <th>COSTO VENTAS</th>
                                <th>UTILIDAD</th>
                            </tr>
                            </thead>
                            <tbody>
                             <!-- original codigo  
                            @foreach($reporte as $item)
                            <tr>
                                <td class="text-center">
                                    {{$item->pro_nombre}}
                                </td>
                                <td class="text-center">
                                    {{$item->pro_precio_compra}}
                                </td>
                                <td class="text-center">
                                    {{$item->pro_precio_venta}}
                                </td>
                                <td class="text-center">
                                    {{$item->total_comprado ?? 0}}
                                </td>
                                <td class="text-center">
                                    {{$item->total_vendido ?? 0}}
                                </td>
                                <td class="text-center">
                                    {{$item->ingresos}}
                                </td>
                                <td class="text-center">
                                    {{$item->costo_ventas}}
                                </td>
                                <td class="text-center">
                                    {{$item->utilidad}}
                                </td>
                            </tr>
                            @endforeach -->
                            @foreach($reporte as $item)
                            <tr>
                                <td class="text-center">{{ $item->pro_nombre }}</td>
                                <td class="text-center">{{ number_format($item->pro_precio_compra ?? 0, 2)}}</td>
                                <td class="text-center">{{ number_format($item->pro_precio_venta ?? 0, 2)}}</td>
                                <td class="text-center">{{ number_format($item->total_comprado ?? 0, 0) }}</td>
                                <td class="text-center">{{ number_format($item->total_vendido ?? 0, 0) }}</td>

                                <!--FORMATO NUMÉRICO -->
                                <td class="text-right">{{ number_format($item->ingresos ?? 0, 2) }}</td>
                                <td class="text-right">{{ number_format($item->costo_ventas ?? 0, 2) }}</td>
                                <td class="text-right utilidad-col">{{ number_format($item->utilidad ?? 0, 2) }}</td>
                            </tr>
                            @endforeach 
                    
                            <!-- TOTAL GENERAL PROFESIONAL 
                        <tr style="font-weight:bold; background:#e9ecef;">
                            <td class="text-center">TOTAL</td>
                            <td></td>
                            <td></td>
                            <td class="text-center">{{ $total_comprado }}</td>
                            <td class="text-center">{{ $total_vendido }}</td>
                            <td class="text-center text-success">{{ number_format($total_ingresos,2) }}</td>
                            <td class="text-center text-danger">{{ number_format($total_costos,2) }}</td>
                            <td class="text-center text-primary">{{ number_format($total_utilidad,2) }}</td>
                        </tr> -->

                             <!-- agregando el codigo  
                            <tr style="font-weight:bold; background:#f2f2f2;">
                                <td>Total</td>
                                <td colspan="6"></td>
                                <td>{{ number_format($total_utilidad, 2) }}</td>
                            </tr> -->
                            </tbody>
                            <tfoot>     
                                <!-- TOTAL CORREGIDO -->
                                <tr style="font-weight:bold; background:#e9ecef;">
                                    <td colspan="3" class="text-center">TOTAL</td>
                                    <td class="text-center">{{ number_format($total_comprado ?? 0, 0)}}</td>
                                    <td class="text-center">{{ number_format($total_vendido ?? 0, 0)}}</td>
                                    <td class="text-right text-success">{{ number_format($total_ingresos ?? 0, 2) }} </td>
                                    <td class="text-right text-danger">{{ number_format($total_costos ?? 0, 2) }} </td>
                                    <td class="text-right text-primary">{{ number_format($total_utilidad ?? 0, 2) }} </td>
                                </tr>
                            </tfoot>
                        </table>
                        @endif
                </div>

            </div>
            <!-- fin card  -->        
        </div>

    </div>

</div>


{{-- INICIO MODAL: ELIMINAR  VENTA--}}
<div class="modal fade" id="modal-eliminar-venta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#eee;">
          <h5 class="modal-title text-primary">
              <i class="fa fa-trash"></i>
              Eliminar venta
            </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="box-data-xtra">
                <h5>
                    <span class="text-success">NOMBRE venta: </span>
                    <span id="txt-usu-nombre"></span><br>
                </h5>
            </div>
            <div class="alert alert-danger">
                <div class="media">
                    <img src="{{secure_asset('img/alert-danger.png')}}" class="align-self-center mr-3" alt="...">
                    <div class="media-body">
                        <h5 class="mt-0">Cuidado.-</h5>
                        <p>
                            ¿Está seguro que desea eliminar éste registro?
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <form id="form-eliminar-venta" action="{{secure_url('ventas')}}" data-simple-action="{{secure_url('ventas')}}" method="post">
            @method('delete')
            @csrf
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Si, eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- FIN MODAL: ELIMINAR VENTA --}}


<script type="text/javascript">
$(function(){
    
    /*
    -------------------------------------------------------------
    * CONFIGURACION DATA TABLES
    -------------------------------------------------------------
    */
  

    $('.tabla-datos').DataTable({"language": { url: "{{secure_asset('js/datatables-lang-es.json') }}" }, "order": [[ 7, "desc" ]], columnDefs: [ { targets: '.utilidad-col', type: 'num' } ]});

    //Conf popove
    $('[data-toggle="popover"]').popover()

    //boton para imprimir
    $('#btn-imprimir').on('click', function () {
        // destruir DataTable temporalmente
    //$('.tabla-datos').DataTable().destroy();
        window.print();
        // recargar para restaurar DataTable
    //location.reload();
    });

    /*
    --------------------------------------------------------------
    ELIMINAR venta
    --------------------------------------------------------------
    */
   /*
   $('.btn-eliminar-venta').click(function(){
       let usu_id = $(this).attr('data-usu-id');
       let usu_nombre = $(this).attr('data-usu-nombre');
       $('#txt-usu-nombre').html(usu_nombre);
       //form data
       let action = $('#form-eliminar-venta').attr('data-simple-action');
       action = action+'/'+usu_id;
       $('#form-eliminar-venta').attr('action',action);
   });*/



});


</script>
<style>

@media print {

    @page {
        margin: 10mm;
    }

    #btn-imprimir,
    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate {
        display: none !important;
    }

    body {
        margin: 0;
        padding: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
}
        
	
</style>



@endsection
