<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
require_once('../conex.php'); // Inclua seu arquivo de conexão
include('../protect.php'); 
require_once('verificar_professor.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um Professor
verificarProfessor();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Professor</title>
</head>
<body>
    <h1>Bem-vindo ao Painel do Professor,  <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
    <p>Aqui você pode gerenciar Assuntos, Questões etc.</p>
    <a href="../function_sair.php">Sair</a>
    <a href="assunto_prof.php">Gerenciar Assuntos</a>
    <a href="questoes_prof.php">Gerenciar Questões</a>
    <a href="consultar_provas.php">Gerenciar Provas </a>
    <a href="../index.php">Ver como usuario</a>
</body>
</html>