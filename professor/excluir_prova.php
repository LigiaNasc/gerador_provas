<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php');
verificarProfessor();

$conn = getConexao();

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $provaId = (int) $_GET['id'];

    // Verifica se a prova pertence ao professor logado
    $verifica = $conn->prepare("
        SELECT 1
        FROM provas
        WHERE id = :id
          AND professor_id = :pid
    ");
    $verifica->execute([
        ':id'  => $provaId,
        ':pid' => $_SESSION['id'],
    ]);

    if ($verifica->rowCount() > 0) {
        try {
            $conn->beginTransaction();

            // 1) Deleta vínculos em prova_questoes
            $delQ = $conn->prepare("DELETE FROM prova_questoes WHERE prova_id = :id");
            $delQ->execute([':id' => $provaId]);

            // 2) Deleta a própria prova
            $delP = $conn->prepare("DELETE FROM provas WHERE id = :id");
            $delP->execute([':id' => $provaId]);

            $conn->commit();

            echo '<p>Prova excluída com sucesso!</p>';
            echo '<button type="button" class="btn btn-success">
                    <a href="consultar_provas.php">Voltar</a>
                  </button>';
        } catch (PDOException $e) {
            $conn->rollBack();
            echo '<p>Erro ao excluir prova: ' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<button type="button" class="btn btn-secondary">
                    <a href="consultar_provas.php">Voltar</a>
                  </button>';
        }
    } else {
        echo '<p>Prova não encontrada ou sem permissão.</p>';
        echo '<button type="button" class="btn btn-secondary">
                <a href="consultar_provas.php">Voltar</a>
              </button>';
    }
} else {
    echo '<p>ID da prova inválido.</p>';
    echo '<button type="button" class="btn btn-secondary">
            <a href="consultar_provas.php">Voltar</a>
          </button>';
}
?>
