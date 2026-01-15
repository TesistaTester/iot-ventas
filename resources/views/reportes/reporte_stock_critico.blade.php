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
                        @if($inventario->count() == 0)
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
                            REPORTE: PRODUCTOS EN STOCK CRITICO
                            <br>
                            <small>Fecha: {{date('d/m/Y H:i:s')}}</small>
                        </h4>
                        <table class="table table-bordered tabla-datos">
                            <thead>
                            <tr>
                                <th>ID PROD</th>
                                <th>SKU</th>
                                <th>PRODUCTO</th>
                                <th>PRECIO VENTA</th>
                                <th>PRECIO COMPRA</th>
                                <th>STOCK</th>
                                <th>STOCK CRITICO</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inventario as $item)
                            @if($item->inv_cantidad <= $item->producto->pro_stock_minimo)
                            <tr>
                                <td class="text-center">
                                    {{$item->producto->pro_id}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_sku}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_nombre}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_precio_venta}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_precio_compra}}
                                </td>
                                <td class="text-center">
                                    {{$item->inv_cantidad}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_stock_minimo}}
                                </td>
                            </tr>
                            @endif
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
    $('.tabla-datos').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "order": [[ 0, "desc" ]]});

    //Conf popover
    $('[data-toggle="popover"]').popover()

    //boton para imprimir
    $('#btn-imprimir').on('click', function () {
        window.print();
    });

    /*
    --------------------------------------------------------------
    ELIMINAR venta
    --------------------------------------------------------------
    */
    $('.btn-eliminar-venta').click(function(){
       let usu_id = $(this).attr('data-usu-id');
       let usu_nombre = $(this).attr('data-usu-nombre');
       $('#txt-usu-nombre').html(usu_nombre);
       //form data
       action = $('#form-eliminar-venta').attr('data-simple-action');
       action = action+'/'+usu_id;
       $('#form-eliminar-venta').attr('action',action);
   });



});


</script>




@endsection
