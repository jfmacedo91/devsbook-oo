<?php
  require 'config.php';
  require 'models/Auth.php';
  require 'dao/PostDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();
  $activeMenu = 'home';

  $postDao = new PostDaoMysql($pdo);
  $feed = $postDao->getHomeFeed($user->id);

  require 'partials/header.php';
  require 'partials/menu.php';
?>

<section class="feed mt-10">
  <div class="row">
    <div class="column pr-5">
      <?php
        include 'partials/feed-editor.php';
        foreach($feed as $feedItem) {
          require 'partials/feed-item.php';
        }
      ?>
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