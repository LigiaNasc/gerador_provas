<?php
require_once('../conex.php');
include('../protect.php');
// Inicia sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Verifica se o ID do professor foi passado na URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Conectar ao banco de dados
        $conn = getConexao();

        // Consulta para obter os dados do professor
        $stmt = $conn->prepare('SELECT * FROM disciplinas WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $disciplinas = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$disciplinas) {
            echo "Professor não encontrado.";
            exit();
        }
    } else {
        echo "ID do professor não fornecido.";
        exit();
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

// Fechar a conexão
$conn = null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <title>Editar Disciplina</title>
</head>
<body>
    <h1>Editar Disciplina</h1>
    <form action="upd_disc.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($disciplinas['id']); ?>">
    
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($disciplinas['nome']); ?>" required>
        <br>
        <br>

        <input type="submit" value="Atualizar">
    </form>
       
<br>
      
   
    <a href="disciplinas_admin.php?id=<?= $disciplinas['id'] ?>" class="btn-voltar" >voltar</a>
</body>
</html>