angular.module("artevisualsoft",['ngMessages','ngMaterial','money-mask','swxSessionStorage','swxLocalStorage']);
angular.module("artevisualsoft").controller("artevisualsoftCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $q, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.urlBase = '<?=$apiServe?>';
    $scope.caixaFechado = [];
    $scope.caixa = [];
    $scope.aguarde = false;
    $scope.idVenda = 0;

    var aguarde = function(){
        $scope.aguarde = !$scope.aguarde;
    }

    var caixaFechado = function(){
        aguarde();
        $http({
            method: 'GET',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               
            }),
            url: $scope.urlBase + "/services/caixa?cx=S&st=F&del=N"
            }).then(function onSuccess(response){
                $scope.caixaFechado = response.data;
                $scope.caixaSelect = $scope.caixaFechado[0].id;
                $('#caixasFechados').modal('show');
                aguarde()
            }).catch(function onError(response){
                aguarde();
        })
    }
    
    var caixaAberto = function(){

        aguarde();
        $http({
            method: 'GET',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               
            }),
            url: $scope.urlBase + "/services/caixa?cx=S&st=A&del=N"
            }).then(function onSuccess(response){
                $scope.caixa = response.data;
                
                if($scope.caixa == ''){
                    caixaFechado();
                }
                aguarde();
            }).catch(function onError(response){
                aguarde();
        })
    }
    caixaAberto();

    $scope.abrirCaixa = function(c, v){
        var saldo = v;

        if(v == undefined){
            saldo = 0;
        }

        aguarde();

        $http({
            method: 'PUT',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
               caixa: c,
               saldo: saldo,
               st:'Aberto'
            }),
            url: $scope.urlBase + "/services/caixa"
            }).then(function onSuccess(response){
                $scope.caixa = response.data;
                $('#caixasFechados').modal('hide');
                aguarde();
            }).catch(function onError(response){
                aguarde();
        })
        
    }

    $scope.cliente = '';
    $scope.salvarCliente = function(e){
        if(e != 0){
            $scope.cliente = e;
        }else{
            $scope.cliente = '';
        }
        
    }


    <?php
        include_once('produto_pdv.js');
    ?>


     $scope.atualizaValor = function(){
        
        var valorUN = $scope.valorUN.replace('R','');
        valorUN = valorUN.replace('$','');
        valorUN = valorUN.replace(',','.');

        $scope.valorTotal =  (valorUN- (valorUN * ($scope.desconto)/100)) * $scope.quantidade;
        
        
    }
    $scope.atualizaValorTipoVenda = function(){

        if($scope.produto != ''){
        
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
            }
            $scope.valorTotal =  ($scope.valorUN - ( $scope.valorUN * ($scope.desconto)/100)) * $scope.quantidade;
        }
    }
    
    $scope.vendaItens = [];
    $scope.totalItemSacola = 0;
    $scope.totalItens = 0;

    var somarItensSacola = function(){
        $scope.totalItemSacola = 0;
        $scope.totalItens = 0;
        $scope.totalItemSacola = $scope.vendaItens.reduce(function (accumulador, total) {return accumulador + parseFloat(total.total);}, 0);
        $scope.totalItens = $scope.vendaItens.reduce(function (accumulador, total) {return accumulador + parseFloat(total.qts);}, 0);
    }

    $scope.addItemVenda = function(){
        
        var item = Math.floor(Math.random() * 10000);
        var produto = $scope.produto;
        var qts = $scope.quantidade;
        var desc = $scope.desconto;
        var total =  $scope.valorTotal;
        var tipoVenda = $scope.tipoVenda;

        if($scope.tipoVenda == 'varejo'){
            var valorProduto =  $scope.produto[0].precovista;
        }else if($scope.tipoVenda == 'atacado'){
            var valorProduto =  $scope.produto[0].precoatacado;
            if(valorProduto == '0.00'){
                valorProduto =  $scope.produto[0].precovista;
            }
            if(valorProduto == undefined){
                valorProduto =  $scope.produto[0].precovista;
            }
        }

        var valorProduto = 0;

        $scope.vendaItens.push({
            item:item,
            idProd: produto[0].id,
            produto: produto[0].descricao + produto[0].descricaograde,
            tipoVenda: tipoVenda,
            qts:qts,
            desc:desc,
            valorProduto: valorProduto,
            total:total,
        })

        somarItensSacola();
        $("#produto").val('');
        $("#idProduto").val('');
        $scope.quantidade = 1;
        $scope.desconto = 0;
        $scope.tipoVenda = 'varejo';
        $scope.valorUN = 0;
        $scope.valorTotal =0;

    }

    $scope.removerItem = function(e){

        var index = $scope.vendaItens.indexOf(e);
        $scope.vendaItens.splice(index,1);
        somarItensSacola();
    }

    $scope.vendaAguardar = [];
    $scope.myDate = Date.now();

    $scope.guardarVenda = function(e){

        if($scope.vendaItens.length != 0){

            var data = $scope.myDate;
            var itensVenda =  $scope.vendaItens
            var totalItemSacola = $scope.totalItemSacola;
            var idVenda = $scope.idVenda;

            $scope.vendaAguardar.push({
                idVenda : idVenda,
                hora:data,
                itensVenda: itensVenda,
                total: totalItemSacola,
            });

            $scope.vendaItens = [];
            $scope.idVenda = 0;
            somarItensSacola();
            
        }
        
    }

    $scope.selecionarVenda = function(e){
        
        if( $scope.vendaItens.length > 0){
            swal ( "VENDAS " , " Finalize ou salve os itens da venda atual primeiro" , "info" )   ;
        }else{

            var index =  $scope.vendaAguardar.indexOf(e);
            $scope.vendaAguardar.splice(index,1);
            $scope.idVenda  = e.idVenda;
            var itensVenda = e.itensVenda;

            angular.forEach(itensVenda, function(value, key){
                $scope.vendaItens.push(itensVenda[key]);
            });
            
            somarItensSacola();
        }
       
    }
    
    $scope.salvarVenda = function(){

        if( $scope.vendaItens.length == 0){
            swal ( "VENDAS " , "Nenhuma venda a ser salva" , "info" )   ;
        }else{

            aguarde();

            var cliente = $scope.cliente;
            var vendas = $scope.vendaItens;
            var totalItens = $scope.totalItens;
            var valorTotal= $scope.totalItemSacola;
            var idVenda =  $scope.idVenda;

            $http({
                method: 'POST',
                headers:{
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                    idVenda: idVenda,
                    cliente: cliente,
                    vendas: vendas,
                    totalItens: totalItens,
                    valorTotal: valorTotal,
                }),
                url: $scope.urlBase + "/services/vendas?salvar=S"
                }).then(function onSuccess(response){
                    $scope.retorno = response.data;
                    
                    if($scope.retorno.return == 'SUCCESS'){
                        
                        swal({

                            title: "Vendas",
                            text: "Venda Salva com sucesso nº "+ $scope.retorno.doc + "",
                            icon: "success",
                            buttons: {
                                cancel: "Cancelar",
                                catch: {
                                    text: "Imprimir",
                                    value: "imprimir",
                                },
                                //confirm:"Mudar Endereço",
                            }
                        }).then((value) =>{
                            
                            
                        })

                        $scope.vendaItens = [];
                        somarItensSacola();

                    }
                    aguarde();
                   
                }).catch(function onError(response){
                    aguarde();
            })

        }
    }

    $scope.vendas_condicional = [];

    $scope.buscarVendas = function(){
        aguarde();

        $http({
        method: 'POST',
        headers:{
            'Content-Type': 'application/json',
        },
        data: JSON.stringify({
            
        }),
        url: $scope.urlBase + "/services/vendas?buscarVenda=S"
        }).then(function onSuccess(response){
            $scope.vendas_condicional = response.data;

            $('#vendas').modal();
            aguarde();
        }).catch(function onError(response){
            aguarde();
        })
    }
    $scope.vendas_condicional_select = [];
    $scope.clienteSelect = ''

    $scope.selecionarVendas = function(e){

        aguarde();

        $http({
            method: 'POST',
            headers:{
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
                id:e.id
            }),
            url: $scope.urlBase + "/services/vendas?selectVenda=S"
            }).then(function onSuccess(response){

                $scope.vendas_condicional_select = response.data;
                $scope.idVenda = e.id;

                var vendas_condicional = $scope.vendas_condicional_select;
                $scope.vendaItens = [];

                $scope.clienteSelect = vendas_condicional[0].idpessoa;

                for(i=0; i < vendas_condicional.length; i++){

                    var item = Math.floor(Math.random() * 10000);

                    $scope.vendaItens.push({
                        item:item,
                        idProd: vendas_condicional[i].id,
                        produto: vendas_condicional[i].descricao + ' ' + vendas_condicional[i].descricaograde,
                        qts:vendas_condicional[i].quantidade,
                        desc: vendas_condicional[i].descontoporcentagem,
                        valorProduto: vendas_condicional[i].precovista,
                        total: vendas_condicional[i].valortotal,
                    });

                    
                }
                somarItensSacola();
                $('#vendas').modal('hide');
                aguarde();
            }).catch(function onError(response){
                
            })
    }

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

    <?php
        include_once('cliente_pdv.js');
    ?>

    //finalizar venda 

    $scope.finalizarVenda = function(){
       
        if($scope.vendaItens.length == 0){
            swal("Aviso!", "Caixa não possui item", "info");
        }else{
            $("#finalizar_venda").modal("show");
        }
    }
    $scope.forma_pagamento=[];
    $scope.getFormaPagamentoTipo = function(f_pagamento){
        //$scope.urlBase
        if(f_pagamento != undefined){

            aguarde();
            $http.get($scope.urlBase+'/services/formaPagamento?buscar=s&id='+f_pagamento).then(function(response) {
                $scope.forma_pagamento = response.data;
            }, function(err) {
                console.log(err);
            });
            aguarde();
        }
    }

}).directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
})



$("#produto").blur(function(){
    //selecionarProduto();
})

$('#produto').keypress(function(e) {
    if((e.keyCode == 10) || (e.keyCode == 13)){
        //selecionarProduto();
    }

})

// $('#quantidade').blur(function(){
//     atualizaValor();
// })
// $('#desconto').blur(function(){
//     atualizaValor();
// })
// $('#valorUN').blur(function(){
//     atualizaValor();
// })
// $('#tipoVenda').blur(function(){
//     atualizaValor();
// })
// $('#tipoVenda').change(function(){
//     var tipoVenda = $("#tipoVenda").val();
//     console.log(tipoVenda);
// })

function buscarProduto(){
    var produtoReturn;
    var searchProd = $('#produto').val();

    var total = searchProd.length;
    var produto = [];
    if(total > 3){
        $.ajax({
            method: "POST",
            url: '<?=$apiServe?>/services/produtos',
            data: {produto: searchProd, busca:'S'},
            dataType: 'json',
            
        }).done(function(data) {
            produtoReturn = data;
            var grade;
            for(var i = 0; i < data.length; i++){
                
                if(data[i].descricaograde != null){
                    grade = data[i].descricaograde;
                }else{
                    grade ='';
                }
                produto.push(data[i].codigoreduzido + " - " +data[i].descricao+ ' ' + grade);
                
            }
           

        })
    }
    
     $( "#produto" ).autocomplete({
        source:produto,
        select: function (e, i) {
            var pdSelect = i.item.value.split(" ", 1)[0];
            var index = produtoReturn.indexOf(produtoReturn.filter((item) => item.codigoreduzido == pdSelect)[0],0);
            // console.log(produtoReturn[index].id);
            $("#idProduto").val(produtoReturn[index].id);

        }
    });
}

// function selecionarProduto(){
//     var selectProd = $('#produto').val();
//     var idProd = $("#idProduto").val();
    
//     if(idProd != ''){
//         $.ajax({
//             method: "POST",
//             url: '<?=$apiServe?>/services/produtos',
//             data: {produto: selectProd,idProd: idProd, select:'S'},
//             dataType: 'json',
            
//         }).done(function(data) {
            
//             var qts =   $("#quantidade").val();
//             var desc =  $("#desconto").val();
//             var tipoVenda = $("#tipoVenda").val();
//             var vendaVarejo = data[0].precovista;
//             var vendaAtacado = data[0].precovista;
            
//             if(tipoVenda == 'varejo'){
//                 var precovista = vendaVarejo;
//             }else if(tipoVenda == 'atacado'){
//                 var precovista = vendaAtacado;
//             }
//            var valorTotal =  (precovista - (precovista * (desc)/100)) * qts;

//            var valorTotal = valorTotal.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
//            var precovista = precovista.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});


//            $("#valorUN").val(precovista);
//            $("#valorTotal").val(valorTotal);

//            $("#valorTotal").mask("R$ 9999.99");

//         })
//     }
//     // var produto = [];
        
//     }
   
//     function atualizaValor(){
//         var qts =   $("#quantidade").val();
//             var desc =  $("#desconto").val();
//             var tipoVenda = $("#tipoVenda").val();
//             var precovista = $("#valorUN").val();
//            var valorTotal =  (precovista - (precovista * (desc)/100)) * qts;

//            var valorTotal = valorTotal.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
//            var precovista = precovista.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});


//            //$("#valorUN").val(precovista);
//            $("#valorTotal").val(valorTotal);

//            $("#valorTotal").mask("R$ 9999.99");
//     }