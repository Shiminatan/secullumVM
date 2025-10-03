<?php
// Conexão com o banco de dados
$db = new PDO('mysql:host=localhost;dbname=formulariovms', 'root');

// Função para gerar um token de redefinição de senha
function generatePasswordResetToken() {
  $token = bin2hex(random_bytes(16));
  return $token;
}

// Criar conexão com o banco de dados
$db = new PDO('mysql:host=localhost;dbname=formulariovms', 'root');

// Função para salvar o token de redefinição de senha no banco de dados
function savePasswordResetToken($user, $token) {
  global $db; // Adicione essa linha para acessar a variável $db dentro da função
  $stmt = $db->prepare('UPDATE usuarios SET password_reset_token = :token WHERE id = :id');
  $stmt->bindParam(':token', $token);
  $stmt->bindParam(':id', $user->id);
  $stmt->execute();
}

// Função para enviar o e-mail com o link de redefinição de senha
function sendPasswordResetEmail($user, $token) {
  $subject = 'Redefinir Senha';
  $message = '
  <p>Olá, ' . $user->name . '</p>
  <p>Clique no link abaixo para redefinir sua senha:</p>
  <p><a href="reset-password.php?token=' . $token . '">Redefinir Senha</a></p>
  ';
  $headers = 'From: seuemail@example.com' . "\r\n" .
             'Reply-To: seuemail@example.com' . "\r\n" .
             'MIME-Version: 1.0' . "\r\n" .
             'Content-Type: text/html; charset=UTF-8';
  mail($user->email, $subject, $message, $headers);
}

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Verifica se o endereço de e-mail é válido
  if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Verifica se o usuário existe no banco de dados
    $stmt = $db->prepare('SELECT * FROM usuarios WHERE email = :email');
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    $user = $stmt->fetchObject();
    if ($user) {
      // Gera um token de redefinição de senha
      $token = generatePasswordResetToken();
      // Salva o token no banco de dados
      savePasswordResetToken($user, $token);
      // Envia um e-mail com o link de redefinição de senha
      sendPasswordResetEmail($user, $token);
      echo "Um link de redefinição de senha foi enviado para o seu endereço de e-mail.";
    } else {
      echo "Usuário não encontrado.";
    }
  } else {
    echo "Endereço de e-mail inválido.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Redefinir Senha</title>
  <style>
    .container {
      max-width: 400px;
      margin: 40px auto;
      padding: 30px;
      background-color: #2c2c2c; /* Preto carvão */
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      color: white;
      text-align: center; /* Centraliza o texto */
      font-size: 18px; /* Aumenta o tamanho da fonte para 18px */

    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    label {
      margin-bottom: 10px;
    }

    input[type="email"] {
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
    }

    button[type="submit"] {
      background-color: #3498db; /* Cor do azul da tela de login */
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
}

button[type="submit"]:hover {
      background-color: #2980b9; /* Cor do azul da tela de login com um pouco de sombra */
}
  </style>
</head>
<body>
  <div class="container">
    <h2>Redefinir Senha</h2>
    <form method="post">
      <label for="email">Insira seu endereço de e-mail:</label>
      <input type="email" id="email" name="email" required>
      <button type="submit">Enviar link de redefinição</button>
    </form>
    <p>Um link de redefinição de senha será enviado para o seu endereço de e-mail.</p>
  </div>
</body>
</html>
``