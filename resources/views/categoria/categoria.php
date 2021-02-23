<?php

   include_once ('./resources/views/menu-bar.php');
?>

<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Categorias
      </h1>
    </section>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Salvar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="">Nome Categoria</label>
                            <input class="form-control form-control-lg" type="text" name="categN" id="categN" value="" ng-model="categN">
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="margin-top:25px; margin-right: 15px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                    <button type="button" class="btn btn-primary" ng-click="salvarCateg(categN,0)">Salva</button>
                    <button type="button" class="btn btn-primary"ng-click="salvarCateg(categN,1)">Salva e continuar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarCategoria" tabindex="-1" aria-labelledby="editarCategoria" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCategoria">Editar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="col-sm-12">
                            
                            <label for="">Editar Categoria</label>
                            <input class="form-control form-control-lg" type="text" name="categ" id="categ" ng-value="categ.descricao" ng-model="categEdit">
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="margin-top:25px; margin-right: 15px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                    <button type="button" class="btn btn-primary" ng-click="salvarEdicao(categ, categEdit)">Salva</button>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="box box-primary">
            
            <div class="box-header">
                <div class="row">
                    
                    <div class="col-md-1">
                        
                        <input type="hidden" value="novo" name="v_e">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Novo</button>
                        
                    </div>

                </div>

                <div class="table-responsive-sm" style="margin-top:20px;">
                    <table id="categoria" class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Descriçao</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="categorias in categorias" repeat-done="initDataTable">
                                <td scope="col">{{categorias.id}}</td>
                                <td scope="col">{{categorias.descricao}}</td>
                                <td scope="col">
                                <button type="btn" class="btn btn-secondary btn-sm" value="view" name="ver" ng-click="editar(categorias)"><i class="fa fa-edit"></i></button>
                                    <button type="btn" class="btn btn-secondary btn-sm" value="view" name="ver" ng-click="removerCategoria(categorias)"><i class="fa fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>
<?php
    include_once ('footer.php');
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

<?php
    include_once ('./controller/categoria/categoria.js');
    
?>

$(document).ready(function() {
    
 })


</script>