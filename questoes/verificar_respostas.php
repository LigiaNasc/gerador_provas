<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('conex.php');
include('protect.php');

$conn = getConexao();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resposta'])) {
    $respostas = $_POST['resposta'];
    echo "<h1>Resultado</h1>";

    foreach ($respostas as $questaoId => $alternativaId) {
        // Buscar se a alternativa marcada é correta
        $stmt = $conn->prepare("SELECT correta FROM alternativas WHERE id = :altId");
        $stmt->bindParam(':altId', $alternativaId);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && $resultado['correta']) {
            echo "<p>Questão {$questaoId}: <span style='color: green;'>Acertou!</span></p>";
        } else {
            echo "<p>Questão {$questaoId}: <span style='color: red;'>Errou!</span></p>";
        }
    }
} else {
    echo "<p>Nenhuma resposta recebida.</p>";
}
echo "<a href = 'questoes.php'>Voltar</a>"
?>
