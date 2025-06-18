<?php

session_start(); //quando acessar ele criara duas variaveis nas linhas 34,35

if(isset($_POST['submit']) && !empty($_POST['nome']) && !empty($_POST['senha'])) 
{

   //recebe do formulario email e senha
   include_once('config.php');
   $nome = $_POST['nome'];
   $senha = $_POST['senha'];

   // print_r('Email: ' . $email);
   // print_r('Senha: ' . $senha);

   //consulta para verificar se o usuario existe no banco de dados
   $sql= "SELECT * FROM usuarios WHERE nome = '$nome' and senha = '$senha'";

   $result = $conexao->query($sql);

   print_r($sql);
   print_r($result);

      if(mysqli_num_rows($result) < 1)
      {
           //pra n consegui acessar o sistema apenas pela url  sem realizar autentic
           unset($_SESSION['nome']);
           unset($_SESSION['senha']);
           header('Location: telaLogin.php'); //redirecioandoo com a tela de login

           //print_r('Nao existe');
   
      }
 
      else
         {

            $_SESSION['nome'] = $nome;
            $_SESSION['senha'] = $senha;
            header('Location: comunicadorServidor.php'); //redirecionando para a tela de cadastros

           // print_r($_REQUEST);
   
         }
   }    
   else
   {
      // Nao acessa
      header('Location: telaLogin.php');
   }

?>
