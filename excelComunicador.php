<?php
// Conexão com o banco de dados
include_once('config.php');

// Consulta SQL para obter os dados
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM comunicador_servidor WHERE revenda LIKE '%$data%' OR cliente LIKE '%$data%' OR cnpj LIKE '%$data%' OR banco LIKE '%$data%' OR port_servidor LIKE '%$data%' OR vm LIKE '%$data%' OR case_ LIKE '%$data%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM comunicador_servidor ORDER BY vm, port_servidor DESC";
}

$result = $conexao->query($sql);

// Iniciar a saída HTML para gerar um arquivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=comunicador_servidor.xls");

// Dados da tabela em formato de tabela HTML
echo "<table border='1'>";
echo "<thead>";
echo "<tr>";
echo "<th>REVENDA</th>";
echo "<th>CNPJ</th>";
echo "<th>CLIENTE</th>";
echo "<th>STATUS</th>";
echo "<th>BANCO</th>";
echo "<th>EQUIP. MODELO</th>";
echo "<th>EQUIP NOME</th>";
echo "<th>PORTA SERVIDOR</th>";
echo "<th>PORTA AGENTE</th>";
echo "<th>VM</th>";
echo "<th>IP SERVIDOR</th>";
echo "<th>DATA INC.</th>";
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
    echo "<td>".$row['equip_modelo']."</td>";
    echo "<td>".$row['equip_nome']."</td>";
    echo "<td>".$row['port_servidor']."</td>";
    echo "<td>".$row['port_agente']."</td>";
    echo "<td>".$row['vm']."</td>";
    echo "<td>".$row['ip_servidor']."</td>";
    echo "<td>".$row['data_incl']."</td>";
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
