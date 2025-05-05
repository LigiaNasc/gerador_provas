<?php

function cadastrarProfessor($nome, $email, $password, $disciplina) {
    $conn = getConexao();
    $message = '';
    $tipo_id = 2; // ID para "Professor"
    $senha = $_POST['password'];
    $confirmacao = $_POST['c-password'];
    
    
    // Verificar se o tipo_id existe
    $stmt_check = $conn->prepare('SELECT id FROM tipos_usuario WHERE id = ?');
    $stmt_check->bindParam(1, $tipo_id, PDO::PARAM_INT);
    $stmt_check->execute();
    $result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($result_check === false) {
        return "Erro: Tipo de usuário inválido.";
    }

    // Verificar email duplicado
    $stmt_email = $conn->prepare('SELECT email FROM professores WHERE email = ?');
    $stmt_email->bindParam(1, $email, PDO::PARAM_STR); 
    $stmt_email->execute();
    $result_email = $stmt_email->fetch(PDO::FETCH_ASSOC);

    if ($result_email !== false) {
        return "Este email já está cadastrado.";
    }

    // Mapear disciplina para ID
    $disciplinas_id = "SELECT disciplinas.nome AS disciplinas_nome 
            FROM professorses
            JOIN disciplinas ON professores.disciplinas_id = disciplinas.id ORDER BY disciplinas_nome";

    $disciplinas_id = $disciplina ?? null;

    if ($disciplinas_id === null) {
        return "Disciplina inválida.";
    }
    // Verifica se as senhas coincidem
    if ($senha !== $confirmacao) {
         echo "As senhas não coincidem!";
        echo "<button type='button' class='btn btn-success'><a href='cadastro_professor.php'>tentar novamente</a></button>";            exit();
    }else{
        // Criptografar senha
        $senha_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Inserir no banco
        $stmt_insert = $conn->prepare('INSERT INTO professores (nome, senha, email, tipo_id, disciplina_id) VALUES (?, ?, ?, ?, ?)');
        $stmt_insert->bindParam(1, $nome, PDO::PARAM_STR);
        $stmt_insert->bindParam(2, $senha_hash, PDO::PARAM_STR);
        $stmt_insert->bindParam(3, $email, PDO::PARAM_STR);
        $stmt_insert->bindParam(4, $tipo_id, PDO::PARAM_INT);
        $stmt_insert->bindParam(5, $disciplinas_id, PDO::PARAM_INT);
    
        if ($stmt_insert->execute()) {
            echo "Cadastro Realizado com sucesso!!";
            echo "<button type='button' class='btn btn-success'><a href='professor_admin.php'>Voltar</a></button>";            exit();
        } else {
            $message = "Erro ao cadastrar: " . implode(", ", $stmt_insert->errorInfo()); // Exibir mensagem de erro
        }
        $stmt_insert->closeCursor();
    }
    
   
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
       