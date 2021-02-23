<?php

    include_once('./config.php');
    include_once("../conn.php");

    date_default_timezone_set('America/Bahia');

    $data = date('Y-m-d H:i:s');

    //var_dump($route);

    $body = file_get_contents('php://input', true);
    $method = $_SERVER['REQUEST_METHOD'];
    
    $matriz = $_REQUEST['matriz'];
    $empresa = $_REQUEST['empresa'];
    $ip = $_REQUEST['ip'];
    $idfuncionario =$_REQUEST['idfuncionario'];
    $nomefuncionario = $_REQUEST['nomefuncionario'];
    $historico = $_REQUEST['historico'];

    if($method == 'POST'){

        try{
            $sql = "INSERT INTO log (matriz, empresa, created_at, ip, idfuncionario, nomefuncionario, historico) 
                        VALUES (?, ?, ?, ?, ?, ?, ?);
                        ";
            $stmt= $pdo->prepare($sql);
            $stmt->execute([$matriz, $empresa, $data, $ip, $idfuncionario, $nomefuncionario, $historico]);
            $row = $stmt->rowCount();
            $erro = $stmt->errorInfo();

            echo json_encode($erro);
        }catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
        
    }

    
    
