<?php
include_once('config.php');

if(isset($_POST['update']))

{   
    $id = $_POST['id'];
    $revenda = $_POST['revenda'];
    $cliente = $_POST['cliente'];
    $cnpj = $_POST['cnpj'];
    $estado = $_POST['estado'];
    $banco = $_POST['banco'];
    $rep = $_POST['rep'];
    $nserial = $_POST['nserial'];
    $portaria = $_POST['portaria'];
    $sistema = $_POST['sistema'];
    $login_ = $_POST['login_'];
    $senha = $_POST['senha']; 
    $ticket_incl = $_POST['ticket_incl'];
    $ticket_canc = $_POST['ticket_canc'];
    $case_ = $_POST['case_'];
    $data_incl = $_POST['data_incl'];
    $data_canc = $_POST['data_canc'];
    $obs = $_POST['obs'];
    $dados = $_POST['dados'];

    $sqlUpdate = "UPDATE idcloud SET revenda='$revenda', cliente='$cliente' , cnpj='$cnpj', estado='$estado', banco='$banco', rep='$rep', nserial='$nserial', portaria='$portaria', sistema='$sistema', login_='$login_', senha='$senha',ticket_incl='$ticket_incl', ticket_canc='$ticket_canc', case_='$case_',data_incl='$data_incl', data_canc='$data_canc', obs='$obs', dados='$dados'
    WHERE id='$id'";

   $result = $conexao->query($sqlUpdate);


}


header ('Location: idcloud.php');


?>