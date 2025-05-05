<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php');
verificarProfessor();

$conn = getConexao();

// Pega o ID da prova
$provaId = $_GET['id'] ?? '';

if (!filter_var($provaId, FILTER_VALIDATE_INT)) {
    header("Location: consultar_provas.php?msg=" . urlencode("Prova inválida."));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados enviados
    $novoNome      = trim($_POST['nome_prova']   ?? '');
    $novoCabecalho = trim($_POST['cabecalho']    ?? '');
    $questoes      = $_POST['questoes']         ?? [];

    // Validações
    if ($novoNome === '') {
        header("Location: editar_prova.php?id={$provaId}&msg=" . urlencode("Nome da prova não pode ficar vazio"));
        exit;
    }
    if (empty($questoes)) {
        header("Location: editar_prova.php?id={$provaId}&msg=" . urlencode("Selecione ao menos uma questão"));
        exit;
    }

    try {
        $conn->beginTransaction();

        // 1) Atualiza título e cabeçalho
        $upd = $conn->prepare("
            UPDATE provas
               SET nome      = :nome,
                   cabecalho = :cabecalho
             WHERE id = :id
               AND professor_id = :pid
        ");
        $upd->execute([
            ':nome'      => $novoNome,
            ':cabecalho' => $novoCabecalho,
            ':id'        => $provaId,
            ':pid'       => $_SESSION['id'],
        ]);

        // 2) Remove vínculos antigos
        $del = $conn->prepare("DELETE FROM prova_questoes WHERE prova_id = :id");
        $del->execute([':id' => $provaId]);

        // 3) Insere vínculos atuais
        $ins = $conn->prepare("
            INSERT INTO prova_questoes (prova_id, questao_id)
            VALUES (:pid, :qid)
        ");
        foreach ($questoes as $qid) {
            $ins->execute([
                ':pid' => $provaId,
                ':qid' => $qid,
            ]);
        }

        $conn->commit();
        header("Location: consultar_provas.php?msg=" . urlencode("Prova atualizada com sucesso"));
        exit;

    } catch (PDOException $e) {
        $conn->rollBack();
        header("Location: editar_prova.php?id={$provaId}&msg=" . urlencode("Erro: " . $e->getMessage()));
        exit;
    }
}

// GET: exibe formulário

// Busca prova (mantém filtro de dono)
$stmt = $conn->prepare("
    SELECT nome, cabecalho 
      FROM provas 
     WHERE id = :id
       AND professor_id = :pid
");
$stmt->execute([
    ':id'  => $provaId,
    ':pid' => $_SESSION['id'],
]);
$prova = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$prova) {
    header("Location: consultar_provas.php?msg=" . urlencode("Prova não encontrada ou sem permissão"));
    exit;
}

// Carrega vínculos atuais
$stmt = $conn->prepare("SELECT questao_id FROM prova_questoes WHERE prova_id = :id");
$stmt->execute([':id' => $provaId]);
$selIds = array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN, 0));

// **Carrega todas as questões do sistema** (sem filtrar por professor)
$stmt = $conn->prepare("
    SELECT q.id, q.enunciado, d.nome AS disciplina, a.nome AS assunto
      FROM questoes q
 LEFT JOIN disciplinas d ON q.disciplina_id = d.id
 LEFT JOIN assuntos    a ON q.assunto_id    = a.id
  ORDER BY d.nome, a.nome
");
$stmt->execute();
$allQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Prova</title>
</head>
<body>
  <h1>Editar Prova</h1>

  <?php if (isset($_GET['msg'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_GET['msg']) ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <label for="nome_prova">Nome da Prova:</label><br>
    <input type="text" name="nome_prova" id="nome_prova"
           value="<?= htmlspecialchars($prova['nome']) ?>"><br><br>

    <label for="cabecalho">Cabeçalho:</label><br>
    <textarea name="cabecalho" id="cabecalho" rows="4" cols="50"><?= 
      htmlspecialchars($prova['cabecalho']) 
    ?></textarea><br><br>

    <h3>Questões:</h3>
    <button type="button" id="marcarTodas">Marcar Todas</button>
    <button type="button" id="desmarcarTodas">Desmarcar Todas</button>
    <br><br>

    <?php foreach ($allQuestoes as $q): 
        $checked = in_array((int)$q['id'], $selIds) ? 'checked' : '';
    ?>
      <div style="margin-bottom:12px;">
        <label>
          <input type="checkbox" name="questoes[]" value="<?= $q['id'] ?>"
                 <?= $checked ?>>
          <strong>[<?= htmlspecialchars($q['disciplina']) ?> – 
                   <?= htmlspecialchars($q['assunto']) ?>]</strong><br>
          <?= nl2br(htmlspecialchars($q['enunciado'])) ?>
        </label>
      </div>
    <?php endforeach; ?>

    <button type="submit">Salvar Alterações</button>
    <a href="consultar_provas.php" style="margin-left:12px;">Cancelar</a>
  </form>

  <script>
    document.getElementById('marcarTodas')
      .addEventListener('click', ()=> {
        document.querySelectorAll('input[name="questoes[]"]')
                .forEach(cb=>cb.checked=true);
      });
    document.getElementById('desmarcarTodas')
      .addEventListener('click', ()=> {
        document.querySelectorAll('input[name="questoes[]"]')
                .forEach(cb=>cb.checked=false);
      });
  </script>
</body>
</html>
