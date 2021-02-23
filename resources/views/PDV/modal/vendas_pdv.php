<!-- MOdal de venda e orçamento -->

<div class="modal fade" id="vendas" tabindex="-1" aria-labelledby="vendasLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-finalizarVenda">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendasLabel">Vendas / orçamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            
                <div class="modal-body">

                   <div class="box-body no-padding">
                        <div class="table-responsive mailbox-messages" style="max-height: 300px; height: 300px; overflow-y: scroll;">
                            <table id="" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th >Doc</th>
                                        <th width="550px">Desc</th>
                                        <th width="350px">Valor</th>
                                        <th>Data</th>
                                        <th width="30px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="vendas_condicional in vendas_condicional">
                                        <td></td>
                                        <td>{{vendas_condicional.doc}}</td>
                                        <td>{{vendas_condicional.descricao}}</td>
                                        <td>{{vendas_condicional.valortotal | currency: 'R$ '}}(%)</td>
                                        <td>{{vendas_condicional.datavenda | date: 'dd/MM/yyyy'}}</td>
                                        <td><button type="button" class="btn btn-sm" ng-click="selecionarVendas(vendas_condicional)"><i class="fas fa-cash-register" style="color:#b50202"></i></button></td>
                                    </tr>
                                </tbody>
                                
                            </table>
                                
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>