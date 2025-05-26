<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../conex.php');
include(__DIR__ .'/../protect.php');
require_once(__DIR__ .'/verificar_professor.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um Professor
verificarProfessor();
// Inicia sessão se não estiver iniciada



try {
    // Verifica se o ID do assunto foi passado na URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Conectar ao banco de dados
        $conn = getConexao();

        // Consulta para obter os dados do assunto
        $stmt = $conn->prepare('SELECT assuntos.id, assuntos.nome, disciplinas.id AS disciplina_id, disciplinas.nome AS disciplina_nome 
        FROM assuntos 
        JOIN disciplinas ON assuntos.disciplina_id = disciplinas.id 
        WHERE assuntos.id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $assunto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$assunto) {
            echo "assunto não encontrado.";
            exit();
        }
    } else {
        echo "ID do assunto não fornecido.";
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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/css/config/main.css">
    <link rel="stylesheet" href="../assets/css/navbar/flat-navbar.css">
    <link rel="stylesheet" href="../assets/css/login/cadastro.css">
    <title>Editar assunto</title>
</head>

<body>
    <nav class="navbar"></nav>
    <main class="main-content">
        <section class="main-section-1">
            <div class="section-title">
                <h1>Editar assunto</h1>
            </div>
        </section>
        <section class="main-section-2">
            <form action="upd_ass.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($assunto['id']); ?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($assunto['nome']); ?>" required>
        <br>


        <label for="disciplina">Disciplina:</label>
        <select name="disciplina" id="disciplina" required>
            <option value="">Selecione uma disciplina</option>
            <?php
            // Usando a mesma conexão para buscar disciplinas
            $conn = getConexao(); // Reabrindo a conexão para buscar disciplinas
            $stmt_disciplinas = $conn->prepare("SELECT id, nome FROM disciplinas ORDER BY nome");
            $stmt_disciplinas->execute();
            while ($reg = $stmt_disciplinas->fetch(PDO::FETCH_ASSOC)) {
                // Verifica se a disciplina atual é a que está associada ao assunto
                $selected = ($reg['id'] == $assunto['disciplina_id']) ? 'selected' : '';
                echo '<option value="' . $reg["id"] . '" ' . $selected . '>' . $reg["nome"] . '</option>';
            }
            ?>
        </select>
        <br>
            
        <input type="submit" value="Atualizar">
        
    </form>
        </section>
    </main>
    
    
    <div class="navigation-options">
        <a href="assunto_prof.php">Voltar</a>
    </div>

    <script src="../assets/js/prof-navbar.js"></script>
</body>

</html>