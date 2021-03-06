@extends('welcome')

@section('contenido')

{!! Html::script('js/controladores/cobrar_contablemente.js') !!}


<div class="nav-md" ng-controller="cobrar_contablemente" >

  <div class="container body" >


    <div class="main_container" >

      <!-- page content -->
      <input type="hidden" id="tipo_tabla" value="bancos">
      <div class="left-col" role="main" >

        <div class="" >

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Cobrar contablemente</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  @verbatim
                  <form class="form-horizontal form-label-left" ng-submit="submit()" id="formulario" >
                   {{ csrf_field() }}

                   <div class="item form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Tipo<span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                       <select class="form-control" ng-model="tipo">
                         <option value="servicios">Servicios</option>
                         <option value="cuotas_sociales">Cuotas sociales</option>
                       </select>
                     </div>
                   </div>

                   <div class="item form-group" ng-show="tipo == 'servicios'">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Deudor<span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                       <select class="form-control" ng-model="deudorSeleccionado">
                         <option ng-value="deudor" ng-repeat="deudor in deudores">{{deudor.nombre}}</option>
                       </select>
                     </div>
                   </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Forma de cobro <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" ng-model="formaCobro">
                          <option value="caja">Caja</option>
                          <option value="banco">Banco</option>
                        </select>
                      </div>
                    </div>

                    <div class="item form-group" ng-show="formaCobro == 'banco'">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Bancos disponibles<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" ng-model="bancoSeleccionado">
                          <option ng-value="banco" ng-repeat="banco in bancos">{{banco.nombre}}</option>
                        </select>
                      </div>
                    </div>



                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="importe">Importe <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required class="form-control col-md-7 col-xs-12" ng-model="importe" placeholder="Ingrese el importe" type="number">{{errores.nombre[0]}}
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button  type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancel</button>
                        <button id="send" type="submit" name="enviar" class="btn btn-success">Cobrar</button>
                      </div>
                    </div>
                  </form>
                  @endverbatim

                </div>
              </div>
            </div>
          </div>
        </div>



      </div>





      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>




</div>


@endsection
