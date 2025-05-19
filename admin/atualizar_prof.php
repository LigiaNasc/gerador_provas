<?php
require_once('../conex.php');
require_once('verificar_admin.php'); // Inclua a função de verificação
  verificarAdmin();

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
        JOIN disciplinas ON professores.disciplina_id = disciplinas.id 
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/cadastro.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>Editar Professor</title>
</head>
<body>
    <main class="main-content">
        <section class="main-section-1">
            <div class="section-title">
                <h1>Editar Professor</h1>
            </div>
            <p>Infome os dados para realizar a alteração da disciplina no sistema.</p>
        </section>

            <section class="main-section-2">
                <form action="upd_prof.php" method="POST">
                    <img src="../assets/img/logo.png" alt="">
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
                    <input type="submit" value="Atualizar">
                </form>
            </section>
    </main>
        <div class="navigation-options"><a href="professor_admin.php?id=<?= $professor['id'] ?>" class="btn-voltar">voltar</a></div>

</body>
</html>