<?php
include_once('config.php');

// Consultar o maior valor de port_servidor
$result = mysqli_query($conexao, "SELECT MAX(port_servidor) AS max_port FROM comunicador_servidor");
$row = mysqli_fetch_assoc($result);
$next_port_servidor = ($row['max_port'] === null) ? 1 : $row['max_port'] + 1;

// Consultar o maior valor de port_agente
$result_agente = mysqli_query($conexao, "SELECT MAX(port_agente) AS max_port FROM comunicador_servidor");
$row_agente = mysqli_fetch_assoc($result_agente);
$next_port_agente = ($row_agente['max_port'] === null) ? 1 : $row_agente['max_port'] + 1;

if (isset($_POST['submit'])) {
    $revenda = $_POST['revenda'];
    $cliente = $_POST['cliente'];
    $cnpj = $_POST['cnpj'];
    $estado = $_POST['estado'];
    $banco = $_POST['banco'];
    $equip_modelo = $_POST['equip_modelo'];
    $equip_nome = $_POST['equip_nome'];
    $port_servidor = $_POST['port_servidor'];
    $port_agente = $_POST['port_agente'];
    $vm = $_POST['vm'];
    $ip_servidor = $_POST['ip_servidor'];
    $data_incl = $_POST['data_incl'];
    $case_ = $_POST['case_'];
    $data_canc = $_POST['data_canc'];
    $ticket_canc = $_POST['ticket_canc'];
    $obs = $_POST['obs'];

    // Inserir dados na tabela
    $result = mysqli_query($conexao, "INSERT INTO comunicador_servidor (revenda, cnpj, cliente, estado, banco, equip_modelo, equip_nome, port_servidor, port_agente, vm, ip_servidor, data_incl, case_, data_canc, ticket_canc, obs) 
    VALUES ('$revenda', '$cnpj', '$cliente', '$estado', '$banco', '$equip_modelo', '$equip_nome', '$port_servidor', '$port_agente', '$vm', '$ip_servidor', '$data_incl', '$case_', '$data_canc', '$ticket_canc', '$obs')");
    //apos a inserção das informacoes ele retorna para a tabela dinâmica
    header('Location: comunicadorServidor.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Comunicador Servidor</title>
    <link rel="stylesheet" href="styles/cadastroComunicador.css">
</head>
<body>
    <div class="box">
        <form action="cadastroComunicador.php" method="POST">
            <fieldset>
                <legend><b>Inserir Dados</b></legend><br>

                <div class="form-container">
                    <!-- Coluna Esquerda -->
                    <div class="column">
                        <div class="inputBox">
                            <label for="revenda">Revenda</label>
                            <input type="text" name="revenda" id="revenda" class="inputUser" required>
                        </div>

                        <div class="inputBox">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" name="cnpj" id="cnpj" class="inputUser" required>
                        </div>

                        <div class="inputBox">
                            <label for="cliente">Cliente</label>
                            <input type="text" name="cliente" id="cliente" class="inputUser" required>
                        </div>

                        <div class="inputBox">
                            <label for="banco">Banco</label>
                            <input type="text" name="banco" id="banco" class="inputUser" required>
                        </div>

                        <div class="inputBox">
                            <label for="equip_nome">Nome do Equipamento</label>
                            <input type="text" name="equip_nome" id="equip_nome" class="inputUser" required>
                        </div>

                        <div class="inputBox">
                            <label for="port_servidor">Porta do Servidor</label><br>
                            <input type="text" name="port_servidor" id="port_servidor" class="inputUser" value="<?php echo $next_port_servidor; ?>" required>
                        </div>

                        <div class="inputBox">
                            <label for= "port_agente" class="labelinput">Porta do Agente</label><br>
                            <input type="text" name="port_agente" id="port_agente" class="inputUser" value="<?php echo $next_port_agente; ?>" required>
                        </div>

                        <div class="inputBox">
                            <label for="case_">Case</label>
                            <input type="text" name="case_" id="case_" class="inputUser" required>
                        </div>
                    </div>

                    <!-- Coluna Direita -->
                    <div class="column">
                        <div class="inputOption">
                            <p>Status</p>
                            <label><input type="radio" id="ativo" name="estado" value="Ativo" checked> Ativo</label>
                            <label><input type="radio" id="cancelado" name="estado" value="Cancelado"> Cancelado</label>
                        </div>

                        <div class="inputBox">
                            <label for="vm">Vm</label>
                            <select id="vm" name="vm">
                                <option value="VmSuportePonto1">VmSuportePonto1</option>
                            </select>
                        </div>

                        <div class="inputBox">
                            <label for="ip_servidor">Ip do Servidor</label>
                            <select id="ip_servidor" name="ip_servidor">
                                <option value="191.232.184.251">191.232.184.251</option>
                            </select>
                        </div>

                        <div class="inputBox">
                            <label for="equip_modelo">Modelo do Equipamento</label>
                            <select id="equip_modelo" name="equip_modelo">
                            <option value="Inner Rep">Inner Rep</option>
                            <option value="Inner Rep Plus">Inner Rep Plus</option>
                            <option value="Inner Rep Plus V5">Inner Rep PLus V5</option>
                            <option value="Inner Ponto4">Inner Ponto4</option>
                            <option value="Prisma SF">Prisma SF</option>
                            <option value="Prisma SF ADV">Prisma SF ADV</option>
                            <option value="Prisma SF ADV 671">Prisma SF ADV 671</option>
                            <option value="Ponto E ADV">Ponto E ADV</option>
                            <option value="Hexa">Hexa</option>
                            <option value="Hexa ADV">Hexa ADV</option>
                            <option value="Hexa ADV 671">Hexa ADV 671</option>
                            <option value="Primme Acesso">Primme Acesso SF</option>
                            <option value="Primme Ponto SF">Primme Ponto SF</option>
							<option value="EVO Rep-C">EVO Rep-C</option>
                        </select>
                        </div>

                        <div class="inputBox">
                            <label for="obs">Observação</label>
                            <textarea name="obs" id="obs" placeholder="Digite sua mensagem"></textarea>
                        </div>

                        <div class="inputBox">
                            <label for="data_incl">Data de Inclusão</label>
                            <input type="date" name="data_incl" id="data_incl" required>
                        </div>

                        <div class="inputBox">
                            <label for="data_canc">Data de Cancelamento</label>
                            <input type="date" name="data_canc" id="data_canc">
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

                <div class="button-container">
                <a href="ComunicadorServidor.php">Voltar</a>
                <input type="submit" name="submit" id="submit" value="Enviar">
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>
