<?php

//header("Content-Type: application/json");

include_once('./config.php');
include_once("../conn.php");

$method = $_SERVER['REQUEST_METHOD'];

$body = json_decode(file_get_contents("php://input"), true);

if($body == null){
  $body = $_REQUEST;
}


if($method = 'POST'){
  $buscaProduto = $body['produto'];
  
  if(isset($body['busca'])){
    
    try{

      if(is_numeric($buscaProduto)){
          
        $sql = 'SELECT produto.id, produto.idmatriz, produto.idempresa, produto.descricao, grade_produto.descricao as descricaograde, 
        produto.codigoreduzido, produto.ativo, produto.custocompra,  produto.precovista, produto.precoatacado, produto.precoprazo, 
        produto.idestoque, produto.contabilizaestoque FROM produto left join grade_produto on ( produto.id = grade_produto.idproduto) 
        where produto.idmatriz = :matriz and habilitapdv = 1 and produto.deletado = "N" and codigoreduzido like :busca;';

      }else{
        $sql = 'SELECT produto.id, produto.idmatriz, produto.idempresa, produto.descricao, grade_produto.descricao as descricaograde, 
        produto.codigoreduzido, produto.ativo, produto.custocompra,  produto.precovista, produto.precoatacado, produto.precoprazo, 
        produto.idestoque, produto.contabilizaestoque FROM produto left join grade_produto on ( produto.id = grade_produto.idproduto) 
        where produto.idmatriz = :matriz and habilitapdv = 1 and produto.deletado = "N" and produto.descricao like :busca;';
      }

      $likeProduto = "%".$buscaProduto."%";
      $produtos =$pdo->prepare($sql);
      $produtos->bindValue(":matriz", $_SESSION['empresa']['matriz']);
      $produtos->bindValue(":busca", $likeProduto);
      $produtos->execute();
      $resultProduto = $produtos->fetchAll(PDO::FETCH_ASSOC);
     
      echo json_encode($resultProduto);

    }catch(PDOException $e){                
      echo "Erro: " . $e->getMessage();    

    }
    

  }

  if(isset($body['select'])){
   
    $produtoB = explode('-',trim($body['produto']));
    
   

    $sql = 'SELECT produto.id, produto.idmatriz, produto.idempresa, produto.descricao, grade_produto.descricao as descricaograde, 
        produto.codigoreduzido, produto.ativo, produto.custocompra,  produto.precovista, produto.precoatacado, produto.precoprazo, 
        produto.idestoque, produto.contabilizaestoque FROM produto left join grade_produto on ( produto.id = grade_produto.idproduto) 
        where produto.idmatriz = :matriz and habilitapdv = 1 and produto.deletado = "N" and produto.id = :id;';

    $produtos =$pdo->prepare($sql);
    $produtos->bindValue(":matriz", $_SESSION['empresa']['matriz']);
    $produtos->bindValue(":id", $body['idProd']);
    $produtos->execute();
    $row = $produtos->fetchAll(PDO::FETCH_ASSOC);

    $produto = array();

    foreach($row as $row){
      array_push($produto, array(
        'id' => $row['id'],
        'idmatriz' => $row['idmatriz'],
        'idempresa' => $row['idempresa'],
        'descricao' => $row['descricao'],
        'descricaograde' => $row['descricaograde'],
        'codigoreduzido' => $row['codigoreduzido'],
        'ativo' => $row['ativo'],
        'custocompra' => $row['custocompra'],
        'precovista' => $row['precovista'],
        'precoatacado' =>$row['precoatacado'],
        'precoprazo' => $row['precoprazo'],
        'idestoque' => $row['idestoque'],
        'qts'=> estoque($pdo , $row['id']),
        'contabilizaestoque' => $row['contabilizaestoque'],
      ));
      
    }

      
      echo json_encode($produto);
      


  }
}
else if($method = 'GET'){
  $buscaProduto = $body['produto'];
  
  if($body['busca'] == 'S'){
    
    try{

      if(is_numeric($buscaProduto)){
        
        $sql = 'SELECT produto.id, produto.idmatriz, produto.idempresa, produto.descricao, grade_produto.descricao as descricaograde, 
        produto.codigoreduzido, produto.ativo, produto.custocompra,  produto.precovista, produto.precoatacado, produto.precoprazo, 
        produto.idestoque, produto.contabilizaestoque FROM produto left join grade_produto on ( produto.id = grade_produto.idproduto) 
        where idmatriz = :matriz and and habilitapdv = 1 and produto.deletado = "N" and codigoreduzido like :busca;';

      }else{
        $sql = 'SELECT SELECT produto.id, produto.idmatriz, produto.idempresa, produto.descricao, grade_produto.descricao as descricaograde, 
        produto.codigoreduzido, produto.ativo, produto.custocompra,  produto.precovista, produto.precoatacado, produto.precoprazo, 
        produto.idestoque, produto.contabilizaestoque FROM produto left join grade_produto on ( produto.id = grade_produto.idproduto) 
        where idmatriz = :matriz and and habilitapdv = 1 and produto.deletado = "N" and descricao like :busca;';
      }

      $likeProduto = "%".$buscaProduto."%";
      $produtos =$pdo->prepare($sql);
      $produtos->bindValue(":matriz", $_SESSION['empresa']['matriz']);
      $produtos->bindValue(":busca", $likeProduto);
      $produtos->execute();
      $resultProduto = $produtos->fetchAll(PDO::FETCH_ASSOC);
      
      echo json_encode($resultProduto);

    }catch(PDOException $e){                
      echo "Erro: " . $e->getMessage();    

    }

  }
}

  function estoque($pdo ,$id){

    $sql = "SELECT id as idest, sum(estatual + estestant) as estatual FROM estoque where idempresa = :empresa and idproduto = :produto;";

    $estoque =$pdo->prepare($sql);
    $estoque->bindValue(":empresa", $_SESSION['empresa']['id']);
    $estoque->bindValue(":produto", $id);
    $estoque->execute();
    $resultEstoque = $estoque->fetch(PDO::FETCH_ASSOC);

    return $resultEstoque;

  }