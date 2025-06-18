<?php

   if(isset($_POST ['submit']))
   {
   // print_r('Nome: ' . $_POST['nome']);
   // print_r('<br>');
   // print_r('Email: ' . $_POST['email']);
   // print_r('<br>');
   // print_r('Senha: ' . $_POST['senha']);
   
   include_once('config.php');
   
   $nome = $_POST ['nome'];
   //$email = $_POST['email'];
   $senha = $_POST['senha'];
   $funcao = $_POST['funcao'];


   $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, senha, funcao) VALUES( '$nome', '$senha', '$funcao')");

   }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
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

    /* Estilo para os radio buttons ficarem lado a lado */
    .funcao-group {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        align-items: center;
    }

    .funcao-group label {
        margin-right: 10px;
        font-size: 16px;
        display: flex;
        align-items: center;
    }

    /* Customizando o estilo do radio button */
    .funcao-group input[type="radio"] {
        display: none; /* Esconde o radio button padrão */
    }

    .funcao-group label::before {
        content: "";
        width: 20px;
        height: 20px;
        border: 2px solid #007BFF;
        border-radius: 50%;
        margin-right: 10px;
        background-color: #fff;
        display: inline-block;
        position: relative;
        top: 1px;
        transition: background-color 0.2s, border-color 0.2s;
    }

    /* Efeito quando o radio button está selecionado */
    .funcao-group input[type="radio"]:checked + label::before {
        background-color: #007BFF;
        border-color: #007BFF;
    }

    .funcao-group input[type="radio"]:checked + label {
        color: #007BFF;
    }
</style>

</head>
<body>
    <div class="container">
        <h2>Cadastro de Usuários</h2>
        <form action="cadastroUsers.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <label for="confirmarSenha">Confirmar Senha:</label>
            <input type="password" name="confirmarSenha" id="confirmarSenha" required>

            <label for="funcao">Permissão:</label>
            <div class="funcao-group">
                <input type="radio" id="admin" name="funcao" value="admin" required>
                <label for="admin">Administrador</label>

                <input type="radio" id="user" name="funcao" value="user" required>
                <label for="user">Usuário</label>
            </div>

            <button type="submit" name="submit">Cadastrar</button>
            <button type="button" class="btn-secondary" onclick="window.location.href='telaLogin.php'">Voltar</button>
        </form>
    </div>
</body>
</html>