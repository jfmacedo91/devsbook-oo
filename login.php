<?php
  require 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= $baseURL; ?>/assets/css/login.css" />
    <title>Devsbook - Login</title>
  </head>
  <body>
    <header>
      <div class="container">
        <a href="<?= $baseURL; ?>"><img src="<?= $baseURL; ?>/assets/images/devsbook_logo.svg" /></a>
      </div>
    </header>
    <section class="container main">
      <form method="POST" action="<?= $baseURL; ?>/login_action.php">
        <?php if(!empty($_SESSION['flash'])): ?>
          <span class="flash"><?= $_SESSION['flash'] ?></span>
          <?php $_SESSION['flash'] = ''; ?>
        <?php endif; ?>
        <input placeholder="Digite seu e-mail" class="input" type="email" name="email" />
        <input placeholder="Digite sua senha" class="input" type="password" name="password" />
        <input class="button" type="submit" value="Acessar o sistema" />
        <a href="<?= $baseURL; ?>/signup.php">Ainda não tem conta? Cadastre-se</a>
      </form>
    </section>
  </body>
</html>
