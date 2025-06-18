<?php
// Configuração do banco de dados
$host = "localhost"; // IP da VM Azure
$dbname = "formulariovms"; // Nome do banco de dados
$usuario = "root"; // Usuário do banco
$senha = ""; // Senha do banco
$porta = 3306; // Porta padrão do MySQL

try {
    // Criando a conexão com PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;port=$porta", $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Ativa os erros do PDO
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Retorna os dados como array associativo
    ]);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Processar redefinição de senha
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $novaSenha = $_POST["novaSenha"];
    $confirmarSenha = $_POST["confirmarSenha"];

    if ($novaSenha !== $confirmarSenha) {
        echo "<script>alert('As senhas não coincidem!');</script>";
    } else {
        // Verificar se o usuário existe
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE nome = :usuario");
        $stmt->bindParam(":usuario", $usuario);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            echo "<script>alert('Usuário não encontrado!');</script>";
        } else {
            // Atualizar a senha sem criptografia
            $stmtUpdate = $db->prepare("UPDATE usuarios SET senha = :senha WHERE nome = :usuario");
            $stmtUpdate->bindParam(":senha", $novaSenha);
            $stmtUpdate->bindParam(":usuario", $usuario);
            
            if ($stmtUpdate->execute()) {
                echo "<script>
        alert('Senha redefinida com sucesso!');
        window.location.href = 'telaLogin.php';
      </script>";
            } else {
                echo "<script>alert('Erro ao redefinir senha.');</script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 10px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #007BFF;
        }
        .btn-secondary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Redefinição de Senha</h2>
        <form method="POST">
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>
            
            <label for="novaSenha">Nova Senha:</label>
            <input type="password" id="novaSenha" name="novaSenha" required>
            
            <label for="confirmarSenha">Confirmar Nova Senha:</label>
            <input type="password" id="confirmarSenha" name="confirmarSenha" required>
            
            <button type="submit">Redefinir Senha</button>
            <button type="button" class="btn-secondary" onclick="window.location.href='telaLogin.php'">Voltar</button>
        </form>
    </div>
</body>
</html>
