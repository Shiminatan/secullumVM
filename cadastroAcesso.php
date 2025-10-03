<?php


   // print_r('Nome: ' . $_POST['revenda']);
   // print_r('<br>');
   // print_r('Email: ' . $_POST['cnpj']);
   // print_r('<br>');
   // print_r('Senha: ' . $_POST['cliente']);

   include_once('config.php');
   // Consultar o maior valor de port_servidor
	$result = mysqli_query($conexao, "SELECT MAX(port_servidor) AS max_port FROM acesso_nuvem");
	$row = mysqli_fetch_assoc($result);
	$next_port_servidor = ($row['max_port'] === null) ? 1 : $row['max_port'] + 1;

	// Consultar o maior valor de port_online
	$result_online = mysqli_query($conexao, "SELECT MAX(port_online) AS max_port FROM acesso_nuvem");
	$row_online = mysqli_fetch_assoc($result_online);
	$next_port_online = ($row_online['max_port'] === null) ? 1 : $row_online['max_port'] + 1;

if (isset($_POST['submit'])) {
   $revenda = $_POST['revenda'];
   $cliente = $_POST['cliente'];
   $cnpj = $_POST['cnpj'];
   $estado = $_POST['estado'];
   $equip_mod = $_POST['equip_mod'];
   $equip_cod = $_POST['equip_cod'];
   $equip_nome = $_POST['equip_nome'];
   $port_servidor = $_POST['port_servidor'];
   $port_online = $_POST['port_online'];
   $push = $_POST['push'];
   $ip_servidor = $_POST['ip_servidor'];
   $nome_vm = $_POST['nome_vm'];
   $link_acesso = $_POST['link_acesso'];
   //$ticket_incl = $_POST['ticket_incl'];
   $ticket_canc = $_POST['ticket_canc'];
   $case_ = $_POST['case_'];
   $validade = $_POST['validade'];
   $backup_ = $_POST['backup_'];
   $mobuss = $_POST['mobuss'];
   $data_incl = $_POST['data_incl'];
   $data_canc = $_POST['data_canc'];
   $obs = $_POST['obs'];


   $result = mysqli_query($conexao, "INSERT INTO acesso_nuvem (revenda, cliente, cnpj, estado, equip_mod, equip_cod, equip_nome, port_servidor,port_online, push, ip_servidor, nome_vm, link_acesso, ticket_canc, case_, validade, backup_, mobuss,data_incl, data_canc, obs) 
   VALUES('$revenda', '$cliente','$cnpj','$estado', '$equip_mod', '$equip_cod', '$equip_nome','$port_servidor', '$port_online', '$push','$ip_servidor', '$nome_vm', '$link_acesso','$ticket_canc', '$case_', '$validade', '$backup_','$mobuss', '$data_incl','$data_canc', '$obs')");
   
   //apos a inserção das informacoes ele retorna para a tabela dinâmica
    header('Location: acessoNuvem.php');
    exit;

   }
   
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Acesso Nuvem</title>
    <link rel="stylesheet" href="styles/cadastroAcesso.css">
</head>
<body>
    <div class="box">
    <form action="cadastroAcesso.php" method="POST">
    <fieldset>
        <legend><b>Inserir Dados</b></legend><br>
        <div class="form-container">
            <!-- Coluna Esquerda -->
            <div class="column">
                <div class="inputBox">
                    <label for="revenda" class="labelinput" >Revenda</label><br>
                    <input type="text" name="revenda" id="revenda" class="inputUser" required>
                </div>
                      <div class="inputBox">
                    <label for= "cliente" class="labelinput">Cliente</label><br>
                    <input type="text" name="cliente" id="cliente" class="inputUser" required>
                </div>

                <div class="inputBox">
                    <label for="cnpj" class="labelinput">CNPJ</label><br>
                    <input type="text" name="cnpj" id="cnpj" class="inputUser" required>
                </div>

                <div class="inputBox">
                    <label for= "equip_mod" class="labelinput">Modelo do Equipamento</label><br>
                    <input type="text" name="equip_mod" id="equip_mod" class="inputUser"  required>
                </div>

                <div class="inputBox">
                    <label for= "equip_cod" class="labelinput">Codigo do Equipamento</label><br>
                    <input type="text" name="equip_cod" id="equip_cod" class="inputUser" required>
                </div>  

                <div class="inputBox">
                    <label for= "equip_nome" class="labelinput">Nome do Equipamento</label><br>
                    <input type="text" name="equip_nome" id="equip_nome" class="inputUser" required>
                </div>  

                <div class="inputBox">
                    <label for="port_servidor">Porta do Servidor</label><br>
                    <input type="text" name="port_servidor" id="port_servidor" class="inputUser" value="<?php echo $next_port_servidor; ?>" required>
                </div> 

                <div class="inputBox">
                    <label for= "port_online" class="labelinput">Porta Online</label><br>
                    <input type="text" name="port_online" id="port_online" class="inputUser" value="<?php echo $next_port_online; ?>" required>
                </div>

                <div class="inputBox">
                    <label for= "push" class="labelinput">Push</label><br>
                    <input type="text" name="push" id="port_online" class="inputUser">
                </div>

                <div class="inputBox">
                    <label for= "link_acesso" class="labelinput">Link de Acesso</label> <br>
                    <input type="text" name="link_acesso" id="link_acesso" class="inputUser" required>
                </div>
            </div>
            <!-- Coluna Direita -->
            <div class="column">
                <div class="inputOption">
                    <p>Status</p>
                    <input type="radio" id="ativo" name="estado" value="Ativo" checked required>
                    <label for="ativo">Ativo</label>
                    <input type="radio" id="user" name="estado" value="Cancelado">
                    <label for="cancelado">Cancelado</label>
                    <!-- <input type="radio" id="a cancelar" name="estado" value="a cancelar">
                    <label for="a cancelar">a Cancelar</label>--->
                </div>  
                <div class="inputBak-mob-container">
                    <div class="inputBak">
                        <p>Backup</p>
                        <div class="radio-options">
                            <input type="radio" id="backup-sim" name="backup_" value="sim">
                            <label for="backup-sim">Sim</label>
                            <input type="radio" id="backup-nao" name="backup_" value="nao">
                            <label for="backup-nao">Não</label>
                        </div>
                    </div>  
                    <div class="inputMob">
                        <p>Mobuss</p>
                        <div class="radio-options">
                            <input type="radio" id="mobuss-sim" name="mobuss" value="sim" >
                            <label for="mobuss-sim">Sim</label>
                            <input type="radio" id="mobuss-nao" name="mobuss" value="nao">
                            <label for="mobuss-nao">Não</label>
                        </div>
                    </div>
                </div>
                
                <div class="inputSelect">
                    <label for="nome_vm">Vm</label>
                    <select id="nome_vm" name="nome_vm">
                    <option value="VmSuporteAcesso1">VmSuporteAcesso1</option>
                    <option value="VmSuporteAcesso5">VmSuporteAcesso5</option>
                </select>
                </div>

                <div class="inputSelect2">
                    <label for="ip_servidor">Ip do Servidor</label>
                    <select id="ip_servidor" name="ip_servidor">
                    <option value="4.201.149.195">4.201.149.195 </option>
                    <option value="20.206.161.75">20.206.161.75 </option>
                </select>
                </div>

                <div class="inputBox">
                    <label for= "validade" class="labelinput">Validade</label><br>
                    <input type="text" name="validade" id="validade" class="inputUser" required>
                </div>   

                <!--
                <div class="inputBox">
                <label for= "ticket_canc" class="labelinput">Ticket de Cancelamento</label><br>
                <input type="text" name="ticket_canc" id="ticket_canc" class="inputUser">
                </div> -->

                <div class="inputBox">
                    <label for= "case_" class="labelinput">Case</label><br>
                    <input type="text" name="case_" id="case_" class="inputUser" required>
                </div>

                <div>
                    <div class="inputObs">
                    <label for= "obs">Observação</label><br>
                    <textarea placeholder="Digite sua mensagem" name="obs" id="obs"></textarea>
                </div>

                <div class="inputData2">
                    <label for="data_incl" >Data de Inclusão</label>
                    <input type= "date" name="data_incl" id="data_incl" required>
                </div>
                <!--
                <div class="inputData">
                    <label for="data_canc" ><b>Data de Cancelamento</b></label>
                    <input type= "date" name="data_canc" id="data_canc">
                </div> -->

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
            <a href="acessoNuvem.php">Voltar</a>
            <input type="submit" name="submit" id="submit" value="Enviar">
        </div>
    </fieldset>
    </form>
    </div>
</body>
</html>
