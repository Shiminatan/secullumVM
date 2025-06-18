<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Secullum Software - Serviços VMs</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #e9e9e9; /* Cinza claro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Altura total da viewport */
            margin: 0; /* Remove a margem padrão do body */
        }
        .container {
            max-width: 400px;
            padding: 30px;
            background-color: #2c2c2c; /* Preto carvão */
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center; /* Centraliza o texto */
        }
        .logo {
            width: 270px;
            height: auto;
            margin-top: 30px;
            margin-bottom: 50px;
        }
        .form {
            margin-top: 20px;
        }
        .form input[type="text"], .form input[type="password"] {
            width: 95%; /* Diminui o tamanho dos campos para 80% */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: dodgerblue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form input[type="submit"]:hover {
            background-color: deepskyblue;
        }
        .forgot-password {
            font-size: 14px;
            color: #ffffff;
            text-decoration: none;
            margin-bottom: 20px;
            margin-top: 20px; /* Adiciona uma margem superior */
            display: block;
            text-align: center;
        }
        .forgot-password:hover {
            color: #666;
        }

        .btn-cadastrar {
        display: inline-block;
        width: 95%;
        padding: 10px;
        background-color: dodgerblue;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        margin-top: 20px; /* Adiciona espaço entre o botão de login e o de cadastro */
        font-size:14px
        }

        .btn-cadastrar:hover {
        background-color: deepskyblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo.png" alt="Logo" class="logo" />
        <h2>Secullum Software - Serviços VMs</h2>
        <form action="testeLogin.php" method="POST" class="form">
            <input type="text" name="nome" placeholder="Login" />
            <input type="password" name="senha" placeholder="Senha" />
            <input type="submit" name="submit" value="Entrar" />
            <a href="cadastroUsers.php" class="btn-cadastrar">Cadastrar Usuários</a>
            <a href="redefinirSenha.php" class="forgot-password">Esqueceu a senha?</a>
        </form>
    </div>
</body>
</html>