
   <style>
    body {
        background-color: #2e4dd4 !important;
    }

    .card{
        margin:0 auto;
       
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
        padding:20px;
    }

</style>

<div class="card" style="width: 339px; background-color:#fff; margin:0 auto; border-radius:20px">

    <form action="./empresaSelecionada" method="post">

        <div class="form-group">
            <div style="margin-bottom:25px;">
                <center><img src="./public/assets/empresa/imagem/<?=$_SESSION['empresas'][0]['matriz']?>/<?=$_SESSION['empresas'][0]['imagem']?>" class="user-image" alt="User Image"></center>
            </div>
            <label for="exampleFormControlSelect1">Selecione a empresa</label>
            <select name="emp" value="" class="form-control" id="exampleFormControlSelect1">
                
                <?php
                    foreach ($_SESSION['empresas'] as $empresa){
                ?>
                    <option value="<?=$empresa['id']?>"><?=$empresa['nomefantasia']?></option>
                <?php
                    }
                ?>
            </select>

            <center><button type="submit" class="btn btn-primary" style="margin-top:10px; margin 0 auto; border-radius:21px; padding: 5px 25px 5px 25px">Selecionar</button></center>

        </div>

    </form>
    
    
    
</div>



    <script src="./public/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="./public/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="./public/assets/plugins/iCheck/icheck.min.js"></script>

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>

