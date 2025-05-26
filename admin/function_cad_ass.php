<?php

function cadastrarAssunto($nome,  $disciplina) {
    $conn = getConexao();
    $message = '';

    // Mapear disciplina para ID
    $disciplinas_id = "SELECT disciplinas.nome AS disciplinas_nome 
            FROM assuntos
            JOIN disciplinas ON assuntos.disciplina_id = disciplinas.id ORDER BY disciplinas_nome";

    $disciplinas_id = $disciplina ?? null;

    if ($disciplinas_id === null) {
        return "Disciplina inválida.";
    }


    // Inserir no banco
    $stmt_insert = $conn->prepare('INSERT INTO assuntos (nome, disciplina_id) VALUES (?, ?)');
    $stmt_insert->bindParam(1, $nome, PDO::PARAM_STR);
    $stmt_insert->bindParam(2, $disciplinas_id, PDO::PARAM_INT);

    if ($stmt_insert->execute()) {
        echo "Cadastro Realizado com sucesso!!";
        echo "<button type='button' class='btn btn-success'><a href='assunto_admin.php'>Voltar</a></button>";            exit();
    } else {
        $message = "Erro ao cadastrar: " . implode(", ", $stmt_insert->errorInfo()); // Exibir mensagem de erro
    }

    $stmt_insert->closeCursor();
    $conn = null; // Fecha a conexão
    return $message;
}

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nome = $_POST['nome'] ?? '';
    $disciplina = $_POST['disciplina'] ?? '';
    $message = cadastrarAssunto($nome,$disciplina);
}
?>
       