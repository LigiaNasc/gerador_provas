<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php');
verificarProfessor();

$conn = getConexao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeProva   = trim($_POST['nome_prova']   ?? '');
    $cabecalho   = trim($_POST['cabecalho']   ?? '');
    $questoes    = $_POST['questoes']         ?? [];

    // Validações
    if ($nomeProva === '') {
        echo "<p>Nome da prova não pode estar vazio.</p>";
        exit;
    }
    if (empty($questoes)) {
        echo "<p>Você deve selecionar ao menos uma questão.</p>";
        exit;
    }

    try {
        // Inserir a prova com cabeçalho
        $stmt = $conn->prepare("
            INSERT INTO provas (professor_id, nome, cabecalho)
            VALUES (:professor_id, :nome, :cabecalho)
        ");
        $stmt->bindParam(':professor_id', $_SESSION['id']);
        $stmt->bindParam(':nome',         $nomeProva);
        $stmt->bindParam(':cabecalho',    $cabecalho);
        $stmt->execute();

        $provaId = $conn->lastInsertId();

        // Associar as questões à prova
        $stmtQ = $conn->prepare("
            INSERT INTO prova_questoes (prova_id, questao_id)
            VALUES (:prova_id, :questao_id)
        ");
        foreach ($questoes as $questaoId) {
            $stmtQ->bindParam(':prova_id',   $provaId);
            $stmtQ->bindParam(':questao_id', $questaoId);
            $stmtQ->execute();
        }

        echo "<p>Prova '<strong>{$nomeProva}</strong>' salva com sucesso! 
              <a href='professor.php'>Voltar ao menu</a></p>";
    } catch (PDOException $e) {
        echo "<p>Erro ao salvar prova: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>Requisição inválida.</p>";
}
?>
