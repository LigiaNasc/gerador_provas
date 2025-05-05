document.addEventListener("DOMContentLoaded", function() {
    const navbarHTML = `  
    <div id="logo">
      <img src="assets/img/logo.svg" alt="logo do nosso site" />
    </div>
    <ul>
      <li><a href="index.php" class="inicio-select">Início</a></li>
      <li><a href="professor.php" class="professor-select">Professor</a></li>
      <li><a href="questoes.php" class="questoes-select">Questões</a></li>
      <li><a href="prova.php" class="prova-select">Gerar Prova</a></li>
      <li><a href="login.php" class="login-select">Entrar</a></li>

    </ul>`;

  document.querySelector(".navbar").innerHTML = navbarHTML
});