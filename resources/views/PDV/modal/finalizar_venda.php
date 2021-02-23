<?php
    $sql= "SELECT id, descricao FROM financeiroformarecebimento where idmatriz = :matriz and ativo = 1 and deletado = 'N';";
    $forma_pagamento = $pdo->prepare($sql);
    $forma_pagamento->bindValue(':matriz', $_SESSION['empresa']['matriz']);
    $forma_pagamento->execute();

    $rowFormaPagamento = $forma_pagamento->fetchAll(PDO::FETCH_ASSOC);

?>

<style>
    .modal-dialog-finalizarVenda{
        width: 95%;
        z-index: 99998;
    }

    .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }

    .card-header{
        padding: .75rem 1.25rem;
        margin-bottom: 0;
        background-color: rgba(0,0,0,.03);
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.25rem;
    }
</style>

<div class="modal fade" id="finalizar_venda" tabindex="-1" aria-labelledby="finalizar_venda_Label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-finalizarVenda">
        <div class="modal-content">
            
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 style="font-weight: bold"><i class="far fa-money-bill-alt"></i> Forma de pagamento</h3>
                            </div>
                            <div class="card-body">
                                <select name="f_pagamento" class="form-control" id="f_pagamento" ng-model="f_pagamento" value="" ng-change="getFormaPagamentoTipo(f_pagamento)">
                                    <option value="" ng-selected="true">SELECIONE</option>
                                    <?php
                                        foreach ($rowFormaPagamento as $formaPagamento){
                                    ?>
                                        <option value="<?=$formaPagamento['id']?>"><?=$formaPagamento['descricao']?></option>
                                    <?php
                                        }
                                    ?>
                                </select>

                                <div ng-if="forma_pagamento.length > 0" style="margin-top:15px;">
                                   
                                    <div ng-if="forma_pagamento[0].parcelado == 'S'">
                                        <div class="row">
                                            <div class="col-sm-2 col-md-2 col-lg-2 parcelas-pagamento" ng-repeat="n in [].constructor(forma_pagamento[0].numeropacela) track by $index">
                                                <button type="button" class="btn btn-primary btn-lg btn-parcela" style="width:100%; margin-bottom:10px">{{ $index + 1 }}x</button>
                                            </div>

                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row" style="margin-top:15px;">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" ng-value="totalItemSacola | currency: 'R$ '" ng-model="PedidoValorPago" aria-describedby="button-addon2" style="font-size: 20px; font-weight: bold; text-align:right">
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-lg btn-primary" type="button" ng-click="valorPago(PedidoValorPago)">Confirmar</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="card" style="margin-top:15px;">
                            <div class="card-header">
                                <h3 style="font-weight: bold"><img src="<?=$apiServe?>/public/assets/image/barcode.svg" width="50">Itens da compra</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive mailbox-messages" style="max-height: 150px; height: 300px; overflow-y: scroll;">
                                    <table id="" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th width="550px">DESCRIÇÃO</th>
                                                <th>QTD</th>
                                                <th>DESC</th>
                                                <th>TOTAL</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="vendaItens in vendaItens">
                                                <td>{{$index+1}}</td>
                                                <td>{{vendaItens.produto}}</td>
                                                <td>{{vendaItens.qts}}</td>
                                                <td>{{vendaItens.desc}}(%)</td>
                                                <td>{{vendaItens.total | currency}}</td>
                                                
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
            
            </div>
        </div>
    </div>
   
</div>