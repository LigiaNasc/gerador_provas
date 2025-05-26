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

    <link rel="stylesheet" href="../assets/css/config/main.css">
    <link rel="stylesheet" href="../assets/css/navbar/navbar.css">
    <link rel="stylesheet" href="../assets/css/login/cadastro.css">
    <link rel="stylesheet" href="../assets/css/footer/footer.css">
    <title>Editar Disciplina</title>
</head>

<body>
    <main class="main-content">
        <section class="main-section-1">
            <div class="section-title">
                <h1>Editar Disciplina</h1>
            </div>
            <p>Infome os dados para realizar a alteração da disciplina no sistema.</p>
        </section>

        <section class="main-section-2">
            <form action="upd_disc.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($disciplinas['id']); ?>">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($disciplinas['nome']); ?>" required>
                <input type="submit" value="Atualizar">
                </form>
        </section>
    </main>


    <div class="navigation-options"><a href="disciplinas_admin.php?id=<?= $disciplinas['id'] ?>" class="btn-voltar">voltar</a></div>
</body>

</html>