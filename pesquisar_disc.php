<?php
require_once('conex.php');

$result = null;

// Verifica se há uma busca
if (isset($_POST['buscar'])) {
    $buscar = $_POST['buscar'];
    $conn = getConexao();

    // Prepare a consulta para buscar disciplinas
    $stmt = $conn->prepare("SELECT * FROM disciplinas WHERE nome LIKE :buscar");
    $searchTerm = "%$buscar%";
    $stmt->bindParam(':buscar', $searchTerm);
    $stmt->execute();

    // Atribui o resultado à variável $result
    $result = $stmt;
} else {
    // Se não houver busca, busca todas as disciplinas
    $conn = getConexao();
    $stmt = $conn->query("SELECT * FROM disciplinas");
    $result = $stmt;
}
?>