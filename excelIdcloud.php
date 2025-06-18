<?php
// Conexão com o banco de dados
include_once('config.php');

// Consulta SQL para obter os dados
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM idcloud WHERE revenda LIKE '%$data%' or cliente LIKE '%$data%'  or cnpj LIKE '%$data%'  or case_ LIKE '%$data%' or banco LIKE '%$data%' or login_ LIKE '%$data%' or nserial LIKE '%$data%' or login_ LIKE '%$data%' ORDER BY id DESC";
} else {
    $sql= "SELECT * FROM idcloud ORDER BY id DESC";
}

$result = $conexao->query($sql);

// Iniciar a saída HTML para gerar um arquivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=idcloud.xls");

// Dados da tabela em formato de tabela HTML
echo "<table border='1'>";
echo "<thead>";
echo "<tr>";
echo "<th>REVENDA</th>";
echo "<th>CNPJ</th>";
echo "<th>CLIENTE</th>";
echo "<th>STATUS</th>";
echo "<th>BANCO</th>";
echo "<th>REP</th>";
echo "<th>SERIAL</th>";
echo "<th>PORTARIA</th>";
echo "<th>SISTEMA</th>";
echo "<th>LOGIN</th>";
echo "<th>SENHA</th>";
echo "<th>DATA INC.</th>";
echo "<th>TICKET INC.</th>";
echo "<th>CASE</th>";
echo "<th>DATA CANC.</th>";
echo "<th>TICKET CANC.</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['revenda']."</td>";
    echo "<td>".$row['cnpj']."</td>";
    echo "<td>".$row['cliente']."</td>";
    echo "<td>".$row['estado']."</td>";
    echo "<td>".$row['banco']."</td>";
    echo "<td>".$row['rep']."</td>";
    echo "<td>".$row['nserial']."</td>";
    echo "<td>".$row['portaria']."</td>";
    echo "<td>".$row['sistema']."</td>";
    echo "<td>".$row['login_']."</td>";
    echo "<td>".$row['senha']."</td>";
    echo "<td>".$row['data_incl']."</td>";
    echo "<td>".$row['ticket_incl']."</td>";
    echo "<td>".$row['case_']."</td>";
    echo "<td>".$row['data_canc']."</td>";
    echo "<td>".$row['ticket_canc']."</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";

// Encerrar a conexão com o banco de dados e sair do script
$conexao->close();
exit;
?>
