

<style>
    .modal-dialog-finalizarVenda{
        width: 95%;
        z-index: 99998;
    }

</style>

<div class="modal fade" id="venda_finalizada" tabindex="-1" aria-labelledby="venda_finalizada_Label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-venda_finalizada">
        <div class="modal-content">
            
            <div class="modal-body">

                <div id="tela-impressao" class="etapa none" style="overflow: hidden; display: block;">
                    <div>
                        <div class="text-center text-success" style="font-size:200px; line-height:1"><i class="fas fa-shopping-bag"></i></div>
                        <h1 class="text-center text-success margin-top-0">VENDA FINALIZADA COM SUCESSO!</h1>
                        <br>
                        <div class="text-center">
                            <button id="nova-venda" type="button" class="btn btn-success btn-lg" ng-click="novaVenda()">INICIAR NOVA VENDA</button>
                            <button id="imprimir-cupom" type="button" class="btn btn-primary btn-lg"ng-click="">IMPRIMIR CUPOM</button>
                            <button id="emitir-nfc" type="button" class="btn btn-maroon btn-lg" disabled="true" ng-click=",x">EMITIR NFC</button>
                        </div>
                    </div>
                    
                </div>

            </div>

            <div class="modal-footer">

            </div>
        </div>
    </div>
   
</div>