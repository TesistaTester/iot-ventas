@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-th-list"></i>
        {{$titulo}}
        <a href="{{ url('inventario/lectura_qr') }}" style="margin-left:5px;" class="btn btn-sm btn-secondary float-right"><i class="fa fa-qrcode"></i> Ingreso/salida QR (manual)</a>
        <a href="#" class="btn btn-sm btn-dark float-right" data-toggle="modal" data-target="#modal-log-inventario" ><i class="fa fa-eye"></i> Ver log de inventario</a>
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
                        <table class="table table-bordered tabla-datos-clientes">
                            <thead>
                            <tr>
                                <th>ID PROD</th>
                                <th>SKU</th>
                                <th>PRODUCTO</th>
                                <th>PRECIO VENTA</th>
                                <th>CANTIDAD</th>
                                <th>OPCION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inventario as $item)
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
                                    {{$item->inv_cantidad}}
                                </td>
                                <td>
                                    <div class="dropdown">
                                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        OPCION
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{url('inventario/altas/'.$item->inv_id)}}"><i class="fa fa-plus"></i> Alta de item en inventario</a>
                                      </div>
                                    </div>
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


{{-- INICIO MODAL: LOG INVENTARIO --}}
<div class="modal fade" id="modal-log-inventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#eee;">
          <h5 class="modal-title text-primary">
              <i class="fa fa-eye"></i>
              Log del inventario
            </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                         <table class="table table-bordered tabla-datos-log">
                            <thead>
                            <tr>
                                <th>ID LOG</th>
                                <th>TIPO MOVIMIENTO</th>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>FUENTE</th>
                                <th>DESCRIPCION</th>
                                <th>FECHA-HORA</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($log_inventario as $item)
                            <tr>
                                <td class="text-center">
                                    {{$item->ilo_id}}
                                </td>
                                <td class="text-center">
                                    {{$item->ilo_tipo_movimiento}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_nombre}}
                                </td>
                                <td class="text-center">
                                    {{$item->ilo_cantidad}}
                                </td>
                                <td class="text-center">
                                    {{$item->ilo_fuente}}
                                </td>
                                <td class="text-center">
                                    {{$item->ilo_descripcion}}
                                </td>
                                <td class="text-center">
                                    {{$item->created_at}}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  {{-- FIN MODAL: LOG INVENTARIO --}}

{{-- INICIO MODAL: ELIMINAR INVENTARIO --}}
<div class="modal fade" id="modal-eliminar-proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#eee;">
          <h5 class="modal-title text-primary">
              <i class="fa fa-trash"></i>
              Eliminar proveedor
            </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="box-data-xtra">
                <h5>
                    <span class="text-success">NOMBRE proveedor: </span>
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
          <form id="form-eliminar-proveedor" action="{{secure_url('proveedores')}}" data-simple-action="{{secure_url('proveedores')}}" method="post">
            @method('delete')
            @csrf
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Si, eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- FIN MODAL: ELIMINAR INVENTARIO --}}

<script type="text/javascript">
$(function(){
    /*
    -------------------------------------------------------------
    * CONFIGURACION DATA TABLES
    -------------------------------------------------------------
    */
    $('.tabla-datos-clientes').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "order": [[ 0, "asc" ]]});
    $('.tabla-datos-log').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "order": [[ 0, "desc" ]]});

    //Conf popover
    $('[data-toggle="popover"]').popover()

    /*
    --------------------------------------------------------------
    log inventario
    --------------------------------------------------------------
    */
    $('.btn-eliminar-proveedor').click(function(){
       let usu_id = $(this).attr('data-usu-id');
       let usu_nombre = $(this).attr('data-usu-nombre');
       $('#txt-usu-nombre').html(usu_nombre);
       //form data
       action = $('#form-eliminar-proveedor').attr('data-simple-action');
       action = action+'/'+usu_id;
       $('#form-eliminar-proveedor').attr('action',action);
   });



});


</script>




@endsection
