<?php
  require_once('conex.php');
  include('function_login.php');

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
  <title>Página de login</title>
</head>
  <body>
    <nav class="navbar"></nav>

    <main class="main-content">
        
        <section>
          <div class="title">
            <h1>Não possui cadastro?</h1>
          </div>
            <button id="btn-title"><a href="cadastro_user.php">Cadastrar</a></button>
        </section>
        
        <section>
            <form action="" method="POST" class="form-login">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>

                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>

                <button style=" border: none;
    border-radius: 20px;
    padding: 0 30px;
    font-weight: 600;
    font-size: 0.7em;
    background-color: #08486B;
    color: #fff;
    "  type="submit">Entrar</button>
                </div>
               <?php echo "<p style='font-size: 14px; color: red; text-align: center; margin-top: 10px;'>" . htmlspecialchars($message) . "</p>"; ?>


            </form>
        </section>
    </main>

    
    <footer class="footer"></footer>

    <script src="assets/js/navbar.js"></script>
    <script src="assets/js/footer.js"></script>
    

</body>
</html>