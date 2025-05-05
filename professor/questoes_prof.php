<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php');
verificarProfessor();
$conn = getConexao();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Consultar Questões</title>
</head>
<body>
  <h1>Consultar Questões</h1>

  <!-- Form de filtros -->
  <form method="POST" action="questoes_prof.php">
    <fieldset>
      <legend>Disciplinas</legend>
      <?php
      $stmt = $conn->query("SELECT id, nome FROM disciplinas");
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo "<label><input type='checkbox' name='disciplinas[]' value='{$row['id']}'> {$row['nome']}</label><br>";
      }
      ?>
    </fieldset>
    <fieldset>
      <legend>Assuntos</legend>
      <?php
      $stmt = $conn->query("SELECT id, nome FROM assuntos");
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo "<label><input type='checkbox' name='assuntos[]' value='{$row['id']}'> {$row['nome']}</label><br>";
      }
      ?>
    </fieldset>
    <button type="submit">Buscar</button>
  </form>
  <a href="cadastro_questoes.php">Cadastrar Questão</a>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $disciplinas = $_POST['disciplinas'] ?? [];
      $assuntos     = $_POST['assuntos']     ?? [];

      // Monta consulta dinâmica
      $query  = "SELECT * FROM questoes WHERE 1=1";
      $params = [];

      if (!empty($disciplinas)) {
          $ph = implode(',', array_fill(0, count($disciplinas), '?'));
          $query .= " AND disciplina_id IN ($ph)";
          $params = array_merge($params, $disciplinas);
      }

      if (!empty($assuntos)) {
          $ph2 = implode(',', array_fill(0, count($assuntos), '?'));
          $query .= " AND assunto_id IN ($ph2)";
          $params = array_merge($params, $assuntos);
      }

      $stmt = $conn->prepare($query);
      $stmt->execute($params);

      if ($stmt->rowCount() > 0) {
          echo "<h2>Questões Encontradas:</h2>";

          // Form único para seleção e envio das questões
          echo "<form method='POST' action='cadastro_prova.php'>";
          echo "<table border='1' cellpadding='5'>";
          echo "<tr><th>Selecionar</th><th>Enunciado</th><th>Ações</th></tr>";

          while ($q = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $id  = htmlspecialchars($q['id']);
              $enc = htmlspecialchars($q['enunciado']);
              echo "<tr>
                      <td><input type='checkbox' name='questoes[]' value='$id'></td>
                      <td>$enc</td>
                      <td>
                        <a href='atualizar_questoes.php?id=$id'>Editar</a> |
                        <a href='excluir_questao.php?id=$id' onclick=\"return confirm('Excluir?')\">Excluir</a>
                      </td>
                    </tr>";
          }

          echo "</table>";
          echo "<br>";
          echo "<button type='submit'>Próximo: Inserir Cabeçalho da Prova</button>";
          echo "</form>";
      } else {
          echo "<p>Nenhuma questão encontrada para esses filtros.</p>";
      }
  }
  ?>
</body>
</html>
