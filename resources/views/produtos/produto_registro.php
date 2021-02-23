<?php
date_default_timezone_set('UTC');
$today = date("Y-m-d H:i:s"); 

$visualizarEditar = $_POST['v_e'];

$codInterno =  str_pad(rand(0,10000), 6, '0', STR_PAD_LEFT);

if($visualizarEditar == 'edit'){
    $idProduto = $_POST['id'];

    $prod =$pdo->prepare("SELECT * FROM produto where id = :id;");
    $prod->bindValue(":id", $idProduto);
    $prod->execute();
    $produto = $prod->fetch(PDO::FETCH_ASSOC);

    if($produto['idestoque'] != null){
        $est = $pdo->prepare("SELECT id, idmatriz, idempresa, estminimo, estmaximo, sum(estatual) as estatual, sum(estestant) as estestant
         FROM estoque where idmatriz = :matriz and idproduto = :produto group by idproduto;");
        $est->bindValue(":matriz", $_SESSION['empresa']['matriz']);
        $est->bindValue(":produto", $idProduto);
        $est->execute();
        $estoque = $est->fetch(PDO::FETCH_ASSOC);
    }else{
        $estoque = array(
            'estatual' => 0,
            'estminimo' => 0,
            'estmaximo' => 0,
            'estestant' => 0

        );
    }

    if($produto['idgrade'] != null){
        $grad =$pdo->prepare("SELECT * FROM grade where matriz = :matriz");
        $grad->bindValue(":matriz", $_SESSION['empresa']['matriz']);
        $grad->execute();
        $grade = $grad->fetch(PDO::FETCH_ASSOC);

        $gradeProd = $pdo->prepare("SELECT * FROM grade_produto where idproduto = :id;");
        $gradeProd->bindValue(":id", $idProduto);
        $gradeProd->execute();
        $gradeProduto = $gradeProd->fetch(PDO::FETCH_ASSOC);
    
    }else{
        $grade = array(
            'descricao'=>'',
        );
        $gradeProduto = NULL;
    }

    
   
}else{
    $produto = array(
        'id' => '',
        'idprodutoregrafiscal' => '',
        'idprodutomarca' => '',
        'idunidademedida' => '',
        'idprodutocategoria' => '',
        'idpessoafornecedor' => '',
        'descricao' => '',
        'codigoreduzido' => $codInterno,
        'codigobarra' => '',
        'descricaoadicional' => '',
        'ativo' => 1,
        'custocompra' => '',
        'precocusto' => '',
        'precovista' => '',
        'precoatacado' => '',
        'precoprazo' => '',
        'margemlucro' => 0,
        'modelo' => '',
        'idgrade' => '',
        'idestoque'=>'',
        'estoquequantidade' => '',
        'estoqueunidade' => '',
        'estoquequantidadecaixa' => '',
        'habilitabalanca' => '',
        'codigobalanca' => '',
        'habilitapdv' => 1,
        'habilitacontroleestoque' => 1,
        'habilitanf' => 0,
        'idorigemmercadoria' => '',
        'idprodutofiscaltipo' => '',
        'idfiscalncm' => '',
        'idfiscalcest' => '',
        'codigofornecedor' => '', 
        'descricaofornecedor' => '',
        'peso' => '',
        'largura' => '',
        'altura' => '',
        'comprimento' => '',
        'observacao' => '',
        'created_at' => '',
        'updated_at' => '',
        'idcstpis' => '',
        'idcstcofins' => '',
        'idcstipi' => '',
        'idcfop' => '',
        'idcsticms' => '',
        'ipi' => '',
        'icms' => '',
        'pis' => '',
        'cofins' => '',
        'contabilizaestoque' => '',
        
    );
    $estoque = array(
        'estatual' => 0,
        'estminimo' => 0,
        'estmaximo' => 0,
        'estestant' => 0

    );
    $grade = array(
        'descricao'=>'',
    );

    $gradeProduto = NULL;
}

$categ =$pdo->prepare("SELECT * FROM produtocategoria where idmatriz = :idmatriz and deletado ='N';");
$categ->bindParam(':idmatriz', $_SESSION['empresa']['matriz']);
$categ->execute();
$categoria = $categ->fetchAll(PDO::FETCH_ASSOC);

$pdmarca =$pdo->prepare("SELECT * FROM produtomarca where idmatriz = :idmatriz;");
$pdmarca->bindParam(':idmatriz', $_SESSION['empresa']['matriz']);
$pdmarca->execute();
$pdmarcas = $pdmarca->fetchAll(PDO::FETCH_ASSOC);

$forn =$pdo->prepare("SELECT * FROM pessoa where idmatriz = :idmatriz and fornecedor = 'S';");
$forn->bindParam(':idmatriz', $_SESSION['empresa']['matriz']);
$forn->execute();
$fornecedor = $forn->fetchAll(PDO::FETCH_ASSOC);

$subc = $pdo->prepare("SELECT * FROM artevi12_erp_cdl.produtosubcategoria where idmatriz = :idmatriz and deletado = 'N';");
$subc->bindParam(':idmatriz', $_SESSION['empresa']['matriz']);
$subc->execute();
$subcategoria = $subc->fetchAll(PDO::FETCH_ASSOC);

include_once ('./resources/views/menu-bar.php');

?>

<style>
.box.box-primary {
    border-top-color: #2E4DD4;
}

.box.box-info{
    border-top-color: #2E4DD4;
}

.form-control{
    text-transform: capitalize;
}

.require{
    background-color: rgba(250, 250, 167,0.8);
}
 .row{
     margin-top: 10px;
 }

 .money{
     text-align: right;
 }
 #gradeConfig{
     display: none;
 }
 .modal{
    z-index: 9999;
 }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Produtos
        </h1>
    </section>

    <div class="modal fade" id="addMArca" tabindex="-1" aria-labelledby="addMArca" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMArca">Adicionar Marca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12" style="margin-bottom: 20px;">
                    <label for="">Nome Marca</label>
                    <input class="form-control form-control-lg" type="text" name="marcaNome" id="marcaNome" value="" ng-model="marcaNome">
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 20px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarM();">Cancelar</button>
                <button type="button" class="btn btn-primary" ng-click="salvarMarca(marcaNome)">Salvar</button>
            </div>
            </div>
        </div>
    </div>
    
    <section class="content">
        <div class="box box-primary">

            <div class="box-header">
                <form class="form-group3 needs-validation" id="cad" action="./produtos_salvar_editar" method="POST" autocomplete="off">
                
                    <div class="" style="position: -webkit-sticky; position: sticky; top: 0; z-index: 9998; background-color: #fff;">
                        <div class="col-12">
                            <div class="col-sm col-lg-12" style="background-color: #fff;">
                                <?php

                                    if(isset($_POST['ver'])){
                                    ?>
                                    <a href="./produtos" type="reset" class="btn btn-danger" style="margin-bottom: 10px;"><i class="fas fa-reply"></i> Voltar</a>
                                    <?php
                                    }else{
                                    ?>
                                    <button type="submit" class="btn btn-primary" id="salvar"><i class="fa fa-save"></i> Salvar</button>
                                                            
                                    <a href="./produtos" type="reset" class="btn btn-danger"><i class="fa fa-close"></i> Cancelar</a>

                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12" style="margin-top:20px;">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#produto" data-toggle="tab">Produto</a></li>
                                    <li><a href="#grade" data-toggle="tab" <?php if(isset($_POST['ver'])){ echo 'style="display:none;"';} ?>>Habilitar Grade</a></li>
                                    <!--li><a href="#balanca" data-toggle="tab">Balança</a></li>      
                                    <li><a href="#detalhe" data-toggle="tab">Detalhes</a></li>                            
                                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li-->
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="produto">
                                        <div class="row">
                                            <div class="col-xs-1">
                                                <label for="">Cód</label>
                                                <input class="form-control form-control-lg" type="text" placeholder="0" name="cod" id="cod" value="<?=$produto['id']?>" readonly>
                                            </div>
                                            <div class="col-xs-6" style="margin-top: 30px">
                                                
                                                <label>
                                                    Ativo: 
                                                </label>  
                                                <input type="checkbox" class="form-check-input" id="pdAtivo" name="pdAtivo" <?php 
                                                if ($produto['ativo'] == 1 ){
                                                    echo 'value="true" checked="checked"';
                                                } 
                                                else {
                                                    echo 'value="false"';
                                                }?>>

                                                <label>
                                                    Contabilizar Estoque? 
                                                </label>
                                                <input type="checkbox" class="form-check-input" id="pdContaEstoque" name="pdContaEstoque" <?php 
                                                if ($produto['habilitacontroleestoque'] == 1 ) {
                                                    echo 'value="true" checked="checked"'; 
                                                }else{
                                                    echo 'value="false"';
                                                }?>>

                                                <label>
                                                    Habilitar PDV? 
                                                </label>
                                                <input type="checkbox" class="form-check-input" id="habilitapdv" name="habilitapdv" <?php 
                                                if ($produto['habilitapdv'] == 1 ) {
                                                    echo 'value="true" checked="checked"'; 
                                                }else{
                                                    echo 'value="false"';
                                                }?>>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <label>Descrição:</label>
                                                <input class="form-control require" placeholder="Digite o nome do produto" autofocus="autofocus" name="descricao" type="text" value="<?=ucwords(strtolower($produto['descricao']))?>" id="descricao" required>
                                            </div>
                                            <div class="col-xs-4">
                                                <label>Código De Barras</label>
                                                <div class="input-group">
                                                    <span class="btn btn-default input-group-addon"><i class="fa fa-barcode"></i></span>
                                                    <input class="form-control" placeholder="Digite o código de barras: 00000000000" name="codigobarra" type="text" value="<?=$produto['codigobarra']?>" onkeypress="return somenteNumeros(event)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <?php
                                                    $unidade_medida = array(
                                                        ['id' => '1','un' => 'KILOGRAMA'],
                                                        ['id' => '2','un' => 'UNIDADE'],
                                                        ['id' => '3','un' => 'CAIXA'],
                                                        ['id' => '4','un' => 'FARDO'],
                                                        ['id' => '5','un' => 'METRO'],
                                                    )
                                                ?>
                                                <label>Unidade</label>
                                                <select class="form-control select2 require" name="idunidademedida" data-placeholder="SELECIONE" style="width: 100%;" required>
                                                    <option value="">SELECIONE</option>
                                                    <?php
                                                        
                                                        foreach($unidade_medida as $unidade_medida){
                                                            echo '<option value="'.$unidade_medida['id'].'"';
                                                            $selected;
                                                             if($produto['idunidademedida'] == $unidade_medida['id']){
                                                                $selected = 'selected';
                                                             }else{
                                                                $selected ='';
                                                             }
                                                            echo ''.$selected. ' >' . $unidade_medida['id'] .' - '. $unidade_medida['un'] . '</option>';
                                                        }
                                                    ?>
                                                    <!--option value="1">1 - KILOGRAMA</option>
                                                    <option value="2" >2 - UNIDADE</option>
                                                    <option value="3" >3 - CAIXA</option>
                                                    <option value="4" >4 - FARDO</option>
                                                    <option value="5" >5 - METRO</option-->
                                                </select>
                                            </div>
                                            <div class="col-xs-4">
                                                <label for="site">Quantidade Caixa</label>
                                                <div class="input-group">
                                                    <span class="btn btn-default input-group-addon"><i class="fa fa-archive"></i></span>
                                                    <input class="form-control" placeholder="Digite quantidade caixa" name="estoquequantidadecaixa" type="text" value="<?=$produto['estoquequantidadecaixa']?>" onkeypress="return somenteNumeros(event)">
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <label>Sub-Categoria</label>
                                                <select class="form-control select2" name="idprodutocategoria" value="" data-placeholder="SELECIONE" style="width: 100%;">
                                                    <option value="">SELECIONE</option>
                                                    <?php
                                                        foreach ($subcategoria as $subcategoria){
                                                    ?>
                                                        <option value="<?=$subcategoria['id']?>"<?php if($subcategoria['id'] == $produto['idprodutocategoria']){echo "selected='selected'";} ?>><?=$subcategoria['descricao']?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            
                                            <div class="col-xs-4">
                                                <label>Marca</label>
                                                
                                                    <div class="input-group">
                                                        <span class="btn btn-default input-group-addon" data-toggle="modal" data-target="#addMArca"><i class="fa fa-plus"></i></span>
                                                        <select class="form-control custom-select select2" name="idprodutomarca" data-placeholder="SELECIONE" style="width: 100%;">
                                                            <option value="">SELECIONE</option>
                                                            <option ng-repeat="marca in marca" value="{{marca.id}}" ng-selected="marca.id == <?=$produto['idprodutomarca']?>">{{marca.descricao}}</option>
                                                        </select>

                                                       <!--select class="form-control custom-select select2" name="idprodutomarca" data-placeholder="SELECIONE" style="width: 100%;">
                                                            <option value="">SELECIONE</option>
                                                            <?php
                                                                foreach ($pdmarcas as $pdmarca){
                                                            ?>
                                                                <option value="<?=$pdmarca['id']?>"<?php if($pdmarca['id'] == $produto['idprodutomarca']){echo "selected='selected'";} ?>><?=$pdmarca['descricao']?></option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select-->
                                                    
                                                    </div>
                                                
                                            </div>

                                            <div class="col-xs-4">
                                                <label for="site">Modelo</label>
                                                <div class="input-group">
                                                    <span class="btn btn-default input-group-addon"><i class="fa fa-tag"></i></span>
                                                    <input class="form-control" placeholder="Digite o modelo" name="modelo" type="text" value="<?=$produto['modelo']?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <label for="site">Código Reduzido</label>
                                                <div class="input-group">
                                                    <span class="btn btn-default input-group-addon"><i class="fa fa-tag"></i></span>
                                                    <input class="form-control" placeholder="Digite o código reduzido" name="codigoreduzido" type="text" value="<?=$produto['codigoreduzido']?>" onkeypress="return somenteNumeros(event)" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span id="box-money" class="info-box-icon bg-blue"><i class="far fa-money-bill-alt"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Margem de lucro</span>
                                                        <span id="margemlucro" class="info-box-number"><?=$produto['margemlucro']?><small>%</small></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-blue"><i class="fa fa-archive"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Estoque atual</span>
                                                        <span class="info-box-number"><?=$estoque['estatual']?></span>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-blue"><i class="fa fa-archive"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Unidade</span>
                                                        <span class="info-box-number">0</span>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-primary" style="margin-top:10px">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Valores</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                <label for="Custo">Custo</label>
                                                                <input class="form-control money" placeholder="Digite o custo" name="custocompra" type="text" value="<?=$produto['custocompra']?>">
                                                            </div>
                                                            <div class="col-xs-3">
                                                                <label for="preco">A vista</label>
                                                                <input class="form-control money require" placeholder="Digite o preço" name="precovista" type="text" value="<?=$produto['precovista']?>" id="preco" required>
                                                            </div>
                                                            <div class="col-xs-3">
                                                                <label for="preco">A Prazo</label>
                                                                <input class="form-control money" placeholder="Digite o preço" name="precoprazo" type="text" value="<?=$produto['precoprazo']?>" id="preco">
                                                            </div>
                                                            <div class="col-xs-3">
                                                                <label for="preco">Atacado</label>
                                                                <input class="form-control money" placeholder="Digite o preço" name="precoatacado" type="text" value="<?=$produto['precoatacado']?>" id="preco">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-primary" style="margin-top:10px">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Estoque</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                <label for="Custo">Est. Minimo</label>
                                                                <input class="form-control" placeholder="Est. min" name="estminimo" type="text" value="<?=$estoque['estminimo']?>" onkeypress="return somenteNumeros(event)" style="text-align:right">
                                                            </div>
                                                            <div class="col-xs-3">
                                                                <label for="preco">Est. Máximo</label>
                                                                <input class="form-control" placeholder="Est. max" name="estmaximo" type="text" value="<?=$estoque['estmaximo']?>" id="preco" onkeypress="return somenteNumeros(event)" style="text-align:right">
                                                            </div>
                                                            <div class="col-xs-3">
                                                                <label for="preco">Lanc. Estoque</label>
                                                                <input class="form-control" placeholder="Lançar Estoque" name="lancestoque" type="text" value="<?=$estoque['estatual']?>" onkeypress="return somenteNumeros(event)" style="text-align:right">
                                                            </div>
                                                            <div class="col-xs-3">
                                                                <label for="preco">Estante</label>
                                                                <input class="form-control" placeholder="Est. estante" name="estante" type="text" value="<?=$estoque['estestant']?>" onkeypress="return somenteNumeros(event)" style="text-align:right">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-primary" style="margin-top:10px">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Fornecedor</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <label for="produto_label">Fornecedor</label>
                                                                <select id="idpessoafornecedor" name="idpessoafornecedor" data-placeholder="SELECIONE" class="form-control select2" style="width: 100%;">
                                                                <option value="">Selecione um fornecedor</option>
                                                                <?php
                                                                    foreach($fornecedor as $fornecedor){
                                                                ?>
                                                                    <option value="<?=$fornecedor['id']?>"><?=$fornecedor['nomefantasia']?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane" id="grade">
                                        <div class="col-xs-6" style="margin-top: 30px">
                                            <label>
                                                Habilitar Grade
                                            </label> 
                                            <input type="checkbox" class="form-check-input" id="habilitarGrade" name="habilitarGrade" onchange="habilitarGrades(this)" <?php 
                                                if ($produto['idgrade'] != NULL ){
                                                    echo 'value="true" checked="checked"';
                                                } 
                                                else {
                                                    echo 'value="false"';
                                                }?>>
                                                
                                        </div>
                                        <div class="row" id="gradeConfig">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-primary" style="margin-top:10px">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Grade</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label for="Custo">Grade</label>
                                                                <input class="form-control require" placeholder="Nome da grade" name="nomeGrade" id="nomeGrade" type="text" value="<?=$grade['descricao']?>" <?php if($visualizarEditar == 'edit'){echo 'readonly';} ?> >
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                
                                                                <label>Tabela de grades</label><br>
                                                                <input class="form-control require" type="text" value="<?=ucwords(strtolower($gradeProduto['descricao']))?>" name="grades" id="grades" data-role="tagsinput">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <!--div class="tab-pane" id="balanca">
                                    
                                    </div>
                                    <div class="tab-pane" id="detalhe">
                                        
                                    </div-->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
<?php
    include_once ('footer.php');
?>
<script src="<?=$url?>/public/assets/bower_components/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<script src="<?=$apiServe?>/app/updateproduto.js"></script>

<script>
<?php
    include_once ('./controller/produtos/produto_registro.js');
?>

function habilitarGrades(){
    var habilitaGrade = $('#habilitarGrade');

    if(habilitaGrade[0].checked == true){
        document.getElementById('gradeConfig').style.display = 'block';
        document.getElementById('nomeGrade').setAttribute('required', '');
        document.getElementById('grades').setAttribute('required', '');
    }else{
        document.getElementById('gradeConfig').style.display = 'none';
        document.getElementById('nomeGrade').removeAttribute('required');
        document.getElementById('grades').removeAttribute('required');
    }
}

$(document).ready(function() {
    $('form#cad').keypress(function(e) {
            if((e.keyCode == 10) || (e.keyCode == 13)){
                e.preventDefault();
            }

    })

    $('#grades').tagsinput({
        maxTags: 1
    })

    var habilitaGrade = $('#habilitarGrade').val();

    if(habilitaGrade == 'true'){
        document.getElementById('gradeConfig').style.display = 'block';
    }

    <?php
        if(isset($_POST['ver'])){
           echo  '$(".form-control").attr("disabled", true);';
        }
    ?>

    $('.select2').select2(/*{
        ajax: {
            url: "<?=$apiServe?>/dadosbase/cidade",
            cache: false
        }
    }*/);

    $('.money').mask("#.##0,00", { reverse: true });

    /*$("#salvar").click(function(){
        //var dados = $(this).closest('form').serialize();
        //console.log(dados);
        var cod = $("$cod").val();
        $.ajax({
            url: './produtos_salvar_editar',
            data: {
             cod: cod
            },
            dataType: "json",
            type: "POST",
            success: function (data) {

            }
        })
    })*/

});

function cancelarM(){
    $('#marcaNome').val('');
}



<?php
    include_once('./app/funcoes.js');
?>


</script>