<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../conex.php');
include('../protect.php');
include("../pesquisar_ass.php");
require_once('verificar_professor.php'); // Inclua a função de verificação

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
</head>
<body>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/navbar.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <link rel="stylesheet" href="../assets/css/tabela.css" />
    <title>Lista de Assuntos</title>
</head>
<body>
    <nav class="navbar"></nav>
    
    <main class="container">
        <h1>Lista de Assuntos</h1>
        
        <form method="POST" class="search-form">
            <input type="text" name="buscar" placeholder="Pesquisar por assunto ou disciplina" value="<?= htmlspecialchars($busca) ?>">
            <button type="submit" class="btn-buscar">Buscar</button>
        </form>
        
        <div class="table-responsive">
            <table class="tabela-dados">
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
                                <td class="acoes">
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
            <a href="cadastro_assunto.php" class="btn-cadastrar">cadastrar</a>
        </div>
        <a href="professor.php">voltar</a>
    </main>

    <footer class="footer"></footer>

    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/footer.js"></script>
</body>
</html>