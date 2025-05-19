<?php
  require_once('conex.php');
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
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <title>Esqueci minha senha</title>
</head>
  <body>
    <nav class="navbar"></nav>

    <main class="main-content">
        <section class="main-section-1">
          <div class="section-title">
            <h1>Lembou a senha?</h1>
          </div>
            <button id="btn-title"><a href="login.php">Voltar à página de login<img src="assets/img/seta.png" alt=""></a></button>
        </section>
        <section class="main-section-2">
            <form action="recuperar_senha.php" method="POST" class="form-login">
                <img src="assets/img/v-logo.png" alt="">

                <input type="text" id="email" name="email"
                placeholder="Email">
               
                <button type="submit">Recuperar Senha</button>
                
                <!-- <?php echo "<p id='senha-incorreta'>" . htmlspecialchars($message) . "</p>"?> -->
            </form>
        </section>
    </main>

    
    <footer class="footer"></footer>

    <script src="assets/js/navbar.js"></script>
    <script src="assets/js/footer.js"></script>
    

</body>
</html>