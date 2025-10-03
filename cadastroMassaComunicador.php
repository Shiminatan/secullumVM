<?php
    session_start();
    include_once('config.php');
    if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['nome']);
        unset($_SESSION['senha']);
        header('Location: telaLogin.php');
        exit();
    }

    $result_servidor = $conexao->query("SELECT MAX(port_servidor) AS max_port FROM comunicador_servidor");
    $next_port_servidor = ($result_servidor->fetch_assoc()['max_port'] ?? 40000) + 1;

    $result_agente = $conexao->query("SELECT MAX(port_agente) AS max_port FROM comunicador_servidor");
    $next_port_agente = ($result_agente->fetch_assoc()['max_port'] ?? 45000) + 1;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro em Massa - Comunicador</title>
    <link rel="stylesheet" href="styles/cadastroMassaComunicador.css">
</head>
<body>
    <div class="box">
        <form action="processaCadastroMassaComunicador.php" method="POST">
            <fieldset>
                <legend><b>Cadastro em Massa - Comunicador</b></legend>
                <h3>Dados do Cliente</h3>
                <div class="form-container">
                    <div class="column">
                        <div class="inputBox"><label>Revenda</label><input type="text" name="revenda" id="revenda" class="inputUser" required></div>
                        <div class="inputBox"><label>CNPJ</label><input type="text" name="cnpj" id="cnpj" class="inputUser" required></div>
                        <div class="inputBox"><label>Cliente</label><input type="text" name="cliente" id="cliente" class="inputUser" required></div>
                        <div class="inputBox"><label>Banco</label><input type="text" name="banco" id="banco" class="inputUser"></div>
                        <div class="inputBox"><label>Case</label><input type="text" name="case_" id="case_" class="inputUser"></div>
                        <div class="inputBox"><p>Status:</p><div class="radio-options-group"><input type="radio" id="ativo" name="estado" value="Ativo" checked><label for="ativo" style="padding-right: 20px;">Ativo</label><input type="radio" id="cancelado" name="estado" value="Cancelado"><label for="cancelado">Cancelado</label></div></div>
                    </div>
                    <div class="column">
                        <div class="inputBox"><label>Vm</label><select id="vm" name="vm" class="inputUser"><option value="VmSuportePonto1">VmSuportePonto1</option></select></div>
                        <div class="inputBox"><label>Ip do Servidor</label><select id="ip_servidor" name="ip_servidor" class="inputUser"><option value="191.232.184.251">191.232.184.251</option></select></div>
                        <div class="inputBox"><label>Observações</label><textarea name="obs" id="obs" class="inputUser"></textarea></div>
                        <div class="inputBox"><label>Data de Inclusão</label><input type="date" name="data_incl" id="data_incl" required></div>
                        <div class="inputBox"><label>Data de Cancelamento</label><input type="date" name="data_canc" id="data_canc"></div>
                    </div>
                </div>

                <hr style="margin-top: 25px; border-color: dodgerblue;">
                <h3>Equipamentos</h3>
                <div id="equipamentos-container"></div>
                <button type="button" id="add-equipamento-btn" class="adicionar-btn">Adicionar Equipamento</button>
                <div class="button-container">
                    <a href="comunicadorServidor.php">Voltar</a>
                    <input type="submit" name="submit" id="submit" value="Salvar Todos">
                </div>
            </fieldset>
        </form>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('add-equipamento-btn');
        const container = document.getElementById('equipamentos-container');

        if (!addBtn || !container) {
            console.error("Erro Crítico: O botão ou o contêiner de equipamentos não foi encontrado.");
            return;
        }

        const initial_port_servidor = <?php echo $next_port_servidor; ?>;
        const initial_port_agente = <?php echo $next_port_agente; ?>;

        function atualizarEquipamentos() {
            const equipamentos = container.getElementsByClassName('equipamento-bloco');
            for (let i = 0; i < equipamentos.length; i++) {
                const h4 = equipamentos[i].querySelector('h4');
                if (h4) {
                    h4.innerHTML = `Equipamento <span class="equipamento-index">${i + 1}</span>`;
                }
            }
        }

        function adicionarEquipamento() {
            let valorPortaServidor;
            let valorPortaAgente;

            // --- LÓGICA PARA PORTA DO AGENTE (SEMPRE A MESMA DO PRIMEIRO) ---
            const primeiroInputAgente = document.querySelector('input[name="port_agente[]"]');
            if (primeiroInputAgente) {
                valorPortaAgente = primeiroInputAgente.value;
            } else {
                valorPortaAgente = initial_port_agente;
            }

            // --- LÓGICA PARA PORTA DO SERVIDOR (INCREMENTA +1) ---
            const todosInputsServidor = document.querySelectorAll('input[name="port_servidor[]"]');
            if (todosInputsServidor.length > 0) {
                const ultimoInputServidor = todosInputsServidor[todosInputsServidor.length - 1];
                valorPortaServidor = parseInt(ultimoInputServidor.value) + 1;
            } else {
                valorPortaServidor = initial_port_servidor;
            }
            
            const div = document.createElement('div');
            div.className = 'equipamento-bloco';

            div.innerHTML = `
                <hr>
                <div class="equipamento-header">
                    <h4>Equipamento <span class="equipamento-index"></span></h4>
                    <button type="button" class="remover-equipamento-btn">Remover</button>
                </div>
                <div class="form-container">
                    <div class="column">
                        <div class="inputBox">
                            <label>Modelo do Equipamento</label>
                            <select name="equip_modelo[]" class="inputUser" required>
                                <option value="" disabled selected>Selecione o modelo</option>
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
                        <div class="inputBox"><label>Porta do Servidor</label><input type="text" name="port_servidor[]" class="inputUser" value="${valorPortaServidor}" required></div>
                    </div>
                    <div class="column">
                        <div class="inputBox"><label>Nome do Equipamento</label><input type="text" name="equip_nome[]" class="inputUser" required></div>
                        <div class="inputBox"><label>Porta do Agente</label><input type="text" name="port_agente[]" class="inputUser" value="${valorPortaAgente}" required></div>
                    </div>
                </div>
            `;
            container.appendChild(div);
            atualizarEquipamentos();
        }

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remover-equipamento-btn')) {
                if (container.children.length > 1) {
                    e.target.closest('.equipamento-bloco').remove();
                    atualizarEquipamentos();
                } else {
                    alert('É necessário manter pelo menos um equipamento.');
                }
            }
        });

        adicionarEquipamento();
        addBtn.addEventListener('click', adicionarEquipamento);
    });
</script>
</body>
</html>