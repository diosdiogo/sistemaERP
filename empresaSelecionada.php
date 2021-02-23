<?php 
    include_once('config.php');
    include_once("conn.php");

    $id = $_POST['emp'];

    $empresa = $pdo->prepare("SELECT * FROM empresa where id = :id;");
    $empresa->bindValue(":id", $id);
    $empresa->execute();
    $result = $empresa->fetch(PDO::FETCH_ASSOC);

    if($result['bloqueiofinanceiro'] == 0){
        $_SESSION['empresa'] = $result;

        //var_dump($_SESSION['empresa']);
        //header("Location:" .$url."/home");
        echo "<script>location.href='".$url."/home'</script>";
    }else{
        $_SESSION["TIPO_AVISO"] = "warning";
        $_SESSION['ERROR'] = "ENTRAR EM CONTATO COM FINANCEIRO";
        //header("Location:" .$url."/login");
        echo "<script>location.href='".$url."/login'</script>";
        
    }
    