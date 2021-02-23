<?php
    date_default_timezone_set('UTC');
    $today = date("Y-m-d H:i:s"); 

    $visualizarEditar = $_POST['v_e'];

    if($visualizarEditar == 'edit'){
        $empresa = $_POST['idEmpresa'];
        
        $empresas =$pdo->prepare("SELECT * FROM empresa where id = :id;");
        $empresas->bindValue(":id", $empresa);
        $empresas->execute();
        $empresa = $empresas->fetch(PDO::FETCH_ASSOC);

        
    }else{
        $empresa = array(
            'id' => 0,
            'razaosocial' => '',
            'nomefantasia' => '',
            'email' => '',
            'cnpj' => '',
            'emp' => '',
            'matriz' => $_SESSION['empresa']['matriz'],
            'inscricaomunicipal' => '',
            'inscricaoestadual' => '',
            'telefone' => '',
            'bairro' => '',
            'cidade' => '',
            'endereco' => '',
            'numero' => '',
            'complemento' => '',
            'pontoreferencia' => '',
            'nomecontato' => '',
            'cep' => '',
            'idfiscalregimetributario' => '',
            'idempresaramoadeatividade' => '',
            'descricaorelatorio' => '',
            'created_at' => $today,
            'updated_at' => $today,
            'numerofilial' => 0,
            'idambiente' => '',
            'idcidade' => '',
            'idcnae' => '',
            'senha' => '',
            'fraserelatorio' => '',
            'aliquotasimplesnacional' => '',
            'idfiscalcfopdentroestado' => '',
            'idfiscalcfopforaestado' => '',
            'imagem' => '',
            'bloqueiofinanceiro' => ''
        );
    }

    $tipoPessoa =$pdo->prepare("SELECT * FROM pessoatipo;");
    $tipoPessoa->execute();
    $rowTipoPessoa = $tipoPessoa->fetchAll(PDO::FETCH_ASSOC);

    $cidade =$pdo->prepare("SELECT * FROM cidade");
    $cidade->execute();
    $rowCidade = $cidade->fetchAll(PDO::FETCH_ASSOC);

    $estado =$pdo->prepare("SELECT * FROM estado");
    $estado->execute();
    $rowEstado = $estado->fetchAll(PDO::FETCH_ASSOC);

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
</style>

<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Empresas
      </h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <form class="form-group3" action="./empresa_salvar_editar" method="POST" autocomplete="off">
                    
                    <div class="" style="position: -webkit-sticky; position: sticky; top: 0; z-index: 9999; background-color: #fff;">
                        <div class="col-12">

                            <div class="col-sm col-lg-12">
                                <?php

                                    if(isset($_POST['ver'])){
                                ?>
                                    <a href="./empresa" type="reset" class="btn btn-danger" style="margin-bottom: 10px;"><i class="fas fa-reply"></i> Voltar</a>
                                <?php
                                    }else{
                                ?>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
                                                            
                                <a href="./empresa" type="reset" class="btn btn-danger"><i class="fa fa-close"></i> Cancelar</a>
                                
                                <label for="label-in-front" aria-hidden="true" tabindex="-1">
                                    Ativo
                                </label>
                                <?php
                                    }
                                ?>
                                
                            
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-xs-12" style="margin-top:20px;">
                        <div class="row">
                            <div class="col-xs-1">
                                <label for="">Cód</label>
                                <input class="form-control form-control-lg" type="text" placeholder="0" name="cod" id="cod" value="<?=$empresa['id']?>" readonly>
                            </div>

                            <div class="col-xs-3">
                                <label for="">CNPJ*</label>
                                <input class="form-control form-control-lg require" type="text" name="cpfcnpj" id="cpfcnpj" value="<?=$empresa['cnpj']?>" require>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <label for="">Razão social*</label>
                                <input class="form-control form-control-lg require" type="text" name="razaosocial" id="razaosocial" value="<?=$empresa['razaosocial']?>" require>
                            </div>

                            <div class="col-xs-6">
                                <label for="">Nome Fantasia*</label>
                                <input class="form-control form-control-lg require" type="text" name="nomefantasia" id="nomefantasia" value="<?=$empresa['nomefantasia']?>" require>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <label for="">Inscrição Municipal</label>
                                <input class="form-control form-control-lg" type="text" name="inscricaomunicipal" id="inscricaomunicipal" value="<?=$empresa['inscricaoestadual']?>">
                            </div>
                            <div class="col-xs-6">
                                <label for="">Inscrição Estadual</label>
                                <input class="form-control form-control-lg" type="text" name="inscricaoestadual" id="inscricaoestadual" value="<?=$empresa['inscricaoestadual']?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <label for="">Email</label>
                                <input class="form-control form-control-lg" type="email" name="email" id="email" value="<?=$empresa['email']?>" style=" text-transform: lowercase;">
                            </div>
                            <div class="col-xs-6">
                                <label for="">Telefone</label>
                                <input class="form-control form-control-lg" type="text" name="fone" id="fone" value="<?=$empresa['telefone']?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12" style="margin-top: 10px;">
                            <div class="box box-solid box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Endereço</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <label for="">CEP*</label>
                                            <input class="form-control form-control-lg require" type="text" name="cep" id="cep" value="<?=$empresa['cep']?>" require>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="">Endereço (Logradouro)*</label>
                                            <input class="form-control form-control-lg require" type="text" name="endereco" id="endereco" value="<?=$empresa['endereco']?>" require>
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="">Número*</label>
                                            <input class="form-control form-control-lg require" type="text" name="numero" id="numero" value="<?=$empresa['numero']?>" require>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="">Complemento</label>
                                            <input class="form-control form-control-lg" type="text" name="complemento" id="complemento" value="<?=$empresa['complemento']?>" require>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="">Bairro*</label>
                                            <input class="form-control form-control-lg require" type="text" name="bairro" id="bairro" value="<?=$empresa['bairro']?>" require>
                                        </div>

                                        <div class="col-xs-4">
                                            <label for="">Cidade*</label>
                                            <select id="idcidade" name="idcidade" class="form-control select2 require" value="<?=$empresa['cidade']?>" style="width: 100%;" require>
                                                <?php
                                                    foreach($rowCidade as $rowCidade){
                                                ?>
                                                    <option value="<?=$rowCidade['id']?>" <?php if($rowCidade['id'] == $empresa['idcidade']){echo "selected='selected'";} ?>><?=$rowCidade['descricao']?><option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        

                                        <div class="col-xs-4">
                                            <label for=""> Referência</label>
                                            <input class="form-control form-control-lg" type="text" name="pontref" id="pontref" value="<?=$empresa['pontoreferencia']?>" require>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--div class="box box-solid box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Logo</h3>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-default btn-sm" data-widget="collapse">
                                <i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    </div-->
                </form>
            </div>
        </div>
    </select>
</div>

<?php
    include_once ('footer.php');
?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<script>
<?php
    include_once ('./controller/empresa/empresa.js');
    
?>
$(document).ready(function() {
    <?php
        if(isset($_POST['ver'])){
           echo  '$(".form-control").attr("disabled", true);';
        }
    ?>
    $('#idcidade').select2(/*{
        ajax: {
            url: "<?=$apiServe?>/dadosbase/cidade",
            cache: false
        }
    }*/);

    var tamanho = $("#cpfcnpj").val().length;

    if(tamanho < 11){
        $("#cpfcnpj").mask("999.999.999-99");
    } else {
        $("#cpfcnpj").mask("99.999.999/9999-99");
    }
    $('#fone').mask("(99)9 9999-9999");

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#endereco").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
        
    };

    $("#cep").blur(function() {
        var cep = $(this).val().replace(/\D/g, '');

        if (cep != "") {
            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                $("#endereco").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");

                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                        
                        $('#numero').focus();
                    }
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        //alert("CEP não encontrado.");
                    }
                })

            }else {
                //cep é inválido.
                limpa_formulário_cep();
                //alert("Formato de CEP inválido.");
            }
        }else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    })

});

<?php
    include_once('./app/funcoes.js');
?>
</script>