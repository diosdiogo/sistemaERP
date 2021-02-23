<?php
    date_default_timezone_set('America/Bahia');

    $data = date('Y-m-d H:i:s');

    $pont = array(".", "/" , "(", ")", "-","R","$",",");

    $sql = 'SELECT produto.id, produto.idmatriz, produto.idempresa, produto.descricao, grade_produto.descricao as descricaograde, 
        produto.codigoreduzido, produto.ativo, produto.custocompra,  produto.precovista, produto.precoatacado, produto.precoprazo, 
        produto.idestoque, produto.contabilizaestoque FROM produto left join grade_produto on ( produto.id = grade_produto.idproduto) 
        where produto.idmatriz = :matriz and habilitapdv = 1 and produto.deletado = "N";';

    $produtos =$pdo->prepare($sql);
    $produtos->bindValue(":matriz", $_SESSION['empresa']['matriz']);
    //$produtos->bindValue(":busca", $likeProduto);
    $produtos->execute();
    $resultProduto = $produtos->fetchAll(PDO::FETCH_ASSOC);

    $sqlCliente = "SELECT id, razaosocial, idpessoatipo, nomefantasia, cpfoucnpj, celular, telefone, limitecredito FROM pessoa where idmatriz = :matriz and cliente = 'S' and ativo = 1 and deletado = 'N';";

    $clientes =$pdo->prepare($sqlCliente);
    $clientes->bindValue(":matriz", $_SESSION['empresa']['matriz']);
    //$produtos->bindValue(":busca", $likeProduto);
    $clientes->execute();
    $resultClientes = $clientes->fetchAll(PDO::FETCH_ASSOC);
  

?>
<style>
    .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single{height: 51px !important; font-size: 28px !important;}.content{ background: #f4f4f4 !important}
    .main-footer{display: none}.skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side{background: #f9f9f9 !important; margin-left: -45px}
    .content-wrapper{background: #f4f4f4 !important}html{background: #f4f4f4 !important}#griditem{height: 380px;}
    .form-control { height: 51px !important; font-size: 28px !important}.nav_venda{display:block !important}.nav_comum{display:none !important} .content-header{display:none;}.main-sidebar{display:none;}.sidebar-mini .content-wrapper, .sidebar-mini .right-side, .sidebar-mini .main-footer {margin-left: -50px !important;z-index: 840;}.sidebar-toggle{display:none;}
    @media (max-width: 1024px) {
        .tablet-esconder {
                display:none!important
        }
        
    }
    
    .botoesAcao {
        margin-top:-20px
    }
    .aguarde{
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        
    }
    .ui-autocomplete{
        z-index: 1050 !important;
    }
    
</style>
<div>

    
    <div class="aguarde" ng-if="aguarde == true">
        <div class="progress-circular">
            <md-progress-circular class="md-accent md-hue-1" md-diameter="60" style=" position: absolute; top: 50%; margin-top: -25px; left:50%; background-color:transparent !important;"></md-progress-circular>
            <!-- <h5 style="margin-left: -30%; margin-top:15px; font-weight: bold; font-size:18px; color: #F51929;">{{aguardeTest}}</h5> -->
        </div>
    
    </div>
    <!-- Modal Caixas fechados-->
    <?php
        include_once ('modal/modal_caixa.php');
    ?>

    <!-- MOdal de venda e orçamento -->

    <?php
        include_once ('modal/vendas_pdv.php');
    ?>

    <!-- Clientes PDV -->

    <?php
        include_once ('modal/clientes_pdv.php');
    ?>

    <?php
        include_once ('modal/finalizar_venda.php');
    ?>

    

<nav class="navbar navbar-static-top" style="background-color: #2E4DD4">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
              
            <li style="display:none" class="nav_venda">
                <a href="./home">
                    <i class="fa fa-retweet"></i> 
                    <b class="hidden-xs">SAIR DO PDV</b>
                </a>
            </li>
            <li style="display:none" class="nav_venda">
                <a href="" ng-click="buscarVendas()">
                    <i class="fa ion ion-bag"></i> 
                    <b class="hidden-xs">BUSCAR VENDA</b>
                </a>
            </li>                                                 
            <li class="nav_comum">
                <a href="">
                    <i class="ion ion-bag"></i> 
                    <b class="hidden-xs"> VENDA</b>
                </a>
            </li>
            <li class="nav_comum">
                <a href="">
                    <i class="fa fa-desktop"></i> 
                    <b class="hidden-xs"> PDV</b>
                </a>
            </li>                        
                                    

        </ul>
        <ul class="nav navbar-nav pull-right">
            <li style="display:none" class="nav_venda">
                <a href="">
                    <i class="fa ion ion-bag"></i> 
                    <b class="hidden-xs">{{caixa[0].descricao}}{{caixa.descricao}}</b>
                </a>
            </li>  
        </ul>
    </div>
</nav>

<form id="formPrincipal" role="form" method="POST" action="">
    <input name="_method" value="POST" type="hidden"/>
    <input id="action" value="" type="hidden"/>
    <a class="btnCancelar" href="" type="hidden"></a>

    <input type="text" name="idpessoavendedor" value="1" hidden>
    <input type="text" name="faturar" value="0" hidden>
    
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">OPERADOR:</span>
                <span class="info-box-number"><?=$_SESSION['usuario']['name']?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-clock-o"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">DATA:</span>
                <span class="info-box-number" id="data"></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">TOTAL:</span>
                <span class="info-box-number totalPagar">{{totalItemSacola | currency: 'R$ '}}</span>
                </div>
            </div>
        </div>	
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-exclamation"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">STATUS:</span>
                <span class="info-box-number" ng-if="caixa != ''">Aberto</span>
                </div>
            </div>
        </div>		
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <label>Produto </label>
                    <input id="produto" name="produto" class="form-control" ng-model="produ" ng-blur="selecionarProduto()" ng-enter="selecionarProduto()" autocomplete="off" style="width: 100%;">
                    <input type="hidden" name="id" id="idProduto" ng-model="idProduto">
                   
                </div>
            </div>
            <div class="row" style="margin-top:5px;margin-left:-25px">
            
                <div>
                    <!-- <div class="col-xs-12">
                        <button type="button" id="btnObservacao" class="btn btn-app">
                                <i class="fa fa-file-text-o"></i> OBSERVAÇÃO
                        </button>
                            								
                    </div> -->
                    
                    
                    <div class="col-xs-12" style="margin-left:15px;" ng-if="vendaAguardar.length != 0">
                        <p class="h5">PEDIDOS EM ESPERA.</p>
                        <div class="table-responsive mailbox-messages" style="max-height: 100px; height: 100px; width:400px; overflow-y: scroll; overflow-x: hidden;">
                        
                            <table class="table table-sm" style="width:400px;">
                                <tbody>
                                    <tr ng-repeat="vendaAguardar in vendaAguardar" ng-click="selecionarVenda(vendaAguardar)">
                                        <td>{{vendaAguardar.itensVenda.length}} - Itens</td>
                                        <td>Total {{vendaAguardar.total | currency: 'R$ '}}</td>
                                        <td>{{vendaAguardar.hora | date: 'HH:mm:ss'}}</td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-xs-12" style="margin-left:15px; height: 150px;" ng-if="vendaAguardar.length == 0">

                    </div>
                    
                </div>
            </div>
            <div class="row">
                
                <div class="col-xs-4">
                    <label>QUANTIDADE</label>
                    <input type="number" class="form-control" id="quantidade" ng-model="quantidade" ng-value="quantidade" ng-change="atualizaValor()" ng-enter="atualizaValor()" min="1" data-toggle="popover" data-placement="top" data-content="Estoque atual da loja {{produto[0].qts.estatual | number}}"style="text-align: right;">
                </div>			
                <div class="col-xs-4">
                    <label>DESCONTO (%)</label>
                    <input type="text" class="form-control money" id="desconto" ng-model="desconto" ng-change="atualizaValor()" ng-enter="atualizaValor()" style="text-align: right;">
                </div>
                   
                <div class="col-xs-4" ng-init="dadosV.tipoVenda = 'varejo'">
                    <label>Tipo Venda</label>
                    <select class="form-control" value="" name="tipoVenda" id="tipoVenda" ng-model="tipoVenda" ng-change="atualizaValorTipoVenda()" ng-enter="atualizaValorTipoVenda()">
                        <option value="varejo">Varejo</option>
                        <option value="atacado">Atacado</option>
                    </select>
                </div>						
            </div>
            <div class="row" style="margin-top: 30px;">
                <div class="col-xs-6">
                    
                    <label>VALOR UN.</label>
                    <input type="text" class="form-control" id="valorUN" ng-model="valorUN" ng-value="valorUN" ng-blur="atualizaValor()" ng-enter="atualizaValor()" style="text-align: right;" money-mask>
                    	
                </div>

                <div class="col-xs-6">
                    
                    <label>VALOR TOTAL</label>
                    <input type="text" class="form-control" id="valorTotal" ng-model="valorTotal" ng-value="valorTotal | currency:'R$'" ng-change="atualizaValor()" ng-enter="atualizaValor()" style="text-align: right;" readonly>
                   	
                </div>
            </div>

            <!-- <div class="row"><br>
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">FORMAS DE PAGAMENTO (FECHAR)</h3>
                        </div>
                        <div class="box-body">
                            <a class="btn btn-app">
                                <i class="fa fa-money"></i> DINHEIRO (F10)
                            </a>
                        
                        </div>
                    </div>				
                </div>			
            </div><br><br><br> -->

            <div class="row" class="botoesAcao" style="margin-top: 35px;">
                <div class="col-xs-12">			
                    <div class="col-xs-3">
                        <button type="button" id="btnInserir" class="btn btn-primary btn-lg" ng-click="addItemVenda()" ng-block="btn == true"><span class="tablet-esconder"></span> INSERIR</button>
                    </div>
                    <div class="col-xs-3">
                        <button type="button" id="btnFechar" class="btn btn-primary btn-lg" ng-click="salvarVenda();"><span class="tablet-esconder"></span> SALVAR</button>
                    </div>
                    <div class="col-xs-3">
                        <button type="button" id="btnSalvar" class="btn btn-primary btn-lg" ng-click="guardarVenda()"><span class="tablet-esconder"></span> AGUARDAR</button>
                    </div>																									
                    <div class="col-xs-3">
                        <button type="button" id="btnCancelar" class="btn btn-primary btn-lg"><span class="tablet-esconder"></span> CANCELAR</button>
                    </div>			
                </div>
            </div>

        </div>
        <div class="col-xs-6">
            <div class="row">
                <div class="col-xs-12" style="margin-bottom:5px">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box-footer bg-blue">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <p style="font-size: 20px;weight: bold;"><strong>Cliente: </strong></p>
                                    </div>
                                    <div class="col-xs-10">
                                        <a href="#" ng-click="buscarCliente()"><p style="font-size: 20px; font-weight: bold; color: #fff" id="cliente_pdv_secionado">{{ cliente_pdv[0].nomefantasia }}</p></a>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-xs-2">
                                        <p style="font-size: 20px;weight: bold;"><strong>Vendedor: </strong></p>
                                    </div>
                                    <div class="col-xs-10">
                                        <a href="#"><p style="font-size: 20px;weight: bold; text-align:right" class="totalPagar"></p></a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- <label for="">Cliente</label>
                    <select class="form-control select2" id="idpessoa" name="idpessoa" ng-model="cliente"  ng-change="salvarCliente(cliente)" style="width: 100%;">
                            <option value="">SELECIONE</option>
                            <option value=""></option>
                            <?php
                                foreach($resultClientes as $clientes){
                            
                            ?>
                                <option value="<?=$clientes['id']?>"><?=$clientes['razaosocial']?></option>
                            <?php
                                }
                            ?>
                            
                    
                    </select> -->
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive mailbox-messages" style="max-height: 300px; height: 300px; overflow-y: scroll;">
                        <table id="" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="550px">DESCRIÇÃO</th>
                                    <th>QTD</th>
                                    <th>DESC</th>
                                    <th>TOTAL</th>
                                    <th width="30px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="vendaItens in vendaItens">
                                    <td>{{$index+1}}</td>
                                    <td>{{vendaItens.produto}}</td>
                                    <td>{{vendaItens.qts}}</td>
                                    <td>{{vendaItens.desc}}(%)</td>
                                    <td>{{vendaItens.total | currency}}</td>
                                    <td><button type="button" class="btn btn-sm" ng-click="removerItem(vendaItens)"><i class="fas fa-trash-alt" style="color:#b50202"></i></button></td>
                                </tr>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="row">
                    <div class="col-xs-8">
                        <div class="box-footer bg-blue">
                            <div class="row">
                                <div class="col-xs-10">
                                    <p style="font-size: 20px;weight: bold;"><strong>ITENS:</strong></p>
                                </div>
                                <div class="col-xs-2">
                                    <p style="font-size: 20px;weight: bold;" id="totalItens">{{totalItens}}</p>
                                </div>
                                <!-- <div class="col-xs-5">
                                    <p style="font-size: 20px;weight: bold;"><strong>D: <span id="spanDesconto">R$ 0,00</span></strong></p>
                                </div>
                                <div class="col-xs-2">
                                    <p style="font-size: 20px;weight: bold;"><strong>A: <span id="spanDesconto">R$ 0,00</span></strong></p>
                                </div> -->
                            </div>
                            <div class="row">
                                <div class="col-xs-8">
                                    <p style="font-size: 20px;weight: bold;"><strong>TOTAL</strong></p>
                                </div>
                                <div class="col-xs-4">
                                    <p style="font-size: 20px;weight: bold; text-align:right" class="totalPagar">{{totalItemSacola | currency: 'R$ '}}</p>
                                </div>
                            </div>											
                        </div>
                    </div>
                    <div class="col-xs-4" style="">
                        <button type="button" class="btn btn btn-app btn-primary btn-lg bg-blue" style="width: 162px; height: 97px; font-size: 20px; font-weight: bold; color:#fff" ng-click="finalizarVenda()">Finalizar<br> Venda</button>
                    </div>
                </div>
                
            </div>				
        </div>
    </div>		
</div>	
        <div class="modal fade" id="itemFormaRecebimento" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div id="idPopUpErro" style="display:none; margin-left: 5px; margin-right: 5px" class="callout callout-danger">
                    <h4>Atenção!</h4>
                    <p></p>
                </div>
                <div id="form-item">
                <div class="modal-body">
                    
                                <div class="row">
                                        <div class="col-xs-12">
                                            <a class="btn btn-block btn-social btn-bitbucket">
                                    <i class="fa fa-money"></i><span class="info-box-number totalPagar">R$ 0,00</span>
                            </a>
                                        </div>
                                </div>		
                                <br>
                                <div class="row">
                                
                                    <div class="col-xs-4">
                                           
                                    </div>		
                                    <div class="col-xs-4">
                                            
                                    </div>	
                                    <div class="col-xs-4">
                                            
                                    </div>											
                                </div>
                                <br><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button id="salvarFormaRecebimento" class="btn btn-primary">Salvar</button>
                </div>
                </div>
                </div>
            </div>
        </div>
	<div class="modal fade" id="itemDataVenda" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
						<label for="codigo">Data venda</label>
						<input class="form-control" name="datavenda" type="date" value="">
						<label for="codigo">Data entrega</label>
						<input class="form-control" name="dataentrega" type="date" value="">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Salvar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="itemObservacao" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					
						<textarea name="observacao" id="observacao" rows="15" cols="90"></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Salvar</button>
				</div>
			</div>
		</div>
	</div>	
</form>


<?php
    include_once ('footer.php');
?>
<!-- DataTables -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
<?php
    include_once ('./controller/PDV/PDV.js');
?>


$(document).ready(function() {

    $('form#formPrincipal').keypress(function(e) {
        if((e.keyCode == 10) || (e.keyCode == 13)){
            e.preventDefault();
        }

    })

    //produto
    var produto = [
        <?php
            foreach ($resultProduto as $produto){

                if($produto['descricaograde'] != null){
                    $grade = $produto['descricaograde'];
                }else{
                   $grade ='';
                }

                echo "'".$produto['codigoreduzido'] . " - " . $produto['descricao']. " ". $grade. "',";
            }
        ?>
    ];

    var produtoReturn = [];
    

    <?php

        foreach ($resultProduto as $produto){
    ?>
        produtoReturn.push({
            ativo : '<?=$produto['ativo']?>',
            codigoreduzido: '<?=$produto['codigoreduzido']?>',
            contabilizaestoque: '<?=$produto['contabilizaestoque']?>',
            custocompra: '<?=$produto['custocompra']?>',
            descricao: '<?=$produto['descricao']?>',
            descricaograde: '<?=$produto['descricaograde']?>',
            id: '<?=$produto['id']?>',
            idempresa: '<?=$produto['idempresa']?>',
            idestoque: '<?=$produto['idestoque']?>',
            idmatriz: '<?=$produto['idmatriz']?>',
            precoatacado: '<?=$produto['precoatacado']?>',
            precoprazo: '<?=$produto['precoprazo']?>',
            precovista: '<?=$produto['precovista']?>',
        });
    <?php
            
        }
    ?>

    $( "#produto" ).autocomplete({
        source:produto,
        select: function (e, i) {
            var pdSelect = i.item.value.split(" ", 1)[0];
            var index = produtoReturn.indexOf(produtoReturn.filter((item) => item.codigoreduzido == pdSelect)[0],0);
            // console.log(produtoReturn[index].id);
            $("#idProduto").val(produtoReturn[index].id);

        }
    })

    //cliente
    
    var cliente_pdv = [
        '0 -  Cliente Consumidor',
        <?php
            foreach ($resultClientes as $cliente){
                echo "'".$cliente['id'] . " - " . $cliente['nomefantasia']."',";
            }
        ?>
    ];
    
    var cliente_pdvReturn = [];

    <?php

        foreach ($resultClientes as $cliente){
    ?>
        cliente_pdvReturn.push({
            id: '<?=$cliente['id']?>', 
            razaosocial: '<?=$cliente['razaosocial']?>', 
            idpessoatipo: '<?=$cliente['idpessoatipo']?>', 
            nomefantasia: '<?=$cliente['nomefantasia']?>', 
            cpfoucnpj: '<?=$cliente['cpfoucnpj']?>', 
            celular: '<?=$cliente['celular']?>', 
            telefone: '<?=$cliente['telefone']?>', 
            limitecredito: '<?=$cliente['limitecredito']?>'
        });
    <?php
            
        }
    ?>

$( "#cliente_pdv" ).autocomplete({
    source:cliente_pdv,
    select: function (e, i) {

        var clSelect = i.item.value.split(" ", 1)[0];
        if(clSelect != 0) {
            var index = cliente_pdvReturn.indexOf(cliente_pdvReturn.filter((item) => item.id == clSelect)[0],0);
            $('#id_cliente_pdv').val(cliente_pdvReturn[index].id)
            $('#cliente_pdv_cel').val(cliente_pdvReturn[index].celular)
            $('#cliente_pdv_telefone').val(cliente_pdvReturn[index].telefone)
            $('#cliente_pdv_limite').val(cliente_pdvReturn[index].limitecredito)
        }
        
    }
});

    //$('#idpessoa').select2();

   // Função para formatar 1 em 01
   const zeroFill = n => {
				return ('0' + n).slice(-2);
			}

    // Cria intervalo
    const interval = setInterval(() => {
        // Pega o horário atual
        const now = new Date();

        // Formata a data conforme dd/mm/aaaa hh:ii:ss
        const dataHora = zeroFill(now.getUTCDate()) + '/' + zeroFill((now.getMonth() + 1)) + '/' + now.getFullYear() + ' ' + zeroFill(now.getHours()) + ':' + zeroFill(now.getMinutes()) + ':' + zeroFill(now.getSeconds());

        // Exibe na tela usando a div#data-hora
        document.getElementById('data').innerHTML = dataHora;
    }, 1000);
    
    
    $("#valor").mask("R$ 9999.99");
    
    
    $("#desconto").mask("000.00");
     
     
     $("#valorUN").val("R$ 0.00");
    $("#valorTotal").val("R$ 0.00");
    
    
    $("#cliente_pdv_cel").keydown(function(){
        $('#cliente_pdv_cel').mask("(99)99999-9999");
    });
    $("#cliente_pdv_telefone").keydown(function(){
        $('#cliente_pdv_telefone').mask("(99)9999-9999");
    });
    $("#cliente_pdv_limite").keydown(function(){
        $('#cliente_pdv_limite').mask("R$ 9999.99");
    });
    
});
    //window.open("/vendasimples/imprimir?id=" + id, "_blank");
</script>