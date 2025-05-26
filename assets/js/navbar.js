document.addEventListener("DOMContentLoaded", function () {
    const navbarHTML = `
    
    <div class="navbar">
        <div id="logo">
            <a href="index.php"><img src="assets/img/logo.png" alt="Logo do Gerador de Gabarito"></a>
        </div>
        <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="pag-professor.php">Professores</a></li>
            <li><a href="questoes/questoes.php">Questões</a></li>
            <li><a href="questoes/prova.php">Gerar Prova</a></li>
        </ul>
    </div>
    
    `;
  
    document.querySelector(".navbar").innerHTML = navbarHTML;
  });