<?php
    
    include_once('./config.php');
    include_once("../conn.php");

    date_default_timezone_set('America/Bahia');

    $data = date('Y-m-d H:i:s');

    $method = $_SERVER['REQUEST_METHOD'];

    $dados = $_REQUEST;

    if($method == 'GET'){
        $sql ="";
    }