@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-line-chart"></i>
        {{$titulo}}
    </h3>
    <div class="row">
        <div class="col-12">
              
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                        <table class="table table-bordered tabla-datos-clientes">
                            <tbody>
                                <tr>
                                    <td>
                                        <h4>
                                            <i class="fa fa-bar-chart"></i>
                                            Reporte: Inventario actual
                                        </h4>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary" href="#"><i class="fa fa-file"></i> VER REPORTE</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>
                                            <i class="fa fa-bar-chart"></i>
                                            Reporte: Movimientos de inventario (entradas y salidas)
                                        </h4>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary" href="#"><i class="fa fa-file"></i> VER REPORTE</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>
                                            <i class="fa fa-bar-chart"></i>
                                            Reporte: Reportes de ventas
                                        </h4>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary" href="#"><i class="fa fa-file"></i> VER REPORTE</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>
                                            <i class="fa fa-bar-chart"></i>
                                            Reporte: Productos con stock critico
                                        </h4>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary" href="#"><i class="fa fa-file"></i> VER REPORTE</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                            </div>
                        </div>
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
                    <img src="{{asset('img/alert-danger.png')}}" class="align-self-center mr-3" alt="...">
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
          <form id="form-eliminar-venta" action="{{url('ventas')}}" data-simple-action="{{url('ventas')}}" method="post">
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
    $('.tabla-datos-clientes').DataTable({"language":{url: '{{asset('js/datatables-lang-es.json')}}'}, "order": [[ 5, "desc" ]]});

    //Conf popover
    $('[data-toggle="popover"]').popover()

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
