<?php
    include_once('./config.php');
    include_once("../conn.php");
    include_once("ip.php");


    date_default_timezone_set('America/Bahia');

    $data = date('Y-m-d H:i:s');
    $ip = get_client_ip();
    $pont = array("/" , "(", ")", "-","R","$",",");

    $method = $_SERVER['REQUEST_METHOD'];

    $dados = $_REQUEST;

    //print_r($dados);

    if($method == 'GET'){

        
        $caixa = $pdo->prepare("SELECT id, descricao FROM financeiroconta where idmatriz=:matriz and caixa = :cx and situacao = :st and deletado = :del order by descricao asc;");
        $caixa->bindValue(":matriz", $_SESSION['empresa']['matriz']);
        $caixa->bindValue(":cx", $dados['cx']);
        $caixa->bindValue(":st", $dados['st']);
        $caixa->bindValue(":del", $dados['del']);
        $caixa->execute();
        $rowCaixa = $caixa->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($rowCaixa);
    }

    if($method == 'PUT'){
        $retorno = array();
        $dados = json_decode(file_get_contents("php://input"), true);

        // echo '<pre>';
        // print_r($dados);
        // echo '</pre>';

        if($dados['st'] == 'Aberto'){
            $valor = str_replace($pont, "", $dados['saldo']);
            
            $sql = "UPDATE financeiroconta SET situacao = 'A', saldo = :saldo, dataabertura = :dataabertura WHERE id = :id;";
            $stmt= $pdo->prepare($sql);
            $stmt->bindValue(":id", $dados['caixa']);
            $stmt->bindValue(":saldo", $valor);
            $stmt->bindValue(":dataabertura", $data);
            $stmt->execute();

            $row = $stmt->rowCount();
            $erro = $stmt->errorInfo();

            if($row > 0){

                $caixa =$pdo->prepare("SELECT id, descricao FROM financeiroconta where id=:id;");
                $caixa->bindValue(":id", $dados['caixa']);
                $caixa->execute();
                $rowCaixa = $caixa->fetch(PDO::FETCH_ASSOC);
                echo json_encode($rowCaixa);

                $msg = 'Caixa '. $dados['caixa'] .' aberto às ' . $data . ' com saldo de ' . $valor . ' ';
                salvarLog($_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'], $ip, $_SESSION['usuario']['id'], $_SESSION['usuario']['name'], $msg);
               
            }
           

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
        //echo $response;
    }