<?php

     $empresa =$pdo->prepare("SELECT * FROM empresa where matriz = :idMatriz and deletado = 'N';");
     $empresa->bindValue(":idMatriz", $_SESSION['empresa']['matriz']);
     $empresa->execute();
     $resulEmpresa = $empresa->fetchAll(PDO::FETCH_ASSOC);
 
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
        Empresa
      </h1>
    </section>

    <section class="content">
    
        <div class="box box-primary">
            
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <form action="./empresa_registro" method="post">
                            <input type="hidden" value="novo" name="v_e">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Novo</button>
                        </form>
                    </div>

                    <div class="col-md-4">
                        
                        <!--input class="form-control" name="clientName" ng-model="pesquisar" placeholder="Pesquisar"-->
                        
                    </div>
                
                </div>

                <div class="table-responsive-sm" style="margin-top:20px;">
                    <table id="empresa" class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Razão Social</th>
                                <th scope="col">Nome Fantasia</th>
                                <th scope="col">Cidade</th>
                                <th scope="col">Telefone</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($resulEmpresa as $empresa){
                            ?>
                            <tr>
                                <td><?=$empresa['id']?></td>
                                <td><?=$empresa['razaosocial']?></td>
                                <td><?=$empresa['nomefantasia']?></td>
                                <td><?=$empresa['cidade']?></td>
                                <td><?=$empresa['telefone']?></td>

                                <td style="width:140px;">
                                    <div class="row" style="margin-left: 8px;">
                                        
                                        <form action="./empresa_registro" method="post" style="float:left;">
                                            <input type="hidden" value="edit" name="v_e">
                                            <input type="hidden" value="<?=$empresa['id']?>" name="idEmpresa">
                                            <button type="submit" class="btn btn-secondary btn-sm" value="view" name="ver"><i class="fa fa-eye"></i></button>
                                        </form>

                                        <form action="./empresa_registro" method="post" style="float:left;">
                                            <input type="hidden" value="edit" name="v_e">
                                            <input type="hidden" value="<?=$empresa['id']?>" name="idEmpresa">
                                            <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></button>
                                        </form>

                                        <form action="./empresa_salvar_editar" method="POST" style="float:left;">
                                            <input type="hidden" value="remove" name="del">
                                            <input type="hidden" value="<?=$empresa['id']?>" name="cod">
                                            <input type="hidden" value="<?=$empresa['razaosocial']?>" name="razaosocial">
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
    include_once ('./controller/empresa/empresa.js');
?>

$(document).ready(function() {
    var table = $('#empresa').DataTable({
        "language": {
            "url": "./public/assets/datatable/Portuguese.json",
        },
    });
    $('#empresa tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
    });

    <?php
        if ($return == true) {
    ?>
        swal("<?=$_SESSION['titulo']?>", "<?=$_SESSION['MsgRetorno']?>", "<?=$_SESSION['tipo']?>");
        window.history.pushState("object", "Title", "./empresa");
    <?php
        }
    ?>

})

</script>