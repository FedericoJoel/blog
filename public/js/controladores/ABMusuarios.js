var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'verificarBaja']).config(function($interpolateProvider){});
app.controller('ABM', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

  $scope.borrarFormulario = function(){
    $('#formulario')[0].reset();
  }

    $scope.guardarDatosBaja = function () { $scope.elemABorrar = this.abm }
  $scope.delete= function(id){
      $scope.enviarFormulario('Borrar', id)
  }
  // manda las solicitud http necesarias para manejar los requerimientos de un abm
   $scope.enviarFormulario = function(tipoSolicitud, id = '')
   {
         var form = '';
         var abm = $("#tipo_tabla").val();
         switch(tipoSolicitud)
         {
            case 'Editar':
               var metodo = 'put';
               var form = $("#formularioEditar").serializeArray();
               var id = $('input[name=id]').val();
               break;
            case 'Alta':
               var metodo = 'post';
               var form = $("#formulario").serializeArray();
               break;
            case 'Borrar':
               var metodo = 'delete';
               break;
            case 'Mostrar':
               var metodo = 'get';
               break;
            default:
               console.log("el tipo de solicitud no existe");
               break;
         }

         var url = id == '' ? abm : abm+'/'+id;

         $http({
            url: url,
            method: metodo,
            data: $.param(form),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response)
            {
               if(tipoSolicitud == 'Mostrar')
                  {
                     console.log(response);
                     llenarFormulario('formularioEditar',response.data);
                  }
               $scope.mensaje = response;
               $('#formulario')[0].reset();
               $scope.errores = '';
             
               UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
                $scope.traerElementos();
            }, function errorCallback(data)
            {
                UserSrv.MostrarError(data)                 
               $scope.errores = data.data;
            });

   }

   $scope.traerRelaciones = function(relaciones)
   {

      for(x in relaciones)
      {

         var url = relaciones[x].tabla + '/traerRelacion'+relaciones[x].tabla;
         $http({
            url: url,
            method: 'get',
         }).then(function successCallback(response)
         {

          console.log(response);
            $.each(response.data, function(val, text) {
               console.log(relaciones[x].select);
               $(relaciones[x].select).append($("<option />").val(text.id).text(text.nombre));
               $(relaciones[x].select+'_Editar').append($("<option />").val(text.id).text(text.nombre));
            });
         }, function errorCallback(data)
         {
            console.log(data);
         });
      }
   }

   $scope.agregarPantalla = function()
   {

      var codigo = '';
      var array = [];
      for(var i = 0; $scope.numeroDeRoles > i; i++){

      codigo += '<div class="item form-group" >' +
           '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni" ng-click="console.log('+'anda'+')">Rol <span class="required">*</span></label>'+
         '<div class="col-md-6 col-sm-6 col-xs-12">'+
       '<select id="roles'+i+'" name="roles'+i+'" class="form-control col-md-7 col-xs-12" ></select>     </div>      </div>';

      }
      //$scope.agregarCodigo = $sce.trustAsHtml(codigo);
      $('#agregarCodigo').html(codigo);

         var url = 'roles/traerRoles';
         $http({
            url: url,
            method: 'get',
         }).then(function successCallback(response)
         {

          console.log(response);
            $.each(response.data, function(val, text) {

               for(var j = 0; $scope.numeroDeRoles > j; j++){

               $('#roles'+j).append($("<option />").val(text.name).text(text.name));


               }

            });
         }, function errorCallback(data)
         {
            console.log(data);
         });
   }

    $scope.traerElementos = function(relaciones)
   {
      var metodito = 'get';
      var abm = $("#tipo_tabla").val();
      var urlabm = abm + "/traerElementos";

      $http({
            url: urlabm,
            method: metodito
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.datosabm = response.data;
                $scope.paramsABMS = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    getData: function (params) {
                      var filterObj = params.filter();
                      filteredData = $filter('filter')($scope.datosabm, filterObj);
                      var sortObj = params.orderBy();
                      orderedData = $filter('orderBy')(filteredData, sortObj);
                      $scope.paramsABMS.total(orderedData.length);
                      $scope.datosabmfiltrados = orderedData;
                      return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });
   }

   $scope.traerElementos();


});
