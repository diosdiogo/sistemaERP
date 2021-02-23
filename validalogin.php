<?php 
    include_once('config.php');
    include_once("conn.php");
    include_once("getIp.php");

    date_default_timezone_set('UTC');
    $today = date("Y-m-d H:i:s"); 

    $ip = get_client_ip();
    
    $email = $_POST['email'];
    $pass = $_POST['password'];

   $user = $pdo->prepare("SELECT * FROM user where email = '$email' and password = '$pass' ;");
   $user->bindValue(":email", $email);
   $user->bindValue(":pass", $pass);
    $user->execute();
    $result = $user->fetch(PDO::FETCH_ASSOC);
    $row = $user->rowCount();

    if ($row > 0) {
        $_SESSION['usuario'] = $result;

            if($_SESSION['usuario']['proprietario'] == 'S'){
                

                $empresa =$pdo->prepare("SELECT * FROM empresa where matriz = :idMatriz;");
                $empresa->bindValue(":idMatriz", $result['idmatriz']);
                $empresa->execute();
                $resultempresa = $empresa->fetchAll(PDO::FETCH_ASSOC);

                if($result['deletado'] == 'N'){
                    if (isset($_SESSION['ERROR'])) {
                        unset($_SESSION['ERROR']);
                    }

                    $session = $pdo->prepare("INSERT INTO sessions (user_id, idmatriz, idempresa, ip_address, login) 
                                            value (:user, :matriz, :empresa, :ip, :login)");
                    $session->bindValue(':user', $result['id']);
                    $session->bindValue(':matriz', $result['idmatriz']);
                    $session->bindValue(':empresa', $result['idempresafilial']);
                    $session->bindValue(':ip', $ip);
                    $session->bindValue(':login', $today);
                    $session->execute();
                    $_SESSION['idSession'] = $pdo->lastInsertId();

                    
                    $_SESSION['empresas'] = $resultempresa;
                    $_SESSION["user"] = $result['email'];
                    $_SESSION["pass"] = $result['password'];

                    $total = count($resultempresa);
                    echo $total;

                    if($total > 1){
                        echo "<script>location.href='" .$url."/selecioneEmpresa'</script>";
                    }else if($total == 1){
                        $_SESSION['empresa'] = $resultempresa[0];
                        echo "<script>location.href='" .$url."/home'</script>";
                    }
                   
                   //echo "<script>location.href='" .$url."/selecioneEmpresa'</script>";
                      
                }else{
                    $_SESSION["TIPO_AVISO"] = "danger";
                    $_SESSION['ERROR'] = "USUÁRIO NÃO TEM PERMISSÃO ";
                    echo "<script>location.href='" .$url."/login'</script>";
                }

            }else{

                $empresa =$pdo->prepare("SELECT * FROM empresa where id = :idFilial;");
                $empresa->bindValue(":idFilial", $result['idempresafilial']);
                $empresa->execute();
                $resultempresa = $empresa->fetch(PDO::FETCH_ASSOC);

                if($result['deletado'] == 'N'){
                    
                    if($resultempresa['bloqueiofinanceiro'] == 0){

                        $_SESSION['empresa'] = $resultempresa;
                        $_SESSION["user"] = $result['email'];
                        $_SESSION["pass"] = $result['password'];

                        $session = $pdo->prepare("INSERT INTO sessions (user_id, idmatriz, idempresa, ip_address, login) 
                        value (:user, :matriz, :empresa, :ip, :login)");
                        $session->bindValue(':user', $result['id']);
                        $session->bindValue(':matriz', $result['idmatriz']);
                        $session->bindValue(':empresa', $result['idempresafilial']);
                        $session->bindValue(':ip', $ip);
                        $session->bindValue(':login', $today);
                        $session->execute();
                        $_SESSION['idSession'] = $pdo->lastInsertId();

                        $_SESSION['empresas'] = $resultempresa;
                        $_SESSION["user"] = $result['email'];
                        $_SESSION["pass"] = $result['password'];
                       
                        echo "<script>location.href='" .$url."/home'</script>";
                    }else{

                        $_SESSION["TIPO_AVISO"] = "warning";
                        $_SESSION['ERROR'] = "ENTRAR EM CONTATO COM FINANCEIRO";
                        echo "<script>location.href='" .$url."/login'</script>";
                        
                    }

                }else{
                    $_SESSION["TIPO_AVISO"] = "danger";
                    $_SESSION['ERROR'] = "USUÁRIO NÃO TEM PERMISSÃO ";
                    echo "<script>location.href='" .$url."/login'</script>";
                }

                

            }
    }else{
        $_SESSION["TIPO_AVISO"] = "danger";
        $_SESSION['ERROR'] = "USUÁRIO OU SENHA INCORRETO";
        echo "<script>location.href='" .$url."/login'</script>";
    }

   