<?php
function verificarProfessor() {
    // Verifica se o usuário está logado e se é um professor
    if (!isset($_SESSION['id']) || !isset($_SESSION['tipo_id']) || $_SESSION['tipo_id'] != 2) {
        // Se não for um professor, redireciona para a página de login
        error_log("Acesso negado: Usuário não é um professor ou não está logado.");
        header("Location:../index.php");
        exit();
    }
}
?>