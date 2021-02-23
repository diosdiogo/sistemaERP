<?php

date_default_timezone_set('America/Bahia');

$data = date('Y-m-d H:i:s');

$pont = array(".", "/" , "(", ")", "-","R","$",",");

if (isset($_POST['del'])) {
    $del = $_POST["del"];
}else{
    $del = null;
}

if ($del == null) {
    $cod = $_POST['cod'];
    $razaosocial = utf8_decode(strtoupper(strtolower($_POST['razaosocial'])));
    $nomefantasia = utf8_decode(strtoupper(strtolower($_POST['nomefantasia'])));
    $cpfcnpj = str_replace($pont, "", $_POST['cpfcnpj']);
    $inscricaoestadual = $_POST['inscricaoestadual'];
    $email = $_POST['email'];
    $fone = str_replace($pont, "", $_POST['fone']);
    $cep = str_replace($pont, "", $_POST['cep']);
    $endereco = utf8_decode(strtoupper(strtolower($_POST['endereco'])));
    $numero = str_replace($pont, "", $_POST['numero']);
    $complemento = utf8_decode(strtoupper(strtolower($_POST['complemento'])));
    $bairro = utf8_decode(strtoupper(strtolower($_POST['bairro'])));
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $referencia = utf8_decode(strtoupper(strtolower($_POST['referencia'])));
    $descricao = utf8_decode(strtoupper(strtolower($_POST['descricao'])));
    $placa = utf8_decode(strtoupper(strtolower(str_replace($pont, "", $_POST['placa']))));
/*
    echo 'Codigo ' . $cod . '<br>';
    echo 'Razao Social ' . $razaosocial . '<br>';
    echo 'Nome Fantasia ' . $nomefantasia . '<br>';
    echo 'CPF CNPJ ' . $cpfcnpj . '<br>';
    echo 'Inscrição estadual ' . $inscricaoestadual . '<br>';
    echo 'Email ' . $email . '<br>';
    echo 'Fone ' . $fone . '<br>';
    echo 'CEP ' . $cep . '<br>';
    echo 'Endereço ' . $endereco . '<br>';
    echo 'numero ' . $numero . '<br>';
    echo 'Complemento ' . $complemento . '<br>';
    echo 'Bairro ' . $bairro . '<br>';
    echo 'Cidade ' . $cidade . '<br>';
    echo 'UF ' . $uf . '<br>';
    echo 'Referencia ' . $referencia . '<br>';
    echo 'Descricao ' . $descricao . '<br>';
    echo 'Placa ' . $placa . '<br>';
*/
    $sql = "SELECT * FROM cidade where id = ?;";
    $cid = $pdo->prepare($sql);
    $cid->execute([$cidade]);
    $rowCidade = $cid->fetch(PDO::FETCH_ASSOC);

    if ($cod == 0) {
        
        $sql = "INSERT INTO transportadora (idmatriz, idempresa, razaosocial, nomefantasia, cnpj, 
            inscricaoestadual, telefone, cep, endereco, numero, bairro, descricao, idcidade, cidade, complemento, 
            iduf, email, placa, ativo, created_at, updated_at, deletado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, 'N');";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'], $razaosocial, $nomefantasia, $cpfcnpj,
                        $inscricaoestadual, $fone, $cep, $endereco, $numero, $bairro, $descricao, $cidade,
                        utf8_decode(strtoupper(strtolower($rowCidade['descricao']))), $complemento, $uf, $email,
                        $placa, $data, $data]);
        $row = $stmt->rowCount();
        $erro = $stmt->errorInfo();

        //print_r($erro);
        //echo $row;

        if ($row > 0) {
            $_SESSION['titulo'] = 'OK';
            $_SESSION['MsgRetorno'] = 'Transportadora '.$razaosocial .', salvo com sucesso';
            $_SESSION['tipo'] = 'success';
            echo "<script>location.href='".$url."/transportadoras?r=true'</script>";
        }else{
            $_SESSION['titulo'] = 'ERRO';
            $_SESSION['MsgRetorno'] = 'Transportadora '.$razaosocial .', não pode ser salvo';
            $_SESSION['tipo'] = 'error';
            echo "<script>location.href='".$url."/transportadoras?r=true'</script>";
        }

    }else{

        $sql = "UPDATE transportadora SET razaosocial = :razaosocial, nomefantasia = :nomefantasia, cnpj = :cnpj, 
        inscricaoestadual = :inscricaoestadual, telefone = :telefone, cep = :cep, endereco = :endereco, 
        numero = :numero, bairro = :bairro, descricao = :descricao, idcidade = :idcidade, cidade = :cidade, 
        complemento = :complemento, iduf = :iduf, email = :email, placa = :placa , updated_at = :updated_at where id = :id";

        $stmt= $pdo->prepare($sql);
        $stmt->bindValue(":razaosocial", $razaosocial);
        $stmt->bindValue(":nomefantasia", $nomefantasia);
        $stmt->bindValue(":cnpj", $cpfcnpj);
        $stmt->bindValue(":inscricaoestadual", $inscricaoestadual);
        $stmt->bindValue(":telefone", $fone);
        $stmt->bindValue(":cep", $cep);
        $stmt->bindValue(":endereco", $endereco);
        $stmt->bindValue(":numero", $numero);
        $stmt->bindValue(":bairro", $bairro);
        $stmt->bindValue(":descricao", $descricao);
        $stmt->bindValue(":idcidade", $cidade);
        $stmt->bindValue(":cidade", utf8_decode(strtoupper(strtolower($rowCidade['descricao']))));
        $stmt->bindValue(":complemento", $complemento);
        $stmt->bindValue(":iduf", $uf);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":placa", $placa);
        $stmt->bindValue(":updated_at", $data);
        $stmt->bindValue(":id", $cod);

        $stmt->execute();
        $row = $stmt->rowCount();
        $erro = $stmt->errorInfo();

        print_r($erro);
        echo $row;

        if ($row > 0) {
            $_SESSION['titulo'] = 'OK';
            $_SESSION['MsgRetorno'] = 'Transportadora '.$razaosocial .', alterado com sucesso';
            $_SESSION['tipo'] = 'success';
            echo "<script>location.href='".$url."/transportadoras?r=true'</script>";
        }else{
            $_SESSION['titulo'] = 'ERRO';
            $_SESSION['MsgRetorno'] = 'Transportadora '.$razaosocial .', não pode ser alterado';
            $_SESSION['tipo'] = 'error';
            echo "<script>location.href='".$url."/transportadoras?r=true'</script>";
        }

    }

}else if($del == 'remove'){
    $cod = $_POST['cod'];
    $razaosocial = utf8_decode(strtoupper(strtolower($_POST['razaosocial'])));

    $sql = "UPDATE transportadora SET deletado = 'S' where id = :id";
    $stmt= $pdo->prepare($sql);
    $stmt->bindValue(":id", $cod);
    $stmt->execute();

    $row = $stmt->rowCount();

    if ($row >= 0) {
        $_SESSION['titulo'] = 'OK';
        $_SESSION['MsgRetorno'] = 'Transportadora '.$razaosocial .', deletado com sucesso';
        $_SESSION['tipo'] = 'success';
        echo "<script>location.href='".$url."/transportadoras?r=true'</script>";
    }else{
        $_SESSION['titulo'] = 'ERRO';
        $_SESSION['MsgRetorno'] = 'Transportadora '.$razaosocial .', não pode ser deletado';
        $_SESSION['tipo'] = 'error';
        echo "<script>location.href='".$url."/transportadoras?r=true'</script>";
    }

}