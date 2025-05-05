<?php
require_once('../conex.php');
include('../protect.php');

// Inicia sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$conn = getConexao();
try {
    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
    
        $stmt = $conn->prepare("UPDATE disciplinas SET nome = :nome WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo "Disciplina atualizada com sucesso!";
            echo "<button type='button' class='btn btn-success'><a href='disciplinas_admin.php'>Voltar</a></button>";            exit();
        } else {
            echo "Erro ao atualizar disciplina.";
        }
    
    } else {
        echo "Método de requisição inválido.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

// Fechar a conexão
$conn = null;
?>