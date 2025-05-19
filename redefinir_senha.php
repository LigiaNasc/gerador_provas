<?php
require_once('conex.php');

$conn = getConexao();
$token = $_GET['token'] ?? null;
$erro = '';
$sucesso = '';

if ($token) {
    $stmt = $conn->prepare("SELECT * FROM reset_senha WHERE token = :token AND expira_em > NOW()");
    $stmt->execute(['token' => $token]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$registro) {
        $erro = "Token inválido ou expirado.";
    }
} else {
    $erro = "Token não fornecido.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_senha']) && isset($_POST['confirmar_senha'])) {
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($nova_senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } elseif (isset($registro['usuario_id'])) {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        // Atualiza em usuarios
        $stmt = $conn->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
        $stmt->execute([
            'senha' => $senha_hash,
            'id' => $registro['usuario_id']
        ]);

        // Se não encontrou, tenta em professores
        if ($stmt->rowCount() === 0) {
            $stmt = $conn->prepare("UPDATE professores SET senha = :senha WHERE id = :id");
            $stmt->execute([
                'senha' => $senha_hash,
                'id' => $registro['usuario_id']
            ]);
        }

        // Remove o token
        $stmt = $conn->prepare("DELETE FROM reset_senha WHERE token = :token");
        $stmt->execute(['token' => $token]);

        $sucesso = "Senha redefinida com sucesso!";
    }
}
?>



<?php
  require_once('conex.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet"
  />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  

  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <title>Esqueci minha senha</title>
</head>
  <body>
    <nav class="navbar"></nav>

    <main class="main-content">
         <section class="main-section-1">
          <div class="section-title">
            <h1>Lembou a senha?</h1>
          </div>
            <button id="btn-title"><a href="login.php">Voltar à página de login<img src="assets/img/seta.png" alt=""></a></button>
        </section>
        <section class="main-section-2">
             <?php if ($erro): ?>
                <p class="erro"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>
            <?php if ($sucesso): ?>
                <p class="sucesso"><?= htmlspecialchars($sucesso) ?></p>
            <?php endif; ?>
            <form onsubmit="return validarsenhas()" method="POST" class="form-login">
                <img src="assets/img/v-logo.png" alt="">
                <input type="password" name="nova_senha" id="nova_senha" placeholder="Nova senha" required><br>
                <input type="password" name="confirmar_senha" id="confirmar_senha" placeholder="Confirmar senha" required><br>
                <p class="erro" id="erro-senhas" style="display:none;">As senhas não coincidem.</p>
                 <button type="submit">Redefinir</button>
                
                <a href="login.php">Voltar para o login</a>
            </form>
        </section>
    </main>

    
    <footer class="footer"></footer>

    <script src="assets/js/navbar.js"></script>
    <script src="assets/js/footer.js"></script>
    

</body>
</html>