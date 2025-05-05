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
        $stmt = $conn->prepare('SELECT professores.id, professores.nome, professores.email, disciplinas.id AS disciplina_id, disciplinas.nome AS disciplina_nome 
        FROM professores 
        JOIN disciplinas ON professores.disciplinas_id = disciplinas.id 
        WHERE professores.id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $professor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$professor) {
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
    <title>Editar Professor</title>
</head>
<body>
    <h1>Editar Professor</h1>
    <form action="upd_prof.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($professor['id']); ?>">
        
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($professor['nome']); ?>" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($professor['email']); ?>" required>
        <br>

        <label for="disciplina">Disciplina:</label>
        <select name="disciplina" id="disciplina" required>
            <option value="">Selecione uma disciplina</option>
            <?php
                // Usando a mesma conexão para buscar disciplinas
                $conn = getConexao(); // Reabrindo a conexão para buscar disciplinas
                $stmt_disciplinas = $conn->prepare("SELECT id, nome FROM disciplinas ORDER BY nome");
                $stmt_disciplinas->execute();
                while($reg = $stmt_disciplinas->fetch(PDO::FETCH_ASSOC)) {
                    // Verifica se a disciplina atual é a que está associada ao professor
                    $selected = ($reg['id'] == $professor['disciplina_id']) ? 'selected' : '';
                    echo '<option value="'.$reg["id"].'" '.$selected.'>'.$reg["nome"].'</option>';    
                }
             ?>
        </select>
        <br>

        <input type="submit" value="Atualizar">
    </form>
</body>
</html>