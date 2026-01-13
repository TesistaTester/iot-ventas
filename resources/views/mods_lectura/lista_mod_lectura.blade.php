@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-microchip"></i>
        {{$titulo}}
        <a href="{{url('modulos-lectura/nuevo')}}" class="btn btn-sm btn-success float-right" style="margin-left:10px;"><i class="fa fa-plus"></i> NUEVO MODULO DE LECTURA</a>
    </h3>
    <div class="row">
        <div class="col-12">
              
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        @if($modulos->count() == 0)
                        <div class="alert alert-info">
                            <div class="media">
                                <img src="{{secure_asset('img/alert-info.png')}}" class="align-self-center mr-3" alt="...">
                                <div class="media-body">
                                    <h5 class="mt-0">Nota.-</h5>
                                    <p>
                                        NO se tienen modulos registrados hasta el momento.
                                    </p>
                                </div>
                            </div>
                        </div>
                        @else
                        <table class="table table-bordered tabla-datos">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>DESCRIPCION</th>
                                <th>LATITUD</th>
                                <th>LONGITUD</th>
                                <th>OPCION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($modulos as $item)
                            <tr>
                                <td>
                                    {{$item->mol_id}}
                                </td>
                                <td>
                                    {{$item->mol_descripcion}}
                                </td>
                                <td>
                                    {{$item->mol_lat}}
                                </td>
                                <td>
                                    {{$item->mol_lon}}
                                </td>
                                <td>
                                    <div class="dropdown">
                                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        OPCION
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        {{-- <a class="dropdown-item" href="{{url('modulos-lectura/'.Crypt::encryptString($item->mol_id).'/editar')}}"><i class="fa fa-edit"></i> Editar</a> --}}
                                        <a class="dropdown-item btn-eliminar-modulo" data-id="{{Crypt::encryptString($item->mol_id)}}" data-descripcion="{{$item->mol_descripcion}}" data-toggle="modal" data-target="#modal-eliminar-modulo" href="#"><i class="fa fa-trash"></i> Eliminar</a>
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


{{-- INICIO MODAL: ELIMINAR ITEM --}}
<div class="modal fade" id="modal-eliminar-modulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#eee;">
          <h5 class="modal-title text-primary">
              <i class="fa fa-trash"></i>
              Eliminar modulo
            </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="box-data-xtra">
                <h5>
                    <span class="text-success">DESCRIPCION: </span>
                    <span id="txt-descripcion"></span><br>
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
          <form id="form-eliminar-modulo" action="{{secure_url('modulos-lectura')}}" data-simple-action="{{secure_url('modulos-lectura')}}" method="post">
            @method('delete')
            @csrf
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Si, eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- FIN MODAL: ELIMINAR ESTADO --}}


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

    /*
    --------------------------------------------------------------
    ELIMINAR USUARIO
    --------------------------------------------------------------
    */
    $('.btn-eliminar-modulo').click(function(){
       let id = $(this).attr('data-id');
       let descripcion = $(this).attr('data-descripcion');
       $('#txt-descripcion').html(descripcion);
       //form data
       action = $('#form-eliminar-modulo').attr('data-simple-action');
       action = action+'/'+id;
       $('#form-eliminar-modulo').attr('action',action);
   });



});


</script>




@endsection
