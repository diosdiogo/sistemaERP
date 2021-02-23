<?php

    $transportadora = $pdo->prepare("SELECT * FROM transportadora where idmatriz = :idMatriz and deletado = 'N';");
    $transportadora->bindValue(":idMatriz", $_SESSION['empresa']['matriz']);
    $transportadora->execute();
    $resulTransportadora = $transportadora->fetchAll(PDO::FETCH_ASSOC);
 
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
        Transportadoras
      </h1>
    </section>

    <section class="content">
    
        <div class="box box-primary">
            
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <form action="./transportadora_registro" method="post">
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
                                    foreach($resulTransportadora as $transportadora){
                                        
                                ?>
                                <tr>
                                    <td><?=$transportadora['id']?></td>
                                    <td><?=$transportadora['nomefantasia']?></td>
                                    <td><?=$transportadora['endereco']?></td>
                                    <td><?=$transportadora['numero']?></td>
                                    <td><?=$transportadora['cnpj']?></td>
                                    <td style="width:140px;">
                                        <div class="row" style="margin-left: 8px;">

                                            <form action="./transportadora_registro" method="post" style="float:left;">
                                                <input type="hidden" value="edit" name="v_e">
                                                <input type="hidden" value="<?=$transportadora['id']?>" name="id">
                                                <button type="submit" class="btn btn-secondary btn-sm" value="view" name="ver"><i class="fa fa-eye"></i></button>
                                            </form>

                                            <form action="./transportadora_registro" method="post" style="float:left;">
                                                <input type="hidden" value="edit" name="v_e">
                                                <input type="hidden" value="<?=$transportadora['id']?>" name="id">
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></button>
                                            </form>
                                            
                                            <form action="./transportadora_salvar_editar" method="POST" style="float:left;">
                                                <input type="hidden" value="remove" name="del">
                                                <input type="hidden" value="<?=$transportadora['id']?>" name="cod">
                                                <input type="hidden" value="<?=$transportadora['razaosocial']?>" name="razaosocial">
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
    include_once ('./controller/transportadoras/transportadoras.js');
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
        window.history.pushState("object", "Title", "./transportadoras");
    <?php
        }
    ?>
})
</script>