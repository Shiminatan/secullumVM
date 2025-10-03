<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['nome'])) {
    header('Location: telaLogin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: cadastroMassaComunicador.php');
    exit();
}

// Dados comuns do cliente
$revenda = $_POST['revenda'];
$cnpj = $_POST['cnpj'];
$cliente = $_POST['cliente'];
$banco = $_POST['banco'];
$case_ = $_POST['case_'];
$estado = $_POST['estado'];
$vm = $_POST['vm'];
$ip_servidor = $_POST['ip_servidor'];
$obs = $_POST['obs'];
$data_incl = $_POST['data_incl'];

// --- AJUSTE APLICADO AQUI ---
// Define valores padrão para data de cancelamento e ticket
$data_canc = ($estado === 'Cancelado' && !empty($_POST['data_canc'])) ? $_POST['data_canc'] : '0000-00-00';
$ticket_canc = ($estado === 'Cancelado' && !empty($_POST['ticket_canc'])) ? trim($_POST['ticket_canc']) : '';

// Dados dos equipamentos (arrays)
$equip_modelos = $_POST['equip_modelo'] ?? [];
$equip_nomes = $_POST['equip_nome'] ?? [];
$port_servidores = $_POST['port_servidor'] ?? [];
$port_agentes = $_POST['port_agente'] ?? [];

if (count($equip_modelos) === 0) {
    die("Erro: Nenhum equipamento foi adicionado.");
}

$conexao->begin_transaction();

try {
    // Query preparada com os campos novos
    $stmt = $conexao->prepare(
        "INSERT INTO comunicador_servidor (revenda, cliente, cnpj, estado, banco, equip_modelo, equip_nome, port_servidor, port_agente, vm, ip_servidor, case_, obs, data_incl, data_canc, ticket_canc) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        throw new Exception("Falha ao preparar a query: " . $conexao->error);
    }

    for ($i = 0; $i < count($equip_modelos); $i++) {
        // bind_param atualizado com 16 parâmetros
        $stmt->bind_param(
            "sssssssiisssssss",
            $revenda, $cliente, $cnpj, $estado, $banco,
            $equip_modelos[$i],
            $equip_nomes[$i],
            $port_servidores[$i],
            $port_agentes[$i],
            $vm, $ip_servidor, $case_, $obs, $data_incl, $data_canc, $ticket_canc
        );

        if (!$stmt->execute()) {
            throw new Exception("Falha ao inserir equipamento " . ($i + 1) . ": " . $stmt->error);
        }
    }

    $stmt->close();
    $conexao->commit();
    header('Location: comunicadorServidor.php?cadastro_massa=sucesso');

} catch (Exception $e) {
    $conexao->rollback();
    error_log("Erro no cadastro em massa de comunicador: " . $e->getMessage());
    header('Location: cadastroMassaComunicador.php?cadastro_massa=erro');
}

exit();
?>