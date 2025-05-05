<?php 
require_once('../conex.php');
session_start();
require('verificar_admin.php');
verificarAdmin();

$conn = getConexao();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (filter_var($id, FILTER_VALIDATE_INT)) {
        // Verifica se há solicitação de exclusão forçada
        $forcar = isset($_GET['forcar']) && $_GET['forcar'] === '1';

        // Verifica se há assuntos vinculados à disciplina
        $stmt_check = $conn->prepare("SELECT COUNT(*) AS total FROM assuntos WHERE disciplina_id = :id");
        $stmt_check->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['total'] > 0 && !$forcar) {
            echo "Não é possível excluir esta disciplina. Existem assuntos vinculados a ela.";
            echo "<br><a href='excluir_disciplina.php?id=$id&forcar=1'><button>Excluir mesmo assim</button></a>";
            echo "<br><button type='button'><a href='disciplina_admin.php'>Voltar</a></button>";
            exit();
        }

        // Se for exclusão forçada, apaga os assuntos primeiro
        if ($forcar) {
            $stmt_delete_assuntos = $conn->prepare("DELETE FROM assuntos WHERE disciplina_id = :id");
            $stmt_delete_assuntos->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_delete_assuntos->execute();
        }

        // Agora exclui a disciplina
        $stmt = $conn->prepare("DELETE FROM disciplinas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Disciplina excluída com sucesso!";
            echo "<br><button type='button'><a href='disciplina_admin.php'>Voltar</a></button>";
            exit();
        } else {
            echo "Erro ao excluir a disciplina.";
        }

    } else {
        echo "ID da disciplina inválido.";
    }

} else {
    echo "ID da disciplina não fornecido.";
}
?>
