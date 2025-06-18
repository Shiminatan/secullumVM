<?php

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName =   'formulariovms';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//parametro utiliazado apenas para validar se a conexao esta sendo estabelecida
//if($conexao ->connect_errno)
 //{
 //  echo "Erro";
//}
//else{
    echo "Conexao realizada com sucesso";
//}

?>