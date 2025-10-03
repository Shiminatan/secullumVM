<?php
// Verifica se os parâmetros foram passados via GET
if (isset($_GET['tabela']) && isset($_GET['data_inicio']) && isset($_GET['data_fim'])) {
    // Dados recebidos via GET
    $tabela = $_GET['tabela'];
    $data_inicio = $_GET['data_inicio'];
    $data_fim = $_GET['data_fim'];

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
    $sql = "SELECT revenda, cliente, cnpj, banco, estado, data_incl FROM $tabela WHERE data_incl BETWEEN ? AND ? ORDER BY revenda ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $data_inicio, $data_fim);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cria um arquivo Excel
    $filename = 'relatorio_' . $tabela . '_' . $data_inicio . '_a_' . $data_fim . '.xls';

    // Cabeçalhos para forçar o download do arquivo gerado
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Início do arquivo Excel
    echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    echo '<head>';
    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    echo '<!--[if gte mso 9]>';
    echo '<xml>';
    echo '<x:ExcelWorkbook>';
    echo '<x:ExcelWorksheets>';
    echo '<x:ExcelWorksheet>';
    echo '<x:Name>Dados</x:Name>';
    echo '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>';
    echo '</x:ExcelWorksheet>';
    echo '</x:ExcelWorksheets>';
    echo '</x:ExcelWorkbook>';
    echo '</xml>';
    echo '<![endif]-->';
    echo '</head>';
    echo '<body>';
    echo '<table>';

    // Cabeçalhos das colunas
    echo '<tr>';
    echo '<th>Revenda</th>';
    echo '<th>Cliente</th>';
    echo '<th>CNPJ</th>';
    echo '<th>Banco</th>';
    echo '<th>Estado</th>';
    echo '<th>Data Inclusão</th>';
    echo '</tr>';

    // Dados do banco de dados
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['revenda']) . '</td>';
        echo '<td>' . htmlspecialchars($row['cliente']) . '</td>';
        echo '<td>' . htmlspecialchars($row['cnpj']) . '</td>';
        echo '<td>' . htmlspecialchars($row['banco']) . '</td>';
        echo '<td>' . htmlspecialchars($row['estado']) . '</td>';
        echo '<td>' . htmlspecialchars($row['data_incl']) . '</td>';
        echo '</tr>';
    }

    // Fechamento do arquivo Excel
    echo '</table>';
    echo '</body>';
    echo '</html>';

    // Fechando conexão
    $stmt->close();
    $conn->close();
} else {
    die("Parâmetros inválidos.");
}
?>
