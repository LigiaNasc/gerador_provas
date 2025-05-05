<?php 
require_once('conex.php');

if (!function_exists('getConexao')) {
    die('A função getConexao não está definida.');
}

session_start();
$message = ''; // Variável para armazenar a mensagem de retorno

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = getConexao();
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Primeiro, consulta na tabela usuarios
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Verificação de senha e email na tabela usuarios
    if ($stmt->rowCount() == 1) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashedPassword = $result['senha'];

        if (password_verify($password, $hashedPassword)) {
            // Armazene o ID do usuário, o email e o tipo na sessão
            $_SESSION['id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['tipo_id'] = $result['tipo_id'];
            $_SESSION['nome'] = $result['nome'];
            // Redireciona com base no tipo de usuário
            if ($_SESSION['tipo_id'] == 1) { // Admin
                header("Location: admin/admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $message = 'Senha incorreta.';
        }
    } else {
        // Se não encontrar na tabela usuarios, verifica na tabela professores
        $stmt = $conn->prepare('SELECT * FROM professores WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Verificação de senha e email na tabela professores
        if ($stmt->rowCount() == 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = $result['senha'];

            if (password_verify($password, $hashedPassword)) {
                // Armazene o ID do professor e o email na sessão
                $_SESSION['id'] = $result['id'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['tipo_id'] = 2; // Supondo que 2 seja o tipo para professores
                $_SESSION['nome'] = $result['nome'];
                // Debug: Verifique se as variáveis de sessão estão corretas
                // var_dump($_SESSION); exit();

                header("Location: professor/professor.php"); // Redireciona para o painel do professor
                exit();
            } else {
                $message = 'Senha incorreta.';
            }
        } else {
            $message = 'Usuário não encontrado em nenhuma das tabelas.';
        }
    }
    $stmt->closeCursor();
}
?>