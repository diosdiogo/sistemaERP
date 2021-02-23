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
   
    // echo '<pre>';
    // print_r($dados);
    // echo '</pre>';

    if(isset($dados['cliente'])){

        if($dados['cliente'] == null){
                $cliente = NULL;
        }else{

            $cliente =$pdo->prepare("SELECT * FROM pessoa where id = :id;");
            $cliente->bindValue(":id", $dados['cliente'] );
            $cliente->execute();
            $rowCliente = $cliente->fetchAll(PDO::FETCH_ASSOC);

            $cliente = $rowCliente[0]['id'];
            // echo '<pre>';
            // print_r($rowCliente);
            // echo '</pre>';
        
        }
    }
    

    if(isset($_GET['salvar'])){

        if($dados['idVenda'] == 0){

            $sqlSalvarVenda = "INSERT INTO venda (idmatriz, idempresa, doc, numeroorcamento, orcamento, descricao, datavenda, idpessoa, valortotal, created_at, faturado, canc) 
                                                        VALUES (?, ?, ?, ?, 1, 'VENDA DE MERCADORIA', ?, ?, ?, ?, 'N', 'N');";
            $stmtSalvarVenda= $pdo->prepare($sqlSalvarVenda);
            $stmtSalvarVenda->execute([$_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'], $doc, $cod, $data, $cliente , $dados['valorTotal'], $data]);

            $error = $stmtSalvarVenda->errorInfo();

            $buscarVenda =$pdo->prepare("SELECT * FROM venda where idempresa = :empresa and doc = :doc;");
            $buscarVenda->bindValue(":empresa", $_SESSION['empresa']['id']);
            $buscarVenda->bindValue(":doc", $doc);

            $buscarVenda->execute();
            $rowBuscarVenda = $buscarVenda->fetchAll(PDO::FETCH_ASSOC);

            //  echo '<pre>';
            // print_r($rowBuscarVenda);
            // echo '</pre>';

        }else{
            
            $sqlSalvarVenda = "UPDATE venda SET datavenda = :dataVenda, valortotal = :valor, updated_at = :dataMotifica WHERE (id = :id);
            ";
            $stmtSalvarVenda= $pdo->prepare($sqlSalvarVenda);
            $stmtSalvarVenda -> bindValue(':dataVenda', $data);
            $stmtSalvarVenda -> bindValue(':valor', $dados['valorTotal']);
            $stmtSalvarVenda -> bindValue(':dataMotifica', $data);
            $stmtSalvarVenda -> bindValue(':dataMotifica', $data);
            $stmtSalvarVenda -> bindValue(':id', $dados['id']);
            $stmtSalvarVenda->execute();

            $error = $stmtSalvarVenda->errorInfo();

            $apagarProduto =$pdo->prepare("DELETE FROM vendaitem where idvenda = :id;");
            $apagarProduto->bindValue(":id", $dados['idVenda']);

            $buscarapagarProdutoVenda->execute();

            //  echo '<pre>';
            // print_r($rowBuscarVenda);
            // echo '</pre>';
        }
            

            $sqlItensVenda = "INSERT INTO vendaitem (ordem, idmatriz, idempresa, idproduto, idvenda, descontomoeda, valorunitario, valortotal, quantidade, created_at, 
                                    descontoporcentagem)  VALUES ";
            
            $itensDaVenda = array();
            $i = 1;
            foreach($dados['vendas'] as $itensVEndas){
                $desconto = ($itensVEndas['valorProduto'] * $itensVEndas['qts']) - $itensVEndas['total'];
                
                $sqlItensVenda .= '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?),';

                array_push($itensDaVenda,
                    $i,
                    $_SESSION['empresa']['matriz'],
                    $_SESSION['empresa']['id'],
                    $itensVEndas['idProd'],
                    $rowBuscarVenda[0]['id'],
                    $desconto,
                    $itensVEndas['valorProduto'],
                    $itensVEndas['total'],
                    $itensVEndas['qts'],
                    $data,
                    $itensVEndas['desc']

                );

                $i++;
            }

            // echo '<pre>';
            // print_r($itensDaVenda);
            // echo '</pre>';

            $sqlItensVenda = trim($sqlItensVenda, ','); //remover a última vírgula

            // echo $sqlItensVenda;

            $smtpItensVendas = $pdo->prepare($sqlItensVenda);
            $smtpItensVendas->execute($itensDaVenda);

            $row = $smtpItensVendas->rowCount();
            $erro = $smtpItensVendas->errorInfo();

            // print_r($erro);

            $retorno = array(
                'return' => 'SUCCESS',
                'doc' => $doc, 
                'ocorrencia ' => $cod,
            );

            echo json_encode($retorno);

            
    }

    if(isset($dados['buscarVenda'])){

        $buscarVenda =$pdo->prepare("SELECT * FROM venda where idempresa = :empresa and faturado = 'N' and canc = 'N';");
        $buscarVenda->bindValue(":empresa", $_SESSION['empresa']['id']);

        $buscarVenda->execute();
        $rowBuscarVenda = $buscarVenda->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($rowBuscarVenda);
    }

    if(isset($_GET['selectVenda'])){
        
        $buscarItem =$pdo->prepare("SELECT vendaitem.id, (SELECT idpessoa FROM venda where id=vendaitem.idvenda) as idpessoa, vendaitem.idproduto, produto.descricao, grade_produto.descricao as descricaograde, 
        produto.id as idproduto, produto.precovista, produto.precoprazo, vendaitem.valorunitario, vendaitem.valortotal, vendaitem.quantidade, 
        vendaitem.descontoporcentagem 
        FROM vendaitem 
        left join produto on (vendaitem.idproduto = produto.id) 
        left join grade_produto on ( produto.id = grade_produto.idproduto)
        where idvenda = :id;");
        $buscarItem->bindValue(":id", $dados['id']);

        $buscarItem->execute();
        $rowBuscarVendaItem = $buscarItem->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($rowBuscarVendaItem);
    }
    
