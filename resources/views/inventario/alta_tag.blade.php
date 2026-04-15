@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-plus"></i>
        {{$titulo}}
    </h3>
    <div class="row">
        <div class="col-12">              
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="box-well">
                                            <h4 class="text-info"><strong>Detalles del item nuevo</strong></h4>
                                            <ul>
                                                <li><b>ID:</b> {{$nuevo_item->ptr_id}}</li>
                                                <li><b>UID Temporal:</b> {{$nuevo_item->ptr_uid}}</li>
                                                <li><b>Código QR:</b> {{$nuevo_item->ptr_codigo}}</li>
                                            </ul>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="box-well text-center">
                                            <h4 class="text-info"><strong>Detalles del Tag RFID</strong></h4>
                                            <p>Aproxime el tag RFID al lector para completar el alta del item en el inventario.</p>
                                            <div id="box-uid" class="box-scanner">
                                                TAG IDENTIFICADO
                                                <h2 id="id_identificado">
                                                    XXXXXXX
                                                </h2>
                                            </div>
                                            <div id="box-loader" class="box-scanner">
                                                ESPERANDO ESCANEO RFID ...
                                                <br><br>
                                                <img src="{{ secure_asset('img/preloader3.gif') }}" alt="">
                                            </div>
                                            <hr>
                                            <div id="box-form">
                                                <form action="{{secure_url('/inventario/guardar_seguir/') }}" method="post" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="pro_id" value="{{ $nuevo_item->pro_id }}">
                                                    <input type="hidden" name="ptr_id" value="{{ $nuevo_item->ptr_id }}">
                                                    <button type="submit" class="btn btn-sm btn-primary">Guardar y registrar más items</button>
                                                </form>
                                                <br><br>
                                                <form action="{{secure_url('/inventario/guardar_terminar/') }}" method="post" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="pro_id" value="{{ $nuevo_item->pro_id }}">
                                                    <input type="hidden" name="ptr_id" value="{{ $nuevo_item->ptr_id }}">
                                                    <button type="submit" class="btn btn-sm btn-success">Guardar y terminar</button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="box-well text-center">
                                            <h4 class="text-info"><strong>QR (Auxiliar)</strong></h4>
                                            <div id="qr-wrapper">
                                            <div id="qr-value" data-qr="{{ $nuevo_item->ptr_codigo }}"></div>
                                            <div id="qrcode" class="qr-small" style="margin:20px 0;"></div>
                                            </div>
                                            <button id="descargar" class="btn btn-sm btn-primary">
                                                <i class="fa fa-download"></i>
                                                Descargar QR
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>              
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

    /*--------------------------------------------------------------
    Generar QR
    --------------------------------------------------------------
    */

    // Obtener valor del QR desde el div
    const qrValue = document.getElementById("qr-value").dataset.qr;

    if (!qrValue) {
        console.error("No se encontró el valor del QR");
        return;
    }

    // Generar QR automáticamente
    const qrContainer = document.getElementById("qrcode");
    qrContainer.innerHTML = "";

    new QRCode(qrContainer, {
        text: qrValue,
        width: 300,
        height: 300,
        correctLevel: QRCode.CorrectLevel.H
    });


    // Botón descargar
    document.getElementById("descargar").addEventListener("click", function () {

        let canvas = qrContainer.querySelector("canvas");

        // fallback si se genera como img
        if (!canvas) {
            const img = qrContainer.querySelector("img");
            if (!img) return alert("QR no encontrado");
            downloadImage(img.src);
            return;
        }

        const image = canvas.toDataURL("image/png");
        downloadImage(image);
    });

    function downloadImage(src) {
        const a = document.createElement("a");
        a.href = src;
        a.download = "QR_{{ $nuevo_item->ptr_codigo }}.png";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    //este trozo de codigo consulta cada 3 segundos si hay un tag rfid asignado, 
    // pero no actualiza la pagina, solo muestra una alerta
    //ademas se para cuando se encuentra un tag asignado
    const intervaloConsulta = setInterval(function() {
        fetch('{{ url('/api/inventario/existe_tag_asignado') }}')
            .then(response => response.json())
            .then(data => {
                if (data.status === '1') {
                    // alert('Tag RFID asignado correctamente al nuevo item del inventario. ID Tag: ' + data.tag.ptr_id + ', UID: ' + data.tag.ptr_uid);
                    $('#id_identificado').text(data.tag.ptr_uid);
                    $('#box-loader').hide();
                    $('#box-uid').show();
                    $('#box-form').show();
                    clearInterval(intervaloConsulta); // Detener las consultas
                } else {
                    console.log('No hay tag RFID asignado aún.');
                }
            })
            .catch(error => {
                console.error('Error al consultar el estado del tag RFID:', error);
            });
    }, 3000);

    //oculta el box-uid al iniciar la pagina
    $('#box-uid').hide();
    $('#box-form').hide();


});




</script>




@endsection
