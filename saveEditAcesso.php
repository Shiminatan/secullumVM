<?php
include_once('config.php');

if(isset($_POST['update']))

{   $id = $_POST['id'];
    $revenda = $_POST['revenda'];
    $cliente = $_POST['cliente'];
    $cnpj = $_POST['cnpj'];
    $estado = $_POST['estado'];
    $equip_mod = $_POST['equip_mod'];
    $equip_cod = $_POST['equip_cod'];
    $equip_nome = $_POST['equip_nome'];
    $port_servidor = $_POST['port_servidor'];
    $port_online = $_POST['port_online'];
    $push = $_POST['push'];
    $ip_servidor = $_POST['ip_servidor'];
    $nome_vm = $_POST['nome_vm'];
    $link_acesso = $_POST['link_acesso'];
    //$ticket_incl = $_POST['ticket_incl'];
    $ticket_canc = $_POST['ticket_canc'];
    $case_ = $_POST['case_'];
    $validade = $_POST['validade'];
    $backup_ = $_POST['backup_'];
    $mobuss = $_POST['mobuss'];
    $data_canc = $_POST['data_canc'];
    $data_incl = $_POST['data_incl'];
    $obs = $_POST['obs'];
    

    $sqlUpdate = "UPDATE acesso_nuvem SET revenda='$revenda', cliente='$cliente' , cnpj='$cnpj', estado='$estado', equip_mod='$equip_mod', equip_cod='$equip_cod', equip_nome= '$equip_nome', port_servidor='$port_servidor', port_online='$port_online', push='$push', ip_servidor='$ip_servidor', nome_vm='$nome_vm', link_acesso='$link_acesso', ticket_canc='$ticket_canc', case_='$case_', validade='$validade', backup_='$backup_', mobuss='$mobuss', data_incl='$data_incl', data_canc='$data_canc', obs='$obs'
    WHERE id='$id'";

   $result = $conexao->query($sqlUpdate);


}


header ('Location: acessoNuvem.php');


?>