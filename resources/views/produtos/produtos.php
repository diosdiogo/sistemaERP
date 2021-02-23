<?php
    $produtos =$pdo->prepare("SELECT produto.id, produto.idmatriz, produto.idempresa, produto.descricao, grade_produto.descricao as descricaograde,
    sum(estoque.estatual) as estatual, codigoreduzido, ativo, custocompra,
    precovista, precoatacado, precoprazo, grade_produto.idgrade, produto.idestoque, produto.deletado
    FROM produto left join grade_produto on ( produto.id = grade_produto.idproduto) 
    left join estoque on (produto.id = estoque.idproduto) 
    where produto.idmatriz = :idMatriz and produto.deletado = 'N' group by estoque.idproduto order by descricao asc;");
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
        Produtos
      </h1>
    </section>

    <section class="content">
    
        <div class="box box-primary">
            
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <form action="./produto_registro" method="post">
                            <input type="hidden" value="novo" name="v_e">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Novo</button>
                        </form>
                    </div>
                </div>

                <div class="table-responsive-sm" style="margin-top:20px;">
                    <table id="clientes" class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                
                                <th style="text-align:center" scope="col">Ativo</th>
                                <th scope="col">Código Reduzido</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Qts</th>
                                <th style="text-align:center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($resultProduto as $resultProduto){
                                        
                            ?>
                                <tr>
                                    <td style="text-align:center; width:30px;">
                                        <input type="checkbox" class="form-check-input" id="pdAtivo" <?php if ($resultProduto['ativo'] == 1 ) echo 'checked="checked"'; ?> disabled="disabled">
                                    </td>
                                    <td style="width:150px; text-align:center"><?=$resultProduto['codigoreduzido']?></td>
                                    <td><?=ucwords(strtolower($resultProduto['descricao']))?><?php if($resultProduto['descricaograde'] != null) echo ' - '. ucwords(strtolower($resultProduto['descricaograde'])); ?></td>
                                    <td style="text-align:right">R$ <?=$resultProduto['precovista']?></td>
                                    <td style="text-align:right"><?=number_format($resultProduto['estatual'])?></td>
                                    <td style="align-items:center">
                                        <div class="row" style="margin-left: 8px;">

                                            <form action="./produto_registro" method="post" style="float:left;">
                                                <input type="hidden" value="edit" name="v_e">
                                                <input type="hidden" value="<?=$resultProduto['id']?>" name="id">
                                                <button type="submit" class="btn btn-secondary btn-sm" value="view" name="ver"><i class="fa fa-eye"></i></button>
                                            </form>

                                            <form action="./produto_registro" method="post" style="float:left;">
                                                <input type="hidden" value="edit" name="v_e">
                                                <input type="hidden" value="<?=$resultProduto['id']?>" name="id">
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></button>
                                            </form>

                                            <form action="./produtos_salvar_editar" method="POST" style="float:left;">
                                                <input type="hidden" value="remove" name="del">
                                                <input type="hidden" value="<?=$resultProduto['id']?>" name="cod">
                                                <input type="hidden" value="<?=$resultProduto['descricao']?>" name="descricao">
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-trash-alt"></i></button>
                                            </form>
                                            <a href="./print_etiqueta?pd=<?=$resultProduto['id']?>" style="color:#000;" target="_blank">
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-barcode"></i></button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
    </select>
    
</div>

<?php
    include_once ('footer.php');
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
<?php
    include_once ('./controller/produtos/produtos.js');
?>

$(document).ready(function() {
    var table = $('#clientes').DataTable({
        "language": {
            "url": "./public/assets/datatable/Portuguese.json",
        },
    });

    $('#clientes tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        //alert( 'You clicked on '+data[0]+'\'s row' );
    })

    <?php
        if ($return == true) {
    ?>
        swal("<?=$_SESSION['titulo']?>", "<?=$_SESSION['MsgRetorno']?>", "<?=$_SESSION['tipo']?>");
        window.history.pushState("object", "Title", "./produtos");
    <?php
        }
    ?>
    
})

</script>