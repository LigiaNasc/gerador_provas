<!-- <?php
// session_start();
// require_once('../conex.php'); // Inclua seu arquivo de conexão
// include('../protect.php'); 
// require_once('verificar_professor.php'); // Inclua a função de verificação

// // Chama a função para verificar se o usuário é um Professor
// verificarProfessor();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Provas</title>
</head>
<body>
    <h1>Cadastrar Provas</h1>
    <form method="POST" action="provas_prof.php">
        <label for="nome">Nome da Prova:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="disciplina">Disciplina:</label>
        <select name="disciplina" id="disciplina" required>
            <option value="">Selecione uma disciplina</option>
            <?php
        //     $conn = getConexao();
        //     $stmt = $conn->query("SELECT * FROM disciplinas");
        //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //         echo "<option value='{$row['id']}'>{$row['nome']}</option>";
        //     }
        //     ?>
        // </select>

        // <label for="assunto">Assunto:</label>
        // <select name="assunto" id="assunto" required>
        //     <option value="">Selecione um assunto</option>
        //     <?php
        //     $stmt = $conn->query("SELECT * FROM assuntos");
        //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //         echo "<option value='{$row['id']}'>{$row['nome']}</option>";
        //     }
            ?>
        </select>

        <button type="submit">Buscar Questões</button>
    </form>

    <?php
    // Exibir questões após a busca
    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //     $disciplinaId = $_POST['disciplina'];
    //     $assuntoId = $_POST['assunto'];

    //     // Montar a consulta com JOINs para incluir disciplina e assunto
    //     $query = "SELECT q.*, d.nome AS disciplina_nome, a.nome AS assunto_nome 
    //               FROM questoes q 
    //               JOIN disciplinas d ON q.disciplina_id = d.id 
    //               JOIN assuntos a ON q.assunto_id = a.id 
    //               WHERE 1=1";
    //     if (!empty($disciplinaId)) {
    //         $query .= " AND q.disciplina_id = :disciplinaId";
    //     }
    //     if (!empty($assuntoId)) {
    //         $query .= " AND q.assunto_id = :assuntoId";
    //     }

    //     $stmt = $conn->prepare($query);
    //     if (!empty($disciplinaId)) {
    //         $stmt->bindParam(':disciplinaId', $disciplinaId);
    //     }
    //     if (!empty($assuntoId)) {
    //         $stmt->bindParam(':assuntoId', $assuntoId);
    //     }
    //     $stmt->execute();

    //     if ($stmt->rowCount() > 0) {
    //         echo "<h2>Questões Encontradas:</h2>";
    //         echo "<form method='POST' action='salvar_prova.php'>"; // Formulário para salvar a prova
    //         echo "<table>";
    //         echo "<tr><th>Selecionar</th><th>Enunciado</th><th>Disciplina</th><th>Assunto</th></tr>";
    //         while ($questao = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //             echo "<tr>";
    //             echo "<td><input type='checkbox' name='questoes[]' value='{$questao['id']}'></td>";
    //             echo "<td>{$questao['enunciado']}</td>";
    //             echo "<td>{$questao['disciplina_nome']}</td>";
    //             echo "<td>{$questao['assunto_nome']}</td>";
    //             echo "</tr>";
    //         }
    //         echo "</table>";
    //         echo "<input type='hidden' name='nome' value='{$_POST['nome']}'>"; // Passar o nome da prova
    //         echo "<button type='submit'>Salvar Prova</button>";
    //         echo "</form>";
    //     } else {
    //         echo "<p>Nenhuma questão encontrada.</p>";
    //     }
    // }
    // ?>
    
</body>
</html> -->