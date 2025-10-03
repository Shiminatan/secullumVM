<?php
    session_start();
    include_once('config.php');

    // Proteção de Rota: Verifica se o usuário está logado
    if ((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true)) {
        unset($_SESSION['nome']);
        unset($_SESSION['senha']);
        header('Location: telaLogin.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro em Massa - iD Cloud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/cadastroIdcloud.css">
    <style>
        /* Estilos específicos para a página de cadastro em massa */
        .equipamento-bloco { 
            border-top: 2px solid #ff0000; 
            padding-top: 15px; 
            margin-top: 15px; 
        }
        .adicionar-btn { 
            background-color: #0d6efd; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 16px; 
            margin-top: 20px; 
            width: 100%; 
        }
        .adicionar-btn:hover { background-color: #0b5ed7; }
        .remover-equipamento-btn { font-size: 12px; padding: 2px 8px; }

        .equipamento-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        /* --- AJUSTE DE ESPAÇAMENTO DOS RADIOS ADICIONADO AQUI --- */
        .radio-options-group {
            display: flex;
            flex-wrap: wrap; /* Permite que os itens quebrem linha se não houver espaço */
            align-items: center;
        }
        .radio-option-item {
            display: flex;
            align-items: center;
            margin-right: 25px; /* Aumenta o espaço à direita de cada opção */
        }
        .radio-option-item label {
            margin-left: 5px; /* Adiciona um pequeno espaço entre o radio e a label */
        }
        .inputOption p, .inputOption2 p, .inputOption3 p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="box">
        <form action="processaCadastroMassaIdcloud.php" method="POST">
            <fieldset>
                <legend><b>Cadastro em Massa - iD Cloud</b></legend>
                <br>
                
                <h3>Dados do Cliente</h3>
                <div class="form-container">
                    <div class="column">
                        <div class="inputBox"><label for="revenda">Revenda</label><input type="text" name="revenda" id="revenda" class="inputUser" required></div>
                        <div class="inputBox"><label for="cnpj">CNPJ</label><input type="text" name="cnpj" id="cnpj" class="inputUser" required></div>
                        <div class="inputBox"><label for="cliente">Cliente</label><input type="text" name="cliente" id="cliente" class="inputUser" required></div>
                        <div class="inputBox"><label for="banco">Banco</label><input type="text" name="banco" id="banco" class="inputUser"></div>
                        <div class="inputBox"><label for="login_">Login</label><input type="text" name="login_" id="login_" class="inputUser" required></div>
                        <div class="inputBox"><label for="ticket_incl">Ticket de Inclusão</label><input type="text" name="ticket_incl" id="ticket_incl" class="inputUser" required></div>
                        <div class="inputBox"><label for="case_">Case</label><input type="text" name="case_" id="case_" class="inputUser" required></div>
                    </div>
                    <div class="column">
                        <div class="inputOption"><p>Status</p><div class="radio-options-group"><div class="radio-option-item"><input type="radio" id="ativo" name="estado" value="Ativo" checked><label for="ativo">Ativo</label></div><div class="radio-option-item"><input type="radio" id="cancelado" name="estado" value="Cancelado"><label for="cancelado">Cancelado</label></div></div></div>
                        <div class="inputOption2"><p>Sistema</p><div class="radio-options-group"><div class="radio-option-item"><input type="radio" id="ponto_web" name="sistema" value="Ponto web" checked required><label for="ponto_web">Ponto web</label></div><div class="radio-option-item"><input type="radio" id="ponto_web_gateway" name="sistema" value="Ponto web Gateway" required><label for="ponto_web_gateway">Ponto web Gateway</label></div></div></div>
                        <div class="inputOption3"><p>Portaria</p><div class="radio-options-group"><div class="radio-option-item"><input type="radio" id="portaria_1510" name="portaria" value="1510" required><label for="portaria_1510">1510</label></div><div class="radio-option-item"><input type="radio" id="portaria_671" name="portaria" value="671" checked required><label for="portaria_671">671</label></div></div></div>
                        <div class="inputBox"><label for="data_incl">Data de Inclusão</label><input type="date" name="data_incl" id="data_incl" required></div>
                        <div class="inputBox"><label for="dados">Dados de Conexão</label><textarea name="dados" id="dados" class="inputUser"></textarea></div>
                        <div class="inputBox"><label for="obs">Observação</label><textarea name="obs" id="obs" class="inputUser"></textarea></div>
                    </div>
                </div>

                <hr style="margin: 20px 0; border-color: #ff0000;">
                <h3>Equipamentos</h3>
                <div id="equipamentos-container">
                    </div>
                
                <button type="button" id="adicionar-equipamento" class="adicionar-btn">Adicionar Equipamento</button>
                
                <div class="button-container" style="margin-top: 20px;">
                    <a href="idcloud.php">Voltar</a>
                    <input type="submit" name="submit" id="submit" value="Salvar Todos">
                </div>
            </fieldset>
        </form>
    </div>

   <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('equipamentos-container');
            const addBtn = document.getElementById('adicionar-equipamento');

            // Checagem de segurança para garantir que os elementos essenciais existem
            if (!addBtn || !container) {
                console.error("Erro Crítico: O botão ou o contêiner de equipamentos não foi encontrado no HTML.");
                return;
            }

            /**
             * Atualiza a numeração dos títulos (Ex: "Equipamento 1", "Equipamento 2").
             */
            function atualizarEquipamentos() {
                const blocos = container.querySelectorAll('.equipamento-bloco');
                blocos.forEach((bloco, index) => {
                    const h4 = bloco.querySelector('h4');
                    if (h4) {
                        h4.textContent = `Equipamento ${index + 1}`;
                    }
                });
            }

            /**
             * Adiciona um novo bloco de equipamento com campos vazios.
             */
            function adicionarEquipamento() {
                const div = document.createElement('div');
                div.className = 'equipamento-bloco';
                
                div.innerHTML = `
                    <div class="equipamento-header">
                        <h4>Equipamento</h4>
                        <button type="button" class="btn btn-danger remover-equipamento-btn">Remover</button>
                    </div>
                    <div class="form-container">
                        <div class="column">
                            <div class="inputBox">
                                <label>Nome do Equipamento (REP)</label>
                                <input type="text" name="rep[]" class="inputUser" required>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inputBox">
                                <label>Serial</label>
                                <input type="text" name="nserial[]" class="inputUser">
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(div);
                atualizarEquipamentos(); // Chama a função para numerar corretamente o título
            }

            // Listener para o botão de REMOVER
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remover-equipamento-btn')) {
                    if (container.children.length > 1) {
                        e.target.closest('.equipamento-bloco').remove();
                        atualizarEquipamentos(); // Re-numera os equipamentos restantes
                    } else {
                        alert('É necessário manter pelo menos um equipamento.');
                    }
                }
            });

            // --- EXECUÇÃO ---
            // 1. Adiciona o primeiro equipamento ao carregar a página
            adicionarEquipamento();
            
            // 2. Adiciona a funcionalidade de criar novos equipamentos ao botão
            addBtn.addEventListener('click', adicionarEquipamento);
        });
    </script>
</body>
</html>