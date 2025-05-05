<?php

    require_once('conex.php');
  $pdo = getConexao(); // Chama a função para obter a conexão
  include('function_user.php');

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
    
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/cadastro.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
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
    <label for="nome">Nome completo:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>

    <label for="c-password">Confirme a senha:</label>
    <input type="password" id="c-password" name="c-password" required>

    <button type="submit">Cadastrar</button>

</form><br>
<a href="login.php"><button>já possuo conta</button></a>
    </section>
    

</main>

    

    <footer class="footer"></footer>
    <script src="assets/js/navbar.js"></script>
    <script src="assets/js/footer.js"></script>
  </body>
</html>
