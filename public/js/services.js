angular.module('Mutual.services', ['ngTable'])


.service('UserSrv', function($http,$mdDialog, NgTableParams,$filter){

    var that = this;
    this.MostrarMensaje = function(titulo,mensaje,tipo,sector,nombremodal){
        if(tipo != 'Error'){
            $('#'+sector).html('<div class="alert alert-success" role="alert"><strong>¡'+titulo+'!</strong> '+mensaje+'</div>');
            setTimeout(function(){ 
                $('#'+sector).html('');
                $('#'+nombremodal).modal('hide');
                 
                }, 2000);
        } else {
            $('#'+sector).html('<div class="alert alert-danger" role="alert"><strong>¡'+titulo+'!</strong> '+mensaje+'</div>');
            setTimeout(function(){ $('#'+sector).html(''); }, 4000);
        }
    }

    this.Excel = function(vista) {
        var vista = prompt("Guardar como..", "");
        var divToPrint=document.getElementById('exportTable');
        var tabla=document.getElementById('tablita').innerHTML;
        var newWin=window.open('','sexportTable');

        newWin.document.open();
        var code = '<html><link rel="stylesheet" href="js/angular-material/angular-material.min.css"><link rel="stylesheet" href="css/bootstrap.min.css"<link rel="stylesheet" href="fonts/css/font-awesome.min.css"><link rel="stylesheet" href="ss/animate.min.css"><link rel="stylesheet" href="css/custom.css"><link rel="stylesheet" href="css/icheck/flat/green.css"><link rel="stylesheet" href="css/barrow.css"><link rel="stylesheet" href="css/floatexamples.css"><link rel="stylesheet" href="css/ng-table.min.css"><link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.min.css"><body onload="window.print()"><div id="juan"><table ng-table="paramsABMS" class="table table-hover table-bordered">'+tabla+'</table></div></body></html>';
        newWin.document.write(code);
        newWin.document.getElementById('botones').innerHTML = '';

        var data_type = 'data:application/vnd.ms-excel';
        var table_html = newWin.document.getElementById('juan').outerHTML.replace(/ /g, '%20');

        var a = newWin.document.createElement('a');
        a.href = data_type + ', ' + table_html;
        a.download = vista + '.xls';
        a.click();

   }

   this.Params = function(array){
   
            
        newParams = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: array.length,
                    getData: function (params) {
                        array = $filter('orderBy')(array, params.orderBy());
                        return array.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
        console.log(newParams);
        return newParams;
    }

    this.RequestTable = function(url,metodo){

        $http({
            url: url,
            method: metodo
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                recibido = that.Params(response.data);
                return recibido;
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });

    }

    this.ShowLoading = function(){
       var path = '';
       return path;
    }

    

});