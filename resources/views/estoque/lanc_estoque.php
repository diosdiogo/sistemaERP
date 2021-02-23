<?php

    $produtos =$pdo->prepare("SELECT * FROM produto where idmatriz = :idMatriz and deletado = 'N';");
    $produtos->bindValue(":idMatriz", $_SESSION['empresa']['matriz']);
    $produtos->execute();
    $resultProduto = $produtos->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['r'])) {
        $return = $_GET['r'];
    }else{
        $return = false;
    }
    include_once ('./resources/views/menu-bar.php');
?>

<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Lançamento de estoque

      </h1>

    </section>

    <section class="content">

        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <form action="estoque_lanc" method="post">
                        <div class="input-group-lg col-md-9">
                            <label for="">Código / Produto</label>
                            <input class="form-control form-control-lg" id="prod" type="text" placeholder="Informe o Código ou o Nome do Produto" autocomplete="off" name="prod" value="">
                        </div>
                        <div class="input-group input-group-lg col-md-2">
                            <label for="">Quantidade</label>
                            <input class="form-control form-control-lg"  type="number" onkeyup="somenteNumeros(this)" autocomplete="off" name="qts" id="qts" value="" >
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-outline-dark" id="btnIncluir" style="margin-top:22px; margin-left:10px; color: white;background-color: #3c8dbc; border: none">
                                    <i class="fas fa fa-plus" ></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>

                <div class="row" style="margin-top: 30px; margin-right: 8px;">
                    <form class="form-group3" action="./estoque_salvar_editar" method="POST" autocomplete="off">
                        <div class="row" style="position: -webkit-sticky; position: sticky; top: 0; z-index: 9999; background-color: #fff;">
                            <div class="col-12">
                                <div class="col-sm col-lg-12">
                                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Salvar Estoque</button>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive-sm" style="margin-top:20px;">
                    <table id="estoque" class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Quant</th>
                                <th scope="col">Preço V.</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($_SESSION['estoque'])){
                                    foreach ($_SESSION['estoque'] as $estoque){
                            ?>
                            <tr>
                                <td><?=$estoque['codigoreduzido']?></td>
                                <td><?=$estoque['descricao']?></td>
                                <td><?=$estoque['estatual']?></td>
                                <td align="right">R$ <?=$estoque['precovista']?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
    </section>

</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php
    include_once ('./footer.php');
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

<?php
    include_once ('./controller/fornecedores/fornecedores.js');
?>

$(document).ready(function() {
    $("#qts").val(1);

    var produtos = [
        <?php
            foreach ($resultProduto as $produto){
                echo '"'.$produto['codigoreduzido'] . ' - ' . $produto['descricao'].'",';
            }
        ?>
    ];
    $( "#prod" ).autocomplete({
        source:produtos
    });

    var table = $('#estoque').DataTable({
        "language": {
            "url": "./public/assets/datatable/Portuguese.json",
        },
    });

    $('#estoque tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
    })

    <?php
        if ($return == true) {
    ?>
        swal("<?=$_SESSION['titulo']?>", "<?=$_SESSION['MsgRetorno']?>", "<?=$_SESSION['tipo']?>");
        window.history.pushState("object", "Title", "./lanc_estoque");
    <?php
        }
    ?>

});


<?php
include_once('./app/funcoes.js');
?>


</script>