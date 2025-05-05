<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../conex.php'); // Inclua seu arquivo de conexão
include('../protect.php');
require_once('verificar_professor.php');// Inclua a função de verificação

// Chama a função para verificar se o usuário é um administrador
verificarProfessor();
include('function_cad_ass.php');

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
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/cadastro.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>Página de Cadastro</title>
</head>

<body>
    <nav class="navbar"></nav>
    <main class="main-content">

        <section>
            <h1 class="title">Cadastro</h1>
            <p>Infome seus dados para realizar o cadastro no sistema.</p>
        </section>

        <section>
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="" method="POST" class="form-login">
                <label for="nome">Nome do assunto</label>
                <input type="text" id="nome" name="nome" required>

                <label for="disciplina">Disciplina que leciona:</label>
                <select id='disciplina' name="disciplina">
                    <?php
                    $query = $pdo->query("SELECT id, nome FROM disciplinas ORDER BY nome");
                    while ($reg = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $reg["id"] . '">' . $reg["nome"] . '</option>';
                    }
                    ?>
                </select>
                <button type="submit">Cadastrar</button>

            </form><br>
            <a href="assunto_prof.php"><button>voltar</button></a>
        </section>


    </main>



    <footer class="footer"></footer>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/footer.js"></script>
</body>

</html>