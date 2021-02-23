<?php

date_default_timezone_set('UTC');
$today = date("Y-m-d H:i:s"); 

$visualizarEditar = $_POST['v_e'];

if($visualizarEditar == 'edit'){
    $idTransp = $_POST['id'];
    
    $transp =$pdo->prepare("SELECT * FROM transportadora where id = :id;");
    $transp->bindValue(":id", $idTransp);
    $transp->execute();
    $transportadora = $transp->fetch(PDO::FETCH_ASSOC);
}else{

    $transportadora = array(
        'id' => '',
        'razaosocial' => '',
        'nomefantasia' => '',
        'email' => '',
        'cnpj' => '',
        'emp' => '',
        'matriz' =>'',
        'inscricaomunicipal' => '',
        'inscricaoestadual' => '',
        'telefone' => '',
        'bairro' => '',
        'cidade' => '',
        'iduf' => '',
        'endereco' => '',
        'numero' => '',
        'complemento' => '',
        'pontoreferencia' => '',
        'nomecontato' => '',
        'cep' => '',
        'idfiscalregimetributario' => '',
        'idempresaramoadeatividade' => '',
        'descricaorelatorio' => '',
        'created_at' => '',
        'updated_at' => '',
        'numerofilial' => '',
        'idambiente' => '',
        'idcidade' => '',
        'idcnae' => '',
        'senha' => '',
        'fraserelatorio' => '',
        'aliquotasimplesnacional' => '',
        'idfiscalcfopdentroestado' => '',
        'idfiscalcfopforaestado' => '',
        'imagem' => '',
        'bloqueiofinanceiro' => '',
        'deletado' => '',
        'descricao' => '',
        'placa' => ''
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
            Transportadoras
        </h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <form class="form-group3" action="./transportadora_salvar_editar" method="POST" autocomplete="off">
                    <div class="" style="position: -webkit-sticky; position: sticky; top: 0; z-index: 9999; background-color: #fff;">
                        <div class="col-12">
                            <div class="col-sm col-lg-12">
                                <?php

                                if(isset($_POST['ver'])){
                                ?>
                                <a href="./transportadoras" type="reset" class="btn btn-danger" style="margin-bottom: 10px;"><i class="fas fa-reply"></i> Voltar</a>
                                <?php
                                }else{
                                ?>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
                                                        
                                <a href="./transportadoras" type="reset" class="btn btn-danger"><i class="fa fa-close"></i> Cancelar</a>

                               <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" style="margin-top:15px;">
                        
                        <div class="row">
                            <div class="col-xs-1">
                                <label for="">Cód</label>
                                <input class="form-control form-control-lg" type="text" placeholder="0" name="cod" id="cod" value="<?=$transportadora['id']?>" readonly>
                            </div>

                            
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <label for="">Razão social*</label>
                                <input class="form-control form-control-lg require" type="text" name="razaosocial" id="razaosocial" value="<?=$transportadora['razaosocial']?>" require>
                            </div>

                            <div class="col-xs-6">
                                <label for="">Nome Fantasia*</label>
                                <input class="form-control form-control-lg require" type="text" name="nomefantasia" id="nomefantasia" value="<?=$transportadora['nomefantasia']?>" require>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <label for="">CNPJ*</label>
                                <input class="form-control form-control-lg require" type="text" name="cpfcnpj" id="cpfcnpj" value="<?=$transportadora['cnpj']?>" require>
                            </div>

                            <div class="col-xs-6">
                                <label for="">Inscrição Estadual</label>
                                <input class="form-control form-control-lg" type="text" name="inscricaoestadual" id="inscricaoestadual" value="<?=$transportadora['inscricaoestadual']?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <label for="">Email</label>
                                <input class="form-control form-control-lg" type="email" name="email" id="email" value="<?=$transportadora['email']?>" style=" text-transform: lowercase;">
                            </div>
                            <div class="col-xs-6">
                                <label for="">Telefone</label>
                                <input class="form-control form-control-lg" type="text" name="fone" id="fone" value="<?=$transportadora['telefone']?>">
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
                                            <input class="form-control form-control-lg" type="text" name="cep" id="cep" value="<?=$transportadora['cep']?>">
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="">Endereço (Logradouro)*</label>
                                            <input class="form-control form-control-lg" type="text" name="endereco" id="endereco" value="<?=$transportadora['endereco']?>">
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="">Número*</label>
                                            <input class="form-control form-control-lg" type="text" name="numero" id="numero" value="<?=$transportadora['numero']?>">
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="">Complemento</label>
                                            <input class="form-control form-control-lg" type="text" name="complemento" id="complemento" value="<?=$transportadora['complemento']?>">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <label for="">Bairro</label>
                                            <input class="form-control form-control-lg" type="text" name="bairro" id="bairro" value="<?=$transportadora['bairro']?>">
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="">Cidade*</label>
                                            <select class="form-control form-control-lg require" id="cidade" name="cidade" value="<?=$transportadora['cidade']?>">
                                                <?php
                                                    foreach($rowCidade as $rowCidade){
                                                ?>
                                                    <option value="<?=$rowCidade['id']?>" <?php if($rowCidade['id'] == $transportadora['idcidade']){echo "selected='selected'";} ?>><?=$rowCidade['descricao']?><option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="">UF*</label>
                                            <select class="form-control form-control-lg require" id="uf" name="uf" value="<?=$transportadora['iduf']?>">
                                                <?php
                                                    foreach($rowEstado as $rowEstado){
                                                ?>
                                                    <option value="<?=$rowEstado['id']?>" <?php if($rowEstado['id'] == $transportadora['iduf']){echo "selected='selected'";} ?>><?=$rowEstado['descricao']?><option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-xs-3">
                                            <label for="">Referencia</label>
                                            <input class="form-control form-control-lg" type="text" name="referencia" id="referencia" value="<?=$transportadora['bairro']?>">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-xs-12" style="margin-top: 10px;">
                            <div class="box box-solid box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Veiculo</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <label for="">Descrição</label>
                                    <input class="form-control form-control-lg" type="text" name="descricao" id="descricao" value="<?=$transportadora['descricao']?>">
                                </div>

                                <div class="col-xs-4">
                                    <label for="">Placa</label>
                                    <input class="form-control form-control-lg" type="text" name="placa" id="placa" value="<?=$transportadora['placa']?>" style="text-transform: uppercase;">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>

<script>
<?php
    include_once ('./controller/transportadoras/transportadoras.js');
    
?>
$(document).ready(function() {
    
    <?php
        if(isset($_POST['ver'])){
           echo  '$(".form-control").attr("disabled", true);';
        }
    ?>
    $('#uf').select2()
    $('#cidade').select2(/*{
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
        
    });
});

<?php
    include_once('./app/funcoes.js');
?>

</script>