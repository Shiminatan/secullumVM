<?php

   if(!empty($_GET['id']))    //puxar os dados existentes do banco para editar
   {

   include_once('config.php');
   
   $id = $_GET['id'];

   $sqlSelect = "SELECT * FROM acesso_nuvem WHERE id = $id";

   $result = $conexao->query($sqlSelect);
   

   if($result->num_rows > 0)
   {

        while($user_data = mysqli_fetch_assoc($result))

       {
                
                $revenda = $user_data ['revenda'];
                $cliente = $user_data['cliente'];
                $cnpj = $user_data['cnpj'];  
                $estado = $user_data['estado'];
                $equip_mod = $user_data['equip_mod'];
                $equip_cod = $user_data['equip_cod'];
                $equip_nome = $user_data['equip_nome'];
                $port_servidor = $user_data['port_servidor'];
                $port_online = $user_data['port_online'];
                $push = $user_data['push'];
                $ip_servidor = $user_data['ip_servidor'];
                $nome_vm = $user_data['nome_vm'];
                $link_acesso = $user_data['link_acesso'];
                //$ticket_incl = $user_data['ticket_incl'];
                $ticket_canc = $user_data['ticket_canc'];
                $case_= $user_data['case_'];
                $validade = $user_data['validade'];
                $backup_ = $user_data['backup_'];
                $mobuss = $user_data['mobuss'];
                $data_incl = $user_data['data_incl'];
                $data_canc = $user_data['data_canc'];
                $obs = $user_data['obs'];

                
        }
    }    
      else
      {
        header('Location: acessoNuvem.php');
      }
    
    }
    else
    {
      header('Location: acessoNuvem.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Acesso nuvem</title>
    <link rel="stylesheet" href="styles/editAcesso.css">
</head>
<body>
    <div class="box">
    <form action="saveEditAcesso.php" method="POST">
    <fieldset>
        <legend><b>Alterar Dados</b></legend>

        <div class="form-container">
            <!-- Coluna Esquerda -->
            <div class="column">
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
                    <input type="text" name="cliente" id="cliente" class="inputUser" value="<?php echo $cliente?>" required>
                </div>
                <div class="inputBox">
                    <label for= "equip_mod" class="labelinput">Modelo do Equipamento</label><br>
                    <input type="text" name="equip_mod" id="equip_mod" class="inputUser" value="<?php echo $equip_mod?>"  required>
                 </div>
                 <div class="inputBox">
                    <label for= "equip_cod" class="labelinput">Codigo do Equipamento</label><br>
                    <input type="text" name="equip_cod" id="equip_cod" class="inputUser"value="<?php echo $equip_cod?>"  required>
                 </div>    
                <div class="inputBox">
                    <label for= "equip_nome" class="labelinput">Nome do Equipamento</label><br>
                    <input type="text" name="equip_nome" id="equip_nome" class="inputUser" value="<?php echo $equip_nome?>"  required>
                 </div>     
                <div class="inputBox">
                    <label for= "port_servidor" class="labelinput">Porta do Servidor</label><br>
                    <input type="text" name="port_servidor" id="port_servidor" class="inputUser" value="<?php echo $port_servidor?>"  required>
                </div> 
                <div class="inputBox">
                    <label for= "port_online" class="labelinput">Porta Online</label><br>
                    <input type="text" name="port_online" id="port_online" class="inputUser" value="<?php echo $port_online?>"  required>   
                 </div>
                 <div class="inputBox">
                    <label for= "push" class="labelinput">Push</label><br>
                    <input type="text" name="push" id="port_online" class="inputUser" value="<?php echo $push?>">   
                </div>
                <div class="inputBox">
                    <label for= "link_acesso" class="labelinput">Link de Acesso</label> <br>
                    <input type="text" name="link_acesso" id="link_acesso" class="inputUser" value="<?php echo $link_acesso?>"  required>
                 </div>
                <div class="inputBox">
                    <label for= "ticket_canc" class="labelinput">Ticket de Cancelamento</label><br>
                    <input type="text" name="ticket_canc" id="ticket_canc" class="inputUser" value="<?php echo $ticket_canc?>" >
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
                    <!---<input type="radio" id="a cancelar" name="estado" value="a cancelar" <?php if($estado == "a cancelar") echo "checked"; ?>>
                    <label for="a cancelar">A Cancelar</label>--->
                    <p></p>
                 </div>
                 <div class="inputBak-mob-container">
                    <div class="inputBak">
                        <p>Backup</p>
                        <div class="radio-options">
                            <input type="radio" id="backup-sim" name="backup_" value="sim" <?php if($backup_ == "sim") echo "checked"; ?>>
                            <label for="backup-sim">Sim</label>
                            <input type="radio" id="backup-nao" name="backup_" value="nao" <?php if($backup_ == "nao") echo "checked"; ?>>
                            <label for="backup-nao">Não</label>
                        </div>
                    </div>  
                    <div class="inputMob">
                        <p>Mobuss</p>
                        <div class="radio-options">
                            <input type="radio" id="mobuss-sim" name="mobuss" value="sim" <?php if($mobuss == "sim") echo "checked"; ?>>
                            <label for="mobuss-sim">Sim</label>
                            <input type="radio" id="mobuss-nao" name="mobuss" value="nao" <?php if($mobuss == "nao") echo "checked"; ?>>
                            <label for="mobuss-nao">Não</label>
                        </div>
                    </div>
                </div>
                <div class="inputSelect">
                    <label for="nome_vm">Vm</label>
                    <select id="nome_vm" name="nome_vm">       
                    <option value="VmSuporteAcesso5" <?php if($nome_vm == "VmSuporteAcesso5") echo "selected"; ?>>VmSuporteAcesso5</option>
                    <option value="VmSuporteAcesso1" <?php if($nome_vm == "VmSuporteAcesso1") echo "selected"; ?>>VmSuporteAcesso1</option>
                    </select>
                </div>
                <div class="inputSelect2">
                    <label for="ip_servidor">Ip do Servidor</label>
                    <select id="ip_servidor" name="ip_servidor">
                    <option value="20.206.161.75" <?php if($ip_servidor == "20.206.161.75") echo "selected"; ?>>20.206.161.75</option>
                    <option value="4.201.149.195" <?php if($ip_servidor == "4.201.149.195") echo "selected"; ?>>4.201.149.195</option>
                    </select>
                </div>

                <div class="inputBox">
                    <label for= "validade" class="labelinput">Validade</label><br>
                    <input type="text" name="validade" id="validade" class="inputUser" value="<?php echo $validade?>" required>
                 </div>
                 <div class="inputBox">
                    <label for= "case_" class="labelinput">Case</label><br>
                    <input type="text" name="case_" id="case_" class="inputUser" value="<?php echo $case_?>" required>
                </div>
                
                <div class="inputObs">
                    <label for="obs">Observação</label><br>
                    <textarea type="text" placeholder="Digite sua mensagem" name="obs" id="obs"><?php echo $obs?></textarea>
                </div>
                <div class="inputData2">
                    <label for="data_incl" ><b>Data de Inclusão</b></label>
                    <input type= "date" name="data_incl" id="data_incl" value="<?php echo $data_incl?>" required>
                 </div>
                 <div class="inputData">
                    <label for="data_canc" ><b>Data de Cancelamento</b></label>
                    <input type= "date" name="data_canc" id="data_canc" value="<?php echo $data_canc?>">
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
            <a href="acessoNuvem.php">Voltar</a>
            <input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="submit" name="update" id="update" value="Enviar">
		</div>
    </fieldset>
    </form>
    </div>
</body>
</html>