<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../conex.php');
include(__DIR__ .'/../protect.php');
include(__DIR__ ."/../pesquisar_ass.php");
require_once(__DIR__ .'/verificar_professor.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um Professor
verificarProfessor();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/navbar/flat-navbar.css" />
    <link rel="stylesheet" href="../assets/css/config/main.css" />
    <link rel="stylesheet" href="../assets/css/tables/tabela-1.css" />
    <title>Lista de Assuntos</title>
</head>
<body>
    <nav class="navbar"></nav>
    
    <main class="main-content">
        <h1>Lista de Assuntos</h1>
        
        <form method="POST" class="search-bar">
            <input type="text" name="buscar" placeholder="Pesquisar por assunto ou disciplina" value="<?= htmlspecialchars($busca) ?>">
            <button type="submit" class="btn-buscar">Buscar</button>
        </form>
        
        <div class="table">
            <table class="table-date">
                <thead>
                    <tr>
                        <th>Assunto</th>
                        <th>Disciplina</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->rowCount() > 0): ?>
                        <?php while ($assunto = $result->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                               
                                <td><?= htmlspecialchars($assunto['nome']) ?></td>
                                <td><?= htmlspecialchars($assunto['disciplinas_nome']) ?></td>
                                <td class="table-actions">
                                    <a href="atualizar_assunto.php?id=<?= $assunto['id'] ?>" class="btn-editar">Editar</a>
                                    <a href="excluir_assunto.php?id=<?= $assunto['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="1" class="sem-dados">Nenhuma disciplina encontrada</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="navigation-options">
            <a href="professor.php">voltar</a>
            <a href="cadastro_assunto.php" class="btn-cadastrar">cadastrar</a>
        </div>
    </main>

    <script src="../assets/js/prof-navbar.js"></script>
</body>
</html>