<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo') - {{env('APP_NAME')}}</title>
    {{-- HOJAS DE ESTILO --}}
    <link rel="shortcut icon" href="{{secure_url('img/favicon.ico')}}" type="image/x-icon">
	<link rel="icon" href="{{secure_url('img/favicon.ico')}}" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="{{secure_url('css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{secure_url('css/int.styles.css')}}">
	<link rel="stylesheet" type="text/css" href="{{secure_url('css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{secure_url('css/datatables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{secure_url('css/bootstrap-multiselect.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{secure_url('css/select2.min.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>

    {{--   JS PARA TODO EL PROYECTO   --}}
    <script src="{{secure_url('js/jquery36.min.js')}}"></script>
    <script src="{{secure_url('js/popper.min.js')}}"></script>
    <script src="{{secure_url('js/bootstrap.min.js')}}"></script>
    <script src="{{secure_url('js/datatables.min.js')}}"></script>
    <script src="{{secure_url('js/bootstrap-multiselect.min.js')}}"></script>
    <script src="{{secure_url('js/select2.min.js')}}"></script>
    <script src="{{secure_url('js/chart.min.js')}}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

</head>
<body>

    {{-- TOP MENÚ (INICIO) --}}
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary nav-top-menu">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand navbar-brand-centered" href="#">
                        <img style="height:55px;" src="{{ asset('img/logo_agua.png')}}" alt="..." class="">
                    </a>
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            {{-- <a class="nav-link" href="#">
                                <i class="fa fa-home"></i> INICIO <span class="sr-only">(current)</span>
                            </a> --}}
                        </li>
                    </ul>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>
                            Cuenta de usuario
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-user-profile" style="padding:0 !important;">
                            <div class="card card-user">
                                <div class="card-body text-center" style="padding:10px;">
                                    <h4 class="text-white">
                                        <small>
                                            {{Auth::user()->usu_nombre_completo}}
                                        </small>
                                        <br>
                                        <small class="text-uppercase text-info" style="font-size:0.6em;">
                                            @if (Auth::user()->usu_rol == 1)
                                            ADMINISTRADOR DE SISTEMA
                                            @else
                                            MONITOREO    
                                            @endif
                                        </small>
                                    </h4>
                                    <div class="box-user-menu">
                                        {{-- <a href="#" class="dropdown-item"><i class="fa fa-user"></i> Ver perfil</a>
                                        <a href="#" class="dropdown-item"><i class="fa fa-lock"></i> Actualizar password</a> --}}
                                        <a href="{{url('logout')}}" class="dropdown-item"><i class="fa fa-sign-out"></i> Cerrar sesión</a>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            </nav>
    
    {{-- TOP MENÚ (FIN) --}}

    {{-- CONTENEDOR PRINCIPAL (INICIO) --}}
    <div class="row page-content"">
        {{-- MENU CONTEXTUAL --}}
        <div class="col-md-2 nav-contextual-container">
            <div class="nav-contextual">
                    <nav class="nav nav-pills" aria-orientation="vertical">
                        <a class="nav-item nav-link @if($modulo_activo == 'dashboard'): active @endif" href="{{url('dashboard')}}"><i class="fa fa-home"></i> PANEL GENERAL</a>
                        @if (true)
                        {{-- @if (Auth::user()->usu_rol == 1) --}}
                        <h6 class="text-center text-white" style="text-transform: uppercase;">
                            <small>- VENTAS Y DESPACHO -</small>
                        </h6>                        
                        <a class="nav-item nav-link @if($modulo_activo == 'ventas'): active @endif" href="{{url('ventas')}}"><i class="fa fa-dollar"></i> VENTAS</a>
                        <a class="nav-item nav-link @if($modulo_activo == 'clientes'): active @endif" href="{{url('clientes')}}"><i class="fa fa-suitcase"></i> CLIENTES</a>
                        @endif
                        <h6 class="text-center text-white" style="text-transform: uppercase;">
                            <small>- ALMACEN-</small>
                        </h6>                        
                        <a class="nav-item nav-link @if($modulo_activo == 'inventario'): active @endif" href="{{url('inventario')}}"><i class="fa fa-th-list "></i> INVENTARIO</a>
                        <a class="nav-item nav-link @if($modulo_activo == 'proveedores'): active @endif" href="{{url('proveedores')}}"><i class="fa fa-share-alt"></i> PROVEEDORES</a>
                        <a class="nav-item nav-link @if($modulo_activo == 'productos'): active @endif" href="{{url('productos')}}"><i class="fa fa-th"></i> PRODUCTOS</a>
                        <h6 class="text-center text-white" style="text-transform: uppercase;">
                            <small>- ADMINISTRACIÓN-</small>
                        </h6>                        
                        {{-- <a class="nav-item nav-link @if($modulo_activo == 'modulos'): active @endif" href="{{url('modulosiot')}}"><i class="fa fa-line-chart"></i> MODULOS IOT</a> --}}
                        <a class="nav-item nav-link @if($modulo_activo == 'usuarios'): active @endif" href="{{url('usuarios')}}"><i class="fa fa-users"></i> USUARIOS</a>
                        <a class="nav-item nav-link @if($modulo_activo == 'reportes'): active @endif" href="{{url('reportes')}}"><i class="fa fa-line-chart"></i> REPORTES</a>
                        {{-- <a class="nav-item nav-link @if($modulo_activo == 'alertas'): active @endif" href="{{url('configuracion')}}"><i class="fa fa-cogs"></i> CONFIGURACION</a> --}}
                    </nav>
    
                <div class="box-copyright">
                    &copy; {{date('Y')}} {{env('APP_NAME')}}
                </div>
    
            </div>
        </div>
        {{-- MENU CONTEXTUAL (FIN) --}}

        {{-- CONTENIDO VARIABLE (INICIO) --}}
        @yield('contenido')        
        {{-- CONTENIDO VARIABLE (FIN)--}}
    </div>
    
    {{-- CONTENEDOR PRINCIPAL (FIN) --}}

    <script>
        $(function(){
			/*
            -----------------------------------------------------------------------
			FUNCIONES / EVENTOS GENERICOS PARA TODA LA APP
            -----------------------------------------------------------------------
            */
            //PRELOADER
            // $('.preloader').fadeOut('fast');
            //TOOLTIPS
            $('[title]').tooltip();
            //HTML SELECT MULTIPLE PLUGIN
            $('.select-multi').multiselect({nonSelectedText:"Seleccione una o más opciones"});

			//CONVERTIR TODOS LOS INPUT TEXT A MAYUSCULAS
			$("input[type=text]:not(input.txt_pwd, input.txt_email), textarea").keyup(function () {
				// if($(this).attr('data-tipo') != 'email' || $(this).attr('data-tipo') != 'pwd'){
    			  var start = this.selectionStart;
				  var end = this.selectionEnd;
				  this.value = this.value.toUpperCase();
				  this.setSelectionRange(start, end);
					// $(this).val($(this).val().toUpperCase());
				// }
			});
            //ALERTAS NO PERSISTENTES
            setTimeout(function(){$('.alert-not-persistent').slideUp(2000);}, 10000);


        });
        </script>
        
</body>
</html>