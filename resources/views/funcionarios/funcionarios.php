<?php

    $clientes =$pdo->prepare("SELECT * FROM pessoa where idmatriz = :idMatriz and idpessoarelacao = 1 and deletado = 'N' and colaborador = 'S';");
    $clientes->bindValue(":idMatriz", $_SESSION['empresa']['matriz']);
    $clientes->execute();
    $resulClientes = $clientes->fetchAll(PDO::FETCH_ASSOC);

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
        Funcionários
      </h1>
    </section>

    <section class="content">
    
        <div class="box box-primary">
            
            <div class="box-header">
                
                <div class="row">
                    <div class="col-md-1">
                        <form action="./funcionario_registro" method="post">
                            <input type="hidden" value="novo" name="v_e">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Novo</button>
                        </form>
                    </div>

                    <div class="col-md-4">
                        
                        <!--input class="form-control" name="clientName" ng-model="pesquisar" placeholder="Pesquisar"-->
                        
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
                                    foreach($resulClientes as $clientes){
                                        
                                ?>
                                <tr>
                                    <td><?=$clientes['id']?></td>
                                    <td><?=$clientes['nomefantasia']?></td>
                                    <td><?=$clientes['endereco']?></td>
                                    <td><?=$clientes['celular']?></td>
                                    <td><?=$clientes['cpfoucnpj']?></td>
                                    <td style="width:140px;">
                                        <div class="row" style="margin-left: 8px;">

                                            <form action="./funcionario_registro" method="post" style="float:left;">
                                                <input type="hidden" value="edit" name="v_e">
                                                <input type="hidden" value="<?=$clientes['id']?>" name="idCliente">
                                                <button type="submit" class="btn btn-secondary btn-sm" value="view" name="ver"><i class="fa fa-eye"></i></button>
                                            </form>

                                            <form action="./funcionario_registro" method="post" style="float:left;">
                                                <input type="hidden" value="edit" name="v_e">
                                                <input type="hidden" value="<?=$clientes['id']?>" name="idCliente">
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></button>
                                            </form>
                                            
                                            <form action="./funcionario_salvar_editar" method="POST" style="float:left;">
                                                <input type="hidden" value="remove" name="del">
                                                <input type="hidden" value="<?=$clientes['id']?>" name="cod">
                                                <input type="hidden" value="<?=$clientes['nomefantasia']?>" name="nomeRF">
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
    include_once ('footer.php');
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
<?php
    include_once ('./controller/funcionarios/funcionarios.js');
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
        window.history.pushState("object", "Title", "./clientes");
    <?php
        }
    ?>
    
})
</script>