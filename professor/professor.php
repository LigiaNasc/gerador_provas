<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
require_once('../conex.php'); // Inclua seu arquivo de conexão
include('../protect.php'); 
require_once('verificar_professor.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um Professor
verificarProfessor();
}
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

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/flat-navbar.css" />
    <link rel="stylesheet" href="../assets/css/panel.css">
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <title>Painel do Professor</title>
</head>
<body>
    <nav class="navbar"></nav>
    <main class="main-content">
        <section class="main-section-1">
            <h1>Bem-vindo ao Painel do Professor,  <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
            <p>Aqui você pode gerenciar Assuntos, Questões etc.</p>

            <div class="panel-options">
                <div>
                    <a href="assunto_prof.php">
                        <img src="../assets/img/book-icon.png" alt="">
                        Gerenciar Assuntos</a>
                </div>
                <div>
                    <a href="questoes_prof.php">
                        <img src="../assets/img/book-icon.png" alt="">
                        Gerenciar Questões</a>
                </div>
                <div>
                    <a href="consultar_provas.php">
                        <img src="../assets/img/book-icon.png" alt="">
                        Gerenciar Provas </a>
                </div>
                
            </div>
            <div class="navigation-options">
                <a href="../login/function_sair.php">Sair</a>
                <a href="../index.php">Ver como usuario</a>
            </div>
        </section>
    </main>

    <script src="../assets/js/prof-navbar.js"></script>
</body>
</html>