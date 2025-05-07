<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php');
// Verifica se o usuário é professor
verificarProfessor();

try {
    // Verifica se o ID da questão foi passado na URL
    if (isset($_GET['id'])) {
        $questao_id = $_GET['id'];

        // Conectar ao banco de dados
        $conn = getConexao();

        // Consulta para obter os dados da questão
        $stmt = $conn->prepare('
            SELECT q.id, q.enunciado, q.disciplina_id, q.assunto_id, 
                   d.nome AS disciplina_nome, a.nome AS assunto_nome
            FROM questoes q
            JOIN disciplinas d ON q.disciplina_id = d.id
            JOIN assuntos a ON q.assunto_id = a.id
            WHERE q.id = :id AND q.professor_id = :professor_id
        ');
        $stmt->bindParam(':id', $questao_id, PDO::PARAM_INT);
        $stmt->bindParam(':professor_id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
        $questao = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$questao) {
            header("Location: questoes_prof.php?msg=Questão não encontrada ou você não tem permissão para editá-la");
            exit();
        }

        // Buscar alternativas da questão
        $stmt_alternativas = $conn->prepare('SELECT id, texto, correta FROM alternativas WHERE questao_id = :questao_id ORDER BY id');
        $stmt_alternativas->bindParam(':questao_id', $questao_id, PDO::PARAM_INT);
        $stmt_alternativas->execute();
        $alternativas = $stmt_alternativas->fetchAll(PDO::FETCH_ASSOC);

    } else {
        header("Location: questoes_prof.php?msg=ID da questão não fornecido");
        exit();
    }
} catch (PDOException $e) {
    header("Location: questoes_prof.php?msg=Erro ao carregar questão: " . urlencode($e->getMessage()));
    exit();
}

// Fechar a conexão
$conn = null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/navbar.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <title>Editar Questão</title>
</head>

<body>
    <nav class="navbar"></nav>
    <main>
        <h1>Editar Questão</h1>
        <form method="POST" action="upd_quest.php">
            <input type="hidden" name="questao_id" value="<?php echo htmlspecialchars($questao['id']); ?>">

            <label for="disciplina">Disciplina:</label>
            <select name="disciplina" id="disciplina" required onchange="carregarAssuntos(this.value)">
                <option value="">Selecione uma disciplina</option>
                <?php
                $conn = getConexao();
                $stmt = $conn->query("SELECT * FROM disciplinas");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($row['id'] == $questao['disciplina_id']) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['nome']}</option>";
                }
                ?>
            </select>

            <label for="assunto">Assunto:</label>
            <select name="assunto" id="assunto" required>
                <option value="">Selecione um assunto</option>
                <?php
                                // Carregar assuntos da disciplina selecionada
                $stmt_assuntos = $conn->prepare("SELECT id, nome FROM assuntos ");
                $stmt_assuntos->bindParam(':disciplina_id', $questao['disciplina_id'], PDO::PARAM_INT);
                $stmt_assuntos->execute();
                while ($row = $stmt_assuntos->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($row['id'] == $questao['assunto_id']) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['nome']}</option>";
                }
                ?>
            </select>

            <label for="texto">Enunciado da Questão:</label>
            <textarea name="texto" id="texto" required><?php echo htmlspecialchars($questao['enunciado']); ?></textarea>

            <h3>Alternativas:</h3>
            <div id="alternativas">
                <?php foreach ($alternativas as $index => $alt): ?>
                <div>
                    <input type="hidden" name="alternativa_id[]" value="<?php echo $alt['id']; ?>">
                    <input type="text" name="alternativas[]" value="<?php echo htmlspecialchars($alt['texto']); ?>" 
                           placeholder="Alternativa <?php echo $index + 1; ?>" required>
                    <input type="radio" name="correta" value="<?php echo $index; ?>" 
                           <?php echo $alt['correta'] ? 'checked' : ''; ?>> Correta
                </div>
                <?php endforeach; ?>
            </div>

            <button type="submit">Atualizar</button>
        </form>

        <?php
        if (isset($_GET['msg'])) {
            echo "<p>" . htmlspecialchars($_GET['msg']) . "</p>";
        }
        ?>
        <a href="questoes_prof.php">Voltar</a>
    </main>
    <footer class="footer"></footer>

    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/footer.js"></script>
</body>
</html>