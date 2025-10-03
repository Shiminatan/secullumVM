<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['nome'])) {
    header('Location: telaLogin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: cadastroMassaAcesso.php');
    exit();
}

// 1. Obter dados comuns do formulário
$revenda = trim($_POST['revenda']);
$cliente = trim($_POST['cliente']);
$cnpj = trim($_POST['cnpj']);
$link_acesso = trim($_POST['link_acesso']);
$case_ = trim($_POST['case_']);
$data_incl = $_POST['data_incl'];
$validade = trim($_POST['validade']);
$estado = $_POST['estado'];
$backup_ = $_POST['backup_'];
$mobuss = $_POST['mobuss'];
$nome_vm = $_POST['nome_vm'];
$ip_servidor = $_POST['ip_servidor'];
$obs = trim($_POST['obs']);

// --- AJUSTE APLICADO AQUI ---
// Define valores padrão para data de cancelamento e ticket
$data_canc = ($estado === 'Cancelado' && !empty($_POST['data_canc'])) ? $_POST['data_canc'] : '0000-00-00';
$ticket_canc = ($estado === 'Cancelado' && !empty($_POST['ticket_canc'])) ? trim($_POST['ticket_canc']) : '';

// 2. Obter dados dos equipamentos como arrays
$equip_mods = $_POST['equip_mod'] ?? [];
$equip_cods = $_POST['equip_cod'] ?? [];
$equip_nomes = $_POST['equip_nome'] ?? [];
$pushs = $_POST['push'] ?? [];
$port_servidores = $_POST['port_servidor'] ?? [];
$port_onlines = $_POST['port_online'] ?? [];

if (count($equip_mods) === 0 || count($equip_mods) !== count($equip_cods)) {
    die("Erro: Dados de equipamentos ausentes ou inconsistentes.");
}

$conexao->begin_transaction();

try {
    // 3. Preparar o statement para inserção (com os campos novos)
    $stmt = $conexao->prepare(
        "INSERT INTO acesso_nuvem 
            (revenda, cliente, cnpj, estado, backup_, mobuss, ip_servidor, nome_vm, link_acesso, case_, validade, data_incl, data_canc, ticket_canc, obs, equip_mod, equip_cod, equip_nome, port_servidor, port_online, push) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        throw new Exception("Falha ao preparar a query: " . $conexao->error);
    }

    // 4. Iterar e inserir cada equipamento
    for ($i = 0; $i < count($equip_mods); $i++) {
        // Vincula os parâmetros e executa
        $stmt->bind_param(
            "sssssssssssssssssssss", // String de tipos atualizada para 21 parâmetros
            $revenda, $cliente, $cnpj, $estado, $backup_, $mobuss, $ip_servidor, $nome_vm, $link_acesso, $case_, $validade, $data_incl, $data_canc, $ticket_canc, $obs,
            $equip_mods[$i],
            $equip_cods[$i],
            $equip_nomes[$i],
            $port_servidores[$i],
            $port_onlines[$i],
            $pushs[$i]
        );

        if (!$stmt->execute()) {
            throw new Exception("Falha ao inserir equipamento " . ($i + 1) . ": " . $stmt->error);
        }
    }

    $stmt->close();
    $conexao->commit();
    
    header('Location: acessoNuvem.php?cadastro_massa=sucesso');

} catch (Exception $e) {
    $conexao->rollback();
    error_log("Erro no cadastro em massa (acessoNuvem): " . $e->getMessage());
    header('Location: cadastroMassaAcesso.php?cadastro_massa=erro');
}

exit();
?>