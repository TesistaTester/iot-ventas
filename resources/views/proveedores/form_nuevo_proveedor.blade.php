@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
		<h3 class="title-header" style="text-transform: uppercase;">
			<i class="fa fa-plus"></i>
			{{$titulo}}
			<a href="{{url('proveedores')}}" title="Volver a lista de proveedores" data-placement="bottom" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-angle-double-left"></i> ATRÁS</a>
		</h3>

		<div class="row">
			<div class="col-md-12">
				<!-- inicio card  -->
				<div class="card">
					<div class="row no-gutters">
						<div class="col-md-12">
							<div class="card-body">
								<form id="form-nuevo-proveedor" action="{{secure_url('proveedores')}}" method="POST">
								  @csrf
								  <section id="seccion-datos-proveedor">
									<h4 class="card-title"><strong><span class="text-primary">
										<i class="fa fa-database"></i>
										Datos del proveedor
									</span></strong></h4>
									<hr>
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Nombre del proveedor:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el nombre del proveedor"></i>
														</label>
														<input required type="text" value="{{old('pve_nombre')}}" class="form-control @error('pve_nombre') is-invalid @enderror" name="pve_nombre" id="pve_nombre" placeholder="Nombre del proveedor">
														@error('pve_nombre')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															NIT Proveedor:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el NIT o CI del proveedor"></i>
														</label>
														<input required type="text" value="{{old('pve_nit')}}" class="form-control @error('pve_nit') is-invalid @enderror" name="pve_nit" id="pve_nit" placeholder="NIT Proveedor">
														@error('pve_nit')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Telefono proveedor:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el telefono del proveedor"></i>
														</label>
														<input required type="text" value="{{old('pve_telefono')}}" class="form-control @error('pve_telefono') is-invalid @enderror" name="pve_telefono" id="pve_telefono" placeholder="Telefono proveedor">
														@error('pve_telefono')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Email Proveedor:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el email del proveedor"></i>
														</label>
														<input required type="email" value="{{old('pve_email')}}" class="form-control @error('pve_email') is-invalid @enderror" name="pve_email" id="pve_email" placeholder="Email proveedor">
														@error('pve_email')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-8">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Direccion Proveedor:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer la direccion del proveedor"></i>
														</label>
														<input required type="text" value="{{old('pve_direccion')}}" class="form-control @error('pve_direccion') is-invalid @enderror" name="pve_direccion" id="pve_direccion" placeholder="Direccion proveedor">
														@error('pve_direccion')
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