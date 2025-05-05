<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php');
verificarProfessor();
$conn = getConexao();

// Pega o array de questões selecionadas
$selecionadas = $_POST['questoes'] ?? [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Prova</title>
</head>
<body>
  <h1>Cadastro de Prova</h1>

  <?php if (empty($selecionadas)): ?>
    <p><strong>Erro:</strong> Nenhuma questão selecionada.</p>
    <p><a href="questoes_prof.php">Voltar para seleção de questões</a></p>
    <?php exit; ?>
  <?php endif; ?>

  <form method="POST" action="salvar_prova.php">
    <!-- Nome da prova -->
    <label for="nome_prova">Nome da Prova:</label><br>
    <input type="text" name="nome_prova" id="nome_prova"><br><br>

    <!-- Cabeçalho da prova -->
    <label for="cabecalho">Cabeçalho (texto que aparecerá no topo):</label><br>
    <textarea name="cabecalho" id="cabecalho" rows="4" cols="50"></textarea>
    <br><br>

    <h3>Questões Selecionadas:</h3>

    <?php
    // Para cada ID, buscar e exibir dados
    $stmt = $conn->prepare("
      SELECT q.id, q.enunciado, d.nome AS disciplina, a.nome AS assunto
      FROM questoes q
      JOIN disciplinas d ON q.disciplina_id = d.id
      JOIN assuntos    a ON q.assunto_id    = a.id
      WHERE q.id = :id
    ");

    foreach ($selecionadas as $qid) {
        $stmt->execute(['id' => $qid]);
        if ($q = $stmt->fetch(PDO::FETCH_ASSOC)) {
  
            echo "<input type='hidden' name='questoes[]' value='{$q['id']}'>";
            echo "<strong>Disciplina:</strong> {$q['disciplina']} |
                  <strong>Assunto:</strong> {$q['assunto']}<br>";
            echo "<strong>Enunciado:</strong> {$q['enunciado']}<br><br>";
        }
    }
    ?>

    <button type="submit">Salvar Prova</button>
  </form>

  <br>
  <a href="professor.php">Voltar ao menu principal</a>
</body>
</html>
