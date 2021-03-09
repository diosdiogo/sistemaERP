<?php
    $sql= "SELECT id, descricao, sigla FROM financeiroformarecebimento where idmatriz = :matriz and ativo = 1 and deletado = 'N';";
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

    .pg-info {
        padding: 0.4rem 0.8rem;
    }
    .pg-info h3 {
        font-size: 16px;
    }
    .btn-parcela-select{
        background-color: #25881b;
    }
    
    .formPagamentos-info {
        padding: 0.5rem;
    }
</style>

<div class="modal fade" id="finalizar_venda" tabindex="-1" aria-labelledby="finalizar_venda_Label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-finalizarVenda">
        <div class="modal-content">
            
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12"><!--dados de pagamento-->
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
                                                <button type="button" class="btn btn-primary btn-lg btn-parcela" style="width:100%; margin-bottom:10px" ng-click="setParcelamentoVezes($index + 1)">{{ $index + 1 }}x</button>
                                            </div>

                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row" style="margin-top:15px;">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="valorTotalRestante" ng-value="valorTotalRestante | currency: ''" ng-model="valorTotalRestante" ng-disabled="disabledInputValor" aria-describedby="button-addon2" style="font-size: 20px; font-weight: bold; text-align:right">
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-lg btn-primary" type="button" ng-click="confirmarFormaPagamento(valorTotalRestantes)" ng-if="forma_pagamento.length > 0">Confirmar</button>
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
                        <div class="card">
                            <div class="card-header">
                                <h3 style="font-weight: bold"><i class="fas fa-dollar-sign"></i> Pagamentos</h3>
                            </div>
                            <div class="card-body formPagamentos-info" layout="row" layout-align="space-between center" ng-if="confirmar == true" ng-repeat="formaDePagamento in setFormaDePagamento">
                                <div>
                                    <span>{{ formaDePagamento.formaPagamento }} <small><em>({{ formaDePagamento.parcela }}X)</em></small></span>
                                </div>
                                <div>
                                <span>{{ formaDePagamento.valor | currency: 'R$' }} <a class="btn btn-sm btn-danger" ng-click="removerFormaPagamento(formaDePagamento)" style="color: #fff;"><i class="fas fa-trash-alt"></i></a> </span>
                                </div>

                            </div>
                        </div>

                        <div class="card" style="margin-top:30px;">
                            <div class="card-header">
                                <h3 style="font-weight: bold"><i class="fas fa-dollar-sign"></i> Total</h3>
                            </div>

                            <div class="card-header pg-info" layout="row" layout-align="space-between center">
                                <div>
                                    <h3 >SUBTOTAL:</h3>
                                </div>
                                <div>
                                    <h3>{{ totalPagar | currency: 'R$ ' }}</h3>
                                </div>
                            </div>  

                            <div class="card-header pg-info" layout="row" layout-align="space-between center">
                                <div>
                                    <h3 >DESCONTOS:</h3>
                                </div>
                                <div>
                                    <h3>{{ 0 | currency: 'R$ ' }}</h3>
                                </div>
                            </div>   

                            <div class="card-header pg-info" layout="row" layout-align="space-between center">
                                <div>
                                    <h3 >PAGAMENTOS:</h3>
                                </div>
                                <div>
                                    <h3>{{ totalPago | currency: 'R$ ' }}</h3>
                                </div>
                            </div>

                            <div class="card-header pg-info" layout="row" layout-align="space-between center">
                                <div>
                                    <h3 >TROCO:</h3>
                                </div>
                                <div ng-if="totalPago > totalPagar">
                                    <h3>{{ totalPago - totalPagar | currency: 'R$ ' }}</h3>
                                </div>

                                <div ng-if="totalPago <= totalPagar">
                                    <h3>{{ 0 | currency: 'R$ ' }}</h3>
                                </div>
                            </div>

                            <div class="card-header pg-info" layout="row" layout-align="space-between center">
                                <div>
                                    <h3 >Total a pagar:</h3>
                                </div>
                                <div ng-if="totalPago <= totalPagar">
                                    <h3>{{ totalPagar - totalPago | currency: 'R$ ' }}</h3>
                                </div>
                                <div ng-if="totalPago > totalPagar">
                                    <h3>{{ 0 | currency: 'R$ ' }}</h3>
                                </div>
                            </div>                      
                           
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

            <button type="submit" id="botao-finalizar" autocomplete="off" class="btn btn-lg btn-success" disabled="disabled" ng-if="totalPago < totalPagar"><span class="glyphicon glyphicon-ok margin-right-10px"></span>Finalizar</button>
            <button type="submit" ng-click="concluirVenda();" id="botao-finalizar" autocomplete="off" class="btn btn-lg btn-success" ng-if="totalPago >= totalPagar"><span class="glyphicon glyphicon-ok margin-right-10px"></span>Finalizar</button>
            <button type="button" ng-click="cancelar();" class="btn btn-lg btn-danger"><span class="glyphicon glyphicon-remove margin-right-10px"></span>Cancelar</button>
            </div>
        </div>
    </div>
   
</div>