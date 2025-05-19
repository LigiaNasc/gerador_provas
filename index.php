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
        Bem-vindo ao Gerador de Provas!
        Nossa plataforma foi criada para facilitar a vida de professores, coordenadores e educadores em geral. Aqui, você pode montar provas personalizadas em poucos minutos, escolhendo questões de um banco organizado por matérias e assuntos. Depois, basta gerar o arquivo em PDF, pronto para ser impresso ou distribuído digitalmente.
      </p>
      <p class="">
        Um gerador de provas é uma ferramenta, geralmente de software, usada para criar questões de provas ou exames. Esses geradores podem produzir diferentes tipos de questões, como múltipla escolha, dissertativas, verdadeiro ou falso, entre outras.
      </p>
      <p class="">
        Eles podem ser configurados para gerar provas com base em conteúdos específicos, ajustando o nível de dificuldade e a quantidade de questões, conforme as necessidades do usuário (como professores, escolas ou instituições de ensino).
      </p>
      <p class="">
        Sabemos o quanto o processo de elaborar avaliações pode ser demorado. Pensando nisso, desenvolvemos uma ferramenta intuitiva, com recursos que otimizam o tempo e aumentam a qualidade das provas. Escolha questões manualmente ou deixe o sistema montar uma prova aleatória para você — o controle está em suas mãos.
      </p>
    </section>

    <section class="main-section-2">
      <div class="">
        <p class="">
          <strong>Provas de múltipla escolha:</strong>
          Geram perguntas com várias alternativas, sendo que apenas uma delas é correta.
        </p>
      </div>
      <div class="">
        <p class="">
          <strong>Correção Automatizada:</strong>
          Os sistemas de geradores de provas tem funcionalidades de correção automática.
        </p>
      </div>
      <div class="">
        <p class="">
          <img src="assets/img/dude.png"alt="">
          <strong>Disponibilidade Online:</strong>
          Os geradores de provas estão disponíveis online, permitindo fácil acesso a educadores e alunos.
        </p>
      </div>
      <div class="">
        <p class="">
          <strong>Criação Rápida:</strong>
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
          <input type="text" id="email" name="email"placeholder="Email">
          <input type="password" id="password" name="password" placeholder="Senha">
          <button>Entrar</button>

          <div>
            <a href="esqueci_minha_senha.php">Esqueci minha senha</a>
            <a href="cadastro_user.php">Cadastre-se</a>
          </div>
        </form>
      </div>
    </div>

  </section>



  <footer class="footer"></footer>

  <script src="assets/js/navbar.js"></script>
  <script src="assets/js/footer.js"></script>
</body>

</html>