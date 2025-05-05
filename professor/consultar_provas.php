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
    <meta charset="UTF-8">
    <title>Consulta de Provas</title>
</head>
<body>
    <h1>Consultar Provas</h1>

    <form method="POST" action="consultar_provas.php">
        <button type="submit" name="buscar_provas">Buscar Provas</button>
    </form>

    <a href="questoes_prof.php">Cadastrar nova prova</a><br>
    <a href="professor.php">Voltar</a>

<?php
if (isset($_POST['buscar_provas'])) {
    // Buscar apenas provas do professor logado
    $stmt = $conn->prepare("SELECT id, nome, data_criacao FROM provas WHERE professor_id = :professor_id");
    $stmt->bindParam(':professor_id', $_SESSION['id']);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<h2>Provas Cadastradas:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Nome</th><th>Data de Criação</th><th>Ações</th></tr>";

        while ($prova = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($prova['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($prova['data_criacao']) . "</td>";
            echo "<td>";
            echo "<a href='editar_prova.php?id={$prova['id']}'>Editar</a> | ";
            echo "<a href='excluir_prova.php?id={$prova['id']}' class='btn-excluir' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a> | ";
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
</body>
</html>
