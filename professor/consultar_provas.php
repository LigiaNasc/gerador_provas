<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php');

verificarProfessor();
$conn = getConexao();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/flat-navbar.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/tabela-1.css" />
    <title>Consulta de Provas</title>
</head>
<body>
    <nav class="navbar"></nav>
    <main class="main-content">
        <section class="main-section-1">
            <h1>Consultar Provas</h1>
            <form method="POST" action="consultar_provas.php" class="tabela">
                <button type="submit" name="buscar_provas">Buscar Provas</button>
            </form>
        </section>
    </main>




<?php
if (isset($_POST['buscar_provas'])) {
    // Buscar apenas provas do professor logado
    $stmt = $conn->prepare("SELECT id, nome, data_criacao FROM provas WHERE professor_id = :professor_id");
    $stmt->bindParam(':professor_id', $_SESSION['id']);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<h2>Provas Cadastradas:</h2>";
        echo "<table class='table'>";
        echo "<tr class='table-date'>
                <th>Nome</th>
                <th>Data de Criação</th>
                <th>Ações</th>
            </tr>";

        while ($prova = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr class='table-date'>";
            echo "<td>" . htmlspecialchars($prova['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($prova['data_criacao']) . "</td>";
            echo "<td class='table-actions'>";
            echo "<a href='editar_prova.php?id={$prova['id']}'>Editar</a>";
            echo "<a href='excluir_prova.php?id={$prova['id']}' class='btn-excluir' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>";
            echo "<a href='gerar_prova.php?id={$prova['id']}'>Gerar PDF</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Nenhuma prova cadastrada.</p>";
    }
}
?>
    <div class="navigation-options">
        <a href="professor.php">Voltar</a>
        <a href="cadastro_questoes.php">Cadastrar Questão</a>
    </div>
    <script src="../assets/js/prof-navbar.js"></script>
</body>
</html>
