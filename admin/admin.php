<?php
require_once('../conex.php'); // Inclua seu arquivo de conexão
include('../protect.php'); 
require_once('verificar_admin.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um administrador
verificarAdmin();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
</head>
<body>
    <h1>Bem-vindo ao Painel do Administrador, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
    <p>Aqui você pode gerenciar usuários, disciplinas, etc.</p>
    <a href="../function_sair.php">Sair</a>
    <a href="professor_admin.php">Gerenciar Professor</a>
    <a href="disciplinas_admin.php">Gerenciar Disciplina</a>
    <a href="../index.php">Ver como usuario</a>
</body>
</html>