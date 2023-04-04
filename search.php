<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/UserDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();

  $userDao = new UserDaoMysql($pdo);

  $searchTerm = filter_input(INPUT_GET, 's');

  if(empty($searchTerm)) {
    header("Location: index.php");
    exit;
  }

  $userList = $userDao->findByName($searchTerm);

  require 'partials/header.php';
  require 'partials/menu.php';
?>

<section class="feed mt-10">
  <div class="row">
    <div class="column pr-5">
      <h2>Pesquisando por: <?= $searchTerm; ?></h2>
      <div class="box mt-10 full-friend-list">
        <?php foreach($userList as $user): ?>
          <div class="friend-icon">
            <a href="<?= $baseURL; ?>/perfil.php?id=<?= $user->id ?>">
              <div class="friend-icon-avatar">
                <img src="<?= $baseURL; ?>/media/avatars/<?= $user->avatar; ?>" />
              </div>
              <div class="friend-icon-name"><?= $user->name; ?></div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="column side pl-5">
      <div class="box banners">
        <div class="box-header">
          <div class="box-header-text">Patrocinios</div>
          <div class="box-header-buttons"></div>
        </div>
        <div class="box-body">
          <a href=""><img src="https://alunos.b7web.com.br/media/courses/php.jpg"/></a>
          <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel.jpg" /></a>
        </div>
      </div>
      <div class="box">
        <div class="box-body m-10">Criado com <?= "\u{1F49A}" ?> por B7Web</div>
      </div>
    </div>
  </div>
</section>

<?php require 'partials/footer.php'; ?>