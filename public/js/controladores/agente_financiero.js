var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable','Mutual.services']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('agente_financiero', function($scope, $http, $compile, $sce, NgTableParams, $filter,UserSrv) {

    $scope.pullSolicitudes = function (){

        $http({
            url: 'agente_financiero/solicitudes',
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

    $scope.IDModal = function(id) {
        $scope.idpropuestae = id;
    }

    $scope.IDPropuesta = function(id,importe,monto,cantcuotas) {
        $scope.idpropuestae = id;
        $scope.importe = importe;
        $scope.monto_por_cuota = monto;
        $scope.cuotas = cantcuotas;
    }

    $scope.ReservarCapital = function(id) {
        $http({
                url: 'agente_financiero/reservarCapital',
                method: 'post',
                data: {'id':id,'estado':'Capital Reservado'}
            }).then(function successCallback(response)
            {
                
                    UserSrv.MostrarMensaje("OK","El capital fue reservado correctamente.","OK","mensaje");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");

            });
    }

    $scope.OtorgarCapital = function(id) {
        
        $http({
            url: 'agente_financiero/otorgarCapital',
            method: 'post',
            data: {'id':id,'estado':'Capital Otorgado'}
        }).then(function successCallback(response)
        {
            
                UserSrv.MostrarMensaje("OK","El capital fue otorgado correctamente.","OK","mensaje");
                $scope.pullSolicitudes();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");

        });
    
    }

    $scope.EnviarPropuesta = function () {
        
        if(($scope.monto_por_cuota * $scope.cuotas) >= $scope.importe){

            $http({
                url: 'agente_financiero/enviarPropuesta',
                method: 'post',
                data: {'id':$scope.idpropuestae,'total':$scope.importe,'cuotas':$scope.cuotas,'monto_por_cuota':$scope.monto_por_cuota,'estado':'Esperando Respuesta Comercializador'}
            }).then(function successCallback(response)
            {
                
                    UserSrv.MostrarMensaje("OK","La propuesta fue enviada correctamente.","OK","mensajemodal","ContraPropuesta");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal");

            });

        } else {
            UserSrv.MostrarMensaje("Error","El monto por cuota y las cuotas son incongruentes con el importe total.","Error","mensajemodal");
        }
    }

    $scope.AceptarContraPropuesta = function () {

        $http({
            url: 'agente_financiero/aceptarPropuesta',
            method: 'post',
            data: {'id':$scope.idpropuestae,'estado':'Aceptada por Comercializador'}
        }).then(function successCallback(response)
        {
            
                UserSrv.MostrarMensaje("OK","La contra propuesta fue aceptada correctamente.","OK","mensajemodal2","AnalizarPropuesta");
                $scope.pullSolicitudes();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal2");

        });

    }

        $scope.RechazarContraPropuesta = function () {

        $http({
            url: 'agente_financiero/rechazarPropuesta',
            method: 'post',
            data: {'id':$scope.idpropuestae,'estado':'Rechazada por Inversionista'}
        }).then(function successCallback(response)
        {
            
                UserSrv.MostrarMensaje("OK","La contra propuesta fue rechazada correctamente.","OK","mensajemodal2","AnalizarPropuesta");
                $scope.pullSolicitudes();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal2");

        });

        }


    $scope.Comprobante = function (){

        archivo = $scope.comprobantevisualizar;
        
        document.getElementById('previsualizacion').src = "images/"+archivo+".png";

    }

    $scope.PropuestaModificada = function () {

        $http({
            url: 'agente_financiero/contraPropuesta',
            method: 'post',
            data: {'id':$scope.idpropuestae,'total':$scope.importe,'cuotas':$scope.cuotas,'monto_por_cuota':$scope.monto_por_cuota,'estado':'Esperando Respuesta Comercializador'}
        }).then(function successCallback(response)
        {
            
                UserSrv.MostrarMensaje("OK","La contra propuesta fue enviada correctamente.","OK","mensajemodal2","AnalizarPropuesta");
                $scope.pullSolicitudes();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal2");

        });

    }

    $scope.ModificarPropuesta = function (valor) {
        $scope.modificandopropuesta = valor;
    }

    $scope.DatosModal = function (documento,recibo,cbu,domicilio,endeudamiento){

        $scope.DatosModalActual = [
        {'comprobante':'Documento','archivo':documento},
        {'comprobante':'Recibo','archivo':recibo},
        {'comprobante':'CBU','archivo':cbu},
        {'comprobante':'Domicilio','archivo':domicilio},
        {'comprobante':'Endeudamiento','archivo':endeudamiento}
        ];

    }
    
    var self = this;
    $scope.pullSolicitudes();
    

});
