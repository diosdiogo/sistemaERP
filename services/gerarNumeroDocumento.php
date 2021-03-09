<?php

include_once('./config.php');
include_once("../conn.php");

$pont = array("/" , "(", ")", "-","R","$",",");

function getNumeroDocumeto($pdo, $matriz){

    $sql = "SELECT max(documento) as documento FROM numerodocumento where idmatriz = :idmatriz;";
    $smtp = $pdo->prepare($sql);
    $smtp->bindValue(":idmatriz", $matriz);
    $smtp->execute();
    $rowDocumento = $smtp->fetch(PDO::FETCH_ASSOC);

    return $rowDocumento['documento'];

}

function setNumeroDocumento($pdo, $matriz){
    $data = date('Y-m-d H:i:s');
    $documto = getNumeroDocumeto($pdo, $matriz);
    $sql = "INSERT INTO numerodocumento (idmatriz, documento, created_at) VALUES (?, ?, ?);";
    $smtp = $pdo->prepare($sql);
    $smtp->execute([$matriz, $documto+1, $data]);

    $documto = getNumeroDocumeto($pdo, $matriz);

    return $documto;

}