$scope.produto=[];


$scope.quantidade = 1;
$scope.desconto = 0;
$scope.tipoVenda = 'varejo';
$scope.valorUN = 0;
$scope.valorTotal =0;
$scope.btn = false;

$scope.selecionarProduto = function(e){
    

    $scope.btn = true;
    var selectProd = $('#produto').val();
    var idProd = $("#idProduto").val();


    if(idProd != ''){
         $scope.aguarde = true;

        $http({

            method: 'POST',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
                produto: selectProd,
                idProd: idProd, 
                select:'S'
            }),
            url: $scope.urlBase + "/services/produtos"
        }).then(function onSuccess(response){
            
            $scope.produto = response.data;
            $scope.btn = false;

            if($scope.tipoVenda == 'varejo'){
                $scope.valorUN =  $scope.produto[0].precovista;
            }else if($scope.tipoVenda == 'atacado'){
                $scope.valorUN =  $scope.produto[0].precoatacado;
                if($scope.valorUN == '0.00'){
                    $scope.valorUN =  $scope.produto[0].precovista;
                }
                if($scope.valorUN == undefined){
                    $scope.valorUN =  $scope.produto[0].precovista;
                }
            }else{
                $scope.valorUN =  $scope.produto[0].precovista;
            }
            $scope.valorTotal =  ($scope.valorUN - ( $scope.valorUN * ($scope.desconto)/100)) * $scope.quantidade;

            $('#quantidade').popover({
                trigger: 'focus'
            })
            $scope.aguarde = false;
        }).catch(function onError(response){
        
        })

    }
    
}