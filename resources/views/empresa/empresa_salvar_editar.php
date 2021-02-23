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
    
    $id = $_POST["cod"];
    $razaosocial = utf8_decode(strtoupper(strtolower($_POST["razaosocial"])));
    $nomefantasia = utf8_decode(strtoupper(strtolower($_POST["nomefantasia"])));
    $email = $_POST["email"];
    $cnpj = str_replace($pont, "", $_POST["cpfcnpj"]);
    $inscricaomunicipal = utf8_decode(strtoupper(strtolower($_POST["inscricaomunicipal"])));
    $inscricaoestadual = utf8_decode(strtoupper(strtolower($_POST["inscricaoestadual"])));
    $bairro = utf8_decode(strtoupper(strtolower($_POST["bairro"])));
    $cidade = $_POST["idcidade"];
    $endereco = utf8_decode(strtoupper(strtolower($_POST["endereco"])));
    $fone = str_replace($pont, "", $_POST["fone"]);
    $complemento = utf8_decode(strtoupper(strtolower($_POST["complemento"])));
    $pontoreferencia = utf8_decode(strtoupper(strtolower($_POST["pontref"])));
    $numero = $_POST['numero'];
    $cep = str_replace($pont, "", $_POST["cep"]);

    $sql = "SELECT * FROM cidade where id = ?;";
    $cid = $pdo->prepare($sql);
    $cid->execute([$cidade]);
    $rowCidade = $cid->fetch(PDO::FETCH_ASSOC);
    
    if($id == 0){

       $sql = "INSERT INTO empresa (razaosocial, nomefantasia, email, cnpj, emp, matriz, inscricaomunicipal, inscricaoestadual, telefone, 
                bairro, cidade, endereco, numero, complemento, pontoreferencia, cep, idfiscalregimetributario, numerofilial, idambiente, 
                idcidade) VALUES (?, ?, ?, ?, '0', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '1', '0', '1', ?);";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$razaosocial, $nomefantasia, $email, $cnpj, $_SESSION['empresa']['matriz'], $inscricaomunicipal, $inscricaoestadual, $fone,
                        $bairro, $rowCidade['descricao'], $endereco, $numero, $complemento, $pontoreferencia, $cep, $cidade]);
        $row = $stmt->rowCount();
        $erro = $stmt->errorInfo();
        
        if($row > 0){
            $sql = "UPDATE empresa SET numerofilial = (SELECT numerofilial+1) where id =" . $_SESSION['empresa']['matriz'] . ";";
            $stmt= $pdo->prepare($sql);
            $stmt->execute();
            $row = $stmt->rowCount();

            if($row >= 0){
                
                    $_SESSION['titulo'] = 'OK';
                    $_SESSION['MsgRetorno'] = 'Empresa '.$razaosocial .', salvo com sucesso';
                    $_SESSION['tipo'] = 'success';
                    echo "<script>location.href='".$url."/empresa?r=true'</script>";
            }else{
                $_SESSION['titulo'] = 'OK';
                $_SESSION['MsgRetorno'] = 'Empresa '.$razaosocial .', salvo com sucesso';
                $_SESSION['tipo'] = 'success';
                echo "<script>location.href='".$url."/empresa?r=true'</script>";
            }
            
        }else{
            $_SESSION['titulo'] = 'ERRO';
            $_SESSION['MsgRetorno'] = 'Empresa '.$razaosocial .', não pode ser salvo';
            $_SESSION['tipo'] = 'error';
            echo "<script>location.href='".$url."/empresa?r=true'</script>";
        }
    }else{
        $sql = "UPDATE empresa SET razaosocial = :razaosocial , nomefantasia = :nomefantasia, email = :email, cnpj = :cnpj, 
                inscricaomunicipal = :inscricaomunicipal, inscricaoestadual = :inscricaoestadual, telefone = :telefone, bairro = :bairro, 
                cidade = :cidade, endereco = :endereco, numero = :numero, complemento = :complemento, pontoreferencia = :pontoreferencia, 
                cep = :cep, idcidade = :idcidade where id = :id";

        $stmt= $pdo->prepare($sql);
        $stmt->bindValue(":razaosocial", $razaosocial);
        $stmt->bindValue("nomefantasia", $nomefantasia);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":cnpj", $cnpj);
        $stmt->bindValue(":inscricaomunicipal", $inscricaomunicipal);
        $stmt->bindValue(":inscricaoestadual", $inscricaoestadual);
        $stmt->bindValue(":telefone", $fone);
        $stmt->bindValue(":bairro", $bairro);
        $stmt->bindValue(":cidade", $rowCidade['descricao']);
        $stmt->bindValue(":endereco" , $endereco);
        $stmt->bindValue(":numero", $numero);
        $stmt->bindValue(":complemento", $complemento);
        $stmt->bindValue(":pontoreferencia", $pontoreferencia);
        $stmt->bindValue(":cep", $cep);
        $stmt->bindValue(":idcidade", $cidade);
        $stmt->bindValue(":id", $id);

        $stmt->execute();
        $row = $stmt->rowCount();
        $erro = $stmt->errorInfo();

        if($row >= 0){
            $_SESSION['titulo'] = 'OK';
            $_SESSION['MsgRetorno'] = 'Empresa '.$razaosocial .', alterado com sucesso';
            $_SESSION['tipo'] = 'success';
            echo "<script>location.href='".$url."/empresa?r=true'</script>";
        }else{
            $_SESSION['titulo'] = 'ERRO';
            $_SESSION['MsgRetorno'] = 'Empresa '.$razaosocial .', não pode ser alterado';
            $_SESSION['tipo'] = 'error';
            echo "<script>location.href='".$url."/empresa?r=true'</script>";
        }
    }
    
}
else if($del == 'remove'){

    $id = $_POST['cod'];
    $razaosocial = utf8_decode(strtoupper(strtolower($_POST['razaosocial'])));

    $sql = "UPDATE empresa SET deletado = 'S' where id = :id";
    $stmt= $pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    $row = $stmt->rowCount();

    if($row >= 0){
        $_SESSION['titulo'] = 'OK';
        $_SESSION['MsgRetorno'] = 'Empresa '.$razaosocial .', deletado com sucesso';
        $_SESSION['tipo'] = 'success';
        echo "<script>location.href='".$url."/empresa?r=true'</script>";
    }else{
        $_SESSION['titulo'] = 'ERRO';
        $_SESSION['MsgRetorno'] = 'Empresa '.$razaosocial .', não pode ser deletado';
        $_SESSION['tipo'] = 'error';
        echo "<script>location.href='".$url."/empresa?r=true'</script>";
    }
    
}

/*
    echo '<pre>';
    
    echo 'ID '.$id.'<br>';
    echo 'Razão Social ' . $razaosocial . '<br>';
    echo 'Nome Fantasia ' . $nomefantasia . '<br>';
    echo 'Email ' . $email . '<br>';
    echo 'CNPJ ' . $cnpj . '<br>';
    echo 'Inscrição Municipal ' . $inscricaomunicipal . '<br>';
    echo 'Inscrição Estadual ' . $inscricaoestadual . '<br>';
    echo 'Inscrição ' . $bairro . '<br>';
    echo 'Cidade ' . $cidade . '<br>';
    echo 'Endereço ' . $endereco . '<br>';
    echo 'Telefone ' . $fone . '<br>';
    echo 'Complemento ' . $complemento . '<br>';
    echo 'Ponto de Referencia ' . $pontoreferencia . '<br>';
    echo 'CEP ' . $cep . '<br>';

    echo '</pre>';
*/
?>