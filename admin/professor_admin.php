<?php
require_once('../conex.php');
include('../protect.php');
// Inicia sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('verificar_admin.php'); // Verifica se o usuário é administrador
verificarAdmin();

$conn = getConexao();

// Captura termo de busca
$busca = $_POST['busca'] ?? '';

// Monta SQL com LEFT JOIN para incluir professores sem disciplina
$sql = "
  SELECT 
    p.id, 
    p.nome, 
    p.email, 
    d.nome AS disciplinas_nome
  FROM professores p
  LEFT JOIN disciplinas d ON p.disciplina_id = d.id
";
if (!empty($busca)) {
    $sql .= " WHERE p.nome LIKE :busca OR d.nome LIKE :busca";
}

$stmt = $conn->prepare($sql);
if (!empty($busca)) {
    $param = "%{$busca}%";
    $stmt->bindParam(':busca', $param);
}
$stmt->execute();
$result = $stmt;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/navbar.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <link rel="stylesheet" href="../assets/css/tabela.css" />
    <title>Professores</title>
</head>
<body>
    <nav class="navbar"></nav>
    <main class="container">
        <h1>Lista de Professores</h1>
        
        <form method="POST" class="search-form">
            <input  type="text" name="busca" placeholder="Pesquisar por nome ou disciplina"  value="<?= htmlspecialchars($busca) ?>"  >
            <button type="submit" class="btn-buscar">Buscar</button>
        </form>
        
        <div class="table-responsive">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Disciplina</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->rowCount() > 0): ?>
                    <?php while ($user = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['nome']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                              <?= htmlspecialchars($user['disciplinas_nome'] ?: 'Sem disciplina') ?>
                            </td>
                            <td class="acoes">
                                <a href="atualizar_prof.php?id=<?= $user['id'] ?>" class="btn-editar">Editar</a>
                                <a href="excluir_professor.php?id=<?= $user['id'] ?>"
                                   class="btn-excluir"
                                   onclick="return confirm('Tem certeza que deseja excluir?')">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="sem-dados">Nenhum professor encontrado</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div>
            <a href="cadastro_professor.php" class="btn-cadastro">Cadastrar professor</a>
        </div>
        <a href="admin.php">Voltar</a>
    </main>

    <footer class="footer"></footer>
</body>
</html>
