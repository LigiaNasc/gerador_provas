<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php');// Inclua a função de verificação

// Chama a função para verificar se o usuário é um administrador
verificarProfessor();
include('cad_quest.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/config/main.css" />
    <link rel="stylesheet" href="../assets/css/login/cadastro.css" />
    <link rel="stylesheet" href="../assets/css/navbar/flat-navbar.css" />
    <title>Banco de Questões</title>
</head>

<body>
    <nav class="navbar"></nav>
    <main class="main-content">
        <section class="main-section-1">
            <h1>Cadastrar Questões</h1>
        </section>
        <section class="main-section-2">
            <form method="POST" action="cad_quest.php">
                <label for="disciplina">Disciplina:</label>
                <select name="disciplina" id="disciplina" required>
                    <option value="">Selecione uma disciplina</option>
                    <?php
                    // Carregar disciplinas do banco de dados
                    $conn = getConexao();
                    $stmt = $conn->query("SELECT * FROM disciplinas");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                    }
                    ?>
                </select>
                <label for="assunto">Assunto:</label>
                <select name="assunto" id="assunto" required>
                    <option value="">Selecione um assunto</option>
                    <?php
                    $stmt = $conn->query("SELECT * FROM assuntos");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                    }
                    ?>
                </select>
                <label for="texto">Enunciado da Questão:</label>
                <textarea name="texto" id="texto" required style="width: 340px; height: 100px; resize: none; border-radius: 10px; padding: 10px;"></textarea>
                <div id="alternativas">
                    <h3>Alternativas:</h3>
                    <div>
                        <input type="text" name="alternativas[]" placeholder="Alternativa 1" required>
                        <input type="radio" name="correta" value="0" required> <p>Correta</p>
                    </div>
                    <div>
                        <input type="text" name="alternativas[]" placeholder="Alternativa 2" required>
                        <input type="radio" name="correta" value="1"> <p>Correta</p>
                    </div>
                    <div>
                        <input type="text" name="alternativas[]" placeholder="Alternativa 3" required>
                        <input type="radio" name="correta" value="2"> <p>Correta</p>
                    </div>
                    <div>
                        <input type="text" name="alternativas[]" placeholder="Alternativa 4" required>
                        <input type="radio" name="correta" value="3"> <p>Correta</p>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                <button type="submit">Salvar</button>
            </form>
        </section>

        <?php
        // Exibir mensagens de erro ou sucesso
        if (isset($_GET['msg'])) {
            echo "<p>" . htmlspecialchars($_GET['msg']) . "</p>";
        }
        ?>
        
    </main>
    <div class="navigation-options">
        <a href="questoes_prof.php"> Voltar</a>
    </div>
    <footer class="footer"></footer>

    <script src="../assets/js/prof-navbar.js"></script>
</body>

</html>