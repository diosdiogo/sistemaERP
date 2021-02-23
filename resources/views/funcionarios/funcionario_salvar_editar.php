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
        $tipo_pessoa = $_POST['tipo-pessoa'];
        $nomeRS = utf8_decode(strtoupper(strtolower($_POST['nomeRS'])));
        $nomeRF = utf8_decode(strtoupper(strtolower($_POST['nomeRF'])));
        $cpfcnpj = str_replace($pont, "", $_POST['cpfcnpj']);
        $rgie = strtoupper(strtolower($_POST['rgie']));
        $telefone = str_replace($pont, "", $_POST['telefone']);
        $celular = str_replace($pont, "", $_POST['celular']);
        $cep = str_replace($pont, "", $_POST['cep']);
        $endereco = utf8_decode(strtoupper(strtolower($_POST['endereco'])));
        $numero = $_POST['numero'];
        $bairro = utf8_decode(strtoupper(strtolower($_POST['bairro'])));
        $complemento = utf8_decode(strtoupper(strtolower($_POST['complemento'])));
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        $email = $_POST['email'];
        $trabalho = utf8_decode(strtoupper(strtolower($_POST['trabalho'])));
        $cargo = utf8_decode(strtoupper(strtolower($_POST['cargo'])));
        $endTrabalho = $_POST['endTrabalho'];
        $numeroTrab = $_POST['numeroTrab'];
        //$bairroTrab = $_POST['bairroTrab'];
        $cidTrab = $_POST['cidTrab'];
        //$cidUFTrab = $_POST['cidUFTrab'];
        $telFoneTrab = $_POST['telFoneTrab'];
        $limiteCredito = null;
        $obs = $_POST['obs'];
        /*
            echo 'Código ' . $cod . '<br>';
            echo 'Tipo de pessoa ' . $tipo_pessoa . '<br>';
            echo 'Razão Social ' . $nomeRS . '<br>';
            echo 'Nome Fantasia ' . $nomeRF . '<br>';
            echo 'CPF/CNPJ ' . $cpfcnpj . '<br>';
            echo 'RG/IE ' . $rgie . '<br>';
            echo 'Telefone ' . $telefone . '<br>';
            echo 'Celular ' . $celular . '<br>';
            echo 'CEP ' . $cep . '<br>';
            echo 'Endereço ' . $endereco . '<br>';
            echo 'Numero ' . $numero . '<br>';
            echo 'Bairro ' . $bairro . '<br>';
            echo 'Complemento ' . $complemento . '<br>';
            echo 'Cidade ' . $cidade . '<br>';
            echo 'UF ' . $uf . '<br>';
            echo 'Email ' . $email . '<br>';
            echo 'Trabalho ' . $trabalho . '<br>';
            echo 'Cargo ' . $cargo . '<br>';
            echo 'End. Trabalho ' . $endTrabalho . '<br>';
            echo 'Numero Trabalho ' . $numeroTrab . '<br>';
            //echo 'Bairro Trabalho ' . $bairroTrab . '<br>';
            echo 'Cidade Trabalho ' . $cidTrab . '<br>';
            //echo 'UF Trabalho ' . $cidUFTrab . '<br>';
            echo 'Tel Trabalho ' . $telFoneTrab . '<br>';
            echo 'Limite ' . $limiteCredito . '<br>';
        */
            if($limiteCredito == null){
                $limiteCredito = null;
            }
            //echo 'Data ' . $data . '<br>';
            //echo 'Obs ' . $obs . '<br>';
            if($obs == null){
                $obs = null;
            }
        //
        $sql = "SELECT * FROM cidade where id = ?;";
        $cid = $pdo->prepare($sql);
        $cid->execute([$cidade]);
        $rowCidade = $cid->fetch(PDO::FETCH_ASSOC);

        if ($cod == 0) {
            
            $sql = "INSERT INTO pessoa (ativo, razaosocial, idpessoatipo, idmatriz, idempresa, nomefantasia, 
            cpfoucnpj, idpessoatipocontribuinte, idpessoarelacao, iduf, rgouinscricaoestadual, celular, email, telefone, bairro, 
            cidade, endereco, numero, complemento, cep, limitecredito, created_at, updated_at, idcidade, observacao, colaborador) 
            VALUES (1, ?, ?, ?, ?, ?, ?, '1', '1', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,'S');";

            $stmt= $pdo->prepare($sql);
            $stmt->execute([$nomeRS, $tipo_pessoa, $_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'], $nomeRF,
                            $cpfcnpj, $uf, $rgie, $celular, $email, $telefone, $bairro, utf8_decode(strtoupper(strtolower($rowCidade['descricao']))), 
                            $endereco, $numero, $complemento, $cep, $limiteCredito, $data, $data, $cidade, $obs]);
            $row = $stmt->rowCount();
            $erro = $stmt->errorInfo();

            //print_r($erro);
            //echo $row;

            if ($row > 0) {
                $_SESSION['titulo'] = 'OK';
                $_SESSION['MsgRetorno'] = 'Funcionário '.$nomeRF .', salvo com sucesso';
                $_SESSION['tipo'] = 'success';
                echo "<script>location.href='".$url."/funcionarios?r=true'</script>";
            }else{
                $_SESSION['titulo'] = 'ERRO';
                $_SESSION['MsgRetorno'] = 'Funcionário '.$nomeRF .', não pode ser salvo';
                $_SESSION['tipo'] = 'error';
                echo "<script>location.href='".$url."/funcionarios?r=true'</script>";
            }

        }else if ($cod != 0){

            $sql = "UPDATE pessoa SET razaosocial = :razaosocial, idpessoatipo = :idpessoatipo, nomefantasia = :nomefantasia,
                    cpfoucnpj = :cpfoucnpj, iduf = :iduf, rgouinscricaoestadual = :rgouinscricaoestadual, celular = :celular,
                    email = :email, telefone = :telefone, bairro = :bairro, cidade = :cidade, endereco = :endereco, numero = :numero,
                    complemento = :complemento, cep = :cep, limitecredito = :limitecredito, updated_at = :updated_at, idcidade = :idcidade,
                    observacao = :observacao where id = :id";

            $stmt= $pdo->prepare($sql);
            $stmt->bindValue(":razaosocial", $nomeRS);
            $stmt->bindValue(":idpessoatipo", $tipo_pessoa);
            $stmt->bindValue(":nomefantasia", $nomeRF);
            $stmt->bindValue(":cpfoucnpj", $cpfcnpj);
            $stmt->bindValue(":iduf", $uf);
            $stmt->bindValue(":rgouinscricaoestadual", $rgie);
            $stmt->bindValue(":celular", $celular);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":telefone", $telefone);
            $stmt->bindValue(":bairro", $bairro);
            $stmt->bindValue(":cidade", utf8_decode(strtoupper(strtolower($rowCidade['descricao']))));
            $stmt->bindValue(":endereco", $endereco);
            $stmt->bindValue(":numero", $numero);
            $stmt->bindValue(":complemento", $complemento);
            $stmt->bindValue(":cep", $cep);
            $stmt->bindValue(":limitecredito", $limiteCredito);
            $stmt->bindValue(":updated_at", $data);
            $stmt->bindValue(":idcidade", $cidade);
            $stmt->bindValue(":observacao", $obs);
            $stmt->bindValue(":id", $cod);

            $stmt->execute();

            $row = $stmt->rowCount();
            $erro = $stmt->errorInfo();

            // print_r($erro);

            if ($row >= 0) {
                $_SESSION['titulo'] = 'OK';
                $_SESSION['MsgRetorno'] = 'Funcionário '.$nomeRF .', alterado com sucesso';
                $_SESSION['tipo'] = 'success';
                echo "<script>location.href='".$url."/funcionarios?r=true'</script>";
            }else{
                $_SESSION['titulo'] = 'ERRO';
                $_SESSION['MsgRetorno'] = 'Funcionário '.$nomeRF .', não pode ser alterado';
                $_SESSION['tipo'] = 'error';
                echo "<script>location.href='".$url."/funcionarios?r=true'</script>";
            }
        }
    }
    else if($del == 'remove'){
        $cod = $_POST['cod'];
        $nomeRF = utf8_decode(strtoupper(strtolower($_POST['nomeRF'])));

        $sql = "UPDATE pessoa SET deletado = 'S' where id = :id";
        $stmt= $pdo->prepare($sql);
        $stmt->bindValue(":id", $cod);
        $stmt->execute();

        $row = $stmt->rowCount();

        if ($row >= 0) {
            $_SESSION['titulo'] = 'OK';
            $_SESSION['MsgRetorno'] = 'Funcionário '.$nomeRF .', deletado com sucesso';
            $_SESSION['tipo'] = 'success';
            echo "<script>location.href='".$url."/funcionarios?r=true'</script>";
        }else{
            $_SESSION['titulo'] = 'ERRO';
            $_SESSION['MsgRetorno'] = 'Funcionário '.$nomeRF .', não pode ser deletado';
            $_SESSION['tipo'] = 'error';
            echo "<script>location.href='".$url."/funcionarios?r=true'</script>";
        }
    
    }