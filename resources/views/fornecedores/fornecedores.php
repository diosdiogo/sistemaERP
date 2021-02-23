<?php
     $fornecedor = $pdo->prepare("SELECT * FROM pessoa where idmatriz = :idMatriz and idpessoarelacao = 1 and deletado = 'N' and fornecedor = 'S';");
     $fornecedor->bindValue(":idMatriz", $_SESSION['empresa']['matriz']);
     $fornecedor->execute();
     $resulFornecedor = $fornecedor->fetchAll(PDO::FETCH_ASSOC);
 
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
        Fornecedores
      </h1>
    </section>

    <section class="content">
    
        <div class="box box-primary">
            
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <form action="./fornecedor_registro" method="post">
                            <input type="hidden" value="novo" name="v_e">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Novo</button>
                        </form>
                    </div>
                </div>

                <div class="table-responsive-sm" style="margin-top:20px;">
                    <table id="clientes" class="table table-bordered table-striped">
                            
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Endereço</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">CPF/CNPJ</th>
                                <th>Ação</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                                <?php
                                    foreach($resulFornecedor as $fornecedor){
                                        
                                ?>
                                <tr>
                                    <td><?=$fornecedor['id']?></td>
                                    <td><?=$fornecedor['nomefantasia']?></td>
                                    <td><?=$fornecedor['endereco']?></td>
                                    <td><?=$fornecedor['celular']?></td>
                                    <td><?=$fornecedor['cpfoucnpj']?></td>
                                    <td style="width:140px;">
                                        <div class="row" style="margin-left: 8px;">

                                            <form action="./fornecedor_registro" method="post" style="float:left;">
                                                <input type="hidden" value="edit" name="v_e">
                                                <input type="hidden" value="<?=$fornecedor['id']?>" name="idCliente">
                                                <button type="submit" class="btn btn-secondary btn-sm" value="view" name="ver"><i class="fa fa-eye"></i></button>
                                            </form>

                                            <form action="./fornecedor_registro" method="post" style="float:left;">
                                                <input type="hidden" value="edit" name="v_e">
                                                <input type="hidden" value="<?=$fornecedor['id']?>" name="idCliente">
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></button>
                                            </form>
                                            
                                            <form action="./fornecedor_salvar_editar" method="POST" style="float:left;">
                                                <input type="hidden" value="remove" name="del">
                                                <input type="hidden" value="<?=$fornecedor['id']?>" name="cod">
                                                <input type="hidden" value="<?=$fornecedor['nomefantasia']?>" name="nomeRF">
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-trash-alt"></i></button>
                                            </form>
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
    include_once ('./footer.php');
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
<?php
    include_once ('./controller/fornecedores/fornecedores.js');
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
        window.history.pushState("object", "Title", "./fornecedores");
    <?php
        }
    ?>
})
</script>