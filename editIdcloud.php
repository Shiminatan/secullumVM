<?php

   if(!empty($_GET['id']))    //puxar os dados existentes do banco para editar
   {

   include_once('config.php');
   
   $id = $_GET['id'];

   $sqlSelect = "SELECT * FROM idcloud WHERE id = $id";

   $result = $conexao->query($sqlSelect);
   

   if($result->num_rows > 0)
   {

        while($user_data = mysqli_fetch_assoc($result)) 
        {

                $revenda = $user_data ['revenda'];
                $cliente = $user_data['cliente'];
                $cnpj = $user_data['cnpj'];
                $estado = $user_data['estado'];
                $banco = $user_data['banco'];
                $rep = $user_data['rep'];
                $nserial = $user_data['nserial'];
                $portaria = $user_data['portaria'];
                $sistema = $user_data['sistema'];
                $login_ = $user_data['login_'];
                //$senha = $user_data['senha'];   
                $ticket_incl = $user_data['ticket_incl'];
                $ticket_canc = $user_data['ticket_canc'];
                $case_= $user_data['case_'];
                $data_incl = $user_data['data_incl'];
                $data_canc = $user_data['data_canc'];
                $obs = $user_data['obs'];
                $dados = $user_data['dados'];
                
        }
    }    
      else
      {
        header('Location: idcloud.php');
      }
    
    }
    else
    {
      header('Location: idcloud.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar iD Cloud</title>
    <link rel="stylesheet" href="styles/editIdcloud.css">
</head>
<body>
    <div class="box">
    <form action="saveEditIdcloud.php" method="POST">
    <fieldset>
        <legend><b>Alterar Dados</b></legend>
        <div class="form-container">
            <!-- Coluna Esquerda -->
            <div class="column">
                <!-- Campos da coluna esquerda -->
                <div class="inputBox">
                    <label for="revenda" class="labelinput" >Revenda</label><br>
                     <input type="text" name="revenda" id="revenda" class="inputUser" value="<?php echo $revenda?>"  required> 
                </div>
                <div class="inputBox">
                    <label for="cnpj" class="labelinput">CNPJ</label><br>
                    <input type="text" name="cnpj" id="cnpj" class="inputUser" value="<?php echo $cnpj?>" required>
                </div>
                <div class="inputBox">
                    <label for= "cliente" class="labelinput">Cliente</label><br>
                    <input type="text" name="cliente" id="cliente" class="inputUser" value="<?php echo $cliente?>"  required>
                </div>
                <div class="inputBox">
                    <label for= "banco" class="labelinput">Banco</label><br>
                    <input type="text" name="banco" id="banco" class="inputUser" value="<?php echo $banco?>" required>
                </div>
                <div class="inputBox">
                    <label for= "rep" class="labelinput">Rep</label><br>
                    <input type="text" name="rep" id="rep" class="inputUser" value="<?php echo $rep?>"  required>
                </div>
                <div class="inputBox">
                    <label for= "nserial" class="labelinput">Serial</label><br>
                    <input type="text" name="nserial" id="nserial" class="inputUser" value="<?php echo $nserial?>">
                </div>
                <div class="inputBox">
                    <label for= "login_" class="labelinput">Login</label><br>
                    <input type="text" name="login_" id="login_" class="inputUser" value="<?php echo $login_?>"  required>
                </div>
                <!--div class="inputBox">
                    <label for= "senha" class="labelinput">Senha</label><br>
                    <input type="text" name="senha" id="senha" class="inputUser" value="<?php echo $senha?>">
                </div-->
                <div class="inputBox">
                    <label for= "ticket_incl" class="labelinput">Ticket de Inclusão</label><br> 
                    <input type="text" name="ticket_incl" id="ticket_incl" class="inputUser" value="<?php echo $ticket_incl?>"  required>   
                </div>
                <div class="inputBox">
                    <label for= "case_" class="labelinput">Case</label><br>
                    <input type="text" name="case_" id="case_" class="inputUser" value="<?php echo $case_?>"  required>
                </div>
                <div class="inputBox">
                    <label for= "ticket_canc" class="labelinput">Ticket de Cancelamento</label><br>
                    <input type="text" name="ticket_canc" id="ticket_canc" class="inputUser" value="<?php echo $ticket_canc?>" >
                </div>           
            </div>
            <!-- Coluna Direita -->
            <div class="column">
                <!-- Campos da coluna direita -->
                <div class="inputOption">
                    <p>Status</p>
                    <input type="radio" id="ativo" name="estado" value="Ativo" <?php if($estado == "Ativo") echo "checked"; ?>>
                    <label for="ativo">Ativo</label>
                    <input type="radio" id="cancelado" name="estado" value="Cancelado" <?php if($estado == "Cancelado") echo "checked"; ?>>
                    <label for="cancelado">Cancelado</label>
                    <p></p>
                </div>
                <div class="inputOption2">
                    <p>Sistema</p>
                     <input type="radio" id="Ponto web" name="sistema" value="Ponto web" <?php if($sistema == "Ponto web") echo "checked"; ?>>
                     <label for="Ponto web">Ponto web</label>
                     <input type="radio" id="user" name="sistema" value="Ponto web Gateway" <?php if($sistema == "Ponto web Gateway") echo "checked"; ?> >
                     <label for="Ponto web Gateway">Ponto web Gateway</label>
                     <p></p>
                </div>
                <div class="inputOption3">
                    <p>Portaria</p>
                    <input type="radio" id="1510" name="portaria" value="1510" <?php if($portaria == "1510") echo "checked"; ?>>
                    <label for="1510">1510</label>
                    <input type="radio" id="user" name="portaria" value="671" <?php if($portaria == "671") echo "checked"; ?> >
                    <label for="671">671</label>
                    <p></p>
                </div>
                <div class="inputObs">
                    <label for="obs">Observação</label><br>
                    <textarea type="text" placeholder="Digite sua mensagem" name="obs" id="obs"><?php echo $obs?></textarea>
                </div>
                <div class="inputObs">
                    <label for="dados">Dados de conexão</label><br>
                    <textarea type="text" placeholder="Digite os dados" name="dados" id="dados"><?php echo $dados?></textarea>
                </div>
                <div class="dataInp2">
                    <label for="data_incl" ><b>Data de Inclusão</b></label>
                    <input type= "date" name="data_incl" id="data_incl" value="<?php echo $data_incl?>" required>
                </div>
                <div class="dataInp">
                    <label for="data_canc" ><b>Data de Cancel.</b></label>
                    <input type= "date" name="data_canc" id="data_canc" value="<?php echo $data_canc?>" >
                </div>

<script>
                     const dataCanc = document.getElementById("data_canc");
                     const radioCancelado = document.getElementById("cancelado");
                     const radioAtivo = document.getElementById("ativo");

                        // Se "Cancelado" for selecionado, torna a data de cancelamento obrigatória
                        radioCancelado.addEventListener("change", function () {
                          if (this.checked) {
                                dataCanc.required = true;
                        }
                            });

                         // Se "Ativo" for selecionado, limpa e remove a obrigatoriedade da data de cancelamento
                         radioAtivo.addEventListener("change", function () {
                            if (this.checked) {
                                 dataCanc.value = "";
                                 dataCanc.required = false;
                        }
                            });
                         // Se o usuário preencher a data manualmente, seleciona automaticamente "Cancelado"
                         dataCanc.addEventListener("input", function () {
                           if (this.value) {
                                 radioCancelado.checked = true;
                                 dataCanc.required = true;
                        }
                            });

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
            <input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="submit" name="update" id="update" value="Enviar">
		</div>
    </fieldset>
    </form>
    </div>
</body>
</html>
