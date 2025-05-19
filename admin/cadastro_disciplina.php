<?php

  require_once('../conex.php');
  $pdo = getConexao(); // Chama a função para obter a conexão
  require_once('verificar_admin.php'); // Inclua a função de verificação
  verificarAdmin();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
  include('function_cad_disc.php');
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
      rel="stylesheet"
    />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/cadastro.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>Página de Cadastro de Disciplinas</title>
  </head>
  <body>
    <nav class="navbar"></nav>
    <main class="main-content">
  
      <section class="main-section-1">
        <div class="section-title">
          <h1 class="title">Cadastro</h1>
        </div>
        <p>Infome os dados para realizar o cadastro da disciplina no sistema.</p>
      </section>

        <?php if (!empty($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <section class="main-section-2">
          <form action="" method="POST">
            <img src="../assets/img/logo.png" alt="">
            <label for="nome">Nome da disciplina :</label>
            <input type="text" id="nome" name="nome" required>
            <button type="submit">Cadastrar</button>
          </form>
        </section>


    </main>
      <div class="navigation-options"><a href="disciplinas_admin.php">Voltar</a></div>

    

  </body>
</html>
