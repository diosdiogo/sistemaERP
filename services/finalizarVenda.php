<?php
    
    include_once('./config.php');
    include_once("../conn.php");
    include_once("ip.php");
    include_once('./gerarNumeroDocumento.php');

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
    // echo $dados['cliente'][0]['id'];
    $nomeCliente = explode('-', $dados['cliente'][0]['nomefantasia']);
    $nomeCliente = $nomeCliente[1];
    echo $nomeCliente;

    if($dados['idVenda'] !== 0){

        //modifica venda como finalizada caso exista
        $sql= "SELECT * FROM venda where id = :id";
        $venda_salva =  $pdo->prepare($sql);
        $venda_salva->bindValue(':id', $dados['idVenda']);
        $venda_salva->execute();
    
        $rowVendas = $venda_salva->fetch(PDO::FETCH_ASSOC);

        $troco = $dados['totalPago'] - $dados['totalPagar'];

        $sql = "UPDATE venda SET faturado = 'S', valortroco = :valortroco, valortotal = :valortotal, updated_at = :updated_at WHERE id = :id";
        $stmt= $pdo->prepare($sql);
        $stmt->bindValue(":id", $dados['idVenda']);
        $stmt->bindValue(":valortroco", $troco);
        $stmt->bindValue(":valortotal", $dados['totalPagar']);
        $stmt->bindValue(":updated_at", $data);
        $stmt->execute();

        $sqlItensVendas = "DELETE FROM vendaitem WHERE idvenda = :idvenda;";
        $stmtItensVendas = $pdo->prepare($sqlItensVendas);
        $stmtItensVendas->bindValue(":idvenda",$dados['idVenda']);
        $stmtItensVendas->execute();

    }else{

        //Cria venda
        $documento = setNumeroDocumento($pdo, $_SESSION['empresa']['matriz']);

        $sqlSalvarVenda = "INSERT INTO venda (idmatriz, idempresa, doc, numeroorcamento, orcamento, descricao, datavenda, idpessoa, valortotal, created_at, faturado, canc) 
                                                        VALUES (?, ?, ?, ?, 1, 'VENDA DE MERCADORIA', ?, ?, ?, ?, 'S', 'N');";

        $stmtSalvarVenda= $pdo->prepare($sqlSalvarVenda);
        $stmtSalvarVenda->execute([$_SESSION['empresa']['matriz'], $_SESSION['empresa']['id'], $documento, $cod, $data, $dados['cliente'][0]['id'] , $dados['totalPagar'], $data]);

        
        $sql= "SELECT * FROM venda where doc = :doc";
        $venda_salva =  $pdo->prepare($sql);
        $venda_salva->bindValue(':doc', $documento);
        $venda_salva->execute();
    
        $rowVendas = $venda_salva->fetch(PDO::FETCH_ASSOC);

    }
    
    // salva novos itens de venda
    $itensDaVenda = array();
    $i = 1;

    $sqlItensVenda = "INSERT INTO vendaitem (ordem, idmatriz, idempresa, idproduto, idvenda, descontomoeda, valorunitario, valortotal, quantidade, created_at, 
        descontoporcentagem, updated_at)  VALUES ";

    foreach($dados['vendaItens'] as $itensVEndas){
        $desconto = ($itensVEndas['valorProduto'] * $itensVEndas['qts']) - $itensVEndas['total'];
        $sqlItensVenda .= '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?),';

        array_push($itensDaVenda,
            $i,
            $_SESSION['empresa']['matriz'],
            $_SESSION['empresa']['id'],
            $itensVEndas['idProd'],
            $rowVendas['id'],
            $desconto,
            $itensVEndas['valorProduto'],
            $itensVEndas['total'],
            $itensVEndas['qts'],
            $rowVendas['created_at'],
            $itensVEndas['desc'],
            $data
        );

        $i++;
    }
    
    $sqlItensVenda = trim($sqlItensVenda, ',');
    
    $smtpItensVendas = $pdo->prepare($sqlItensVenda);
    $smtpItensVendas->execute($itensDaVenda); 

    // lançamento pagamento

    $lancamentoPagamento = array();
    
    $sqlLançamentoCaixa = "INSERT INTO movimentacaocaixaaberto (idcaixa, idmatriz, idempresa, doc, orcamento, numeroorcamento, 
                                        emissao, idhistorico, formapagamento, creditodebito, descricao, created_at, valor) VALUES ";

    foreach($dados['formaPagamento'] as $pagamento){

        $historico = 0 ;

        if($pagamento['fotmaPagamentoSG'] == 'CC' or $pagamento['fotmaPagamentoSG'] == 'CH' or $pagamento['fotmaPagamentoSG'] == 'PC'){
            $historico = 501;


        }
        else if($pagamento['fotmaPagamentoSG'] == 'AV' or $pagamento['fotmaPagamentoSG'] == 'CD'){
            $historico = 500;
        }

        if($rowVendas['orcamento'] == 1){
            $descricao = 'VENDA DE MERCADORIA';
        }else if($rowVendas['orcamento'] == 2){
            $descricao = 'FECHAMENTO DE ORDEM DE SERVIÇO';
        }

        $sqlLançamentoCaixa .= "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?),";
        

        array_push($lancamentoPagamento,
            $dados['caixa'][0]['id'],
            $_SESSION['empresa']['matriz'],
            $_SESSION['empresa']['id'],
            $rowVendas['doc'],
            $rowVendas['orcamento'],
            $rowVendas['numeroorcamento'],
            $data,
            $historico,
            $pagamento['id'],
            'C',
            $descricao,
            $data,
            $rowVendas['valortotal'],
        );

        //lançar conta pagar
        if( $pagamento['fotmaPagamentoSG'] == 'PC'){

            $sqlLançamentoContaPagar ="INSERT INTO contas (idmatriz, idempresa, numerodocumento, idcliente, cliente, emissao, vencto, valor, parc, recebepagar, created_at) 
                                                        VALUES ";
            $lancamentoContaPagar = array();

            for($i=1; $i <= $pagamento['parcela']; $i++){
                $sqlLançamentoContaPagar .= '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?),';

                $dataVencto = date('Y-m-d', strtotime("+".$i." month", strtotime($data)));
                $parcelaValor = $pagamento['valor'] / $pagamento['parcela'];

                array_push($lancamentoContaPagar,
                                $_SESSION['empresa']['matriz'], 
                                $_SESSION['empresa']['id'], 
                                $rowVendas['doc'], 
                                $dados['cliente'][0]['id'],
                                $nomeCliente,
                                $data,
                                $dataVencto,
                                $parcelaValor,
                                $i.'/'.$pagamento['parcela'],
                                'R',
                                $data
                            );
            }

            $sqlLançamentoContaPagar = trim($sqlLançamentoContaPagar, ',');

            $smtpLancarContaPagar = $pdo->prepare($sqlLançamentoContaPagar);
            $smtpLancarContaPagar->execute($lancamentoContaPagar);     
            $erro = $smtpLancarContaPagar->errorInfo();

            $lancamentoContaPagar = array();
            $sqlLançamentoContaPagar = null;
           
        }
    }
    $sqlLançamentoCaixa = trim($sqlLançamentoCaixa, ',');

    $smtpItensVendas = $pdo->prepare($sqlLançamentoCaixa);
    $smtpItensVendas->execute($lancamentoPagamento); 
    $erro = $smtpItensVendas->errorInfo();

    $return = array(
        'documento' => $rowVendas['doc'],
        'id'        => $rowVendas['id'],
    );

    echo json_encode($return);