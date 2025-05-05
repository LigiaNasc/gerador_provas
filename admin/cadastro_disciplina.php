<?php

  require_once('../conex.php');
  $pdo = getConexao(); // Chama a função para obter a conexão
  include('function_cad_disc.php');
  include('../protect.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
    <title>Página de Cadastro de Disciplinas</title>
  </head>
  <body>
    <nav class="navbar"></nav>
<main class="main-content">
  
      <section>
        <h1 class="title">Cadastro</h1>
        <p>Infome os dados para realizar o cadastro da disciplina no sistema.</p>
      </section>

      <section>
      <?php if (!empty($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
      <form action="" method="POST" class="form-login">
    <label for="nome">Nome :</label>
    <input type="text" id="nome" name="nome" required>
    <button type="submit">Cadastrar</button>

</form><br>
<a href="disciplinas_admin.php"><button>Voltar</button></a>
    </section>
    

</main>

    

  </body>
</html>
