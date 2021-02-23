<div class="modal fade" id="modal_cliente_pdv" tabindex="-1" aria-labelledby="cliente_pdv_Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <label>Cliente </label>
                        <input name="cliente_pdv" class="form-control" ng-model="cliente_pdv[0].nomefantasia" ng-blur="setCliente()" ng-enter="setCliente()" id="cliente_pdv" autocomplete="off" style="width: 100%;">
                        <input type="hidden" name="id" id="id_cliente_pdv" ng-model="cliente_pdv[0].id">
                    </div>
                    <div class="col-xs-6">
                        <label for="">Celular</label>
                        <input name="cliente_pdv_cel" class="form-control" ng-model="cliente_pdv[0].celular" ng-blur="setCliente()" ng-enter="setCliente()" id="cliente_pdv_cel" autocomplete="off" style="width: 100%;" readonly>
                    </div>
                    <div class="col-xs-6">
                        <label for="">Telefone</label>
                        <input name="cliente_pdv_telefone" class="form-control" ng-model="cliente_pdv[0].telefone" ng-blur="setCliente()" ng-enter="setCliente()" id="cliente_pdv_telefone" autocomplete="off" style="width: 100%;" readonly>
                    </div>
                    <div class="col-xs-12">
                        <label for="">Limite de crédito</label>
                        <input name="cliente_pdv_limite" class="form-control" ng-model="cliente_pdv[0].limitecredito" ng-blur="setCliente()" ng-enter="setCliente()" id="cliente_pdv_limite" autocomplete="off" style="width: 100%; text-align: right;" readonly>
                    </div>
                    <!-- <label for="">Saldo</label>
                    <input name="cliente_saldo" class="form-control" ng-model="cliente_pdv.telefone" ng-blur="setCliente()" ng-enter="setCliente()" id="cliente_pdv_telefone" autocomplete="off" style="width: 50%;" readonly> -->


                    
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" ng-click="cancelarSelectCliente()">Cancelar</button>
                <button type="button" class="btn btn-primary" ng-click="SelectCliente()">OK</button>
            </div>
        </div>
    </div>
</div>