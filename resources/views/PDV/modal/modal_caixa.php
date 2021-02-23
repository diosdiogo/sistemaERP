<!-- Modal Caixas fechados-->
<div class="modal fade" id="caixasFechados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="caixasFechados" style="display: flex; align-items: center; justify-content: center;">Abrir Caixa</h3>
                    
                    </button>
                </div>
                
                <form  ng-submit="abrirCaixa(caixaSelect,valor)">
                    <div class="modal-body">
                        
                        <div style="display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-cash-register" style="font-size: 150px;"></i>
                        </div>

                        <div class="row" style="display: flex; align-items: center; justify-content: center;">
                            
                            <div class="col-sm-8">
                                <label>Caixa</label>
                                <select class="form-control form-control-lg require" id="caixa" value="" ng-model="caixaSelect">
                                    <option ng-repeat="caixaFechado in caixaFechado" ng-value="caixaFechado.id">{{caixaFechado.descricao}}</option>
                                </select>
                            </div>

                        </div>

                        <div class="row" style="display: flex; align-items: center; justify-content: center;">
                            
                            <div class="col-sm-8">
                                <label>Valor</label>
                                <input class="form-control form-control-lg require" id="valor" ng-model="valor" style="text-align: right;"></input>
                            </div>

                        </div>

                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" >Sair</button>
                        <button type="submit" class="btn btn-primary" >Abrir Caixa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>