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
        //$body = file_get_contents('php://input', true);
       // $dados = $_REQUEST;
        
        // $dados = $_REQUEST;
        //print_r($dados['dados']);

        
        $cod = $_POST['cod'];
        if(isset($_POST['pdAtivo'])){
            $pdAtivo = $_POST['pdAtivo'];
            if($pdAtivo == true){
                $pdAtivo = 1;
            }else{
                $pdAtivo = 0;
            }
        }else{
            $pdAtivo = 0;
        }
        
        if(isset($_POST['pdContaEstoque'])){
            $pdContaEstoque = $_POST['pdContaEstoque'];
            if($pdContaEstoque == true){
                $pdContaEstoque = 1;
            }else{
                $pdContaEstoque = 0;
            }
        }else{
            $pdContaEstoque = 0;
        }

        if(isset($_POST['habilitapdv'])){
            $habilitapdv = $_POST['habilitapdv'];
            if($habilitapdv == true){
                $habilitapdv = 1;
            }else{
                $habilitapdv = 0;
            }
        }else{
            $habilitapdv = 0;
        }
        
        
        $descricao = strtoupper($_POST['descricao']);
        $codigobarra = $_POST['codigobarra'];
        $idunidademedida = $_POST['idunidademedida'];
        if($idunidademedida == null){
            $idunidademedida = NULL;
        }
        $estoquequantidadecaixa = $_POST['estoquequantidadecaixa'];

        if($estoquequantidadecaixa == null){
            $estoquequantidadecaixa = 0;
        }
        $idprodutocategoria = $_POST['idprodutocategoria'];

        if($idprodutocategoria == null){
            $idprodutocategoria = NULL;
        }
        $idprodutomarca = $_POST['idprodutomarca'];
        if($idprodutomarca == null){
            $idprodutomarca = NULL;
        }
        $modelo = $_POST['modelo'];
        $codigoreduzido = $_POST['codigoreduzido'];

        
        $custocompra = str_replace('.', '', $_POST['custocompra']);
        $custocompra = str_replace(',','.', $custocompra);
        
        if($custocompra == 0){
            $custocompra ='0';
        }
        

        $precovista = str_replace('.', '', $_POST['precovista']);
        $precovista = str_replace(',', '.', $precovista);

        if(isset( $_POST['precoprazo'])){
            $precoprazo = str_replace('.', '', $_POST['precoprazo']);
            $precoprazo = str_replace(',', '.', $precoprazo);

            if($precoprazo == 0){
                $precoprazo = '0';
            }
        }else{
            $precoprazo=0;
        }
        

        if(isset($_POST['precoatacado'])){
            $precoatacado = str_replace('.', '', $_POST['precoatacado']);
            $precoatacado = str_replace(',', '.', $precoatacado);
            if($precoatacado == 0){
                $precoatacado = '0';
            }
        }else{
            $precoatacado = 0;
        }
       

        if($custocompra != 0){
            $margemlucro = number_format((((($custocompra - $precovista) / $custocompra) * 100) * -1), 2, '.', '');
        }else{
            $margemlucro = 0;
        }
        
        $idpessoafornecedor = $_POST['idpessoafornecedor'];
        if($idpessoafornecedor == null){
            $idpessoafornecedor = NULL;
        }

        $estminimo = $_POST['estminimo'];
        $estmaximo = $_POST['estmaximo'];
        $lancestoque = $_POST['lancestoque'];
        $estante = $_POST['estante'];

        if(isset($_POST['nomeGrade'])){
            $nomeGrade = $_POST['nomeGrade'];
        }else{
            $nomeGrade = NULL;
        }
        if(isset($_POST['grades'])){
            $grades = explode(',', $_POST['grades']);
        }else{
            $grades = NULL;
        }
        
/*
        echo 'id ' . $cod . '<br>';
        echo 'Ativo ' . $pdAtivo . '<br>';
        echo 'Conta Estoque ' . $pdContaEstoque . '<br>';
        echo 'Habilitar PDV '. $habilitapdv . '<br>';
        echo 'Descrição ' . $descricao . '<br>';
        echo 'Código de Barra ' . $codigobarra. '<br>';
        echo 'Unidade de medida ' . $idunidademedida . '<br>';
        echo 'Estoque quantidade de caixa '. $estoquequantidadecaixa .'<br>';
        echo 'Produto Categoria ' . $idprodutocategoria . '<br>';
        echo 'Produto Marca '. $idprodutomarca . '<br>';
        echo 'Modelo ' . $modelo .'<br>';
        echo 'Modelo ' . $codigoreduzido . '<br>';
        echo 'Custo de compra '. $custocompra .'<br>';
        echo 'Preco Vista ' .$precovista . '<br>';
        echo 'Preco Prazo ' . $precoprazo . '<br>';
        echo 'Preco atacado ' . $precoatacado . '<br>';
        echo 'Margem de Lucro ' . $margemlucro . '<br>';
        echo 'Fornecedor ' . $idpessoafornecedor . '<br>';
        echo 'Estoque Minimo '. $estminimo . '<br>';
        echo 'Estoque Maximo ' . $estmaximo.'<br>';
        echo 'Lançar estoque '. $lancestoque . '<br>';
        echo 'Estante ' . $estante . '<br>';
        echo 'Nome Grade '. $nomeGrade . '<br>';
        print_r($grades);

        */

        
        
        if ($cod == 0) {

            if($nomeGrade != NULL){

                $sqlGrade = "INSERT INTO grade (matriz, empresa, descricao, deletado) VALUES (?, ?, ?, ?);";
                $stmtGrade = $pdo->prepare($sqlGrade);
                $stmtGrade->execute([$_SESSION['empresa']['matriz'],$_SESSION['empresa']['id'],strtoupper($nomeGrade), 'N']);
                
                $sqlGradeId = "SELECT max(id) as id FROM grade where empresa = :empresa";
                $stmtGradeId = $pdo->prepare($sqlGradeId);
                $stmtGradeId->bindValue(':empresa', $_SESSION['empresa']['id']);
                $stmtGradeId->execute();
                $gradeId =  $stmtGradeId->fetch(PDO::FETCH_ASSOC);
                
                foreach($grades as $grades){
                    
                    $sql = "INSERT INTO produto (idmatriz, idempresa, ativo, habilitacontroleestoque, habilitapdv, descricao, codigobarra, 
                    idunidademedida, estoquequantidadecaixa, idprodutocategoria, idprodutomarca, modelo, codigoreduzido, custocompra, 
                    precovista, precoatacado, precoprazo, margemlucro, idpessoafornecedor, created_at, updated_at, deletado, idgrade) 
                     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                     $stmt= $pdo->prepare($sql);
                     $stmt->execute([$_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'], $pdAtivo, $pdContaEstoque, $habilitapdv,
                                    strtoupper($descricao), $codigobarra, $idunidademedida, $estoquequantidadecaixa, $idprodutocategoria,
                                    $idprodutomarca, $modelo, str_pad($codigoreduzido, 6, '0', STR_PAD_LEFT), $custocompra, $precovista, $precoatacado, $precoprazo, 
                                    $margemlucro, $idpessoafornecedor, $data, $data, 'N',  $gradeId['id']]);
                    $row = $stmt->rowCount();
                    $erro = $stmt->errorInfo();

                    $sqlProdutoId = "SELECT max(id) as id FROM produto where idempresa = :empresa and codigoreduzido = :codigo;";
                    $stmtProdutoId = $pdo->prepare($sqlProdutoId);
                    $stmtProdutoId->bindValue(':empresa', $_SESSION['empresa']['id']);
                    $stmtProdutoId->bindValue(':codigo', str_pad($codigoreduzido, 6, '0', STR_PAD_LEFT));
                    $stmtProdutoId->execute();
                    $produtoId =  $stmtProdutoId->fetch(PDO::FETCH_ASSOC);

                    if($lancestoque != NULL){
                        $sqlEstoque = "INSERT INTO estoque (idmatriz, idempresa, idproduto, estminimo, estmaximo, estatual, estestant, 
                        created_at, idgrade) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);
                        ";
                        $stmtEstoque= $pdo->prepare($sqlEstoque );
                        $stmtEstoque->execute([$_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'],$produtoId['id'], $estminimo, $estmaximo, $lancestoque, $estante ,
                        $data, $gradeId['id']]);

                        $stmt2 = $pdo->prepare("SELECT max(id) as id FROM estoque where idempresa = :empresa and idproduto = :produto;");
                        $stmt2->bindValue(":empresa", $_SESSION['empresa']['id']);
                        $stmt2->bindValue(":produto", $produtoId['id']);
                        $stmt2->execute();
                        $row_linha = $stmt2->fetch(PDO::FETCH_ASSOC);

                        $sql_linha = "UPDATE produto SET idestoque = :estoque WHERE (id = :id);";
                        $stmt3 = $pdo->prepare($sql_linha);
                        $stmt3->bindValue(":estoque", $row_linha['id']);
                        $stmt3->bindValue(":id", $produtoId['id']);
                        $stmt3->execute();
                        
                    }

                     $sqlGradeProduto = "INSERT INTO grade_produto (idgrade, idproduto, descricao, deletado) 
                     VALUES (?, ?, ?, ?);";
                    $stmtGradeProduto = $pdo->prepare($sqlGradeProduto);
                    $stmtGradeProduto->execute([$gradeId['id'], $produtoId['id'], strtoupper($grades), 'N']);

                    
                    $codigoreduzido ++;
                }

                if ($row > 0) {
                    $_SESSION['titulo'] = 'OK';
                    $_SESSION['MsgRetorno'] = 'Produto '.$descricao .', salvo com sucesso';
                    $_SESSION['tipo'] = 'success';
                    echo "<script>location.href='".$url."/produtos?r=true'</script>";
                }else{
                    $_SESSION['titulo'] = 'ERRO';
                    $_SESSION['MsgRetorno'] = 'Produto '.$descricao .', não pode ser salvo';
                    $_SESSION['tipo'] = 'error';
                    echo "<script>location.href='".$url."/produtos?r=true'</script>";
                }
    
            }else{

                $sql = "INSERT INTO produto (idmatriz, idempresa, ativo, habilitacontroleestoque, habilitapdv, descricao, codigobarra, 
                idunidademedida, estoquequantidadecaixa, idprodutocategoria, idprodutomarca, modelo, codigoreduzido, custocompra, 
                precovista, precoatacado, precoprazo, margemlucro, idpessoafornecedor, created_at, updated_at, deletado) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $stmt= $pdo->prepare($sql);
                $stmt->execute([$_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'], $pdAtivo, $pdContaEstoque, $habilitapdv,
                                strtoupper($descricao), $codigobarra, $idunidademedida, $estoquequantidadecaixa, $idprodutocategoria,
                                $idprodutomarca, $modelo, $codigoreduzido, $custocompra, $precovista, $precoatacado, $precoprazo, 
                                $margemlucro, $idpessoafornecedor, $data, $data, 'N']);
                $row = $stmt->rowCount();
                $erro = $stmt->errorInfo();


                $sqlProdutoId = "SELECT max(id) as id FROM produto where idempresa = :empresa and codigoreduzido = :codigo;";
                $stmtProdutoId = $pdo->prepare($sqlProdutoId);
                $stmtProdutoId->bindValue(':empresa', $_SESSION['empresa']['id']);
                $stmtProdutoId->bindValue(':codigo', str_pad($codigoreduzido, 6, '0', STR_PAD_LEFT));
                $stmtProdutoId->execute();
                $produtoId =  $stmtProdutoId->fetch(PDO::FETCH_ASSOC);

                if($lancestoque != NULL){
                    $sqlEstoque = "INSERT INTO estoque (idmatriz, idempresa, idproduto, estminimo, estmaximo, estatual, estestant, 
                    created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?);
                    ";
                    $stmtEstoque= $pdo->prepare($sqlEstoque );
                    $stmtEstoque->execute([$_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'],$produtoId['id'], $estminimo, $estmaximo, $lancestoque, $estante ,
                    $data]);

                    $stmt2 = $pdo->prepare("SELECT max(id) as id FROM estoque where idempresa = :empresa and idproduto = :produto;");
                    $stmt2->bindValue(":empresa", $_SESSION['empresa']['id']);
                    $stmt2->bindValue(":produto", $produtoId['id']);
                    $stmt2->execute();
                    $row_linha = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $sql_linha = "UPDATE produto SET idestoque = :estoque WHERE (id = :id);";
                    $stmt3 = $pdo->prepare($sql_linha);
                    $stmt3->bindValue(":estoque", $row_linha['id']);
                    $stmt3->bindValue(":id", $produtoId['id']);
                    $stmt3->execute();
                    
                }

                if ($row > 0) {
                    $_SESSION['titulo'] = 'OK';
                    $_SESSION['MsgRetorno'] = 'Produto '.$descricao .', salvo com sucesso';
                    $_SESSION['tipo'] = 'success';
                    echo "<script>location.href='".$url."/produtos?r=true'</script>";
                }else{
                    $_SESSION['titulo'] = 'ERRO';
                    $_SESSION['MsgRetorno'] = 'Produto '.$descricao .', não pode ser salvo';
                    $_SESSION['tipo'] = 'error';
                    echo "<script>location.href='".$url."/produtos?r=true'</script>";
                }

            }

        }else if ($cod != 0){

            $sqlProdutoId = "SELECT * FROM produto where idmatriz = :matriz and id = :id;";
            $stmtProdutoId = $pdo->prepare($sqlProdutoId);
            $stmtProdutoId->bindValue(':matriz', $_SESSION['empresa']['matriz']);
            $stmtProdutoId->bindValue(':id', $cod);
            $stmtProdutoId->execute();
            $produto=  $stmtProdutoId->fetch(PDO::FETCH_ASSOC);

            $stmtEstoque = $pdo->prepare("SELECT * FROM estoque where idempresa = :empresa and idproduto = :produto;");
            $stmtEstoque->bindValue(":empresa", $_SESSION['empresa']['id']);
            $stmtEstoque->bindValue(":produto", $cod);
            $stmtEstoque->execute();
            $row_linha = $stmtEstoque->fetch(PDO::FETCH_ASSOC);

            if($produto['idgrade'] != null){

                $stmtGrade = $pdo->prepare("SELECT * FROM grade_produto where idproduto = :produto;");
                $stmtGrade->bindValue(":produto", $cod);
                $stmtGrade->execute();
                $rowGrade = $stmtGrade->fetch(PDO::FETCH_ASSOC);

            }  

           $sql = "UPDATE produto set idunidademedida = :idunidademedida, descricao = :descricao, codigobarra = :codigobarra, 
            estoquequantidadecaixa = :estoquequantidadecaixa, ativo =:ativo, idprodutocategoria = :idprodutocategoria, idprodutomarca = :idprodutomarca, 
            modelo = :modelo, codigoreduzido = :codigoreduzido, precovista = :precovista, precoatacado = :precoatacado, 
            precoprazo = :precoprazo, margemlucro = :margemlucro, idpessoafornecedor = :idpessoafornecedor, habilitapdv = :habilitapdv, 
            habilitacontroleestoque = :habilitacontroleestoque, updated_at= :updated_at where id = :id";

            $stmt= $pdo->prepare($sql);
             $stmt->bindValue(':idunidademedida', $idunidademedida);
             $stmt->bindValue(':descricao', strtoupper($descricao));
             $stmt->bindValue(':codigobarra', $codigobarra);
             $stmt->bindValue(':estoquequantidadecaixa', $estoquequantidadecaixa);
             $stmt->bindValue(':ativo', $pdAtivo);
             $stmt->bindValue(':idprodutocategoria', $idprodutocategoria);
             $stmt->bindValue(':idprodutomarca', $idprodutomarca);
             $stmt->bindValue(':modelo', $modelo);
             $stmt->bindValue(':codigoreduzido', $codigoreduzido);
             $stmt->bindValue(':precovista', $precovista); 
             $stmt->bindValue(':precoatacado', $precoatacado); 
             $stmt->bindValue(':precoprazo', $precoprazo);
             $stmt->bindValue(':margemlucro', $margemlucro);
             $stmt->bindValue(':idpessoafornecedor', $idpessoafornecedor);
             $stmt->bindValue(':habilitapdv', $habilitapdv);
             $stmt->bindValue(':habilitacontroleestoque',$pdContaEstoque);
             $stmt->bindValue(':updated_at', $data);
             $stmt->bindValue(':id', $cod);
             $stmt->execute();

            $row = $stmt->rowCount();
            $erro = $stmt->errorInfo();
            
            if($nomeGrade != NULL){
            
                $sqlGrade = "UPDATE grade_produto set descricao = :descricao where id = :id";
                $grade = $pdo->prepare($sqlGrade);
                $grade->bindValue(':descricao', strtoupper($grades[0]));
                $grade->bindValue(':id', $rowGrade['id']);
                $grade->execute();

            }
                
            
            if ($row > 0) {
                $_SESSION['titulo'] = 'OK';
                $_SESSION['MsgRetorno'] = 'Produto '.$descricao .', alterado com sucesso';
                $_SESSION['tipo'] = 'success';
                echo "<script>location.href='".$url."/produtos?r=true'</script>";
            }else{
                $_SESSION['titulo'] = 'ERRO';
                $_SESSION['MsgRetorno'] = 'Produto '.$descricao .', não pode ser alterado';
                $_SESSION['tipo'] = 'error';
                echo "<script>location.href='".$url."/produtos?r=true'</script>";
            }

        }
    }else if($del == 'remove'){
        $cod = $_POST['cod'];
        $descricao = utf8_decode(strtoupper(strtolower($_POST['descricao'])));

        $sql = "UPDATE produto SET deletado = 'S' where id = :id";
        $stmt= $pdo->prepare($sql);
        $stmt->bindValue(":id", $cod);
        $stmt->execute();

        $row = $stmt->rowCount();

       if ($row >= 0) {
            $_SESSION['titulo'] = 'OK';
            $_SESSION['MsgRetorno'] = 'Produto '.$descricao .', deletado com sucesso';
            $_SESSION['tipo'] = 'success';
            echo "<script>location.href='".$url."/produtos?r=true'</script>";
        }else{
            $_SESSION['titulo'] = 'ERRO';
            $_SESSION['MsgRetorno'] = 'Produto '.$descricao .', não pode ser deletado';
            $_SESSION['tipo'] = 'error';
            echo "<script>location.href='".$url."/produtos?r=true'</script>";
        }
    }