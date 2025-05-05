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

        // Verifica se há questões vinculadas
        $stmt_check = $conn->prepare("SELECT COUNT(*) AS total FROM questoes WHERE professor_id = :id");
        $stmt_check->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['total'] > 0 && !$forcar) {
            echo "Não é possível excluir o professor. Existem questões vinculadas a ele.";
            echo "<br><a href='excluir_professor.php?id=$id&forcar=1'><button>Excluir mesmo assim</button></a>";
            echo "<br><button type='button'><a href='professor_admin.php'>Voltar</a></button>";
            exit();
        }

        // Se for exclusão forçada, remove as questões primeiro
        if ($forcar) {
            $stmt_delete_questoes = $conn->prepare("DELETE FROM questoes WHERE professor_id = :id");
            $stmt_delete_questoes->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_delete_questoes->execute();
        }

        // Agora exclui o professor
        $stmt = $conn->prepare("DELETE FROM professores WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Professor excluído com sucesso!";
            echo "<br><button type='button'><a href='professor_admin.php'>Voltar</a></button>";
            exit();
        } else {
            echo "Erro ao excluir o professor.";
        }

    } else {
        echo "ID do professor inválido.";
    }

} else {
    echo "ID do professor não fornecido.";
}
?>
