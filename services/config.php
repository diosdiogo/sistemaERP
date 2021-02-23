<?php

    $producao = false;

    if($producao == false){
        $url = '/sistemaErp';
    }
    else if($producao == true){

    }
    

    $urlBase = $_SERVER['REQUEST_URI'];
    session_name('erp');
    session_start();
    
    if($producao == false){
        $route = explode('/',$urlBase);
    }
    else if($producao == true){

    }
    
    //var_dump($route);