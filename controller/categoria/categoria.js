angular.module("artevisualsoft",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("artevisualsoft").controller("artevisualsoftCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.urlBase = '<?=$apiServe?>';
    $scope.categorias = [];

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

    $scope.salvarCateg = function(e,r){
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
                url: $scope.urlBase + "/services/categoria"
                }).then(function onSuccess(response){
                    $scope.return = response.data;
                    if($scope.return[0].return == 'SUCCESS'){
                        if(r == 0){
                            $('#exampleModal').modal('hide');
                            $('#categN').val('');
                        }else if(r == 1){
                            $('#categN').val('');
                        }
                        getCategorias();
                    }
                    
                   
                }).catch(function onError(response){
    
            })
        }
    }

    $scope.removerCategoria = function(categoria){
        $http({
            method:'DELETE',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               categ: categoria.id,
               name: categoria.descricao,
               matriz: "<?=$_SESSION['empresa']['matriz']?>",
                empresa:"<?=$_SESSION['empresa']['id']?>",
                codfunc: "<?=$_SESSION['usuario']['id']?>",
                nomefunc: "<?=$_SESSION['usuario']['name']?>",

            }),
            url: $scope.urlBase + "/services/categoria"
            }).then(function onSuccess(response){
                $scope.return = response.data;
                if($scope.return[0].return == 'SUCCESS'){
                   getCategorias();
                }
               
            }).catch(function onError(response){

        })
    }

    $scope.categ=[];
    $scope.editar = function(categoria){
        $('#editarCategoria').modal('show');
        $scope.categ=categoria;

    }

    $scope.salvarEdicao = function(e,n){
        $http({
            method:'PUT',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               categ: e.id,
               name: n,
               matriz: "<?=$_SESSION['empresa']['matriz']?>",
               empresa:"<?=$_SESSION['empresa']['id']?>",
               codfunc: "<?=$_SESSION['usuario']['id']?>",
               nomefunc: "<?=$_SESSION['usuario']['name']?>",

            }),
            url: $scope.urlBase + "/services/categoria"
            }).then(function onSuccess(response){
                $scope.return = response.data;
                if($scope.return[0].return == 'SUCCESS'){
                   getCategorias();
                   $('#editarCategoria').modal('hide');
                }
                
               
            }).catch(function onError(response){

        })
    }

    $scope.initDataTable = function() {
        var table = $('#categoria').DataTable({
            "language": {
                "url": "./public/assets/datatable/Portuguese.json",
            },
        });
    
        $('#categoria tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();
        })
  }

}).directive('repeatDone', function() {
    return function(scope, element, attrs) {
        if (scope.$last) { // all are rendered
            scope.$eval(attrs.repeatDone);
        }
    }
})
