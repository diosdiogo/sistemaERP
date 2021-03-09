<?php

include_once('./config.php');
include_once("../conn.php");

if($route[3] == 'log'){
    include_once ('log.php');
}
if($route[3] == 'categoria'){
    include_once ('categoria.php');
}
if(substr($route[3], 0, strpos($route[3], '?')) == 'categoria'){
    include_once ('categoria.php');
}
if($route[3] == 'subcategoria'){
    include_once ('subcategoria.php');
}
if(substr($route[3], 0, strpos($route[3], '?')) == 'subcategoria'){
    include_once ('subcategoria.php');
}

if($route[3] == 'marca'){
    include_once ('marca.php');
}
if(substr($route[3], 0, strpos($route[3], '?')) == 'marca'){
    include_once ('marca.php');
}

if($route[3] == 'caixa'){
    include_once ('caixa.php');
}
if(substr($route[3], 0, strpos($route[3], '?')) == 'caixa'){
    include_once ('caixa.php');
}

if($route[3] == 'produtos'){
    include_once ('produtos.php');
}
if(substr($route[3], 0, strpos($route[3], '?')) == 'produtos'){
    include_once ('produtos.php');
}

if($route[3] == 'vendas'){
    include_once ('vendas.php');
}
if(substr($route[3], 0, strpos($route[3], '?')) == 'vendas'){
    include_once ('vendas.php');
}

if($route[3] == 'formaPagamento'){
    include_once ('formaPagamento.php');
}
if(substr($route[3], 0, strpos($route[3], '?')) == 'formaPagamento'){
    include_once ('formaPagamento.php');
}

if($route[3] == 'finalizarVenda'){
    include_once ('finalizarVenda.php');
}
if(substr($route[3], 0, strpos($route[3], '?')) == 'finalizarVenda'){
    include_once ('finalizarVenda.php');
}