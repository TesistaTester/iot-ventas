@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-dollar"></i>
        {{$titulo}}
        <a href="#" id="btn-imprimir" class="btn btn-sm btn-primary float-right" style="margin-left:10px;"><i class="fa fa-print"></i> IMPRIMIR</a>
        <a href="{{url('ventas/')}}" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-arrow-left"></i> ATRAS</a>
    </h3>
    <div class="row">
        <div class="col-12">
              
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        @if($detalle->count() == 0)
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
                        <h4 class="text-info text-bold text-center">NOTA DE VENTA</h4>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="text-info text-bold">CLIENTE</td>
                                    <td>{{$venta->cliente->cli_nombre}}</td>
                                    <td class="text-info text-bold">NIT/CIT</td>
                                    <td>{{$venta->cliente->cli_nro_documento}}</td>
                                    <td class="text-info text-bold">DESPACHO</td>
                                    <td>
                                        @if($venta->ven_estado == 0)
                                        <span class="btn btn-warning disabled">
                                        PENDIENTE
                                        </span>
                                        @else
                                        <span class="btn btn-success disabled">
                                        REALIZADO
                                        </span>
                                        @endif
                                </td>
                                </tr>
                                <tr>
                                    <td class="text-info text-bold">FECHA VENTA</td>
                                    <td>{{$venta->ven_fecha_venta}}</td>
                                    <td class="text-info text-bold">TOTAL (Bs)</td>
                                    <td class="decimal-number">{{$venta->ven_total}}</td>
                                    <td class="text-info text-bold">METODO PAGO</td>
                                    <td>{{$venta->ven_metodo_pago}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered tabla-datos-clientes">
                            <thead>
                            <tr>
                                <th>SKU</th>
                                <th>NOMBRE PRODUCTO</th>
                                <th>PRECIO UNITARIO</th>
                                <th>CANTIDAD</th>
                                <th>SUBTOTAL</th>
                                <th class="cell-despacho">DESPACHADO</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($detalle as $item)
                            <tr>
                                <td>
                                    {{$item->producto->pro_sku}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_nombre }}
                                </td>
                                <td class="text-right decimal-number">
                                    {{$item->dve_precio_unitario}}
                                </td>
                                <td class="text-center">
                                    {{$item->dve_cantidad}}
                                </td>
                                <td class="text-right decimal-number">
                                    {{$item->dve_subtotal}}
                                </td>
                                <td class="text-center cell-despacho">
                                    <div class="btn btn-secondary disabled" style="text-transform: uppercase">
                                    {{$item->dve_despachados}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right text-bold">TOTAL (Bs): </td>
                                <td class="text-right text-bold decimal-number">{{$venta->ven_total}}</td>
                                <td class="cell-despacho"></td>
                            </tr>
                            </tbody>
                        </table>
                        <div style="background:#eee; border:1px solid #777; padding:3px;">
                            <span class="text-info">Usuario:</span> {{ Auth::user()->usu_nombre_completo }}
                        </div>
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
    $('.tabla-datos-clientes').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "order": [[ 5, "desc" ]]});

    //Conf popover
    $('[data-toggle="popover"]').popover()

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
