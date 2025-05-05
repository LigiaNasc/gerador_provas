<?php
$logado = $_SESSION['id'] ?? null;
$busca = $_POST['busca'] ?? '';

// Query base com prepared statement
$sql = "SELECT professores.id, professores.nome, professores.email, 
               tipos_usuario.tipo AS tipos_usuario, 
               disciplinas.nome AS disciplinas_nome 
        FROM professores
        JOIN disciplinas ON professores.disciplinas_id = disciplinas.id
        JOIN tipos_usuario ON professores.tipo_id = tipos_usuario.id
        WHERE professores.tipo_id = 2";

// Adiciona filtro de busca se existir
if (!empty($busca)) {
    $sql .= " AND (professores.nome LIKE :busca OR disciplinas.nome LIKE :busca)";
}

$sql .= " ORDER BY disciplinas.nome";

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