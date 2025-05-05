<?php
$logado = $_SESSION['id'] ?? null;
$busca = $_POST['buscar'] ?? ''; // Corrigido para 'buscar'

// Query base com prepared statement
$sql = "SELECT assuntos.id, assuntos.nome,
               disciplinas.nome AS disciplinas_nome 
        FROM assuntos 
        JOIN disciplinas ON assuntos.disciplina_id = disciplinas.id";

// Adiciona filtro de busca se existir
if (!empty($busca)) {
    $sql .= " WHERE (assuntos.nome LIKE :busca OR disciplinas.nome LIKE :busca)";
}

$sql .= " ORDER BY assuntos.nome";

try {
    $stmt = $pdo->prepare($sql);
    
    if (!empty($busca)) {
        $termoBusca = "%$busca%";
        $stmt->bindParam(':busca', $termoBusca, PDO::PARAM_STR);
    }
    
    $stmt->execute();
    $result = $stmt;
} catch (PDOException $e) {
    die("Erro ao consultar o banco de dados: " . $e->getMessage());
}
?>