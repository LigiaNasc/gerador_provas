<?php
// Inicia a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Habilita a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui arquivos necessários
require_once('../conex.php');
include('../protect.php');
require_once('verificar_professor.php'); // Inclua a função de verificação

// Chama a função para verificar se o usuário é um professor
verificarProfessor();

$conn = getConexao();
if (!$conn) {
    die("Erro na conexão com o banco de dados.");
}

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Log para verificar se o formulário foi enviado

    $disciplina_id = $_POST['disciplina'] ?? null;
    $assunto_id = $_POST['assunto'] ?? null;
    $texto = $_POST['texto'] ?? '';
    $alternativas = $_POST['alternativas'] ?? [];
    $correta = $_POST['correta'] ?? null;
    $professor_id = $_SESSION['id'] ?? null; 

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!empty($disciplina_id) && !empty($assunto_id) && !empty($texto) && count($alternativas) >= 2) {
        // Inicia a transação
        $conn->beginTransaction();
        try {
            // Insere a questão
            $stmt = $conn->prepare("INSERT INTO questoes (enunciado, disciplina_id, assunto_id, professor_id) VALUES (:texto, :disciplina_id, :assunto_id, :professor_id)");
            $stmt->bindParam(':texto', $texto);
            $stmt->bindParam(':disciplina_id', $disciplina_id);
            $stmt->bindParam(':assunto_id', $assunto_id);
            $stmt->bindParam(':professor_id', $professor_id);
            $stmt->execute();

            // Obtém o ID da questão recém-inserida
            $questaoId = $conn->lastInsertId();

            // Insere as alternativas
            foreach ($alternativas as $index => $alternativaTexto) {
                $stmt = $conn->prepare("INSERT INTO alternativas (texto, questao_id, correta) VALUES (:texto, :questaoId, :correta)");
                $stmt->bindParam(':texto', $alternativaTexto);
                $stmt->bindParam(':questaoId', $questaoId);
                $corretaFlag = ($index == $correta) ? 1 : 0; // Define se a alternativa é correta
                $stmt->bindParam(':correta', $corretaFlag);
                $stmt->execute();
            }

            // Confirma a transação
            $conn->commit();
            echo "Questão salva com sucesso!";
            echo "<button type='button' class='btn btn-success'><a href='cadastro_questoes.php'>Voltar</a></button>";
            exit();
        } catch (Exception $e) {
            // Reverte a transação em caso de erro
            $conn->rollBack();
            echo "Erro ao salvar a questão: " . $e->getMessage();
            exit();
        }
    } else {
        echo "Verificar dados necessários para cadastro de questão.";
        exit();
    }
}
?>