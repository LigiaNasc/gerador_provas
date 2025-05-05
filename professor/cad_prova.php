<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
require_once('../conex.php'); // Inclua seu arquivo de conexão
include('../protect.php'); 
require_once('verificar_professor.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um Professor
verificarProfessor();
}
// Verificar se dados foram enviados
if (isset($_POST['titulo'], $_POST['questoes'])) {
    $titulo = $_POST['titulo'];
    $id_professor = $_SESSION['id_usuario']; // pega id do professor logado
    $questoes = $_POST['questoes']; // array de id das questões selecionadas

    // Inserir prova
    $sql = "INSERT INTO tb_provas (titulo, id_professor) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $titulo, $id_professor);

    if ($stmt->execute()) {
        $id_prova = $stmt->insert_id;

        // Associar questões à prova
        $stmt_questao = $conn->prepare("INSERT INTO tb_provas_questoes (id_prova, id_questao) VALUES (?, ?)");

        foreach ($questoes as $id_questao) {
            $stmt_questao->bind_param("ii", $id_prova, $id_questao);
            $stmt_questao->execute();
        }

        echo "Prova salva com sucesso!";
    } else {
        echo "Erro ao salvar a prova.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Dados incompletos.";
}
?>
