<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('conex.php');
include('protect.php');

$conn = getConexao();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['questoes_selecionadas'])) {
    $questoesIds = $_POST['questoes_selecionadas'];

    // Proteção: transformar em (?,?,?,...) para bind
    $placeholders = implode(',', array_fill(0, count($questoesIds), '?'));

    $stmt = $conn->prepare("SELECT * FROM questoes WHERE id IN ($placeholders)");
    $stmt->execute($questoesIds);

    echo "<h1>Responder Questões Selecionadas</h1>";

    echo "<form method='POST' action='verificar_respostas.php'>";

    while ($questao = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div style='margin-bottom: 20px;'>";
        echo "<p><strong>{$questao['enunciado']}</strong></p>";

        // Buscar alternativas
        $stmtAlt = $conn->prepare("SELECT * FROM alternativas WHERE questao_id = ?");
        $stmtAlt->execute([$questao['id']]);

        while ($alt = $stmtAlt->fetch(PDO::FETCH_ASSOC)) {
            echo "<label>";
            echo "<input type='radio' name='resposta[{$questao['id']}]' value='{$alt['id']}'> {$alt['texto']}";
            echo "</label><br>";
        }

        echo "</div>";
    }

    echo "<button type='submit'>Enviar Respostas</button>";
    echo "</form>";
} else {
    echo "<p>Nenhuma questão selecionada!</p>";
}
?>
