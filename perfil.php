<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/PostDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();
  $activeMenu = '';

  $id = filter_input(INPUT_GET, 'id');

  if(!$id) {
    $id = $user->id;
  }

  if($id == $user->id) {
    $activeMenu = 'profile';
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

  $feed = $postDao->getUserFeed($id);

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
          <?php foreach($profileUser->following as $following): ?>
            <div class="friend-icon">
              <a href="<?= $baseURL; ?>/perfil.php?id=<?= $following->id ?>">
                <div class="friend-icon-avatar">
                  <img src="<?= $baseURL; ?>/media/avatars/<?= $following->avatar; ?>" />
                </div>
                <div class="friend-icon-name"><?= $following->name; ?></div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="column pl-5">
      <div class="box">
        <div class="box-header m-10">
          <div class="box-header-text">
            Fotos
            <span>(<?= count($profileUser->photos); ?>)</span>
          </div>
          <div class="box-header-buttons">
            <a href="<?= $baseURL; ?>/fotos.php?id=<?= $profileUser->id; ?>">ver todos</a>
          </div>
        </div>
        <div class="box-body row m-20">
          <?php
            if(count($profileUser->photos) > 0):
              foreach($profileUser->photos as $photo):
          ?>
            <div class="user-photo-item">
              <a href="#modal-<?= $photo->id; ?>" rel="modal:open">
                <img src="<?= $baseURL; ?>/media/uploads/<?= $photo->body; ?>" />
              </a>
              <div id="modal-<?= $photo->id; ?>" style="display: none">
                <img src="<?= $baseURL; ?>/media/uploads/<?= $photo->body; ?>" />
              </div>
            </div>
          <?php
              endforeach;
            else:
          ?>
            Nenhuma foto para ser exibida!
          <?php endif; ?>
        </div>
      </div>

      <?php
        if($id == $user->id) {
          include 'partials/feed-editor.php';
        }
        if(count($feed) > 0) {
          foreach($feed as $feedItem) {
            require 'partials/feed-item.php';
          }
        } else {
          echo 'Nenhuma postagem para ser exibida!';
        }
      ?>
    </div>
  </div>
</section>

<?php require 'partials/footer.php'; ?>