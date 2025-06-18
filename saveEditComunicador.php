<?php
include_once('config.php');

if(isset($_POST['update']))

{   
    $id = $_POST['id'];
    $revenda = $_POST['revenda'];
    $cnpj = $_POST['cnpj'];
    $cliente = $_POST['cliente'];
    $estado = $_POST['estado'];
    $banco = $_POST['banco'];
    $equip_modelo = $_POST['equip_modelo'];
    $equip_nome = $_POST['equip_nome'];
    $port_servidor = $_POST['port_servidor'];
    $port_agente = $_POST['port_agente'];
    $vm = $_POST['vm'];
    $ip_servidor = $_POST['ip_servidor'];
    //$ticket_incl = $_POST['ticket_incl'];
    $data_incl = $_POST['data_incl'];
    $case_ = $_POST['case_'];
    $data_canc = $_POST['data_canc'];
    $ticket_canc = $_POST['ticket_canc'];
    $obs = $_POST['obs'];

    $sqlUpdate = "UPDATE comunicador_servidor SET revenda='$revenda', cnpj='$cnpj', cliente='$cliente' , estado='$estado', banco='$banco', equip_modelo='$equip_modelo', equip_nome= '$equip_nome', port_servidor='$port_servidor', port_agente='$port_agente', vm='$vm', ip_servidor='$ip_servidor', data_incl='$data_incl', case_='$case_', data_canc='$data_canc', ticket_canc='$ticket_canc', obs='$obs'
    WHERE id='$id'";

   $result = $conexao->query($sqlUpdate);


}


header ('Location: comunicadorServidor.php');


?>