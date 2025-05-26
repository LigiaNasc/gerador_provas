<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php');

verificarProfessor();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = getConexao();
        
        // Dados básicos da questão
        $questao_id = $_POST['questao_id'];
        $enunciado = $_POST['texto'];
        $disciplina_id = $_POST['disciplina'];
        $assunto_id = $_POST['assunto'];
        $professor_id = $_SESSION['id'];
        
        // Verificar se a questão pertence ao professor
        $stmt_verifica = $conn->prepare('SELECT id FROM questoes WHERE id = :id AND professor_id = :professor_id');
        $stmt_verifica->bindParam(':id', $questao_id, PDO::PARAM_INT);
        $stmt_verifica->bindParam(':professor_id', $professor_id, PDO::PARAM_INT);
        $stmt_verifica->execute();
        
        if (!$stmt_verifica->fetch()) {
            header("Location: questoes_prof.php?msg=Você não tem permissão para editar esta questão");
            exit();
        }
        
        // Atualizar a questão
        $stmt = $conn->prepare('
            UPDATE questoes 
            SET enunciado = :enunciado, 
                disciplina_id = :disciplina_id, 
                assunto_id = :assunto_id 
            WHERE id = :id
        ');
        $stmt->bindParam(':enunciado', $enunciado);
        $stmt->bindParam(':disciplina_id', $disciplina_id);
        $stmt->bindParam(':assunto_id', $assunto_id);
        $stmt->bindParam(':id', $questao_id);
        $stmt->execute();
        
        // Atualizar alternativas
        $alternativas = $_POST['alternativas'];
        $alternativa_ids = $_POST['alternativa_id'];
        $correta_index = $_POST['correta'];
        
        for ($i = 0; $i < count($alternativas); $i++) {
            $stmt_alt = $conn->prepare('
                UPDATE alternativas 
                SET texto = :texto, 
                    correta = :correta 
                WHERE id = :id AND questao_id = :questao_id
            ');
            $stmt_alt->bindParam(':texto', $alternativas[$i]);
            $correta = ($i == $correta_index) ? 1 : 0;
            $stmt_alt->bindParam(':correta', $correta, PDO::PARAM_INT);
            $stmt_alt->bindParam(':id', $alternativa_ids[$i], PDO::PARAM_INT);
            $stmt_alt->bindParam(':questao_id', $questao_id, PDO::PARAM_INT);
            $stmt_alt->execute();
        }
        
        header("Location: questoes_prof.php?msg=Questão atualizada com sucesso");
        exit();
        
    } catch (PDOException $e) {
        header("Location: edit_questao.php?id=$questao_id&msg=Erro ao atualizar questão: " . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: questoes_prof.php");
    exit();
}