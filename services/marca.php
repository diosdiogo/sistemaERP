<?php

    include_once('./config.php');
    include_once("../conn.php");
    include_once("ip.php");


    date_default_timezone_set('America/Bahia');

    $data = date('Y-m-d H:i:s');
    $ip = get_client_ip();

    $method = $_SERVER['REQUEST_METHOD'];

    $dados = $_REQUEST;

    
    if($method == 'GET'){

        $categorias =$pdo->prepare("SELECT id, descricao FROM produtomarca where idmatriz = :matriz and deletado = 'N' order by descricao asc;");
        $categorias->bindValue(":matriz", $dados['matriz']);
        $categorias->execute();
        $rowCategorias = $categorias->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($rowCategorias);

    }
    if($method == 'POST'){
        $retorno = array();
        $dados = json_decode(file_get_contents("php://input"), true);
        
       $sql = "INSERT INTO produtomarca (descricao, ativo, idmatriz, idempresa, created_at, deletado) 
        VALUES (?, 1, ?, ? , ?, 'N');
        ";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$dados['categ'], $dados['matriz'], $dados['empresa'], $data]);

        $row = $stmt->rowCount();
        $erro = $stmt->errorInfo();

        if($row >= 1){
            array_push($retorno, array(
                'return'=> 'SUCCESS'
            ));
            echo json_encode($retorno);

           $msg = 'Marca salva nome ' . $dados['categ'] . '';
           salvarLog($dados['matriz'], $dados['empresa'], $ip, $dados['codfunc'], $dados['nomefunc'], $msg);
        }else{
            array_push($retorno, array(
                'return'=> 'ERROR'
            ));
            echo json_encode($retorno);
        }

    }

    if($method == 'DELETE'){
        $retorno = array();
        $dados = json_decode(file_get_contents("php://input"), true);
        
        $sql = "UPDATE produtocategoria SET deletado = 'S', updated_at = :dataH WHERE (id = :id);
        ";
        $stmt= $pdo->prepare($sql);
        $stmt->bindValue(":dataH", $data);
        $stmt->bindValue(":id", $dados['categ']);
        $stmt->execute();

        $row = $stmt->rowCount();
        $erro = $stmt->errorInfo();

        if($row >= 1){
            array_push($retorno, array(
                'return'=> 'SUCCESS'
            ));
            echo json_encode($retorno);

           $msg = 'Categoria Deletada nome ' . $dados['name'] . '';
           salvarLog($dados['matriz'], $dados['empresa'], $ip, $dados['codfunc'], $dados['nomefunc'], $msg);
        }else{
            array_push($retorno, array(
                'return'=> 'ERROR'
            ));
            echo json_encode($retorno);
        }

    }

    if($method == 'PUT'){
        $retorno = array();
        $dados = json_decode(file_get_contents("php://input"), true);
        
        $sql = "UPDATE produtocategoria SET descricao = :descricao, updated_at = :dataH WHERE (id = :id);";
        $stmt= $pdo->prepare($sql);
        $stmt->bindValue(":id", $dados['categ']);
        $stmt->bindValue(":dataH", $data);
        $stmt->bindValue(":descricao", $dados['name']);
        $stmt->execute();

        $row = $stmt->rowCount();
        $erro = $stmt->errorInfo();

        if($row >= 1){
            array_push($retorno, array(
                'return'=> 'SUCCESS'
            ));
            echo json_encode($retorno);

           $msg = 'Categoria modificada nome ' . $dados['name'] . '';
           salvarLog($dados['matriz'], $dados['empresa'], $ip, $dados['codfunc'], $dados['nomefunc'], $msg);
        }else{
            array_push($retorno, array(
                'return'=> 'ERROR'
            ));
            echo json_encode($retorno);
        }
    }

    function salvarLog($matriz, $empresa, $ip, $codfunc, $nomefunc, $msg){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://artevisualsoft.com.br/sistema/services/log',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('matriz' => $matriz,'empresa' => $empresa,'ip' => $ip, 'idfuncionario' => $codfunc,'nomefuncionario' => $nomefunc,'historico' => $msg),
        CURLOPT_HTTPHEADER => array(
            'Cookie: erp=ee9ed5d733f8eaf338b9672bf3c2328c'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }