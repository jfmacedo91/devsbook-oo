<?php
  require 'config.php';
  require 'models/Auth.php';
  require 'dao/PostDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();
  $activeMenu = 'profile';

  $id = filter_input(INPUT_GET, 'id');

  if(!$id) {
    $id = $user->id;
  }

  $postDao = new PostDaoMysql($pdo);
  $userDao = new UserDaoMysql($pdo);

  $profileUser = $userDao->findById($id, true);

  if(!$profileUser) {
    header("Location: $baseURL");
    exit;
  }

  $dateFrom = new DateTime($profileUser->birthdate);
  $dateTo = new DateTime('today');
  $profileUserAge = $dateFrom->diff($dateTo)->y;

  // $feed = $postDao->getUserFeed($user->id);

  require 'partials/header.php';
  require 'partials/menu.php';
?>

<section class="feed">
  <div class="row">
    <div class="box flex-1 border-top-flat">
      <div class="box-body">
        <div class="profile-cover" style="background-image: url('<?= $baseURL; ?>/media/covers/<?= $profileUser->cover; ?>')"></div>
        <div class="profile-info m-20 row">
          <div class="profile-info-avatar">
            <img src="<?= $baseURL; ?>/media/avatars/<?= $profileUser->avatar; ?>" />
          </div>
          <div class="profile-info-name">
            <div class="profile-info-name-text"><?= $profileUser->name; ?></div>
            <?php if(!empty($profileUser->city)): ?>
              <div class="profile-info-location"><?= $profileUser->city; ?></div>
            <?php endif; ?>
          </div>
          <div class="profile-info-data row">
            <div class="profile-info-item m-width-20">
              <div class="profile-info-item-n"><?= count($profileUser->followers); ?></div>
              <div class="profile-info-item-s">Seguidores</div>
            </div>
            <div class="profile-info-item m-width-20">
              <div class="profile-info-item-n"><?= count($profileUser->following); ?></div>
              <div class="profile-info-item-s">Seguindo</div>
            </div>
            <div class="profile-info-item m-width-20">
              <div class="profile-info-item-n"><?= count($profileUser->photos); ?></div>
              <div class="profile-info-item-s">Fotos</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="column side pr-5">
      <div class="box">
        <div class="box-body">
          <div class="user-info-mini">
            <img src="<?= $baseURL; ?>/assets/images/calendar.svg" />
            <?= date('d/m/Y', strtotime($profileUser->birthdate)); ?> (<?= $profileUserAge; ?> anos)
          </div>

          <?php if(!empty($profileUser->city)): ?>
            <div class="user-info-mini">
              <img src="<?= $baseURL; ?>/assets/images/pin.svg" />
              <?= $profileUser->city; ?>
            </div>
          <?php endif; ?>

          <?php if(!empty($profileUser->work)): ?>
            <div class="user-info-mini">
              <img src="<?= $baseURL; ?>/assets/images/work.svg" />
              <?= $profileUser->work; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="box">
        <div class="box-header m-10">
          <div class="box-header-text">
            Seguindo
            <span>(<?= count($profileUser->following); ?>)</span>
          </div>
          <div class="box-header-buttons">
            <a href="<?= $baseURL; ?>/amigos.php?id=<?= $profileUser->id ?>&tab=following">ver todos</a>
          </div>
        </div>
        <div class="box-body friend-list">
          <div class="friend-icon">
            <a href="">
              <div class="friend-icon-avatar">
                <img src="media/avatars/default.jpg" />
              </div>
              <div class="friend-icon-name">Bonieky</div>
            </a>
          </div>

          <div class="friend-icon">
            <a href="">
              <div class="friend-icon-avatar">
                <img src="media/avatars/default.jpg" />
              </div>
              <div class="friend-icon-name">Bonieky</div>
            </a>
          </div>

          <div class="friend-icon">
            <a href="">
              <div class="friend-icon-avatar">
                <img src="media/avatars/default.jpg" />
              </div>
              <div class="friend-icon-name">Bonieky</div>
            </a>
          </div>

          <div class="friend-icon">
            <a href="">
              <div class="friend-icon-avatar">
                <img src="media/avatars/default.jpg" />
              </div>
              <div class="friend-icon-name">Bonieky</div>
            </a>
          </div>

          <div class="friend-icon">
            <a href="">
              <div class="friend-icon-avatar">
                <img src="media/avatars/default.jpg" />
              </div>
              <div class="friend-icon-name">Bonieky</div>
            </a>
          </div>

          <div class="friend-icon">
            <a href="">
              <div class="friend-icon-avatar">
                <img src="media/avatars/default.jpg" />
              </div>
              <div class="friend-icon-name">Bonieky</div>
            </a>
          </div>

          <div class="friend-icon">
            <a href="">
              <div class="friend-icon-avatar">
                <img src="media/avatars/default.jpg" />
              </div>
              <div class="friend-icon-name">Bonieky</div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="column pl-5">
      <div class="box">
        <div class="box-header m-10">
          <div class="box-header-text">
            Fotos
            <span>(12)</span>
          </div>
          <div class="box-header-buttons">
            <a href="">ver todos</a>
          </div>
        </div>
        <div class="box-body row m-20">
          <div class="user-photo-item">
            <a href="#modal-1" rel="modal:open">
              <img src="media/uploads/1.jpg" />
            </a>
            <div id="modal-1" style="display: none">
              <img src="media/uploads/1.jpg" />
            </div>
          </div>

          <div class="user-photo-item">
            <a href="#modal-2" rel="modal:open">
              <img src="media/uploads/1.jpg" />
            </a>
            <div id="modal-2" style="display: none">
              <img src="media/uploads/1.jpg" />
            </div>
          </div>

          <div class="user-photo-item">
            <a href="#modal-3" rel="modal:open">
              <img src="media/uploads/1.jpg" />
            </a>
            <div id="modal-3" style="display: none">
              <img src="media/uploads/1.jpg" />
            </div>
          </div>

          <div class="user-photo-item">
            <a href="#modal-4" rel="modal:open">
              <img src="media/uploads/1.jpg" />
            </a>
            <div id="modal-4" style="display: none">
              <img src="media/uploads/1.jpg" />
            </div>
          </div>
        </div>
      </div>

      <div class="box feed-item">
        <div class="box-body">
          <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
              <a href=""><img src="media/avatars/default.jpg" /></a>
            </div>
            <div class="feed-item-head-info">
              <a href=""
                ><span class="fidi-name">Bonieky Lacerda</span></a
              >
              <span class="fidi-action">fez um post</span>
              <br />
              <span class="fidi-date">07/03/2020</span>
            </div>
            <div class="feed-item-head-btn">
              <img src="assets/images/more.png" />
            </div>
          </div>
          <div class="feed-item-body mt-10 m-width-20">
            Pessoal, tudo bem! Busco parceiros para empreender comigo em
            meu software.<br /><br />
            Acabei de aprová-lo na Appstore. É um sistema de atendimento
            via WhatsApp multi-atendentes para auxiliar empresas.<br /><br />
            Este sistema permite que vários funcionários/colaboradores da
            empresa atendam um mesmo número de WhatsApp, mesmo que estejam
            trabalhando remotamente, sendo que cada um acessa com um login
            e senha particular....
          </div>
          <div class="feed-item-buttons row mt-20 m-width-20">
            <div class="like-btn on">56</div>
            <div class="msg-btn">3</div>
          </div>
          <div class="feed-item-comments">
            <div class="fic-item row m-height-10 m-width-20">
              <div class="fic-item-photo">
                <a href=""><img src="media/avatars/default.jpg" /></a>
              </div>
              <div class="fic-item-info">
                <a href="">Bonieky Lacerda</a>
                Comentando no meu próprio post
              </div>
            </div>

            <div class="fic-item row m-height-10 m-width-20">
              <div class="fic-item-photo">
                <a href=""><img src="media/avatars/default.jpg" /></a>
              </div>
              <div class="fic-item-info">
                <a href="">Bonieky Lacerda</a>
                Muito legal, parabéns!
              </div>
            </div>

            <div class="fic-answer row m-height-10 m-width-20">
              <div class="fic-item-photo">
                <a href=""><img src="media/avatars/default.jpg" /></a>
              </div>
              <input
                type="text"
                class="fic-item-field"
                placeholder="Escreva um comentário"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require 'partials/footer.php'; ?>