<?php
require_once('../conex.php');
include("../pesquisar_disc.php");
require_once('verificar_admin.php'); // Inclua a função de verificação
  verificarAdmin();
// Chama a função para verificar se o usuário é um administrador
include('../protect.php');


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/navbar.css" />
    <link rel="stylesheet" href="../assets/css/tabela-disciplinas.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <title>Disciplinas</title>
</head>

<body>
    <nav class="navbar"></nav>

    <main class="main-content">
        <section class="main-section-1">
            <div class="section-title">
                <h1>Lista de Disciplinas</h1>
            </div>

            <form method="POST" class="search-bar">
                <input type="text" name="buscar" placeholder="Pesquisar por nome ou disciplina" value="<?= htmlspecialchars($buscar ?? '') ?>">
                <button type="submit" class="btn-buscar">Buscar</button>
            </form>

                <div class="tabela">
                    <table class="tabela-dados">
                        <thead>
                            <tr>
                                <th>Disciplina</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->rowCount() > 0): ?>
                                <?php while ($user_data = $result->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user_data['nome']) ?></td>
                                        <td class="tabela-acoes">
                                            <a href="atualizar_disciplina.php?id=<?= $user_data['id'] ?>" class="btn-editar">Editar</a>
                                            <a href="excluir_disciplina.php?id=<?= $user_data['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="sem-dados">Nenhuma disciplina encontrada</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            

            <div class="navigation-options">
                <a href="admin.php">Voltar</a>
                <a href="cadastro_disciplina.php" class="btn-cadastrar">Cadastrar disciplina</a>
            </div>
        </section>
    </main>

</body>

</html>