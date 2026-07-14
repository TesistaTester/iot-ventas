@extends('layouts.autenticado')
@section('titulo', $titulo)

@section('contenido')

<div class="col-md-9 content-pane">
    <h3 class="title-header" style="text-transform: uppercase;">
        <i class="fa fa-plus"></i>
        {{$titulo}}
        <a class="btn btn-sm btn-secondary float-right" style="margin-left:10px;" href="#"><i class="fa fa-angle-double-left"></i> ATRÁS</a>
    </h3>

    <div class="row">
        <div class="col-md-12">
            <!-- inicio card  -->
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title"><strong><span class="text-primary">
                                        <i class="fa fa-database"></i>
                                        Datos básicos
                                    </span></strong></h4>
                                    <hr>
                                    <small>Los campos marcados con asterisco (<span class="text-danger">*</span>) son obligatorios.</small>
                                    <form>
                                      <div class="form-group">
                                            <label class="label-blue label-block" for="">
                                                Nombre de la urbanización:
                                                <span class="text-danger">*</span>
                                                <i class="fa fa-question-circle float-right" title="Descripcion adicional"></i>
                                            </label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nombre urbanización">
                                      </div>
                                      <div class="form-group">
                                            <label class="label-blue label-block" for="">
                                                Fecha de aprobación:
                                                <i class="fa fa-question-circle float-right" title="Descripcion adicional"></i>
                                            </label>
                                        <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Fecha de aprobacion">
                                      </div>
                                        <div class="form-group">
                                            <label class="label-blue label-block" for="">
                                                Ley de municipal:
                                                <i class="fa fa-question-circle float-right" title="Descripcion adicional"></i>
                                            </label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ley municipal">
                                      </div>
                                      <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i>
                                            Guardar datos
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="card-title"><strong><span class="text-primary">
                                        <i class="fa fa-map"></i>
                                        Datos del plano
                                    </span></strong></h4>
                                    <hr>
                                    <form>
                                        <div class="alert alert-info">
                                            <div class="media">
                                                <img src=" {{asset('img/alert-info.png')}}" class="align-self-center mr-3" alt="...">
                                                <div class="media-body">
                                                    <h5 class="mt-0">Nota.-</h5>
                                                    <p>
                                                        Esta urbanización aún no tiene registrado el plano.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                      <button type="submit" class="btn btn-primary" disabled>
                                            <i class="fa fa-save"></i>
                                            Cargar planos
                                        </button>
                                    </form>
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


@endsection
