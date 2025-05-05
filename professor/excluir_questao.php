<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../conex.php'); // Ajuste o caminho se necessário

require_once('verificar_professor.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um Professor
verificarProfessor();

$conn = getConexao(); // Certifique-se de que a conexão está correta

if (isset($_GET['id'])) {
    $questao= $_GET['id'];

    // Verifica se o ID é um número inteiro
    if (filter_var($questao, FILTER_VALIDATE_INT)) {
        // Iniciar a exclusão do professor
        $stmt = $conn->prepare("DELETE FROM questoes WHERE id = :id");
        $stmt->bindParam(':id', $questao, PDO::PARAM_INT); // Use bindParam para PDO

        // Verificar se a execução foi bem-suce$questaoa
        if ($stmt->execute()) {
            // Redireciona após a exclusão
            echo'Questao Excluida com sucesso';
            echo "<button type='button' class='btn btn-success'><a href='questoes_prof.php'>Voltar</a></button>";            exit();
            exit();
        } else {
            echo "Erro ao excluir a questao.";
        }
    } else {
        echo "ID do questao inválido.";
    }
} else {
    echo "ID do questao não fornecido.";
}

?>