@extends('welcome')

@section('contenido')


{!! Html::script('js/controladores/correr_vto_servicios.js') !!}

  <!-- CSS TABLAS -->
  <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<div class="nav-md" ng-controller="correr_vto_servicios" >

  <div class="container body">

    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" value="organismos">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Postergar vencimiento <small>Postergar el vencimiento de una cuota</small></h2>
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

                    <span class="section">Datos del servicio</span>


                  @verbatim
                    <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">

                        <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]" >
                        <tr class="clickableRow" title="Datos">
                            <td title="'Asociado'" sortable="'nombre'">
                              {{abm.socio.nombre}}
                            </td>
                            <td title="'Proveedor'" sortable="'nombre'">
                              {{abm.producto.proovedor.nombre}}
                            </td>
                            <td title="'Producto'" sortable="'apellido'">
                                {{abm.producto.nombre}}
                            </td>
                            <td title="'Importe'" sortable="'documento'">
                                {{abm.importe}}
                            </td>
                            <td title="'Numero de cuotas'" sortable="'email'">
                                {{abm.nro_cuotas}}
                            </td>
                            <td title="'Numero de credito'" sortable="'cuit'">
                                {{abm.nro_credito}}
                            </td>
                            <td title="'Fecha de vencimiento'" sortable="'domicilio'">
                                {{abm.fecha_vencimiento | date: "dd/MM/y"}}
                            </td>

                              <td title="'Postergar'" sortable="'domicilio'">
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="Cantidad de dias" ng-model="cantDias">
                                  <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary" ng-click="confirmarCambios(abm.fecha_vencimiento, cantDias, abm.id)">
                                      <i class="glyphicon glyphicon-chevron-right"></i>
                                    </button>
                                  </div>
                                </div>
                              </td>
                        </tr>
                    </table>
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

  <!-- bootstrap progress js -->


  <!-- icheck -->

  <!-- pace -->


  <!-- form validation -->

        <script src="js/datatables/jquery.dataTables.min.js"></script>
        <script src="js/datatables/dataTables.bootstrap.js"></script>
        <script src="js/datatables/dataTables.buttons.min.js"></script>
        <script src="js/datatables/buttons.bootstrap.min.js"></script>
        <script src="js/datatables/jszip.min.js"></script>
        <script src="js/datatables/pdfmake.min.js"></script>
        <script src="js/datatables/vfs_fonts.js"></script>
        <script src="js/datatables/buttons.html5.min.js"></script>
        <script src="js/datatables/buttons.print.min.js"></script>
        <script src="js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="js/datatables/dataTables.keyTable.min.js"></script>
        <script src="js/datatables/dataTables.responsive.min.js"></script>
        <script src="js/datatables/responsive.bootstrap.min.js"></script>
        <script src="js/datatables/dataTables.scroller.min.js"></script>


<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/jszip.min.js"></script>

<script type="text/javascript">

</script>



         <script>

        </script>

</div>


@endsection