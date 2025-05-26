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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/flat-navbar.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/tabela-questoes.css" />
  <title>Consultar Questões</title>
</head>
<body>
  <nav class="navbar"></nav>
  <h1>Consultar Questões</h1>
  <main class="main-content">
    <section class="main-section-1">
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
        <div><button type="submit">Buscar</button></div>
      </form>
    </section>

    <section class="main-section-2">
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
              echo "<h2>Questões encontradas:</h2>";
              // Form único para seleção e envio das questões
              echo "<form method='POST' action='cadastro_prova.php' class='tabela-questoes'>";
              echo "<table cellpadding='5' class='table'>";
              echo "<tr>
                      <th>Selecionar</th>
                      <th>Enunciado</th>
                      <th>Ações</th>
                    </tr>";
              while ($q = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $id  = htmlspecialchars($q['id']);
                  $enc = htmlspecialchars($q['enunciado']);
                  echo "<tr>
                          <td class='table-checkbox'><input type='checkbox' name='questoes[]' value='$id'></td>
                          <td>$enc</td>
                          <td class='table-actions'>
                            <a class='btn-edit' href='atualizar_questoes.php?id=$id'>Editar</a>
                            <a class='btn-delete' href='excluir_questao.php?id=$id' onclick=\"return confirm('Excluir?')\">Excluir</a>
                          </td>
                        </tr>";
              }
              echo "</table>";
              echo "<br>";
              echo "<div><button type='submit'>Próximo: Inserir Cabeçalho da Prova</button></div>";
              echo "</form>";
          } else {
              echo "<p>Nenhuma questão encontrada para esses filtros.</p>";
          }
      }
      ?>
    </section>
  </main>
        <div class="navigation-options">
      <a href="professor.php">Voltar</a>
      <a href="cadastro_questoes.php">Cadastrar Questão</a>
    </div>

  <script src="../assets/js/prof-navbar.js"></script>
</body>
</html>
