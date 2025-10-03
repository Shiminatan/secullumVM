<?php
session_start();
include_once('config.php');

// Proteção de Rota
if (!isset($_SESSION['nome'])) {
    header('Location: telaLogin.php');
    exit();
}

// Validação de Método
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: cadastroMassaIdcloud.php');
    exit();
}

// 1. Obter dados comuns do formulário
$revenda = trim($_POST['revenda']);
$cliente = trim($_POST['cliente']);
$cnpj = trim($_POST['cnpj']);
$estado = $_POST['estado'];
$banco = trim($_POST['banco']);
$portaria = $_POST['portaria'];
$sistema = $_POST['sistema'];
$login_ = trim($_POST['login_']);
$ticket_incl = trim($_POST['ticket_incl']);
$case_ = trim($_POST['case_']);
$data_incl = $_POST['data_incl'];
$obs = trim($_POST['obs']);
$dados = trim($_POST['dados']);

// --- AJUSTE APLICADO AQUI ---
// Define valores padrão para data de cancelamento e ticket
$data_canc = ($estado === 'Cancelado' && !empty($_POST['data_canc'])) ? $_POST['data_canc'] : '0000-00-00';
$ticket_canc = ($estado === 'Cancelado' && !empty($_POST['ticket_canc'])) ? trim($_POST['ticket_canc']) : '';


// Dados dos equipamentos
$reps = $_POST['rep'] ?? [];
$nserials = $_POST['nserial'] ?? [];

if (count($reps) === 0 || count($reps) !== count($nserials)) {
    header('Location: cadastroMassaIdcloud.php?cadastro_massa=erro_equipamento');
    exit();
}

$conexao->begin_transaction();

try {
    // 2. Prepara a query de inserção com os campos novos
    $stmt = $conexao->prepare(
        "INSERT INTO idcloud 
            (revenda, cliente, cnpj, estado, banco, portaria, sistema, login_, ticket_incl, case_, data_incl, data_canc, ticket_canc, obs, dados, rep, nserial) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        throw new Exception("Falha ao preparar a query: " . $conexao->error);
    }

    // 3. Itera e insere cada equipamento
    for ($i = 0; $i < count($reps); $i++) {
        // bind_param atualizado com 17 parâmetros
        $stmt->bind_param(
            "sssssssssssssssss",
            $revenda,
            $cliente,
            $cnpj,
            $estado,
            $banco,
            $portaria,
            $sistema,
            $login_,
            $ticket_incl,
            $case_,
            $data_incl,
            $data_canc,
            $ticket_canc,
            $obs,
            $dados,
            $reps[$i],
            $nserials[$i]
        );

        if (!$stmt->execute()) {
            throw new Exception("Falha ao inserir equipamento " . ($i + 1) . ": " . $stmt->error);
        }
    }

    $stmt->close();
    $conexao->commit();
    
    header('Location: idcloud.php?cadastro_massa=sucesso');

} catch (Exception $e) {
    $conexao->rollback();
    error_log("Erro no cadastro em massa de iD Cloud: " . $e->getMessage());
    header('Location: cadastroMassaIdcloud.php?cadastro_massa=erro');
}

exit();
?>