<?php
// Conexão com o banco de dados
include_once('config.php');

// Consulta SQL para obter os dados
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM acesso_nuvem WHERE revenda LIKE '%$data%' OR cliente LIKE '%$data%' OR cnpj LIKE '%$data%' OR link_acesso LIKE '%$data%' OR case_ LIKE '%$data%' OR nome_vm LIKE '%$data%' OR port_servidor LIKE '%$data%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM acesso_nuvem ORDER BY nome_vm, port_servidor DESC";
}

$result = $conexao->query($sql);

// Iniciar a saída HTML para gerar um arquivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=acesso_nuvem.xls");

// Dados da tabela em formato de tabela HTML
echo "<table border='1'>";
echo "<thead>";
echo "<tr>";
echo "<th>REVENDA</th>";
echo "<th>CLIENTE</th>";
echo "<th>CNPJ</th>";
echo "<th>STATUS</th>";
echo "<th>EQUIP. MODELO</th>";
echo "<th>COD. EQUIP</th>";
echo "<th>NOME EQUIP</th>";
echo "<th>PORTA SERVIDOR</th>";
echo "<th>PORTA ONLINE</th>";
echo "<th>PUSH</th>";
echo "<th>IP SERVIDOR</th>";
echo "<th>VM</th>";
echo "<th>LINK</th>";
echo "<th>TICKET CAN.</th>";
echo "<th>CASE</th>";
echo "<th>VALIDADE</th>";
echo "<th>BACKUP</th>";
echo "<th>MOBUSS</th>";
echo "<th>DATA INC.</th>";
echo "<th>DATA CANC.</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['revenda']."</td>";
    echo "<td>".$row['cliente']."</td>";
    echo "<td>".$row['cnpj']."</td>";     
    echo "<td>".$row['estado']."</td>";
    echo "<td>".$row['equip_mod']."</td>";
    echo "<td>".$row['equip_cod']."</td>";
    echo "<td>".$row['equip_nome']."</td>";
    echo "<td>".$row['port_servidor']."</td>"; 
    echo "<td>".$row['port_online']."</td>";
    echo "<td>".$row['push']."</td>";
    echo "<td>".$row['ip_servidor']."</td>";
    echo "<td>".$row['nome_vm']."</td>";
    echo "<td>".$row['link_acesso']."</td>";
    echo "<td>".$row['ticket_canc']."</td>";
    echo "<td>".$row['case_']."</td>";
    echo "<td>".$row['validade']."</td>";
    echo "<td>".$row['backup_']."</td>";
    echo "<td>".$row['mobuss']."</td>";
    echo "<td>".$row['data_incl']."</td>";
    echo "<td>".$row['data_canc']."</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";

// Encerrar a conexão com o banco de dados e sair do script
$conexao->close();
exit;
?>
