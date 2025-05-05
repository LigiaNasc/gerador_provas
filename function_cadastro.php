<?php
function cadastrarUsuario($nome, $email, $password, $disciplina) {
    $conn = getConexao();
    $message = '';
    $tipo_id = 2; // ID para "Professor"

    // Verificar se o tipo_id existe
    $stmt_check = $conn->prepare('SELECT id FROM tipos_usuario WHERE id = ?');
    $stmt_check->bindParam(1, $tipo_id, PDO::PARAM_INT); // Corrigido para bindParam
    $stmt_check->execute();
    $result_check = $stmt_check->fetch();

    if ($result_check === false) {
        return "Erro: Tipo de usuário inválido.";
    }

    // Verificar email duplicado
    $stmt_email = $conn->prepare('SELECT email FROM usuarios WHERE email = ?');
    $stmt_email->bindParam(1, $email, PDO::PARAM_STR); // Corrigido para bindParam
    $stmt_email->execute();
    $result_email = $stmt_email->fetch();

    if ($result_email !== false) {
        return "Este email já está cadastrado.";
    }

    // Mapear disciplina para ID
    $disciplinas = [
        'portugues' => 1, 'ingles' => 2, 'espanhol' => 3,
        'educacao_fisica' => 4, 'artes' => 5, 'filosofia' => 6,
        'sociologia' => 7, 'historia' => 8, 'geografia' => 9,
        'biologia' => 10, 'fisica' => 11, 'quimica' => 12, 'matematica' => 13
    ];

    $disciplinas_id = $disciplinas[$disciplina] ?? null;

     if ($disciplinas_id === null) {
        return "Disciplina inválida.";
    }

    // Criptografar senha
    $senha_hash = password_hash($password, PASSWORD_DEFAULT);

    // Inserir no banco
    $stmt_insert = $conn->prepare('INSERT INTO usuarios (nome, senha, email, tipo_id, disciplinas_id) VALUES (?, ?, ?, ?, ?)');
    $stmt_insert->bindParam(1, $nome, PDO::PARAM_STR);
    $stmt_insert->bindParam(2, $senha_hash, PDO::PARAM_STR);
    $stmt_insert->bindParam(3, $email, PDO::PARAM_STR);
    $stmt_insert->bindParam(4, $tipo_id, PDO::PARAM_INT);
    $stmt_insert->bindParam(5, $disciplinas_id, PDO::PARAM_INT);

    if ($stmt_insert->execute()) {
        $message = "Cadastro realizado com sucesso!";
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
    session_start();
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $disciplina = $_POST['disciplina'] ?? '';
    $message = cadastrarUsuario($nome, $email, $password, $disciplina);
}
?>