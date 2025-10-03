<?php

   if(isset($_POST ['submit']))    
   {

   // print_r('Nome: ' . $_POST['revenda']);
   // print_r('<br>');
   // print_r('Email: ' . $_POST['cnpj']);
   // print_r('<br>');
   // print_r('Senha: ' . $_POST['cliente']);

   include_once('config.php');
   
   $revenda = $_POST['revenda'];
   $cliente = $_POST['cliente'];
   $cnpj = $_POST['cnpj'];
   $estado = $_POST['estado'];
   $banco = $_POST['banco'];
   $rep = $_POST['rep'];
   $nserial = $_POST['nserial'];
   $portaria = $_POST['portaria'];
   $sistema = $_POST['sistema'];
   $login_ = $_POST['login_'];
   //$senha = $_POST['senha']; 
   $ticket_incl = $_POST['ticket_incl'];
   $ticket_canc = $_POST['ticket_canc'];
   $case_ = $_POST['case_'];
   $data_incl = $_POST['data_incl'];
   $data_canc = $_POST['data_canc'];
   $obs = $_POST['obs'];
   $dados = $_POST['dados'];
   

   $result = mysqli_query($conexao, "INSERT INTO idcloud (revenda, cliente, cnpj, estado, banco, rep, nserial, portaria,sistema, login_,ticket_incl, ticket_canc, case_, data_incl, data_canc, obs, dados) 
   VALUES('$revenda', '$cliente','$cnpj','$estado', '$banco', '$rep', '$nserial', '$portaria','$sistema', '$login_', '$ticket_incl','$ticket_canc', '$case_','$data_incl', '$data_canc', '$obs', '$dados')");
   //apos a inserção das informacoes ele retorna para a tabela dinâmica
    header('Location: idcloud.php');
    exit;
   }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta nome="Viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro iD Cloud</title>
<link rel="stylesheet" href="styles/cadastroIdcloud.css">
</head>

<body>
    <div class="box">
    <form action="cadastroIdcloud.php" method="POST">
    <fieldset>
        <legend><b>Inserir Dados</b></legend>

        <div class="form-container">
            <!-- Coluna Esquerda -->
            <div class="column">
                <!-- Campos da coluna esquerda -->
                <div class="inputBox">
                    <label for="revenda" class="labelinput" >Revenda</label><br>
                    <input type="text" name="revenda" id="revenda" class="inputUser" required>
                </div>
                <div class="inputBox">
                    <label for="cnpj" class="labelinput">CNPJ</label><br>
                    <input type="text" name="cnpj" id="cnpj" class="inputUser" required>
                </div>
                <div class="inputBox">
                    <label for= "cliente" class="labelinput">Cliente</label><br>
                    <input type="text" name="cliente" id="cliente" class="inputUser" required>
                 </div>
                 <div class="inputBox">
                    <label for= "banco" class="labelinput">Banco</label><br>
                    <input type="text" name="banco" id="banco" class="inputUser" required>
                 </div>
                <div class="inputBox">
                    <label for= "rep" class="labelinput">Nome do Equipamento</label><br>
                    <input type="text" name="rep" id="rep" class="inputUser"  required>
                </div>
                <div class="inputBox">
                    <label for= "nserial" class="labelinput">Serial</label><br>
                    <input type="text" name="nserial" id="nserial" class="inputUser">
                </div>
                <div class="inputBox">
                    <label for= "login_" class="labelinput">Login</label><br>
                    <input type="text" name="login_" id="login_" class="inputUser" required>
                </div>
                <!--div class="inputBox">
                    <label for= "senha" class="labelinput">Senha</label><br>
                    <input type="text" name="senha" id="senha" class="inputUser">  
                </div> -->
                <div class="inputBox">
                    <label for= "ticket_incl" class="labelinput">Ticket de Inclusão</label><br> 
                    <input type="text" name="ticket_incl" id="ticket_incl" class="inputUser" required>
                 </div>
                <!--<div class="inputBox">
                    <label for= "ticket_canc" class="labelinput">Ticket de Cancelamento</label><br>
                    <input type="text" name="ticket_canc" id="ticket_canc" class="inputUser">
                </div> -->
                 <div class="inputBox">
                    <label for= "case_" class="labelinput">Case</label><br>
                    <input type="text" name="case_" id="case_" class="inputUser" required>
                 </div>

            </div>
            <!-- Coluna Direita -->
            <div class="column">
                <!-- Campos da coluna direita -->
                <div class="inputOption">
                    <p>Status</p>
                    <input type="radio" id="ativo" name="estado" value="Ativo" checked>
                    <label for="ativo">Ativo</label>
                    <input type="radio" id="user" name="estado" value="Cancelado">
                    <label for="cancelado">Cancelado</label>
                    <!--<input type="radio" id="a cancelar" name="estado" value="a cancelar">
                    <label for="a cancelar">a Cancelar</label>-->
                    <p></p>
                </div>
                <div class="inputOption2">
                    <p>Sistema</p>
                    <input type="radio" id="Ponto web" name="sistema" value="Ponto web" checked required>
                    <label for="Ponto web">Ponto web</label>
                    <input type="radio" id="user" name="sistema" value="Ponto web Gateway" required >
                    <label for="Ponto web Gateway">Ponto web Gateway</label>
                    <p></p>
                </div>
                <div class="inputOption3">
                    <p>Portaria</p>
                    <input type="radio" id="1510" name="portaria" value="1510" required>
                    <label for="1510">1510</label>
                    <input type="radio" id="user" name="portaria" value="671" checked required >
                    <label for="671">671</label>
                    <p></p>
                 </div>
                <!--<div class="dataInp">
                    <label for="data_canc" ><b>Data de Cancel.</b></label>
                    <input type= "date" name="data_canc" id="data_canc">
                 </div> -->
                <div class="inputObs">
                    <label for= "obs">Observação</label><br>
                    <textarea placeholder="Digite sua mensagem" name="obs" id="obs"></textarea>
                </div>
                <div class="inputObs">
                    <label for= "dados">Dados de Conexão</label><br>
                    <textarea placeholder="Digite os dados" name="dados" id="dados"></textarea>
                </div>
                <div class="dataInp2">
                    <label for="data_incl" ><b>Data de Inclusão</b></label>
                    <input type= "date" name="data_incl" id="data_incl" required>
                 </div>

                 <script>
                            // Seleciona todos os inputs de data
                            document.querySelectorAll('input[type="date"]').forEach(input => {
                                // Adiciona o evento de clique
                                input.addEventListener('click', function () {
                                    this.showPicker(); // Abre o seletor de data
                                });
                            });
                </script>
            </div>
        </div>
        <!-- Botões abaixo das colunas -->
        <div class="button-container">
            <a href="idcloud.php">Voltar</a>
			<input type="submit" name="submit" id="submit" value="Enviar">
		</div>
    </fieldset>
    </form>
    </div>
</body>
</html>