<?php
include_once('config.php');
include_once("conn.php");

?>
<!DOCTYPE html>
<html ng-app="artevisualsoft" lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <title>Arte Visual Sot</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="./public/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./public/assets/bower_components/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="<?=$url?>/public/assets/dist/css/angular-material.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./public/assets/bower_components/font-awesome/css/all.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./public/assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./public/assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="./public/assets/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="./public/assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="./public/assets/bower_components/jvectormap/jquery-jvectormap.css">
 
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="./assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./public/assets/jquery.dataTables.min.css">
  <link rel="stylesheet" href="./public/assets/bower_components/jquery-ui/jquery-ui.css">

  
    <link rel="icon" type="image/png" href="./public/assets/image/Logo-azul1.png"/>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<style>
    .sidebar-toggle{
        color: #fff;
    }

    .navbar-static-top a:hover{
        background-color: #367fa9 !important;
    }
    .busca {
        box-shadow: none !important;
        background-color: #374850 !important;
        border: 1px solid transparent !important;
        height: 35px !important;
        border-radius: 6px;
    }
    .btnbuscar{
        box-shadow: none !important;
        background-color: #374850 !important;
        border: 1px solid transparent !important;
        height: 35px !important;
        border-radius: 6px;
    }
    .navbar-nav a{
        color: #fff !important;
    }
    .sidebar a{
        color: #b8c7ce !important;
    }

    .main-header .sidebar-toggle:before {
        content: "";
    }
    .skin-blue .main-header .logo{
        background-color: #3c8dbc;
    }
    <?php
        if($_SESSION['empresa']['matriz'] != 1){
    ?>
        .block{
            display:none;
        }
    <?php
        }else{
    ?>
        .block{
            display:block;
        }
    <?php
        }
    ?>
    

   
    
</style>
<body class="hold-transition skin-blue sidebar-mini">

<?php

    if($route[2] == ''){
        
        if(!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])){
            //var_dump($route);
            echo "<script>location.href='" .$url."/login'</script>";
           // echo $url."/login";
        }else{
            
            echo "<script>location.href='" .$url."/home'</script>";
        }

    }

    else if ($route[2] == 'login') {
        include_once 'resources/views/login.php';
    }
    else if ($route[2] == 'logout') {
        include_once 'logout.php';
    }
    else if ($route[2] == 'validalogin') {
        include_once 'validalogin.php';
    }
    else if($route[2] == 'empresaSelecionada'){
        include_once 'empresaSelecionada.php';
    } 

    if($route[2] != 'login'){
        if(!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])){
            
            echo "<script>location.href='" .$url."/login'</script>";
        }
        //var_dump($route);
    ?>

    <div ng-controller="artevisualsoftCtrl">
        
        <?php 
            include_once 'router.php'
            
        ?>
           
  
            
    <?php
    
    }

    ?>
    </div>
</body>
</html>

