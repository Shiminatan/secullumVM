  // Variáveis para persistir os campos após a consulta
  <?php
    $data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : '';
    $data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Cancelados</title>
</head>
<body>
    <header>
        <h1>Relatório de cancelados por período</h1>
        <link rel="stylesheet" href="styles/relatorioIncluidos.css">
    </header>
    <main>
        <section class="form-container">
            <form method="POST" action="">
                <div class="select-container">
                    <label for="tabela">Selecione o serviço:</label>
                    <select name="tabela" id="tabela" required>
                        <option value="comunicador_servidor">Comunicador Servidor</option>
                        <option value="acesso_nuvem">Acesso na Nuvem</option>
                        <option value="idcloud">iD Cloud</option>
                    </select>
                </div>
                
                <div class="input-data-container">
                    <label for="data_inicio">Data Início:</label>
                    <input type="date" name="data_inicio" id="data_inicio" value="<?php echo htmlspecialchars($data_inicio); ?>" required>
                    
                    <label for="data_fim">Data Fim:</label>
                    <input type="date" name="data_fim" id="data_fim" value="<?php echo htmlspecialchars($data_fim); ?>" required>

                    <div class="btn-container">
                        <input type="submit" name="gerar_relatorio" value="Gerar Relatório" class="submit-btn">
                    </div>

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
            </form>
        </section>
    </main>
</body>
    <?php
        // Substitua as colunas abaixo pelos nomes das colunas que você deseja exibir
        $colunas = "Revenda, Cliente, CNPJ, Banco, Estado, data_canc";

        // Mapeamento de colunas para cabeçalhos amigáveis
        $cabecalhos = [
            'Revenda' => 'Revenda',
            'Cliente' => 'Cliente',
            'CNPJ' => 'CNPJ',
            'Banco' => 'Banco',
            'Estado' => 'Estado',
            'data_canc' => 'Data cancelamento'
        ];

  
    if (isset($_POST['gerar_relatorio'])) {
        $tabela = $_POST['tabela'];
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];

        // Conexão com o banco de dados
        $conn = new mysqli('localhost', 'root', '', 'formulariovms');

        // Verificando conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Verifica a tabela e ajusta a consulta
        $tabelas_permitidas = ['comunicador_servidor', 'acesso_nuvem', 'idcloud'];
        if (!in_array($tabela, $tabelas_permitidas)) {
            die("Tabela inválida.");
        }

        // Consulta SQL com prepared statement
        $sql = "SELECT $colunas FROM $tabela WHERE data_canc BETWEEN ? AND ? ORDER BY revenda ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $data_inicio, $data_fim);
        $stmt->execute();
        $result = $stmt->get_result();

        // Exibindo o total de resultados
        $totalResultados = $result->num_rows;
        echo "<p>Total de resultados: $totalResultados</p>";

        if ($totalResultados > 0) {
            echo "<h2>Resultados da busca de " . date('d/m/Y', strtotime($data_inicio)) . " até " . date('d/m/Y', strtotime($data_fim)) . " na tabela " . strtoupper($tabela) . "</h2>";
            echo "<table class='result-table'>
                    <thead>
                        <tr>";
            // Exibe os cabeçalhos das colunas com nomes amigáveis
            foreach (explode(',', $colunas) as $coluna) {
                $coluna = trim($coluna);
                echo "<th>" . $cabecalhos[$coluna] . "</th>";
            }
            echo "</tr>
                    </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach (explode(',', $colunas) as $coluna) {
                    echo "<td>" . htmlspecialchars($row[trim($coluna)]) . "</td>";
                }
                echo "</tr>";
            }
            echo "</tbody>
                </table>";  
        
            // Botão Exportar para Excel
            echo '<div class="btn-container export-btn-container">';
            echo '<a href="exportarCancelados.php?tabela=' . urlencode($tabela) . '&data_inicio=' . urlencode($data_inicio) . '&data_fim=' . urlencode($data_fim) . '" class="submit-btn">Exportar para Excel</a>';
            echo '</div>';
        }

        // Fechando conexão
        $stmt->close();
        $conn->close();
        

        } else {
            echo "Nenhum registro encontrado.";
        }


    
    ?>
</body>
</html>