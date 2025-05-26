<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../conex.php'); // Inclua seu arquivo de conexão
include('../protect.php'); 
require_once('verificar_professor.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um Professor
verificarProfessor();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['questoes'])) {
    $questoesSelecionadas = $_POST['questoes']; // Array com os IDs das questões selecionadas

    // Aqui você pode processar as questões selecionadas
    // Por exemplo, você pode excluir as questões, editar, ou realizar outra ação
    foreach ($questoesSelecionadas as $questaoId) {
        // Exemplo: Excluir a questão
        // $stmt = $conn->prepare("DELETE FROM questoes WHERE id = :id");
        // $stmt->bindParam(':id', $questaoId);
        // $stmt->execute();
        
        // Exibir uma mensagem ou realizar outra ação
        echo "Questão ID {$questaoId} selecionada.<br>";
    }
} else {
    echo "Nenhuma questão selecionada.";
}
?>