<?php
// config.php
// ARQUIVO DE CONFIGURAÇÃO SENSÍVEL.
// Em um ambiente de produção, este arquivo deve estar FORA da pasta pública da web (public_html).

// --- Configurações do Banco de Dados ---
// Usar constantes (define) é uma prática mais segura para credenciais.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');         // ATENÇÃO: 'root' é aceitável apenas para desenvolvimento local.
define('DB_PASS', '');             // ATENÇÃO: NUNCA use senha em branco em um ambiente de produção.
define('DB_NAME', 'formulariovms');

// --- Conexão MySQLi ---
$conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// 1. VERIFICAÇÃO DE ERRO DE CONEXÃO (ESSENCIAL)
if ($conexao->connect_error) {
    // A função error_log() registra o erro em um arquivo no servidor, sem expô-lo ao usuário.
    error_log("Falha na conexão com o banco de dados: " . $conexao->connect_error);
    
    // A função die() interrompe a execução e exibe uma mensagem genérica.
    die("Erro: Não foi possível conectar ao serviço. Por favor, tente novamente mais tarde.");
}

// 2. DEFINIÇÃO DO CHARSET (PONTO CRÍTICO PARA CORRIGIR ACENTOS)
// Garante que a comunicação com o banco de dados preserve caracteres especiais e acentos.
if (!$conexao->set_charset("utf8mb4")) {
    error_log("Erro ao definir o charset utf8mb4: " . $conexao->error);
    die("Erro de configuração do sistema. Contate o administrador.");
}
?>