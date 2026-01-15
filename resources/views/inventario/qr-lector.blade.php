@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-qrcode"></i>
        {{$titulo}}
        <a href="{{url('inventario')}}" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-arrow-left"></i> ATRAS</a>
    </h3>
    <div class="row">
        <div class="col-12">              
                <!-- inicio card  -->
                <div class="card card-stat">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4 offset-md-4 text-center">
                                <div id="qr-reader" style="300px"></div>
                                <input type="hidden" id="qr-result">
                                <br>
                                <select class="form-control" name="evento" id="evento">
                                    <option value="">Seleccione evento entrada/salida</option>
                                    <option value="entrada">Entrada</option>
                                    <option value="salida">Salida</option>
                                </select>
                                <br>

                                <button id="btn-enviar" class="btn btn-success">
                                    <i class="fa fa-send"></i>
                                    Enviar datos
                                </button>

                                <hr>

                                <button id="btn-finalizar" class="btn btn-primary">
                                    <i class="fa fa-arrow-left"></i>
                                    Finalizar escaneo
                                </button>

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

    //inhabilita boton enviar hasta que se lea un codigo qr
    $('#btn-enviar').prop('disabled', true);
    //campo evento habilita boton enviar al seleccionar un evento si codigo qr ya fue leido
    $('#evento').on('change', function(){
        var codigo = $('#qr-result').val();
        if(codigo != '' && $('#evento').val() != ''){
            $('#btn-enviar').prop('disabled', false);
        }
    });
    //btn-enviar llama a la funcion onScanSuccess con el codigo qr leido
    $('#btn-enviar').on('click', function(e){
        e.preventDefault();
        var codigo = $('#qr-result').val();
        //condicional verifica si codigo esta vacio y evento esta seleccionado
        if(codigo == '' || $('#evento').val() == ''){
            alert('No se ha leído ningún código QR o no se ha seleccionado un evento.');
            return;
        }
        onScanSuccess(codigo, null);
    });    
    //btn-finalizar redirige a inventarios
    $('#btn-finalizar').on('click', function(e){
        e.preventDefault();
        window.location.href = "{{ url('inventario') }}";
    });

    function onScanSuccess(decodedText, decodedResult) {
        console.log("QR leído:", decodedText);
        $('#qr-result').val(decodedText);   

        $.ajax({
            url: "{{ url('/api/inventario/lectura_almacen_qr') }}",
            method: "POST",
            data: {
                codigo: decodedText,
                evento: $('#evento').val(),
                //token CSRF
                _token: '{{ csrf_token() }}'                    
            },
            success: function (response) {
                alert(response);
            }
        });
    }

    const scanner = new Html5QrcodeScanner(
        "qr-reader",
        {
            fps: 10,
            qrbox: 250
        },
        false
    );

    // 🔹 CAMBIAR TEXTOS A ESPAÑOL
    scanner.render(onScanSuccess, null);

    // Esperar a que se renderice el DOM interno
    setTimeout(() => {
        $(".html5-qrcode-element").each(function () {
            const text = $(this).text().trim();

            if (text === "Scan an Image File") $(this).text("Escanear imagen");
            if (text === "Start Scanning") $(this).text("Iniciar escaneo");
            if (text === "Stop Scanning") $(this).text("Detener escaneo");
            if (text === "Switch On Torch") $(this).text("Encender linterna");
            if (text === "Switch Off Torch") $(this).text("Apagar linterna");
            if (text === "Camera based scan") $(this).text("Escaneo con cámara");
            if (text === "File based scan") $(this).text("Escaneo desde archivo");
        });
    }, 500);



});


</script>




@endsection
