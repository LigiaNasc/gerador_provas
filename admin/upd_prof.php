<?php
require_once('../conex.php');
include('../protect.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $disciplina_id = $_POST['disciplina'];

        $conn = getConexao();

        // Verificar email duplicado
        $stmt_email = $conn->prepare('SELECT email FROM professores WHERE email = ? AND id != ?');
        $stmt_email->bindParam(1, $email, PDO::PARAM_STR);
        $stmt_email->bindParam(2, $id, PDO::PARAM_INT);
        $stmt_email->execute();
        $result_email = $stmt_email->fetch(PDO::FETCH_ASSOC);

        if ($result_email !== false) {
            echo "Este email já está cadastrado.";
            exit();
        }

        // Atualizar dados
        $stmt = $conn->prepare("UPDATE professores SET nome = :nome, email = :email, disciplina_id = :disciplina_id WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':disciplina_id', $disciplina_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Professor atualizado com sucesso!";
            echo "<button type='button'><a href='professor_admin.php'>Voltar</a></button>";
            exit();
        } else {
            echo "Erro ao atualizar professor.";
        }
    } else {
        echo "Método de requisição inválido.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

$conn = null;
?>
