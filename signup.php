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
      <form method="POST" action="<?= $baseURL; ?>/signup_action.php">
        <?php if(!empty($_SESSION['flash'])): ?>
          <span class="flash"><?= $_SESSION['flash'] ?></span>
          <?php $_SESSION['flash'] = ''; ?>
        <?php endif; ?>
        <input placeholder="Digite seu nome completo" class="input" type="text" name="name" />
        <input placeholder="Digite seu e-mail" class="input" type="email" name="email" />
        <input placeholder="Digite sua senha" class="input" type="password" name="password" />
        <input placeholder="Digite sua data de nascimento" class="input" type="text" name="birthdate" id="birthdate" />
        <input class="button" type="submit" value="Fazer cadastrar" />
        <a href="<?= $baseURL; ?>/login.php">Já tem conta? Faça o login</a>
      </form>
    </section>
    <script src="https://unpkg.com/imask"></script>
    <script>
      IMask(
        document.getElementById("birthdate"),
        { mask: '00/00/0000' }
      );
    </script>
  </body>
</html>
