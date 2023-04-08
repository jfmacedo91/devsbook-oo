<?php
  $firstName = current(explode(' ', $user->name));
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="icon" href="<?= $baseURL; ?>/assets/images/favicon.png" type="image/png">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <title>Devsbook</title>
  </head>
  <body>
    <header>
      <div class="container">
        <div class="logo">
          <a href="<?= $baseURL; ?>"><img src="<?= $baseURL; ?>/assets/images/devsbook_logo.svg" /></a>
        </div>
        <div class="head-side">
          <div class="head-side-left">
            <div class="search-area">
              <form method="GET" action="<?= $baseURL; ?>/search.php">
                <input type="search" placeholder="Pesquisar" name="s" />
              </form>
            </div>
          </div>
          <div class="head-side-right">
            <a href="<?= $baseURL; ?>/perfil.php" class="user-area">
              <div class="user-area-text"><?= $firstName; ?></div>

              <div class="user-area-icon">
                <img src="<?= $baseURL ?>/media/avatars/<?= $user->avatar; ?>" />
              </div>
            </a>

            <a href="<?= $baseURL; ?>/logout.php" class="user-logout">
              <img src="<?= $baseURL ?>/assets/images/power_white.svg" />
            </a>
          </div>
        </div>
      </div>
    </header>
    <section class="container main">