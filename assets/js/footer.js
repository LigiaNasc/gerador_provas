document.addEventListener("DOMContentLoaded", function () {
  const footerHTML = `
    
    <div class="footer">
        <div class="footer-img"><img src="assets/img/icon.png" alt="Icon do Gerador de Gabarito"></div>
        <div class="footer-content">
            <div class="footer-section-1">
                <p class="footer-title">Desenvolvedores</p class="footer-title">
                <p><a href="https://www.instagram.com/marciolc_/" target="_blank">Mácio Gabriel Lopes Carvalho</a></p>
                <p><a href="https://github.com/LigiaNasc" target="_blank">Maria Lígia do Nascimento Souza</a></p>
                <p><a href="https://github.com/ogeraldinh" target="_blank">Geraldo Duarte de Medeiros Neto</a></p>
                <p><a href="https://www.instagram.com/davifreitt/" target="_blank">Davi Freitas Alves</a></p>
                <p><a href="http://instagram.com/_p.fla/" target="_blank">Paulo Flávio Quirino Neto</a></p>
            </div>
            <div class="footer-section-2">
                <p class="footer-title">Navegação</p class="footer-title">
                <p><a href="index.php">Início</a></p>
                <p><a href="professor.php">Professor</a></p>
                <p><a href="questoes,php">Banco de Questões</a></p>
            </div>
            <div class="footer-section-3">
                <p class="footer-title">Contatos</p class="footer-title">
                <p>email@gmail.com</p>
                <p>email@gmail.com</p>
                <p>+55 (85) 99999-9999</p>
                <p>+55 (85) 99999-9999</p>
            </div>
        </div>
    </div>
    
    `;

  document.querySelector(".footer").innerHTML = footerHTML;
});
