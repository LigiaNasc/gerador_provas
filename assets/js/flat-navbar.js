document.addEventListener("DOMContentLoaded", function () {
    const navbarHTML = `
    
    <div class="navbar">
        <div id="logo">
            <a href="index.php"><img src="assets/img/logo.png" alt="Logo do Gerador de Gabarito"></a>
        </div>
        <ul>
            <li><a href="login/login.php">Entrar</a></li>
        </ul>
    </div>
    
    `;
  
    document.querySelector(".navbar").innerHTML = navbarHTML;
  });