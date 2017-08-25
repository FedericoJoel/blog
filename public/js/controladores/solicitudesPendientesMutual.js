var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable','Mutual.services']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('solicitudesPendientesMutual', function($scope, $http, $compile, $sce, NgTableParams, $filter,UserSrv) {

    $scope.pullSolicitudes = function (){

        $http({
            url: 'solicitudesPendientesMutual/solicitudes',
            method: 'get'
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.solicitudes = response.data;
                $scope.paramssolicitudes = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.solicitudes.length,
                    getData: function (params) {
                        $scope.solicitudes = $filter('orderBy')($scope.solicitudes, params.orderBy());
                        return $scope.solicitudes.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });



    }

        $scope.pullSolicitudes2 = function (){

        $http({
            url: 'solicitudesPendientesMutual/solicitudes2',
            method: 'get'
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.solicitudes2 = response.data;
                $scope.paramssolicitudes2 = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.solicitudes2.length,
                    getData: function (params) {
                        $scope.solicitudes2 = $filter('orderBy')($scope.solicitudes2, params.orderBy());
                        return $scope.solicitudes2.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });



    }

    $scope.IDModal = function(id) {
        $scope.idpropuestae = id;
        $scope.getAgentes();
    }

    $scope.AsignarAF = function() {
        $http({
                url: 'solicitudesPendientesMutual/actualizar',
                method: 'post',
                data: {'id':$scope.idpropuestae,'agente_financiero':$scope.agente}
            }).then(function successCallback(response)
            {
                
                    UserSrv.MostrarMensaje("OK","El agente financiero fué asignado correctamente.","OK","mensajemodal","AgenteFinanciero");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal","AgenteFinanciero");

            });
    }

    $scope.AprobarSolicitud = function(id) {
        $http({
                url: 'solicitudesPendientesMutual/aprobarSolicitud',
                method: 'post',
                data: {'id':id,'estado':'Solicitud Aprobada'}
            }).then(function successCallback(response)
            {
                    UserSrv.MostrarMensaje("OK","El agente financiero fué asignado correctamente.","OK","mensaje");
                    $scope.pullSolicitudes();
            }, function errorCallback(data)
            {
                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");
            });
    }

    $scope.AsignarEndeudamiento = function() {
        $http({
                url: 'solicitudesPendientesMutual/actualizar',
                method: 'post',
                data: {'id':$scope.idpropuestae,'doc_endeudamiento':$scope.endeudamiento}
            }).then(function successCallback(response)
            {
                
                    UserSrv.MostrarMensaje("OK","El endeudamiento fué asignado correctamente.","OK","mensajemodal2","Endeudamiento");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal","Endeudamiento");

            });
    }

    $scope.getAgentes = function (){
        $http({
            url: 'solicitudesPendientesMutual/proveedores',
            method: 'post',
            data: {'id':$scope.idpropuestae}
        }).then(function successCallback(response)
        {
          
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                $scope.agentesasignar = response.data;
                console.log(response);
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });
    }

    $scope.getFotos = function(idsolicitud)
    {
        $scope.idpropuestae = idsolicitud;
        return $http({
            url: 'comercializador/fotos',
            method: 'post',
            data: {'id' : idsolicitud}
            }).then(function successCallback(response)
                {
                    $scope.DatosModalActual = response.data;
                    console.log(response.data);
                }, function errorCallback(data){
                    console.log(data);
                });
    }

    $scope.Comprobante = function (){
 
        archivo = $scope.comprobantevisualizar;
        document.getElementById('previsualizacion').src = "storage/solicitudes/solicitud" + $scope.idpropuestae + "/"+archivo;

    }


    var self = this;
    $scope.pullSolicitudes();
    $scope.pullSolicitudes2();
    
    

});

