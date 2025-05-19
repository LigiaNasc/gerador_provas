<?php
require_once('../conex.php'); // Inclua seu arquivo de conexão
require_once('verificar_admin.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um administrador
verificarAdmin();
include('../protect.php'); 

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
    <link rel="stylesheet" href="../assets/css/navbar.css" />
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <title>Painel do Administrador</title>
</head>
<body>
    <main class="main-content">
        <section class="main-section-1">
        <h1>Bem-vindo ao Painel do Administrador, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
        <p>Aqui você pode gerenciar usuários, disciplinas, etc.</p>
        <div class="admin-options">
            <a href="../function_sair.php">Sair</a>
            <a href="professor_admin.php">Gerenciar Professor</a>
            <a href="disciplinas_admin.php">Gerenciar Disciplina</a>
            <a href="../index.php">Ver como usuario</a>
        </div>
        </section>
    </main>
</body>
</html>