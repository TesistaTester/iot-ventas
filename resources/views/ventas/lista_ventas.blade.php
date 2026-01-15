@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-dollar"></i>
        {{$titulo}}
        <a href="{{url('ventas/nuevo')}}" class="btn btn-sm btn-success float-right" style="margin-left:10px;"><i class="fa fa-plus"></i> REGISTRAR VENTA</a>
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
                        <table class="table table-bordered tabla-datos-clientes">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>CLIENTE</th>
                                <th>CI/NIT</th>
                                <th>MONTO</th>
                                <th>FECHA VENTA</th>
                                <th>METODO PAGO</th>
                                <th>DESPACHO</th>
                                <th>OPCION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ventas as $item)
                            <tr>
                                <td>
                                    {{$item->ven_id}}
                                </td>
                                <td class="text-center">
                                    {{$item->cliente->cli_nombre }}
                                </td>
                                <td class="text-center">
                                    {{$item->cliente->cli_nro_documento}}
                                </td>
                                <td class="text-center">
                                    {{$item->ven_total}}
                                </td>
                                <td class="text-center">
                                    {{$item->ven_fecha_venta}}
                                </td>
                                <td class="text-center">
                                    <div class="badge badge-dark" style="text-transform: uppercase">
                                    {{$item->ven_metodo_pago}}
                                    </div>
                                </td>
                                <td class="text-center">
                                        @if($item->ven_estado == 0)
                                        <span class="btn btn-sm btn-warning disabled">
                                        PENDIENTE
                                        </span>
                                        @else
                                        <span class="btn btn-sm btn-success disabled">
                                        REALIZADO
                                        </span>
                                        @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        OPCION
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ url("ventas/$item->ven_id/detalle") }}"><i class="fa fa-eye"></i> Ver detalle</a>
                                        <a class="dropdown-item btn-eliminar-venta" data-id="{{$item->ven_id}}" data-descripcion="<b>Total Venta: </b> Bs {{$item->ven_total}} <br><b>Fecha:</b> {{ $item->ven_fecha_venta }} <br><b>Cliente: </b> {{ $item->cliente->cli_nombre }}" data-toggle="modal" data-target="#modal-eliminar-venta" href="#"><i class="fa fa-trash"></i> Anular venta</a>
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


{{-- INICIO MODAL: ANULAR  VENTA--}}
<div class="modal fade" id="modal-eliminar-venta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#eee;">
          <h5 class="modal-title text-primary">
              <i class="fa fa-trash"></i>
              Anulación de venta
            </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="box-data-xtra">
                <h5>
                    <span class="text-success">DETALLE DE LA VENTA </span><br>
                    <span id="txt-descripcion"></span><br>
                </h5>
            </div>
            <div class="alert alert-danger">
                <div class="media">
                    <img src="{{secure_asset('img/alert-danger.png')}}" class="align-self-center mr-3" alt="...">
                    <div class="media-body">
                        <h5 class="mt-0">Atención.-</h5>
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
    $('.tabla-datos-clientes').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "order": [[ 0, "desc" ]]});

    //Conf popover
    $('[data-toggle="popover"]').popover()

    /*
    --------------------------------------------------------------
    ELIMINAR venta
    --------------------------------------------------------------
    */
    $('.btn-eliminar-venta').click(function(){
       let ven_id = $(this).attr('data-id');
       let ven_descripcion = $(this).attr('data-descripcion');
       $('#txt-descripcion').html(ven_descripcion);
       //form data
       action = $('#form-eliminar-venta').attr('data-simple-action');
       action = action+'/'+ven_id;
       $('#form-eliminar-venta').attr('action',action);
   });



});


</script>




@endsection
