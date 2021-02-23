<?php
date_default_timezone_set('UTC');
$today = date("Y-m-d H:i:s"); 

$visualizarEditar = $_POST['v_e'];

$cliente = array();

if($visualizarEditar == 'edit'){
    $idCliente = $_POST['idCliente'];
    
    $clientes =$pdo->prepare("SELECT * FROM pessoa where id = :id;");
    $clientes->bindValue(":id", $idCliente);
    $clientes->execute();
    $rowCliente = $clientes->fetch(PDO::FETCH_ASSOC);
    
    array_push($cliente, array(
        'id' => $rowCliente['id'],
        'ativo'=> $rowCliente['ativo'],
        'razaosocial' => ucwords(strtolower(utf8_decode($rowCliente['razaosocial']))),
        'idpessoatipo' => $rowCliente['idpessoatipo'],
        'idmatriz' => $rowCliente['idmatriz'],
        'idempresa' => $rowCliente['idempresa'],
        'nomefantasia' => ucwords(strtolower(utf8_decode($rowCliente['nomefantasia']))),
        'cpfoucnpj' => $rowCliente['cpfoucnpj'],
        'idpessoatipocontribuinte' => $rowCliente['idpessoatipocontribuinte'],
        'idufdocumento' => $rowCliente['idufdocumento'],
        'iduf' => $rowCliente['iduf'],
        'rgouinscricaoestadual' => $rowCliente['rgouinscricaoestadual'],
        'rgorgaoemissor' => $rowCliente['rgorgaoemissor'],
        'idpessoasexo' => $rowCliente['idpessoasexo'],
        'iddiadasemana' => $rowCliente['iddiadasemana'],
        'datanascimentoouabertura' => $rowCliente['datanascimentoouabertura'],
        'site' => utf8_decode($rowCliente['site']),
        'celular' => $rowCliente['celular'],
        'fax' => $rowCliente['fax'],
        'email' => utf8_decode($rowCliente['email']),
        'ignoralimitecredito' => $rowCliente['ignoralimitecredito'],
        'telefone' => $rowCliente['telefone'],
        'bairro' => ucwords(strtolower(utf8_decode($rowCliente['bairro']))),
        'cidade' => ucwords(strtolower(utf8_decode($rowCliente['cidade']))),
        'endereco' => ucwords(strtolower(utf8_decode($rowCliente['endereco']))),
        'numero' => $rowCliente['numero'],
        'complemento' => ucwords(strtolower(utf8_decode($rowCliente['complemento']))),
        'pontoreferencia' => ucwords(strtolower(utf8_decode($rowCliente['pontoreferencia']))),
        'nomecontato' => ucwords(strtolower(utf8_decode($rowCliente['nomecontato']))),
        'cep' => $rowCliente['cep'],
        'limitecredito' => $rowCliente['limitecredito'],
        'codigopesonalizado' => $rowCliente['codigopesonalizado'],
        'idenderecotipo' => $rowCliente['idenderecotipo'],
        'idpessoaramoatividade' => $rowCliente['idpessoaramoatividade'],
        'consumidorfinal' => $rowCliente['consumidorfinal'],
        'created_at' => $rowCliente['created_at'],
        'updated_at' => $today,
        'idcidade' => $rowCliente['idcidade'],
        'observacao'=> $rowCliente['observacao'],
    ));

}else{

    array_push($cliente, array(
        'id'=> 0,
        'ativo'=>'',
        'razaosocial'=>'',
        'idpessoatipo'=>1,
        'idmatriz'=>'',
        'idempresa'=>'',
        'nomefantasia'=>'',
        'cpfoucnpj'=>'',
        'idpessoatipocontribuinte'=>'',
        'idufdocumento'=>'',
        'iduf'=>'',
        'rgouinscricaoestadual'=>'',
        'rgorgaoemissor'=>'',
        'idpessoasexo'=>'',
        'iddiadasemana'=>'',
        'datanascimentoouabertura'=>'',
        'site'=>'',
        'celular'=>'',
        'fax'=>'',
        'email'=>'',
        'ignoralimitecredito'=>'',
        'telefone'=>'',
        'bairro'=>'',
        'cidade'=>'',
        'endereco'=>'',
        'numero'=>'',
        'complemento'=>'',
        'pontoreferencia'=>'',
        'nomecontato'=>'',
        'cep'=>'',
        'limitecredito'=>'',
        'codigopesonalizado'=>'',
        'idenderecotipo'=>'',
        'idpessoaramoatividade'=>'',
        'consumidorfinal'=>'',
        'created_at'=>$today,
        'updated_at'=> $today,
        'idcidade'=>'',
        'observacao'=>'',

    ));
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

</style>

<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Clientes
      </h1>
    </section>
<?php

?>
    <section class="content">
    
        <div class="box box-primary">
            
            <div class="box-header">

                <form class="form-group3" action="./funcionario_salvar_editar" method="POST" autocomplete="off">
                    
                    <div class="row" style="position: -webkit-sticky; position: sticky; top: 0; z-index: 9999; background-color: #fff;">
                        <div class="col-12">

                            <div class="col-sm col-lg-12">
                                <?php

                                    if(isset($_POST['ver'])){
                                ?>
                                    <a href="./funcionarios" type="reset" class="btn btn-danger" style="margin-bottom: 10px;"><i class="fas fa-reply"></i> Voltar</a>
                                <?php
                                    }else{
                                ?>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
                                                            
                                <a href="./funcionarios" type="reset" class="btn btn-danger"><i class="fa fa-close"></i> Cancelar</a>
                                
                                <label for="label-in-front" aria-hidden="true" tabindex="-1">
                                    Ativo
                                </label>
                                <md-checkbox ng-model="data.cb3" id="label-in-front"
                                            aria-label="Label in Front">
                                </md-checkbox>
                                <?php
                                    }
                                ?>
                                
                            
                            </div>
                            
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info" style="border: 1px rgba(10,0,0,0.5) solid">
                                
                                <div class="box-header with-border" style="background-color: #2E4DD4;">
                                    <h3 class="box-title" style="color:#fff">Dados Pessoais</h3>
                                    
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="box-body">
                                    <div class="row" style="margin-top:10px;">
                                        
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <label for="">Código</label>
                                                <input class="form-control form-control-lg" type="text" placeholder="0" name="cod" id="cod" value="<?=$cliente[0]['id']?>" readonly>
                                            </div>

                                            <div class="col-sm-2">
                                                <label for="">Tipo De Pessoa</label>
                                                <select class="form-control form-control-lg" id="tipo-pessoa" name="tipo-pessoa" value="<?=$cliente[0]['idpessoatipo']?>">
                                                    <?php
                                                        foreach ($rowTipoPessoa as $tipoPessoa){

                                                    ?>
                                                        <option value="<?=$tipoPessoa['id']?>" <?php if($tipoPessoa['id'] == $cliente[0]['idpessoatipo']){echo "selected='selected'";} ?>><?=$tipoPessoa['descricao']?></option>
                                                    <?php
                                                        }
                                                                                        
                                                    ?>
                                                    
                                                </select>
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="">Nome / Razão Social*</label>
                                                <input class="form-control form-control-lg require" type="text" name="nomeRS" value="<?=$cliente[0]['razaosocial']?>" require>
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="">Nome Fantasia</label>
                                                <input class="form-control form-control-lg" type="text" name="nomeRF" value="<?=$cliente[0]['nomefantasia']?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row" style="margin-top:10px;">
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label for="">CPF / CNPJ*</label>
                                                <input class="form-control form-control-lg require" type="text" name="cpfcnpj" id="cpfcnpj" value="<?=$cliente[0]['cpfoucnpj']?>" require>
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="">RG / Inscrição Estadual</label>
                                                <input class="form-control form-control-lg" type="text" name="rgie" value="<?=$cliente[0]['rgouinscricaoestadual']?>">
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="">Telefone</label>
                                                <input class="form-control form-control-lg" type="text" name="telefone" id="fone" value="<?=$cliente[0]['telefone']?>">
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="">Celular*</label>
                                                <input class="form-control form-control-lg require" type="text" name="celular" id="cel" value="<?=$cliente[0]['celular']?>" require>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:10px;">
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <label for="">CEP</label>
                                                <input class="form-control form-control-lg require" type="text" name="cep" id="cep" value="<?=$cliente[0]['cep']?>" require>
                                            </div>
                                        
                                            <div class="col-sm-4">
                                                <label for="">Endereço*</label>
                                                <input class="form-control form-control-lg require" type="text" name="endereco" id="endereco" value="<?=$cliente[0]['endereco']?>" require>
                                            </div>
                                        
                                            <div class="col-sm-2">
                                                <label for="">Numero*</label>
                                                <input class="form-control form-control-lg require" type="text" name="numero" id="numero" value="<?=$cliente[0]['numero']?>" require>
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="">Bairro*</label>
                                                <input class="form-control form-control-lg require" type="text" name="bairro" id="bairro" value="<?=$cliente[0]['bairro']?>" require>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row" style="margin-top:10px;">
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label for="">Complemento</label>
                                                <input class="form-control form-control-lg" type="text" name="complemento" id="complemento" value="<?=$cliente[0]['complemento']?>">
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="">Cidade*</label>
                                                <select class="form-control form-control-lg require" id="cidade" name="cidade" value="<?=$cliente[0]['cidade']?>">
                                                    <?php
                                                      foreach($rowCidade as $rowCidade){
                                                    ?>
                                                        <option value="<?=$rowCidade['id']?>" <?php if($rowCidade['id'] == $cliente[0]['idcidade']){echo "selected='selected'";} ?>><?=$rowCidade['descricao']?><option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="">UF*</label>
                                                <select class="form-control form-control-lg require" id="uf" name="uf" value="<?=$cliente[0]['iduf']?>">
                                                    <?php
                                                        foreach($rowEstado as $rowEstado){
                                                    ?>
                                                        <option value="<?=$rowEstado['id']?>" <?php if($rowEstado['id'] == $cliente[0]['iduf']){echo "selected='selected'";} ?>><?=$rowEstado['descricao']?><option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="">Email</label>
                                                <input class="form-control form-control-lg" type="email" name="email" id="email" value="<?=$cliente[0]['email']?>">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:10px;">
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <label for="">Trabalho</label>
                                                <input class="form-control form-control-lg" type="text" name="trabalho" id="trabalho" value="" readonly>
                                            </div>

                                            <div class="col-sm-2">
                                                <label for="">Cargo</label>
                                                <input class="form-control form-control-lg" type="text" name="cargo" id="cargo" value="" readonly>
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="">Endereço</label>
                                                <input class="form-control form-control-lg" type="text" name="endTrabalho" id="endTrabalho" value="" readonly>
                                            </div>

                                            <div class="col-sm-2">
                                                <label for="">Numero</label>
                                                <input class="form-control form-control-lg" type="text" name="numeroTrab" id="numeroTrab" value="" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="">Bairro</label>
                                                <input class="form-control form-control-lg" type="text" name="bairroTrab" id="bairoTrab" value="" readonly>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:10px;">
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <label for="">Cidade</label>
                                                <input class="form-control form-control-lg" type="text" name="cidTrab" id="cidTrab" value="" readonly>
                                            </div>

                                            <div class="col-sm-2">
                                                <label for="">UF</label>
                                                <input class="form-control form-control-lg" type="text" name="cidUFTrab" id="cidUFTrab" value="" readonly>
                                            </div>

                                            <div class="col-sm-2">
                                                <label for="">Telefone/Celular</label>
                                                <input class="form-control form-control-lg" type="text" name="telFoneTrab" id="telFoneTrab" value="" readonly>
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="">OBS</label>
                                                <input class="form-control form-control-lg" type="text" name="obs" id="obs" value="" readonly>
                                            </div>
                                            
                                        </div>
                                    </div>  

                                </div>
                            </div>
                        </div>

                        
                    </div>

                    <!--div class="row">
                        <div class="col-md-12">
                            <div class="box box-info" style="border: 1px rgba(10,0,0,0.5) solid">
                                
                                <div class="box-header with-border" style="background-color: #2E4DD4;">
                                    <h3 class="box-title" style="color:#fff">Dados Comerciais</h3>
                                    
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="row" style="margin-top:10px;">
                                        <div class="form-group">
                                            
                                            <div class="col-sm-6">
                                                <label for="">Referencia 1</label>
                                                <input class="form-control form-control-lg" type="text" name="ref1" id="ref1" value="">
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="">Referencia 2</label>
                                                <input class="form-control form-control-lg" type="text" name="ref2" id="ref2" value="">
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-sm-6">
                                                <label for="">Referencia Bancária</label>
                                                <input class="form-control form-control-lg" type="text" name="refBanc" id="refBanc" value="">
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="">Limite de Credito</label>
                                                <input class="form-control form-control-lg" type="text" name="limiteCredito" id="limiteCredito" value="<?=$cliente[0]['limitecredito']?>">
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="">Fechamento de Cobrança</label>
                                                <input class="form-control form-control-lg" type="date" name="fechamentoCobranca" id="fechamentoCobranca" value="">
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="">Observação</label>
                                                <textarea class="form-control text" name="obs" id="obs" cols="30"><?=$cliente[0]['observacao']?></textarea>
                                               
                                            </div>
                                        </div>

                                    </div>
                                </div>
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
<!-- DataTables -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<script>
<?php
    include_once ('./controller/clientes/clientes.js');
    
?>

$(document).ready(function() {
    <?php
        if(isset($_POST['ver'])){
           echo  '$(".form-control").attr("disabled", true);';
        }
    ?>

    $('#tipo-pessoa').select2();
    $('#cidade').select2(/*{
        ajax: {
            url: "<?=$apiServe?>/dadosbase/cidade",
            cache: false
        }
    }*/);
    $('#uf').select2();

    var tamanho = $("#cpfcnpj").val().length;

    if(tamanho < 11){
        $("#cpfcnpj").mask("999.999.999-99");
    } else {
        $("#cpfcnpj").mask("99.999.999/9999-99");
    }
    
    $('#fone').mask("(99)9 9999-9999");
    $('#cel').mask("(99)9 9999-9999");
    $("#cep").mask("99999-999");
    $("#limiteCredito").mask("R$ 9.999.99");

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
})

<?php
include_once('./app/funcoes.js');
?>
</script>

