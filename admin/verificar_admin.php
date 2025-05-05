<?php
function verificarAdmin() {
    // Verifica se o usuário está logado e se é um administrador
    if (!isset($_SESSION['id']) || !isset($_SESSION['tipo_id']) || $_SESSION['tipo_id'] != 1) {
        // Se não for um administrador, redireciona para a página de login
        header("Location:../index.php");
        exit();
    }
}
?>