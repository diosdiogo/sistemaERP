$scope.buscarCliente = function(){
    $scope.cliente_pdv = [{
        id: 0,
        razaosocial: "",
        nomefantasia : "",
        idpessoatipo : null, 
        cpfoucnpj : null, 
        celular : null, 
        telefone : null, 
        limitecredito : null,
    }];

    $("#modal_cliente_pdv").modal("show");
}
$scope.cancelarSelectCliente = function(){
    
    $scope.cliente_pdv = [{
        id: 0,
        razaosocial: "0 - Cliente Consumidor",
        nomefantasia : "0 - Cliente Consumidor",
        idpessoatipo : null, 
        cpfoucnpj : null, 
        celular : null, 
        telefone : null, 
        limitecredito : null,
    }];
    
    $("#modal_cliente_pdv").modal("hide");
}

$scope.SelectCliente = function(){

    $scope.cliente_pdv = [{
        id:  $('#id_cliente_pdv').val(),
        razaosocial: "",
        nomefantasia : $('#cliente_pdv').val(),
        limitecredito : $('#cliente_pdv_limite').val(),
    }];

    $scope.salvarCliente($scope.cliente_pdv[0].id);
    $("#modal_cliente_pdv").modal("hide");
}