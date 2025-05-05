<?php

function cadastrarUsuario($nome,) {
    $conn = getConexao();
    $message = '';
    // Inserir no banco
    $stmt_insert = $conn->prepare('INSERT INTO disciplinas (nome) VALUE(?)');
    $stmt_insert->bindParam(1, $nome, PDO::PARAM_STR);
    

    if ($stmt_insert->execute()) {
        echo "Cadastro realizado com sucesso!";
        echo "<button type='button' class='btn btn-success'><a href='disciplinas_admin.php'>Voltar</a></button>";           
        echo "<button type='button' class='btn btn-success'><a href='Cadastro_disciplina.php'>Cadastrar novamente</a></button>";    exit();
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
    $message = cadastrarUsuario($nome);
}
?>
       