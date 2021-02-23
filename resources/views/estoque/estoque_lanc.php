<?php

    date_default_timezone_set('America/Bahia');

    $data = date('Y-m-d H:i:s');

    $pont = array(".", "/" , "(", ")", "-","R","$",",");

    if (isset($_POST['del'])) {
        $del = $_POST["del"];
    }else{
        $del = null;
    }
    //unset($_SESSION['estoque']);

    $prod = $_POST['prod'];
    $qts = $_POST['qts'];

    $produto = explode('-',$prod);


    $codigo = trim($produto[0]);
    $descricao = trim($produto[1]);

    try{
        //$sql = "SELECT * FROM produto where idmatriz = ".$_SESSION['empresa']['matriz']." and codigoreduzido = '".$codigo."' and descricao = '".$descricao."';";
        //echo $sql;

        $ProdStmt= $pdo->prepare("SELECT * FROM produto where idmatriz = :idmatriz and codigoreduzido = :codigo and descricao = :descricao;");
        $ProdStmt->bindValue(":idmatriz", $_SESSION['empresa']['matriz']);
        $ProdStmt->bindValue(":codigo", $codigo);
        $ProdStmt->bindValue(":descricao", $descricao);
        $ProdStmt->execute();
        $rowProd = $ProdStmt->fetch(PDO::FETCH_ASSOC);
        
        //$erro = $stmt->errorInfo();

        /*$estStmt = $pdo->prepare("SELECT * FROM estoque where idproduto = :idproduto and idempresa = :empresa;");
        $estStmt->bindValue(":idproduto",$rowProd['id']);
        $estStmt->bindValue(":empresa", $_SESSION["empresa"]['id']);
        $estStmt->execute();
        $rowEst = $estStmt->fetch(PDO::FETCH_ASSOC);

        echo '<pre>';
        print_r($rowEst);
        echo '</pre>';
        $estoque = $rowEst['estatual']+1;
        */
        

        if(!isset($_SESSION['estoque'])){
            $_SESSION['estoque'] = array();

            array_push($_SESSION['estoque'], array(
                'id'=>$rowProd['id'],
                'codigoreduzido' => $rowProd['codigoreduzido'],
                'descricao' => $rowProd['descricao'],
                'estatual' => $qts,
                'precovista' => $rowProd['precovista']

            ));
            
        }else{
            $key = array_keys(array_column($_SESSION['estoque'], 'descricao'), $descricao); 
           
            if(isset($key[0])){
                $key = $key[0];
                $_SESSION['estoque'][$key]['estatual'] += $qts;
            }else{
                array_push($_SESSION['estoque'], array(
                    'id'=>$rowProd['id'],
                    'codigoreduzido' => $rowProd['codigoreduzido'],
                    'descricao' => $rowProd['descricao'],
                    'estatual' => $qts,
                    'precovista' => $rowProd['precovista']
    
                ));
            }
        }
       
        echo "<script>location.href='".$url."/lanc_estoque'</script>";

    }catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }