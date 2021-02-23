<?php

    include_once('./config.php');
    include_once("../conn.php");

    $method = $_SERVER['REQUEST_METHOD'];

    //header("Content-Type: application/json");

    $body = file_get_contents('php://input', true);

    //var_dump($body);
   
    if($method === 'GET'){
        
        if(isset($route['4'])){
            if($route['4'] == 'pessoatipo'){
                $tipoPessoa =$pdo->prepare("SELECT * FROM pessoatipo;");
                $tipoPessoa->execute();
                $rowTipoPessoa = $tipoPessoa->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($rowTipoPessoa);            
            }
            else if($route['4'] == 'cidade'){
                $cidade =$pdo->prepare("SELECT * FROM cidade");
                $cidade->execute();
                $rowCidade = $cidade->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($rowCidade);
            }

            else if($route['4'] == 'estado'){
                $estado =$pdo->prepare("SELECT * FROM estado");
                $estado->execute();
                $rowEstado = $estado->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($rowEstado);
            }else{
                $result = array(
                    'ERROR'=> '404'
                );
                echo json_encode($result);
            }
        }else{
            $result = array(
                'ERROR'=> 'ERROR'
            );
            echo json_encode($result);
        }
        
    }else if($method === 'POST'){
        
        if($route['4'] == 'cidade'){

            $cid = $_POST['cidade'];
            
            $sql = "SELECT id, descricao FROM cidade where descricao LIKE '%$cid%'";
            $cidade =$pdo->prepare($sql);
            $cidade->execute();
            $rowCidade = $cidade->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rowCidade);
        }
    }
    