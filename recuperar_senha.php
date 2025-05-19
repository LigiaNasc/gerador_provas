<?php
require_once('conex.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;

    if ($email) {
        $conn = getConexao();

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            $stmt = $conn->prepare("SELECT * FROM professores WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        if ($usuario) {
            $token = bin2hex(random_bytes(16));
            $expira_em = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Enviar e-mail com o link de redefinição de senha
            $stmt = $conn->prepare("
                INSERT INTO reset_senha (usuario_id, token, expira_em)
                VALUES (:usuario_id, :token, :expira_em)
            ");
            $stmt->execute([
                'usuario_id' => $usuario['id'],
                'token' => $token,
                'expira_em' => $expira_em
            ]);

            $link_redefinicao = "redefinir_senha.php?token=$token";
            ?>
            
            <!-- HTML com redirecionamento após 3 segundos -->
            <html>
            <head>
                <meta http-equiv="refresh" content="3;url=<?php echo $link_redefinicao; ?>">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        text-align: center;
                        margin-top: 100px;
                    }
                </style>
            </head>
            <body>
                <h2>Redirecionando para redefinir a senha...</h2>
                <p>Por favor, aguarde alguns segundos.</p>
            </body>
            </html>

            <?php
            exit;
        } else {
            echo "E-mail não encontrado.";
        }
    } else {
        echo "Por favor, insira seu e-mail.";
    }
}
?>
