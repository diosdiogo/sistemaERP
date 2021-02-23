<?php 
    include_once('config.php');
    include_once("conn.php");

    date_default_timezone_set('UTC');
    $today = date("Y-m-d H:i:s"); 

    $session = $pdo->prepare("update sessions set logout = :logout where  id = :idsession;");
    $session->bindValue(':logout', $today);
    $session->bindValue(':idsession', $_SESSION['idSession']);
   
    $session->execute();

    session_destroy();
    //header("Location:" .$url."/login");
    echo "<script>location.href='".$url."/login'</script>";