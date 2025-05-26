<?php

function cadastrarQuestao($enunciado, $Alternativa_A,  $Alternativa_B, $Alternativa_C, $Alternativa_D, $Alternativa_E,$RespostaCerta) {
    $conn = getConexao();
    $message = '';
   

   
    


    // Inserir no banco
    $stmt_insert = $conn->prepare('INSERT INTO questoes (alt_a, alt_b, alt_c, alt_d, alt_e,resp_certa) VALUES (?, ?, ?, ?, ?,?)');
    $stmt_insert->bindParam(1, $Alternativa_A, PDO::PARAM_STR);
    $stmt_insert->bindParam(2, $Alternativa_B, PDO::PARAM_STR);
    $stmt_insert->bindParam(3, $Alternativa_C, PDO::PARAM_STR);
    $stmt_insert->bindParam(4, $Alternativa_D, PDO::PARAM_INT);
    $stmt_insert->bindParam(5, $Alternativa_E, PDO::PARAM_INT);

    if ($stmt_insert->execute()) {
        echo "Cadastro Realizado com sucesso!!";
        echo "<button type='button' class='btn btn-success'><a href='professor.php'>Voltar</a></button>";            exit();
    } else {
        $message = "Erro ao cadastrar: " . implode(", ", $stmt_insert->errorInfo()); // Exibir mensagem de erro
    }

    $stmt_insert->closeCursor();
    $stmt_check->closeCursor();
    $stmt_email->closeCursor();
    $conn = null; // Fecha a conexão
    return $message;
}

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $disciplina = $_POST['disciplina'] ?? '';
    $message = cadastrarProfessor($nome, $email, $password, $disciplina);
}
?>
       