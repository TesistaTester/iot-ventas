@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
		<h3 class="title-header" style="text-transform: uppercase;">
			<i class="fa fa-edit"></i>
			{{$titulo}}
			<a href="{{url('usuarios')}}" title="Volver a lista de usuarios" data-placement="bottom" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-angle-double-left"></i> ATRÁS</a>
		</h3>

		<div class="row">
			<div class="col-md-12">
				<!-- inicio card  -->
				<div class="card">
					<div class="row no-gutters">
						<div class="col-md-12">
							<div class="card-body">
								<form id="form-nuevo-usuario" action="{{url('usuarios/'.Crypt::encryptString($usuario->usu_id))}}" method="POST">
									@method('PUT')
									@csrf
								  <section id="seccion-datos-cuenta-usuario">
									<h4 class="card-title"><strong><span class="text-primary">
										<i class="fa fa-database"></i>
										Datos de la cuenta de usuario
									</span></strong></h4>
									<hr>
									<div class="row">
										<div class="col-md-10 offset-md-1">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
															<label class="label-blue label-block" for="">
																Nombre de usuario:
																<span class="text-danger">*</span>
																<i class="fa fa-question-circle float-right" title="Establecer el número de cédula de identidad + expedido. Pej.: 2334548 LP"></i>
															</label>
														<input required type="text" value="{{old('usu_nombre', $usuario->usu_nombre)}}" class="form-control @error('usu_nombre') is-invalid @enderror" name="usu_nombre" id="usu_nombre" placeholder="Nombre de usuario">
														@error('usu_nombre')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
															<label class="label-blue label-block" for="">
																Contraseña:
																<span class="text-danger">*</span>
																<i class="fa fa-question-circle float-right" title="Contraseña del usuario. Autogenerado la primera vez"></i>
															</label>
														<input required type="text" value="{{old('usu_password', "")}}" placeholder="Escribe la nueva contraseña" class="form-control txt_pwd @error('usu_password') is-invalid @enderror" name="usu_password" id="usu_password">
														@error('usu_password')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>

											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
															<label class="label-blue label-block" for="">
															Nombres y apellidos:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer los nombres de la persona que maneja la cuenta"></i>
															</label>
														<input required type="text" value="{{old('usu_nombre_completo', $usuario->usu_nombre_completo)}}" class="form-control @error('usu_nombre_completo') is-invalid @enderror" name="usu_nombre_completo" id="usu_nombre_completo" placeholder="Nombres y apellidos">
														@error('usu_nombre_completo')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>

												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="label-blue label-block" for="">
														Rol:
														<span class="text-danger">*</span>
														<i class="fa fa-question-circle float-right" title="Establecer el rol del usuario"></i>
														</label>
														<select required class="form-control @error('usu_rol') is-invalid @enderror" name="usu_rol" id="usu_rol">
															<option value="">Seleccione una opción</option>
															<option value="1" {{ old('usu_rol', $usuario->usu_rol) == 1 ? 'selected' : '' }}>Administrador</option>
															<option value="2" {{ old('usu_rol', $usuario->usu_rol) == 2 ? 'selected' : '' }}>Encargado Almacen</option>
															<option value="3" {{ old('usu_rol', $usuario->usu_rol) == 3 ? 'selected' : '' }}>Encargado Ventas</option>
															<option value="4" {{ old('usu_rol', $usuario->usu_rol) == 4 ? 'selected' : '' }}>Gerencia</option>
														</select>
														@error('usu_rol')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<button type="submit" class="btn btn-primary">
															<i class="fa fa-save"></i>
															Guardar datos
													</button>
												</div>
											</div>

										</div>
									</div>

								  </section>


								  
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- fin card  -->

			</div>
		</div>
	</div>

<script>
$(function(){

});	


	</script>


    @endsection