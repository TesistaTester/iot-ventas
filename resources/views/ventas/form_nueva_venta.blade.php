@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-10 content-pane">
		<h3 class="title-header" style="text-transform: uppercase;">
			<i class="fa fa-plus"></i>
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
								<form id="form-nuevo-producto" action="{{secure_url('ventas')}}" method="POST">
								  @csrf
								  <section id="seccion-datos-cuenta-modulo-lectura">
									<div class="row">
										<div class="col-md-12">
											<h5 class="card-title"><strong><span class="text-primary">
												<i class="fa fa-user"></i>
												Datos del cliente
											</span></strong></h5>
											<hr>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Nombre cliente:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el nombre del cliente"></i>
														</label>
														<input required type="text" value="{{old('cli_nombre')}}" class="form-control @error('cli_nombre') is-invalid @enderror" name="cli_nombre" id="cli_nombre" placeholder="Nombre del cliente">
														@error('cli_nombre')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															NIT/CI:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el nro de documento"></i>
														</label>
														<input required type="text" value="{{old('cli_nro_documento')}}" class="form-control @error('cli_nro_documento') is-invalid @enderror" name="cli_nro_documento" id="cli_nro_documento" placeholder="Nro documento">
														@error('cli_nro_documento')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Telefono/celular:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el telefono del cliente"></i>
														</label>
														<input required type="text" value="{{old('cli_telefono')}}" class="form-control @error('cli_telefono') is-invalid @enderror" name="cli_telefono" id="cli_telefono" placeholder="Telefono cliente">
														@error('cli_telefono')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Email:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el email del cliente"></i>
														</label>
														<input required type="text" value="{{old('cli_email')}}" class="form-control @error('cli_email') is-invalid @enderror" name="cli_email" id="cli_email" placeholder="Email cliente">
														@error('cli_email')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
											</div>
											<div class="row">
												{{-- <div class="col-md-8">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Direccion:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer la direccion del cliente"></i>
														</label>
														<input required type="text" value="{{old('cli_direccion')}}" class="form-control @error('cli_direccion') is-invalid @enderror" name="cli_direccion" id="cli_direccion" placeholder="Direccion cliente">
														@error('cli_direccion')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div> --}}
											</div>
											<h5 class="card-title"><strong><span class="text-primary">
												<i class="fa fa-dollar"></i>
												Datos de la venta
											</span></strong></h5>
											<hr>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Fecha venta:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer la descripcion del producto"></i>
														</label>
														<input required type="date" value="{{old('ven_fecha_venta', date('Y-m-d'))}}" class="form-control @error('ven_fecha_venta') is-invalid @enderror" name="ven_fecha_venta" id="ven_fecha_venta" placeholder="Fecha de venta">
														@error('ven_fecha_venta')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Metodo pago:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el precio de venta"></i>
														</label>
														<select required class="form-control @error('ven_metodo_pago') is-invalid @enderror" name="ven_metodo_pago" id="ven_metodo_pago">
															<option value="">Seleccione una opción</option>
															<option value="Efectivo" {{ old('ven_metodo_pago') == 'Efectivo' ? 'selected' : '' }} selected>Efectivo</option>
															<option value="Transferencia Bancaria" {{ old('ven_metodo_pago') == 'Transferencia Bancaria' ? 'selected' : '' }}>Transferencia Bancaria</option>
															<option value="QR" {{ old('ven_metodo_pago') == 'QR' ? 'selected' : '' }}>QR</option>
														</select>
														@error('ven_metodo_pago')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div>
												{{-- <div class="col-md-4">
													<div class="form-group">
														<label class="label-blue label-block" for="">
															Total venta:
															<span class="text-danger">*</span>
															<i class="fa fa-question-circle float-right" title="Establecer el precio de venta"></i>
														</label>
														<input required type="number" step="0.1" value="{{old('ven_total')}}" class="form-control @error('ven_total') is-invalid @enderror" name="ven_total" id="ven_total" placeholder="Precio total de venta">
														@error('ven_total')
														<div class="invalid-feedback">
															{{$message}}
														</div>											
														@enderror
													</div>
												</div> --}}

											</div>

											
											<div class="row">
												<div class="col-md-6 offset-md-3 text-center">
													<button type="button" data-toggle="modal" data-target="#modal-detalle-venta" class="btn btn-primary btn-lg">
															<i class="fa fa-shopping-cart"></i>
															Llenar Carrito
													</button>
												</div>
											</div>

										</div>
									</div>

								  </section>


{{-- INICIO MODAL: DETALLE VENTA --}}
<div class="modal fade" id="modal-detalle-venta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#eee;">
          <h5 class="modal-title text-primary">
              <i class="fa fa-shopping-cart"></i>
              Carrito de compra
            </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
						<div class="row">
							<div class="col-md-6 offset-md-3">
								<div class="box-data-xtra">
									<h2>Total compra (Bs): <span class="box-result-numbers" style="padding:3px;" id="total-compra">0,00</span></h2>
									<input type="hidden" name="carrito_json" id="carrito_json">
									{{-- <textarea name="carrito_json" id="carrito_json" cols="30" rows="10"></textarea> --}}
								</div>
							</div>
							<div class="col-md-3 text-right">
								<button type="submit" class="btn btn-success btn-lg" id="btn-enviar-carrito">
									<i class="fa fa-save"></i>
									Registrar compra
								</button>
							</div>
						</div>
                        <table class="table table-bordered tabla-carrito">
                            <thead>
                            <tr>
                                <th>ID PROD</th>
                                <th>SKU</th>
                                <th>PRODUCTO</th>
                                <th>PRECIO VENTA</th>
                                <th>CANTIDAD</th>
                                <th>AGREGAR</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inventario as $item)
                            <tr
								class="item-carrito"
								data-id="{{ $item->producto->pro_id }}"
								data-precio="{{ $item->producto->pro_precio_venta }}"
							>
                                <td class="text-center">
                                    {{$item->producto->pro_id}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_sku}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_nombre}}
                                </td>
                                <td class="text-center">
                                    {{$item->producto->pro_precio_venta}}
                                </td>
                                <td class="text-center cantidad">
                                    {{$item->inv_cantidad}}
                                </td>
                                <td>
									<div class="input-group cantidad-item" 
										data-id="{{ $item->producto->pro_id }}"
										data-max="{{ $item->inv_cantidad }}">
										<div class="input-group-prepend">
											<button class="btn btn-outline-secondary btn-minus" type="button">−</button>
										</div>

										<input type="number" class="form-control text-center input-cantidad"
											value="0" min="0" max="{{ $item->inv_cantidad }}">

										<div class="input-group-append">
											<button class="btn btn-outline-secondary btn-plus" type="button">+</button>
										</div>
									</div>

                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
			
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  {{-- FIN MODAL: DETALLE VENTA --}}





								  
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
    $('.tabla-carrito').DataTable({"language":{url: '{{secure_asset('js/datatables-lang-es.json')}}'}, "order": [[ 0, "desc" ]]});

	$('#btn-enviar-carrito').attr('disabled','disabled');

	function actualizarCarrito() {
		let carrito = [];
		let total = 0;

		$('.item-carrito').each(function () {
			let fila = $(this);
			let cantidad = parseInt(fila.find('.input-cantidad').val()) || 0;

			if (cantidad > 0) {
				let productoId = fila.data('id');
				let precio = parseFloat(fila.data('precio'));
				let subtotal = precio*cantidad;

				carrito.push({
					producto_id: productoId,
					precio_unitario: precio,
					cantidad: cantidad,
					subtotal: subtotal,
				});

				total += precio * cantidad;
			}
		});

		// Guardar JSON en input hidden
		$('#carrito_json').val(JSON.stringify(carrito));

		// Mostrar total
		$('#total-compra').text(total.toLocaleString('es-BO', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		}));


		if(total == 0){
			$('#btn-enviar-carrito').attr('disabled','disabled');
		}else{
			$('#btn-enviar-carrito').removeAttr('disabled');
		}
	}


	// Botón +
    $(document).on('click', '.btn-plus', function () {
		let grupo = $(this).closest('.cantidad-item');
		let input = grupo.find('.input-cantidad');

		let max = parseInt(grupo.data('max'));
		let valor = parseInt(input.val()) || 0;

		if (valor < max) {
			input.val(valor + 1);
			actualizarCarrito();
		}	
	});

    // Botón -
    $(document).on('click', '.btn-minus', function () {
		let grupo = $(this).closest('.cantidad-item');
		let input = grupo.find('.input-cantidad');

		let valor = parseInt(input.val()) || 0;

		if (valor > 0) {
			input.val(valor - 1);
			actualizarCarrito();
		}		
    });

	$(document).on('input', '.input-cantidad', function () {
		let grupo = $(this).closest('.cantidad-item');
		let max = parseInt(grupo.data('max'));
		let valor = parseInt($(this).val()) || 1;

		if (valor < 0) valor = 0;
		if (valor > max) valor = max;

		$(this).val(valor);
		actualizarCarrito();
				
	});

	$(document).on('change', '.input-cantidad', function () {
		let grupo = $(this).closest('.cantidad-item');
		let max = parseInt(grupo.data('max'));
		let valor = parseInt($(this).val());

		grupo.find('.btn-plus').prop('disabled', valor >= max);
		grupo.find('.btn-minus').prop('disabled', valor <= 0);
	});



});	


	</script>


    @endsection