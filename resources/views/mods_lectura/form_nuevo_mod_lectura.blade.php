@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
		<h3 class="title-header" style="text-transform: uppercase;">
			<i class="fa fa-plus"></i>
			{{$titulo}}
			<a href="{{url('modulos-lectura')}}" title="Volver a lista de modulo-lecturas" data-placement="bottom" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-angle-double-left"></i> ATRÁS</a>
		</h3>

		<div class="row">
			<div class="col-md-12">
				<!-- inicio card  -->
				<div class="card">
					<div class="row no-gutters">
						<div class="col-md-12">
							<div class="card-body">
								<form id="form-nuevo-modulo-lectura" action="{{secure_url('modulos-lectura')}}" method="POST">
								  @csrf
								  <section id="seccion-datos-cuenta-modulo-lectura">
									<h4 class="card-title"><strong><span class="text-primary">
										<i class="fa fa-database"></i>
										Datos del modulo de lectura
									</span></strong></h4>
									<hr>
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
															<label class="label-blue label-block" for="">
																Descripción:
																<span class="text-danger">*</span>
																<i class="fa fa-question-circle float-right" title="Establecer una descripcion del modulo de lectura"></i>
															</label>
														<input required type="text" value="{{old('mol_descripcion')}}" class="form-control @error('mol_descripcion') is-invalid @enderror" name="mol_descripcion" id="mol_descripcion" placeholder="Descripcion breve">
														@error('mol_descripcion')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Latitud:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer la latitud del modulo de lectura"></i>
														</label>
													<input required type="text" value="{{old('mol_lat', 0)}}" class="form-control @error('mol_lat') is-invalid @enderror" name="mol_lat" id="mol_lat" placeholder="Latitud" readonly>
													@error('mol_lat')
													<div class="invalid-feedback">
														{{$message}}
													</div>											
													@enderror
												</div>
												<div class="form-group">
													<label class="label-blue label-block" for="">
														Longitud:
														<span class="text-danger">*</span>
														<i class="fa fa-question-circle float-right" title="Establecer la longitud del modulo de lectura"></i>
													</label>
												<input required type="text" value="{{old('mol_lon', 0)}}" class="form-control @error('mol_lon') is-invalid @enderror" name="mol_lon" id="mol_lon" placeholder="Longitud" readonly>
												@error('mol_lon')
												<div class="invalid-feedback">
													{{$message}}
												</div>											
												@enderror
											</div>
									</div>
												<div class="col-md-8">
													<div class="form-group">
															<label class="label-blue label-block" for="">
																Seleccione un punto en el mapa:
																<span class="text-danger">*</span>
																<i class="fa fa-question-circle float-right" title="Contraseña del modulo-lectura. Autogenerado la primera vez"></i>
															</label>
															<div id="mapa-lecturas"></div>
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
	var map = L.map('mapa-lecturas').setView([-16.5580771, -67.9532047], 14);
	var marker = L.marker([-16.5580771, -67.9532047], {draggable:true})
	.on("dragend", function(e) {
	    punto = e.target.getLatLng();
		$('#mol_lat').val(punto.lat);
		$('#mol_lon').val(punto.lng);
	})
	.addTo(map);

	L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

});	


	</script>


    @endsection