document.addEventListener("DOMContentLoaded", function () {
    const navbarHTML = `
    
    <div class="navbar">
        <div id="logo">
            <a href="admin.php"><img src="../assets/img/logo.png" alt="Logo do Gerador de Gabarito"></a>
        </div>
    `;
  
    document.querySelector(".navbar").innerHTML = navbarHTML;
  });