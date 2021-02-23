angular.module("artevisualsoft",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("artevisualsoft").controller("artevisualsoftCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.urlBase = '<?=$apiServe?>';
    $scope.categorias = [];
    $scope.subcategorias = [];

    var getSubCategorias = function(){
        
        $http({
            method:'GET',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               
            }),
            url: $scope.urlBase + "/services/subcategoria?matriz=<?=$_SESSION['empresa']['matriz']?>"
            }).then(function onSuccess(response){
                $scope.subcategorias = response.data;
                
            }).catch(function onError(response){

        })
    }
    
    getSubCategorias();

    var getCategorias = function(){
        
        $http({
            method:'GET',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               
            }),
            url: $scope.urlBase + "/services/categoria?matriz=<?=$_SESSION['empresa']['matriz']?>"
            }).then(function onSuccess(response){
                $scope.categorias = response.data;
                
            }).catch(function onError(response){

        })
    }
    
    getCategorias();

    $scope.salvarSubCateg = function(e,c,r){
               
        if(e != undefined && e != '' && c != undefined && c != ''){
            $http({
                method:'POST',
                headers:{
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                   subcateg: e,
                   categ: c,
                   matriz: "<?=$_SESSION['empresa']['matriz']?>",
                   empresa:"<?=$_SESSION['empresa']['id']?>",
                   codfunc: "<?=$_SESSION['usuario']['id']?>",
                   nomefunc: "<?=$_SESSION['usuario']['name']?>",

                }),
                url: $scope.urlBase + "/services/subcategoria"
                }).then(function onSuccess(response){
                    $scope.return = response.data;
                    if($scope.return[0].return == 'SUCCESS'){
                        if(r == 0){
                            $('#exampleModal').modal('hide');
                            $('#categN').val('');
                        }else if(r == 1){
                            $('#categN').val('');
                        }
                        getSubCategorias();
                    }
                    
                   
                }).catch(function onError(response){
    
            })
        }
    }

    $scope.removerSubCategoria = function(subcategorias){
        $http({
            method:'DELETE',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               categ: subcategorias.id,
               name: subcategorias.descricao,
               matriz: "<?=$_SESSION['empresa']['matriz']?>",
                empresa:"<?=$_SESSION['empresa']['id']?>",
                codfunc: "<?=$_SESSION['usuario']['id']?>",
                nomefunc: "<?=$_SESSION['usuario']['name']?>",

            }),
            url: $scope.urlBase + "/services/subcategoria"
            }).then(function onSuccess(response){
                $scope.return = response.data;
                if($scope.return[0].return == 'SUCCESS'){
                    getSubCategorias();
                }
               
            }).catch(function onError(response){

        })
    }

    $scope.subcateg=[];

    $scope.editar = function(subcategoria){
        $('#editarSubCategoria').modal('show');
        $scope.subcateg=subcategoria;

    }

    $scope.salvarSubEdicao = function(e,n,c){

        var categoria = c;
        
        if(categoria == undefined){
            categoria =  $scope.subcateg.idcategoria;
            
        }
        
        $http({
            method:'PUT',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               subcateg: e.id,
               name: n,
               categ: categoria,
               matriz: "<?=$_SESSION['empresa']['matriz']?>",
               empresa:"<?=$_SESSION['empresa']['id']?>",
               codfunc: "<?=$_SESSION['usuario']['id']?>",
               nomefunc: "<?=$_SESSION['usuario']['name']?>",

            }),
            url: $scope.urlBase + "/services/subcategoria"
            }).then(function onSuccess(response){
                $scope.return = response.data;
                if($scope.return[0].return == 'SUCCESS'){
                    getSubCategorias();
                   $('#editarSubCategoria').modal('hide');
                }
                
               
            }).catch(function onError(response){

        })
    }

})
