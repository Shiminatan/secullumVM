<?php

   if(!empty($_GET['id']))    //puxar os dados existentes do banco para editar
   {

   include_once('config.php');
   
   $id = $_GET['id'];

   $sqlSelect = "SELECT * FROM comunicador_servidor WHERE id = $id";

   $result = $conexao->query($sqlSelect);
   

   if($result->num_rows > 0)
   {

        while($user_data = mysqli_fetch_assoc($result))
        {
                $revenda = $user_data ['revenda'];
                $cnpj = $user_data['cnpj'];
                $cliente = $user_data['cliente'];
                $estado = $user_data['estado'];
                $banco = $user_data['banco'];
                $equip_modelo = $user_data['equip_modelo'];
                $equip_nome = $user_data['equip_nome'];
                $port_servidor = $user_data['port_servidor'];
                $port_agente = $user_data['port_agente'];
                $vm = $user_data['vm'];
                $ip_servidor = $user_data['ip_servidor'];
                //$ticket_incl = $user_data['ticket_incl'];
                $data_incl = $user_data['data_incl'];
                $case_= $user_data['case_'];
                $data_canc = $user_data['data_canc'];
                $ticket_canc = $user_data['ticket_canc'];
                $obs = $user_data['obs'];

                
        }
    }    
      else
      {
        header('Location: ComunicadorServidor.php');
      }
    
    }
    else
    {
      header('Location: ComunicadorServidor.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Comunicador Servidor</title>
    <link rel="stylesheet" href="styles/editComunicador.css">
</head>
<body>
<div class="box">
        <form action="saveEditComunicador.php" method="POST">
    <fieldset>
        <legend><b>Alterar Dados</b> </legend>
        <br>
        <div class="form-container">
      <!-- Coluna Esquerda -->
    <div class="column">
        <div class="inputBox">
            <label for="revenda" class="labelinput" >Revenda</label><br>
            <input type="text" name="revenda" id="revenda" class="inputUser" value="<?php echo $revenda?>" required>
        </div>
        <div class="inputBox">
            <label for="cnpj" class="labelinput">CNPJ</label><br>
            <input type="text" name="cnpj" id="cnpj" class="inputUser" value="<?php echo $cnpj?>" required>
        </div>
        <div class="inputBox">
            <label for= "cliente" class="labelinput">Cliente</label><br>
            <input type="text" name="cliente" id="cliente" class="inputUser" value="<?php echo $cliente?>" required>        
        </div>  
        <div class="inputBox">
        <label for= "banco" class="labelinput">Banco</label><br>
            <input type="text" name="banco" id="banco" class="inputUser" value="<?php echo $banco?>" required>
        </div>
        <div class="inputBox">
            <label for= "equip_nome" class="labelinput">Nome do Equipamento</label><br>
            <input type="text" name="equip_nome" id="equip_nome" class="inputUser" value="<?php echo $equip_nome?>" required>
        </div>     
        <div class="inputBox">
            <label for= "port_servidor" class="labelinput">Porta do Servidor</label><br>
            <input type="text" name="port_servidor" id="port_servidor" class="inputUser" value="<?php echo $port_servidor?>" required>
        </div> 
        <div class="inputBox">
            <label for= "port_agente" class="labelinput">Porta do Agente</label><br>
            <input type="text" name="port_agente" id="port_agente" class="inputUser" value="<?php echo $port_agente?>" required>
        </div>
        <div class="inputBox">
            <label for= "case_" class="labelinput">Case</label><br>
            <input type="text" name="case_" id="case_" class="inputUser" value="<?php echo $case_?>" required>
            </div>
        <div class="inputBox">
            <label for= "ticket_canc" class="labelinput">Ticket de Cancelamento</label><br>
            <input type="text" name="ticket_canc" id="ticket_canc" class="inputUser" value="<?php echo $ticket_canc?>">
        </div>
    </div>
    <!-- Coluna Direita -->
    <div class="column">
        <div class="inputOption">
        <p>Status</p>
                    <input type="radio" id="ativo" name="estado" value="Ativo" <?php if($estado == "Ativo") echo "checked"; ?>>
                    <label for="ativo">Ativo</label>
                    <input type="radio" id="cancelado" name="estado" value="Cancelado" <?php if($estado == "Cancelado") echo "checked"; ?>>
                    <label for="cancelado">Cancelado</label>
        <!--<input type="radio" id="a cancelar" name="estado" value="a cancelar" <?php if($estado == "a cancelar") echo "checked"; ?>>
        <label for="a cancelar">A Cancelar</label>-->
    </div>

        <div class="inputSelect">
        <label for="vm">Vm</label>
        <select id="vm" name="vm">
        <option value="VmSuportePonto1" <?php if($vm == "VmSuportePonto1") echo "selected"; ?>>VmSuportePonto1</option>
        </select>
        <div class="inputSelect2">
        <br><label for="ip_servidor">Ip do Servidor</label>
        <select id="ip_servidor" name="ip_servidor">
            <option value="191.232.184.251" <?php if($ip_servidor == "191.232.184.251") echo "selected"; ?>>191.232.184.251</option>
        </select>
            </div>
        </div>

        <div class="inputSelect3">
            <label for="equip_modelo">Modelo do Equipamento</label>
            <select id="equip_modelo" name="equip_modelo">
            <option value="Inner Rep"         <?php if($equip_modelo == "Inner Rep") echo "selected"; ?>>Inner Rep </option>
            <option value="Inner Rep Plus"    <?php if($equip_modelo == "Inner Rep Plus") echo "selected"; ?>>Inner Rep Plus</option>
            <option value="Inner Rep Plus V5" <?php if($equip_modelo == "Inner Rep Plus V5") echo "selected"; ?>>Inner Rep Plus V5</option>
			<option value="Inner Ponto4" <?php if($equip_modelo == "Inner Rep Plus V5") echo "selected"; ?>>Inner Ponto4</option>
            <option value="Prisma SF"         <?php if($equip_modelo == "Prisma SF") echo "selected"; ?>>Prisma SF</option>
            <option value="Prisma SF ADV"     <?php if($equip_modelo == "Prisma SF ADV") echo "selected"; ?>>Prisma SF ADV</option>
            <option value="Prisma SF ADV 671"<?php if($equip_modelo == "Prisma SF ADV 671") echo "selected"; ?>>Prisma SF ADV 671</option>
            <option value="Ponto E ADV"      <?php if($equip_modelo == "Ponto E ADV") echo "selected"; ?>>Ponto E ADV</option>
            <option value="Hexa"            <?php if($equip_modelo == "Hexa") echo "selected"; ?>>Hexa</option>
            <option value="Hexa ADV"         <?php if($equip_modelo == "Hexa ADV") echo "selected"; ?>>Hexa ADV</option>
			<option value="Hexa ADV 671"         <?php if($equip_modelo == "Hexa ADV") echo "selected"; ?>>Hexa ADV 671</option>
            <option value="Primme Acesso"    <?php if($equip_modelo == "Primme Acesso") echo "selected"; ?>>Primme Acesso SF</option>
			<option value="Primme Ponto SF"    <?php if($equip_modelo == "Primme Ponto SF") echo "selected"; ?>>Primme Ponto SF</option>
            <option value="EVO Rep-C"    <?php if($equip_modelo == "EVO Rep-C") echo "selected"; ?>>EVO Rep-C</option>			
            </select>
        </div>

        <div class="inputObs">
            <label for="obs">Observação</label><br>
            <textarea type="text" placeholder="Digite sua mensagem" name="obs" id="obs"><?php echo $obs?></textarea>
        </div>

        <div class="inputData">
            <label for="data_incl" ><b>Data de Inclusão</b></label>
            <input type= "date" name="data_incl" id="data_incl" value="<?php echo $data_incl?>" required>
        </div>

        <div class="inputData2">
            <label for="data_canc" ><b>Data de Cancelamento</b></label>
            <input type= "date" name="data_canc" id="data_canc" value="<?php echo $data_canc?>">

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
        
                <div class="button-container">
                <a href="ComunicadorServidor.php">Voltar</a>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="submit" name="update" id="update" value="Enviar">
                </div>
</fieldset>
</form>
</body>
</html>