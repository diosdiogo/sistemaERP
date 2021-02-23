<?php
    include_once('./config.php');
    include_once("../conn.php");
    include_once("ip.php");

    date_default_timezone_set('America/Bahia');

    $data = date('Y-m-d H:i:s');
    $ip = get_client_ip();
    $pont = array("/" , "(", ")", "-","R","$",",");

    $cod = rand(1000,999999);
    $doc = rand(1000,999999);

    $method = $_SERVER['REQUEST_METHOD'];

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == null){
        $dados = $_REQUEST;
    }
   
    if($method == 'GET'){

        if(!empty($dados['buscar'])){

            $sql= "SELECT * FROM financeiroformarecebimento where id = :id;";
            $forma_pagamento = $pdo->prepare($sql);
            $forma_pagamento->bindValue(':id', $dados['id']);
            $forma_pagamento->execute();
        
            $rowFormaPagamento = $forma_pagamento->fetchAll(PDO::FETCH_ASSOC);

            $rowFormaPagamento[0]['numeropacela'] =  (float)$rowFormaPagamento[0]['numeropacela'];
            echo json_encode($rowFormaPagamento);
            
        }
    }
