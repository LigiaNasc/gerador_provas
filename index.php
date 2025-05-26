<?php
require_once('conex.php');
include('login/function_login.php');

if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/config/main.css">
  <link rel="stylesheet" href="assets/css/navbar/flat-navbar.css">
  <link rel="stylesheet" href="assets/css/login/index.css">
  <link rel="stylesheet" href="assets/css/footer/footer.css">

  <title>Gerador de Provas</title>

  <style>
    .error-message {
      color: red;
      font-weight: bold;
      margin: 1rem auto;
      text-align: center;
    }

    .main-section-2 img {
      max-width: 100px;
      display: block;
      margin: 0 auto 10px;
    }

    .main-section-2 p {
      text-align: center;
      margin-bottom: 1.5rem;
    }
  </style>
</head>

<body>
  <nav class="navbar"></nav>

  <main class="main-content">
    <section class="main-section-1">
      <div class="section-title">
        <h1>O que é o Gerador de Provas?</h1>
      </div>

      <p>
        Bem-vindo ao Gerador de Provas! Nossa plataforma foi criada para facilitar a vida de educadores. Com ela,
        você pode montar provas personalizadas em poucos minutos, escolhendo questões de um banco organizado por
        matérias e assuntos.
      </p>

      <p>
        O gerador permite gerar questões de múltipla escolha, dissertativas, verdadeiro ou falso, entre outras.
        Configure nível de dificuldade e quantidade de questões conforme sua necessidade.
      </p>

      <p>
        Otimize seu tempo com uma interface intuitiva e ferramentas de geração automática de avaliações. Escolha questões
        manualmente ou deixe o sistema montar uma prova aleatória para você!
      </p>
    </section>

    <section class="main-section-2">
      <div>
        <p><strong>Provas de múltipla escolha:</strong> Escolha entre diversas alternativas com apenas uma correta.</p>
      </div>
      <div>
        <p><strong>Correção automatizada:</strong> Geração de gabaritos e correção rápida com o sistema integrado.</p>
      </div>
      <div>
        <img src="assets/img/dude.png" alt="Ícone de disponibilidade">
        <p><strong>Disponibilidade online:</strong> Acesse sua conta e provas de qualquer lugar com internet.</p>
      </div>
      <div>
        <p><strong>Criação rápida:</strong> Economize o tempo que você gastaria criando questões manualmente.</p>
      </div>

      <a href="login/function_sair.php"><button>Sair</button></a>
    </section>
  </main>

  <section class="cta-section">
    <div class="cta-section-img">
      <img src="assets/img/icon.png" alt="Logo Gerador de Provas">
    </div>

    <div class="cta-section-content">
      <div class="cta-section-1">
        <div class="section-title">
          <h2>REALIZE SUAS CONQUISTAS</h2>
        </div>
        <button><a href="login/cadastro_user.php">COMECE JÁ <img src="assets/img/seta.png" alt=""></a></button>
      </div>

      <div class="cta-section-2">
        <form action="login/function_login.php" method="post">
          <img src="assets/img/v-logo.png" alt="Logo da plataforma">

          <?php if (!empty($_SESSION['message'])): ?>
            <p class="error-message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></p>
          <?php endif; ?>

          <input type="email" id="email" name="email" placeholder="Email" required>
          <input type="password" id="password" name="password" placeholder="Senha" required>
          <button type="submit">Entrar</button>

          <div>
            <a href="login/esqueci_minha_senha.php">Esqueci minha senha</a>
            <a href="login/cadastro_user.php">Cadastre-se</a>
          </div>
        </form>
      </div>
    </div>
  </section>

  <footer class="footer"></footer>
  
  <?php if (isset($_SESSION['id'])): ?>
    <script src="assets/js/navbar.js"></script>
  <?php endif; ?>
  <?php if (!isset($_SESSION['id'])): ?>
  <script src="assets/js/flat-navbar.js"></script>
<?php endif; ?>


  
  <script src="assets/js/footer.js"></script>
</body>

</html>
