angular.module("artevisualsoft",['ngMessages','ngMaterial','money-mask','swxSessionStorage','swxLocalStorage']);
angular.module("artevisualsoft").controller("artevisualsoftCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.marca=[];

    $scope.urlBase = '<?=$apiServe?>';
    $scope.marca = [];

    var getMarca = function(){
        
        $http({
            method:'GET',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               
            }),
            url: $scope.urlBase + "/services/marca?matriz=<?=$_SESSION['empresa']['matriz']?>"
            }).then(function onSuccess(response){
                $scope.marca = response.data;
                
            }).catch(function onError(response){

        })
    }
    
    getMarca();

    $scope.salvarMarca = function(e){
        console.log(e);
        if(e != undefined && e != ''){
            $http({
                method:'POST',
                headers:{
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                   categ: e,
                   matriz: "<?=$_SESSION['empresa']['matriz']?>",
                   empresa:"<?=$_SESSION['empresa']['id']?>",
                   codfunc: "<?=$_SESSION['usuario']['id']?>",
                   nomefunc: "<?=$_SESSION['usuario']['name']?>",

                }),
                url: $scope.urlBase + "/services/marca"
                }).then(function onSuccess(response){
                    $scope.return = response.data;
                    if($scope.return[0].return == 'SUCCESS'){
                        
                        $('#addMArca').modal('hide');
                        $('#marcaNome').val('');
                       
                        getMarca();
                    }
                    
                   
                }).catch(function onError(response){
    
            })
        }
    }


})
