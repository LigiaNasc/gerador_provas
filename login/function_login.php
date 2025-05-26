<?php 
require_once(__DIR__ . '/../conex.php');
// Verifica se a função getConexao está definida
// Se não estiver, exibe uma mensagem de erro
if (!function_exists('getConexao')) {
    die('A função getConexao não está definida.');
}

if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getConexao();

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validação básica
    if (empty($email) || empty($password)) {
        $_SESSION['message'] = 'Preencha todos os campos.';
        header('Location: ../login/login.php');
        exit();
    }

    // Função para tentar login em uma tabela
    function tentarLogin($conn, $email, $password, $tabela) {
        $stmt = $conn->prepare("SELECT * FROM $tabela WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $result['senha'])) {
                $_SESSION['id'] = $result['id'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['nome'] = $result['nome'];

                // Define tipo e redireciona conforme necessário
                if ($tabela === 'usuarios') {
                    $_SESSION['tipo_id'] = $result['tipo_id'];
                    switch ($result['tipo_id']) {
                        case 1:
                            header("Location: ../admin/admin.php");
                            break;   // Admin
                        case 3:
                            header("Location: ../usuario/usuario.php");
                            break; // Usuário comum
                        default:
                            $_SESSION['message'] = 'Tipo de usuário inválido.';
                            header('Location: ../login/login.php');
                            exit();
                    }
                } else if ($tabela === 'professores') {
                    $_SESSION['tipo_id'] = 2;
                    header("Location: ../professor/professor.php"); // Professor
                }

                exit();
            } else {
                $_SESSION['message'] = 'Senha incorreta.';
                header('Location: ../login/login.php');
                exit();
            }
        }
    }

    // Tentativas de login
    tentarLogin($conn, $email, $password, 'usuarios');
    tentarLogin($conn, $email, $password, 'professores');

    // Se chegou aqui, não encontrou em nenhuma das tabelas
    $_SESSION['message'] = 'Usuário não encontrado.';
    header('Location: ../login/login.php');
    exit();
}
