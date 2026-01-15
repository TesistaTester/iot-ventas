@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
		<h3 class="title-header" style="text-transform: uppercase;">
			<i class="fa fa-edit"></i>
			{{$titulo}}
			<a href="{{url('productos')}}" title="Volver a lista de productos" data-placement="bottom" class="btn btn-sm btn-secondary float-right" style="margin-left:10px;"><i class="fa fa-angle-double-left"></i> ATRÁS</a>
		</h3>

		<div class="row">
			<div class="col-md-12">
				<!-- inicio card  -->
				<div class="card">
					<div class="row no-gutters">
						<div class="col-md-12">
							<div class="card-body">
								<form id="form-nuevo-producto" action="{{secure_url('productos/'.Crypt::encryptString($producto->pro_id))}}" method="POST">
								  @csrf
   								  @method('PUT')								  
								  <section id="seccion-datos-cuenta-modulo-lectura">
									<h4 class="card-title"><strong><span class="text-primary">
										<i class="fa fa-database"></i>
										Datos del producto
									</span></strong></h4>
									<hr>
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Nombre del producto:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer una descripcion del modulo de lectura"></i>
														</label>
														<input required type="text" value="{{old('pro_nombre', $producto->pro_nombre)}}" class="form-control @error('pro_nombre') is-invalid @enderror" name="pro_nombre" id="pro_nombre" placeholder="Nombre del producto">
														@error('pro_nombre')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Proveedor:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer una descripcion del modulo de lectura"></i>
														</label>
														<select required class="form-control @error('pve_id') is-invalid @enderror" name="pve_id" id="pve_id">
															<option value="">Seleccione una opción</option>
															@foreach ($proveedores as $item)
															<option value="{{ $item->pve_id }}" {{ old('pve_id', $producto->pve_id) == $item->pve_id ? 'selected' : '' }}>{{ $item->pve_nombre }}</option>																
															@endforeach
														</select>
														@error('pve_id')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															SKU:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer una descripcion del modulo de lectura"></i>
														</label>
														<input required type="text" value="{{old('pro_sku', $producto->pro_sku)}}" class="form-control @error('pro_sku') is-invalid @enderror" name="pro_sku" id="pro_sku" placeholder="SKU Producto">
														@error('pro_sku')
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
															Descripcion del producto:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer la descripcion del producto"></i>
														</label>
														<input required type="text" value="{{old('pro_descripcion', $producto->pro_descripcion)}}" class="form-control @error('pro_descripcion') is-invalid @enderror" name="pro_descripcion" id="pro_descripcion" placeholder="Descripcion producto">
														@error('pro_descripcion')
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
															Precio venta:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el precio de venta"></i>
														</label>
														<input required type="number" step="0.1" value="{{old('pro_precio_venta', $producto->pro_precio_venta)}}" class="form-control @error('pro_precio_venta') is-invalid @enderror" name="pro_precio_venta" id="pro_precio_venta" placeholder="Precio de venta">
														@error('pro_precio_venta')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Precio compra:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el precio de compra"></i>
														</label>
														<input required type="number" step="0.1" value="{{old('pro_precio_compra', $producto->pro_precio_compra)}}" class="form-control @error('pro_precio_compra') is-invalid @enderror" name="pro_precio_compra" id="pro_precio_compra" placeholder="Precio de compra">
														@error('pro_precio_compra')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Stock Minimo:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer una descripcion del modulo de lectura"></i>
														</label>
														<input required type="number" step="1" value="{{old('pro_stock_minimo', $producto->pro_stock_minimo)}}" class="form-control @error('pro_stock_minimo') is-invalid @enderror" name="pro_stock_minimo" id="pro_stock_minimo" placeholder="Stock minimo">
														@error('pro_stock_minimo')
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
															Actualizar datos
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