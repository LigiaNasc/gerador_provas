<?php
  require_once('conex.php');
  include('function_login.php');

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
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

  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/index.css">
  <link rel="stylesheet" href="assets/css/footer.css">

  <title>Gerador de Provas</title>
</head>

<body>
  <nav class="navbar"></nav>

  <main class="main-content">
    <section class="main-section-1">

      <div class="section-title">
        <h1>O que é o Gerador de Provas?</h1>
      </div>

      <p class="">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi rem hic
        eligendi id. Perspiciatis, voluptates amet! Perspiciatis, saepe
        provident officiis placeat alias cupiditate delectus facilis eius.
        Aspernatur, iste. Rerum, deserunt.
      </p>
      <p class="">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque id
        minus facilis neque? Saepe ullam nostrum eius beatae eaque odit, eum,
        repellat sed error cum, vero assumenda expedita laudantium sint.
      </p>
      <p class="">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam adipisci
        quod excepturi eius nulla quae ex ad est consectetur, quidem possimus
        eum, unde voluptatem et soluta doloremque voluptate veritatis
        eligendi!
      </p>
      <p class="">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum
        consequuntur dolores, ducimus molestias nihil eveniet nisi repellat
        possimus placeat corrupti error, quibusdam at enim. Illum beatae
        maxime porro officia veritatis.
      </p>
      <p class="">
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam
        nesciunt quisquam illum suscipit possimus. Omnis, nesciunt iusto.
        Eligendi deserunt eius est labore debitis animi illo neque cupiditate!
        Itaque, aliquid molestiae.
      </p>
    </section>

    <section class="main-section-2">
      <div class="">
        <p class="">
          Provas de múltipla escolha:
          Geram perguntas com várias alternativas, sendo que apenas uma delas é correta.
        </p>
      </div>
      <div class="">
        <p class="">
          Correção Automatizada:
          Os sistemas de geradores de provas tem funcionalidades de correção automática.
        </p>
      </div>
      <div class="">
        <p class="">
          Disponibilidade Online:
          Os geradores de provas estão disponíveis online, permitindo fácil acesso a educadores e alunos.

      </div>
      <div class="">
        <p class="">
          Criação Rápida:
          O gerador de provas economiza o tempo que o professor gastaria criando questões manualmente.
        </p>
      </div>

      <a href="function_sair.php"><button>Sair</button></a>
    </section>
  </main>

  <section class="cta-section">

    <div class="cta-section-img">
      <img src="assets/img/icon.png" alt="">
    </div>

    <div class="cta-section-content">
      <div class="cta-section-1">
        <div class="section-title">
          <h2>REALIZE SUAS CONQUISTAS</h2>
        </div>
        <button><a href="cadastro_user.php">COMECE JÁ<img src="assets/img/seta.png" alt=""></a></button>
      </div>
      <div class="cta-section-2">
        <form action="" method="post">
          <img src="assets/img/v-logo.png" alt="">
          <input type="text" id="email" name="email" placeholder="Email" required>
          <input type="password" id="password" name="password" placeholder="Senha" required>
          <button>Entrar</button>
          <div>
            <a href="cadastro_user.php">Cadastre-se</a>
          </div>
          <?php echo "<p>" . htmlspecialchars($message) . "</p>"?> 
        </form>
      </div>
    </div>

  </section>



  <footer class="footer"></footer>

  <script src="assets/js/navbar.js"></script>
  <script src="assets/js/footer.js"></script>
</body>

</html>