<?php 
require_once('../conex.php'); // Ajuste o caminho se necessário

session_start(); // Inicia a sessão
require('verificar_admin.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um administrador
verificarAdmin(); 

$conn = getConexao(); // Certifique-se de que a conexão está correta

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica se o ID é um número inteiro
    if (filter_var($id, FILTER_VALIDATE_INT)) {
        // Iniciar a exclusão do professor
        $stmt = $conn->prepare("DELETE FROM disciplinas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Use bindParam para PDO

        // Verificar se a execução foi bem-sucedida
        if ($stmt->execute()) {
            // Redireciona após a exclusão
            echo'Disciplina Excluida com sucesso';
            echo "<button type='button' class='btn btn-success'><a href='disciplinas_admin.php'>Voltar</a></button>";            exit();
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