
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
    .callout{
       
        position: absolute;
        top: 10%;
        right: 0;
       
        padding:20px;
    }

</style>
<div ng-controller="artevisualsoftCtrl">
<div class="card" style="width: 339px; background-color:#fff; margin:0 auto; border-radius:20px">
   <form action="<?=$url?>/validalogin" role="form" method="POST">

        <div class="form-group" style="margin-bottom: 20px;">
            <div>
                <center><img class="rounded d-block" src="./public/assets/image/Logo-azul1.png" alt=""></center>
            
            </div>
            
            <center><span class="text-center" style="font-size: 18px;">Bem Vindos!</span><br>
            <span class="text-center" style="">Faça login na sua conta</span></center>

            <div class="form-group row" style="margin-top:25px; margin-left: 10px;">
                <div class="col-sm-2 col-form-label"  style="width:40px; background-color:#fff; padding:10px; border-radius: 100px; box-shadow: 0 0 0.3em #2e4dd4; z-index: 999;">
                    <center><i class="fa fa-user"></i></center>
                </div>

                <div class="col-sm-10" style="margin-left: -25px;">
                    <input id="email" name="email" type="email" class="form-control" placeholder="Usuário" name="email" style="border-radius: 15px; box-shadow: 0 0 0.3em rgba(46, 77, 212, 0.5);">
                </div>
            </div>
            
            <div class="form-group row" style="margin-top:25px; margin-left: 10px;">
                <div class="col-sm-2 col-form-label"  style="width:40px; background-color:#fff; padding:10px; border-radius: 100px; box-shadow: 0 0 0.3em #2e4dd4; z-index: 999;">
                    <center><i class="fa fa-unlock-alt"></i></center>
                </div>

                <div class="col-sm-10" style="margin-left: -25px;">
                    <input id="password" name="password" type="password" class="form-control" placeholder="Senha" name="senha" style="border-radius: 15px; box-shadow: 0 0 0.3em rgba(46, 77, 212, 0.5);">
                </div>

            </div>

        </div>
        
            <center><button type="submit" class="btn btn-primary" style="margin 0 auto; border-radius:21px; padding: 5px 25px 5px 25px">Entrar</button></center>
            
        </div>

        <br>

       <?php if(isset($_SESSION['ERROR'])){
            
        ?>
            <div class="callout callout-<?=$_SESSION["TIPO_AVISO"]?>" style="width:339px;">
                <h4> <?=$_SESSION['ERROR']?></h4>
            </div>
       <?php
       }
       ?>
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

