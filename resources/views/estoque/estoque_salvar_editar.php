<?php

date_default_timezone_set('America/Bahia');

$data = date('Y-m-d H:i:s');

$pont = array(".", "/" , "(", ")", "-","R","$",",");

foreach ($_SESSION['estoque'] as $estoque){
    $linhaEstoque = $pdo->prepare("SELECT * FROM estoque where idproduto = :produto and idempresa = :empresa;");
    $linhaEstoque->bindValue(":produto", $estoque['id']);
    $linhaEstoque->bindValue(":empresa", $_SESSION['empresa']['id']);
    $linhaEstoque->execute();
    $row = $linhaEstoque->fetch(PDO::FETCH_ASSOC);

    if($row == NULL){

        $sql = "INSERT INTO estoque (idmatriz, idempresa, idproduto, estminimo, estmaximo, estatual, estestant, 
        created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?);
        ";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'],$estoque['id'], 0, 0, $estoque['estatual'],0 ,
        $data]);
        
        $row = $stmt->rowCount();
        
        $erro = $stmt->errorInfo();

        //$sql_linha = "select max(id) as id from estoque where idempresa = :empresa and idproduto = :produto;";
        $stmt2 = $pdo->prepare("SELECT max(id) as id FROM estoque where idempresa = :empresa and idproduto = :produto;");
        $stmt2->bindValue(":empresa", $_SESSION['empresa']['id']);
        $stmt2->bindValue(":produto", $estoque['id']);
        $stmt2->execute();
        $row_linha = $stmt2->fetch(PDO::FETCH_ASSOC);

        $sql_linha = "UPDATE produto SET idestoque = :estoque WHERE (id = :id);";
        $stmt3 = $pdo->prepare($sql_linha);
        $stmt3->bindValue(":estoque", $row_linha['id']);
        $stmt3->bindValue(":id", $estoque['id']);
        $stmt3->execute();
        

    }else{
       
        $sql = "UPDATE estoque SET estatual = (select estatual)+:estatual WHERE (idproduto = :id) and idempresa = :idempresa;";
        $stmt= $pdo->prepare($sql);
        $stmt->bindValue(":estatual", $estoque['estatual']);
        $stmt->bindValue(":idempresa", $_SESSION['empresa']['id']);
        $stmt->bindValue(":id", $estoque['id']);
        $stmt->execute();

        $row = $stmt->rowCount();
        $erro = $stmt->errorInfo();
        
    }
}
        $_SESSION['titulo'] = 'OK';
        $_SESSION['MsgRetorno'] = 'Estoque, lançado com sucesso';
        $_SESSION['tipo'] = 'success';

        unset($_SESSION['estoque']);
    echo "<script>location.href='".$url."/lanc_estoque?r=true'</script>";