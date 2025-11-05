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

    $result_servidor = $conexao->query("SELECT MAX(port_servidor) AS max_port FROM acesso_nuvem");
    $next_port_servidor = ($result_servidor->fetch_assoc()['max_port'] ?? 20000) + 1;

    $result_online = $conexao->query("SELECT MAX(port_online) AS max_port FROM acesso_nuvem");
    $next_port_online = ($result_online->fetch_assoc()['max_port'] ?? 30000) + 1;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cadastro em Massa - Acesso Nuvem</title>
    <link rel="stylesheet" href="styles/cadastroAcesso.css">
    <style>
        .equipamento-bloco { border-top: 2px solid #228658; padding-top: 15px; margin-top: 15px; }
        .adicionar-btn { background-color: #0d6efd; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 20px; width: 100%; }
        .adicionar-btn:hover { background-color: #0b5ed7; }
        .remover-equipamento-btn { font-size: 12px; padding: 2px 8px; }
        .radio-options-group { display: flex; gap: 20px; align-items: center; }
    </style>
</head>
<body>
    <div class="box">
        <form action="processaCadastroMassa.php" method="POST">
            <fieldset>
                <legend><b>Cadastro em Massa - Acesso Nuvem</b></legend>
                <br>
                
                <h3>Dados do Cliente</h3>
                <div class="form-container">
                    <div class="column">
                        <div class="inputBox"><label for="revenda">Revenda</label><input type="text" name="revenda" id="revenda" class="inputUser" required></div>
                        <div class="inputBox"><label for="cliente">Cliente</label><input type="text" name="cliente" id="cliente" class="inputUser" required></div>
                        <div class="inputBox"><label for="cnpj">CNPJ</label><input type="text" name="cnpj" id="cnpj" class="inputUser" required></div>
                        <div class="inputBox"><label for="link_acesso">Link de Acesso</label><input type="text" name="link_acesso" id="link_acesso" class="inputUser" required></div>
                        <div class="inputBox"><label for="obs">Observação</label><textarea name="obs" id="obs" class="inputUser"></textarea></div>
                    </div>
                    <div class="column">
                        <div class="inputBox"><label for="case_">Case</label><input type="text" name="case_" id="case_" class="inputUser" required></div>
                        <div class="inputBox"><label for="validade">Validade</label><input type="text" name="validade" id="validade" class="inputUser" required></div>
                        <div class="inputData2"><label for="data_incl">Data de Inclusão</label><input type="date" name="data_incl" id="data_incl" required></div>
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
                        <div class="inputOption" style="margin-top: 15px;"><p>Status</p><div class="radio-options"><input type="radio" id="ativo" name="estado" value="Ativo" checked><label for="ativo">Ativo</label><input type="radio" id="cancelado" name="estado" value="Cancelado"><label for="cancelado">Cancelado</label></div></div>
                        <div class="d-flex" style="gap: 40px; margin-top: 15px;">
                            <div class="inputBak" style="width: auto;"><p>Backup</p><div class="radio-options"><input type="radio" id="backup-sim" name="backup_" value="sim" checked><label for="backup-sim">Sim</label><input type="radio" id="backup-nao" name="backup_" value="nao"><label for="backup-nao">Não</label></div></div>
                            <div class="inputMob" style="width: auto;"><p>Mobuss</p><div class="radio-options"><input type="radio" id="mobuss-sim" name="mobuss" value="sim"><label for="mobuss-sim">Sim</label><input type="radio" id="mobuss-nao" name="mobuss" value="nao" checked><label for="mobuss-nao">Não</label></div></div>
                        </div>
                    </div>
                </div>

                <hr style="margin: 20px 0;">
                <h3>Equipamentos</h3>
                <div id="equipamentos-container">
                    </div>
                
                <button type="button" id="add-equipamento-btn" class="adicionar-btn">Adicionar Equipamento</button>
                
                <div class="button-container" style="margin-top: 20px;">
                    <a href="acessoNuvem.php">Voltar</a>
                    <input type="submit" name="submit" id="submit" value="Salvar Todos">
                </div>
            </fieldset>
        </form>
    </div>

   <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('equipamentos-container');
            const addBtn = document.getElementById('add-equipamento-btn');
            
            if (!addBtn || !container) {
                console.error("Erro Crítico: O botão ou o contêiner de equipamentos não foi encontrado.");
                return;
            }

            const initial_port_servidor = <?php echo $next_port_servidor; ?>;
            const initial_port_online = <?php echo $next_port_online; ?>;

            function atualizarEquipamentos() {
                const blocos = container.querySelectorAll('.equipamento-bloco');
                blocos.forEach((bloco, index) => {
                    bloco.querySelector('h4').textContent = `Equipamento ${index + 1}`;
                });
            }

            function adicionarEquipamento() {
                let valorPortServidor;
                let valorPortOnline;

                // --- LÓGICA PARA PORTA ONLINE (SEMPRE A MESMA DO PRIMEIRO) ---
                const primeiroInputOnline = document.querySelector('input[name="port_online[]"]');
                if (primeiroInputOnline) {
                    valorPortOnline = primeiroInputOnline.value;
                } else {
                    valorPortOnline = initial_port_online;
                }

                // --- LÓGICA PARA PORTA SERVIDOR (INCREMENTA +1) ---
                const todosInputsServidor = document.querySelectorAll('input[name="port_servidor[]"]');
                if (todosInputsServidor.length > 0) {
                    const ultimoInputServidor = todosInputsServidor[todosInputsServidor.length - 1];
                    valorPortServidor = parseInt(ultimoInputServidor.value) + 1;
                } else {
                    valorPortServidor = initial_port_servidor;
                }
                
                const div = document.createElement('div');
                div.className = 'equipamento-bloco';
                
                div.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Equipamento</h4>
                        <button type="button" class="btn btn-danger remover-equipamento-btn">Remover</button>
                    </div>
                    <div class="form-container">
                        <div class="column">
                            <div class="inputBox">
                                <label>Modelo</label>
                                <input type="text" name="equip_mod[]" class="inputUser" required>
                            </div>
                             <div class="inputBox">
                                <label>Nome</label>
                                <input type="text" name="equip_nome[]" class="inputUser" required>
                            </div>
                            <div class="inputBox">
                                <label>Porta Servidor</label>
                                <input type="text" name="port_servidor[]" class="inputUser" value="${valorPortServidor}" required>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inputBox">
                                <label>Código</label>
                                <input type="text" name="equip_cod[]" class="inputUser" required>
                            </div>
                             <div class="inputBox">
                                <label>Push</label>
                                <input type="text" name="push[]" class="inputUser">
                            </div>
                            <div class="inputBox">
                                <label>Porta Online</label>
                                <input type="text" name="port_online[]" class="inputUser" value="${valorPortOnline}" required>
                            </div>
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
                        // Importante: NÃO precisamos recalcular as portas após remover,
                        // pois a lógica de incremento agora olha sempre para o último valor da lista.
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