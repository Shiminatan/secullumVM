<?php
    $data = isset($_GET['search']) ? $_GET['search'] : '';
    session_start();
    include_once('config.php');
    //print_r($_SESSION);

    // Verificar se o usuário está logado
    if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
    { 
        unset($_SESSION['nome']);
        unset($_SESSION['senha']);
        header('Location: telaLogin.php');
    }
    // Definir a variável $logado como o nome do usuário logado
    $logado = $_SESSION['nome'];
    // Consulta se na tabela de usuarios com colunas 'id', 'nome', 'funcao'.
    $sqlUserInfo = "SELECT * FROM usuarios WHERE nome = '$logado'";
    $resultUserInfo = $conexao->query($sqlUserInfo);
       
    // Verificar se a consulta foi bem-sucedida e se encontrou informações do usuário
    if ($resultUserInfo->num_rows > 0) {
      $userInfo = $resultUserInfo->fetch_assoc();
      // Definir $currentUser com as info do usuário atualmente logado , vai olhar para o campo (função) que esta informado no if pela linha 185
      $currentUser = array(
        'id' => $userInfo['id'],
        'nome' => $userInfo['nome'],
        'funcao' => $userInfo['funcao']
      );
    } else {
      // Se não encontrar informações do usuário, posso $currentUser como vazio ou null, dependendo da sua lógica de tratamento de erro
      $currentUser = null;
    }

    // Definir o número de itens por página
    $itens_por_pagina = 100;

    // Recuperar o número da página atual
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $pagina = ($pagina < 1) ? 1 : $pagina;
    $offset = ($pagina - 1) * $itens_por_pagina;

    // Consulta SQL ajustada para a paginação
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $data = $_GET['search'];
        $sql = "SELECT * FROM comunicador_servidor 
                WHERE revenda LIKE '%$data%' 
                   OR cliente LIKE '%$data%' 
                   OR cnpj LIKE '%$data%' 
                   OR banco LIKE '%$data%' 
                   OR port_servidor LIKE '%$data%' 
                   OR vm LIKE '%$data%' 
                   OR case_ LIKE '%$data%' 
                ORDER BY id DESC 
                LIMIT $offset, $itens_por_pagina";
    } else {
        $sql = "SELECT * FROM comunicador_servidor 
                ORDER BY vm, port_servidor DESC 
                LIMIT $offset, $itens_por_pagina";
    }

    $result = $conexao->query($sql);

    // Contabiliza todos os registros
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $data = $_GET['search'];
        $sql_total = "SELECT COUNT(*) FROM comunicador_servidor 
                      WHERE revenda LIKE '%$data%' 
                         OR cliente LIKE '%$data%' 
                         OR cnpj LIKE '%$data%' 
                         OR banco LIKE '%$data%' 
                         OR port_servidor LIKE '%$data%' 
                         OR vm LIKE '%$data%' 
                         OR case_ LIKE '%$data%'";
        $total_registros = $conexao->query($sql_total)->fetch_row()[0];
    } else {
        $total_registros = $conexao->query("SELECT COUNT(*) FROM comunicador_servidor")->fetch_row()[0];
    }

    // Calcula o total de páginas
    $total_paginas = ceil($total_registros / $itens_por_pagina);

    //mostra os totais de ativos que são trazidos pela consulta search 
    $sql_ativos_count = "SELECT COUNT(*) as total FROM comunicador_servidor WHERE estado = 'ativo' AND (revenda LIKE '%$data%' OR cliente LIKE '%$data%' OR cnpj LIKE '%$data%' OR banco LIKE '%$data%' OR port_servidor LIKE '%$data%' OR vm LIKE '%$data%' OR case_ LIKE '%$data%')";
    $result_ativos_count = $conexao->query($sql_ativos_count);
    $row_ativos = mysqli_fetch_assoc($result_ativos_count);
    $total_ativos = $row_ativos['total'];

    // Contabiliza todos os cancelados retornados pela consulta search
    $sql_cancelados_count = "SELECT COUNT(*) as total FROM comunicador_servidor WHERE estado = 'cancelado' AND (revenda LIKE '%$data%' OR cliente LIKE '%$data%' OR cnpj LIKE '%$data%' OR banco LIKE '%$data%' OR port_servidor LIKE '%$data%' OR vm LIKE '%$data%' OR case_ LIKE '%$data%')";
    $result_cancelados_count = $conexao->query($sql_cancelados_count);
    $row_cancelados = mysqli_fetch_assoc($result_cancelados_count);
    $total_cancelado = $row_cancelados['total'];

    // Contabiliza todos a cancelar da tabela com base nos resultados da consulta search
    $sql_a_cancelar_count = "SELECT COUNT(*) as total FROM comunicador_servidor WHERE estado = 'a cancelar' AND (revenda LIKE '%$data%' OR cliente LIKE '%$data%' OR cnpj LIKE '%$data%' OR banco LIKE '%$data%' OR port_servidor LIKE '%$data%' OR vm LIKE '%$data%' OR case_ LIKE '%$data%')";
    $result_a_cancelar_count = $conexao->query($sql_a_cancelar_count);
    $row_a_cancelar = mysqli_fetch_assoc($result_a_cancelar_count);
    $total_a_cancelar = $row_a_cancelar['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IT-edge">
    <meta name="Viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title> Comunicador Servidor</title>
    <style>
        body {
            background-color: #75787B;
            text-align: right;
            margin: 5px;
            padding: 10px;
            font-size: 12px;
        }
        .table-bg{
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px 10px 0 0;
        }
        .navigation_header{
            display: flex;
        }
        .box-search{
            display: flex;
            position: absolute;
            top: 90px;
            justify-content: center;
            gap: 10px;
            width: 100%;
            margin: 4px;
        }
        .btn-btn-primary{
            position: absolute;
            width: 200px;
            left: 150px;
        }
        .navbar-brand{
            margin: 3px;
        }
        .btn {
            margin: 1px;
        }
        .table{
            position: absolute;
            top: 160px;
        }
        .total_registros{
            position: absolute;
            color: white;
            top: 110px;
            font-weight: bold;
        }
        .total_ativos{
            position: absolute;
            top: 110px;
            color: PaleGreen;
            left: 150px;
            font-weight: bold;
        }
        .total_cancelado{
            position: absolute;
            top: 110px;
            color: yellow;
            left: 270px;
            font-weight: bold;
        }
        .total_a_cancelar{
            position: absolute;
            top: 110px;
            color: yellow;
            left: 430px;
            font-weight: bold;
        }
        .btn-custom {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 15px;
            background-color: grey;
        }
        .navbar-brand {
            font-size: 22px;
            margin-left: 15px;
            margin-right: 20px;
        }
        .navbar-toggler {
            color: white;
        }
        .navbar h5{
            position: absolute;
            right: 300px;
            margin: 4px;
        }
        .btn-danger{
            margin-right: 15px;
            background-color: #FF0000;
            display: inline-block;
        }
        .btn-success {
            position: static;
            background-color: #28a745;
            border-color: #28a745;
            color: #ffffff;
            border-radius: 5px;
            left: 1720px;
            top: 85px;
            width: 150px;
            margin-right: 10px;
        }
        .btn-warning {
            display: inline-block;
            margin-top: 8px;
            margin-left: 8px;
            height: 45px;
            line-height: 44px;
            text-align: center;
            padding: 0 20px;
            border-radius: 5px;
            background-color: #808080;
            color: white;
            border: 1px solid #0d6efd;
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
            text-align: center;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 200px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .option a {
            display: block;
            font-size: 18px;
            padding: 10px;
            color: #4CAF50;
            text-decoration: none;
            background-color: #f0f0f0;
            border-radius: 5px;
            margin: 5px 0;
            text-align: center;
            font-weight: bold;
        }
        .option a:hover {
            background-color: #d0e0d0;
        }
        .btn-export {
            background-color: #007bff;
            margin-left: 25px;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-export:hover {
            background-color: #0056b3;
        }
        .btn-export:active {
            background-color: #004494;
            box-shadow: inset 0px 0px 5px rgba(0, 0, 0, 0.2);
        }
        .pagination-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            background-color: #f8f9fa;
            padding: 5px 0;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
        .pagination-link {
            display: inline-block;
            padding: 4px 8px;
            margin: 0 2px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
            font-size: 12px;
        }
        .pagination-link:hover {
            background-color: #007bff;
            color: white;
        }
        .pagination-link.active {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }
        .pagination-link.disabled {
            color: #6c757d;
            border-color: #6c757d;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #999da1;">
        <a class="navbar-brand" href="#">COMUNICADOR SERVIDOR</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="acessoNuvem.php">
                        <button type="button" class="btn btn-primary btn-custom">ACESSO NUVEM</button>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="idcloud.php">
                        <button type="button" class="btn btn-primary btn-custom">ID CLOUD</button>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="verifyPassword()">
                        <button type="button" class="btn btn-primary btn-custom">LICENÇA FACIAL</button>
                    </a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-warning" id="myBtn">RELATÓRIOS</button>
                </li>
            </ul>
            <script>
                function verifyPassword() {
                    const password = prompt("Digite a senha para acessar a página de licenças:");
                    const correctPassword = "_43690@sa";
                    if (password === correctPassword) {
                        window.open("https://dougllassillva27.com.br/Secullum/Listar-Licencas/", "_blank");
                    } else {
                        alert("Senha incorreta. Você não tem permissão para acessar esta página.");
                    }
                }
            </script>
            <!-- O Modal -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeBtn">×</span>
                    <div class="option">
                        <a href="relatorioIncluidos.php" target="_blank">INCLUIDOS</a>
                    </div>
                    <div class="option">
                        <a href="relatorioCancelados.php" target="_blank">CANCELADOS</a>
                    </div>
                </div>
            </div>
            <?php
            // Verifica se o usuário está logado e se possui a função de administrador
            if (isset($currentUser) && $currentUser['funcao'] == 'admin') {
                echo '<div>';
                echo '<a href="cadastroComunicador.php" class="btn btn-success">CADASTRAR</a>';
                echo '</div>';
            }
            ?>
            <div class="d-flex">
                <h5 class="text-white me-3">Bem vindo <?php echo $logado; ?></h5>
                <a href="sair.php" class="btn btn-danger">SAIR</a>
            </div>
        </div>
    </nav>
    <br><br>
    <div class="box-search">
        <input type="search" class="form-control w-25" placeholder="pesquisar" id="pesquisar">
        <button onclick="searchData()" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
        <form action="excelComunicador.php" method="post">
            <button type="submit" class="btn-export">Exportar para Excel</button>
        </form>
    </div>
    <h6 class="total_registros"> TOTAL: <?php echo $total_registros; ?></h6>
    <h6 class="total_ativos">ATIVOS: <?php echo $total_ativos; ?></h6>
    <h6 class="total_cancelado">CANCELADOS: <?php echo $total_cancelado; ?></h6>
    <!--<h6 class="total_a_cancelar">A CANCELAR: <?php echo $total_a_cancelar; ?></h6>-->
    <table class="table table-striped table-sm table-hover" style="text-align:left">
        <thead>
            <tr>
                <th scope="col">REVENDA</th>
                <th scope="col">CNPJ</th>
                <th scope="col">CLIENTE</th>
                <th scope="col">STATUS</th>
                <th scope="col">BANCO</th>
                <th scope="col">EQUIP. MODELO</th>
                <th scope="col">EQUIP NOME</th>
                <th scope="col">PORTA SERVIDOR</th>
                <th scope="col">PORTA AGENTE</th>
                <th scope="col">VM</th>
                <th scope="col">IP SERVIDOR</th>
                <th scope="col">DATA INC.</th>
                <th scope="col">CASE</th>
                <th scope="col">DATA CANC.</th>
                <th scope="col">TICKET CANC.</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($user_data = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $user_data['revenda'] . "</td>";
                echo "<td>" . $user_data['cnpj'] . "</td>";
                echo "<td>" . $user_data['cliente'] . "</td>";
                echo "<td>" . $user_data['estado'] . "</td>";
                echo "<td>" . $user_data['banco'] . "</td>";
                echo "<td>" . $user_data['equip_modelo'] . "</td>";
                echo "<td>" . $user_data['equip_nome'] . "</td>";
                echo "<td>" . $user_data['port_servidor'] . "</td>";
                echo "<td>" . $user_data['port_agente'] . "</td>";
                echo "<td>" . $user_data['vm'] . "</td>";
                echo "<td>" . $user_data['ip_servidor'] . "</td>";
                echo "<td>" . $user_data['data_incl'] . "</td>";
                echo "<td>" . $user_data['case_'] . "</td>";
                echo "<td>" . $user_data['data_canc'] . "</td>";
                echo "<td>" . $user_data['ticket_canc'] . "</td>";
                if ($currentUser['funcao'] == 'admin') {
                    echo "<td>
                        <a class='btn btn-primary btn-sm' href='editComunicador.php?id={$user_data['id']}'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                            </svg>
                        </a>
                        <a class='btn btn-danger btn-sm' href='deleteComunicador.php?id=$user_data[id]' onclick='return confirmDelete()'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                            </svg>
                        </a>
                    </td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="pagination-footer">
        <a href="?pagina=<?php echo $pagina - 1; ?><?php echo isset($data) ? '&search=' . urlencode($data) : ''; ?>" class="pagination-link <?php echo ($pagina <= 1) ? 'disabled' : ''; ?>">Anterior</a>
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="?pagina=<?php echo $i; ?><?php echo isset($data) ? '&search=' . urlencode($data) : ''; ?>" class="pagination-link <?php echo ($i == $pagina) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        <a href="?pagina=<?php echo $pagina + 1; ?><?php echo isset($data) ? '&search=' . urlencode($data) : ''; ?>" class="pagination-link <?php echo ($pagina >= $total_paginas) ? 'disabled' : ''; ?>">Próximo</a>
    </div>
    <script>
        var search = document.getElementById('pesquisar');
        search.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                searchData();
            }
        });
        function searchData() {
            window.location = 'comunicadorServidor.php?search=' + search.value;
        }
        function confirmDelete() {
            return confirm('Tem certeza que deseja excluir este registro?');
        }
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementById("closeBtn");
        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>