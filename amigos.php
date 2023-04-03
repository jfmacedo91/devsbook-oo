<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/PostDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();
  $activeMenu = '';

  $id = filter_input(INPUT_GET, 'id');
  $tab = filter_input(INPUT_GET, 'tab');

  if (!$id) {
    $id = $user->id;
  }

  if ($id == $user->id) {
    $activeMenu = 'friends';
  }

  $postDao = new PostDaoMysql($pdo);
  $userDao = new UserDaoMysql($pdo);

  $profileUser = $userDao->findById($id, true);

  if (!$profileUser) {
    header("Location: $baseURL");
    exit;
  }

  $dateFrom = new DateTime($profileUser->birthdate);
  $dateTo = new DateTime('today');
  $profileUserAge = $dateFrom->diff($dateTo)->y;

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
            <?php if (!empty($profileUser->city)) : ?>
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
    <div class="column">
      <div class="box">
        <div class="box-body">
          <div class="tabs">
            <div class="tab-item <?= $tab == 'followers' ? 'active' : '' ?>" data-for="followers">Seguidores</div>
            <div class="tab-item <?= $tab == 'following' ? 'active' : '' ?>" data-for="following">Seguindo</div>
          </div>
          <div class="tab-content">
            <div class="tab-body" data-item="followers">
              <div class="full-friend-list">
                <?php foreach($profileUser->followers as $follower): ?>
                  <div class="friend-icon">
                    <a href="<?= $baseURL; ?>/perfil.php?id=<?= $follower->id; ?>">
                      <div class="friend-icon-avatar">
                        <img src="<?= $baseURL; ?>/media/avatars/<?= $follower->avatar; ?>" />
                      </div>
                      <div class="friend-icon-name"><?= $follower->name; ?></div>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="tab-body" data-item="following">
              <div class="full-friend-list">
                <?php foreach($profileUser->following as $follow): ?>
                  <div class="friend-icon">
                    <a href="<?= $baseURL; ?>/perfil.php?id=<?= $follow->id; ?>">
                      <div class="friend-icon-avatar">
                        <img src="<?= $baseURL; ?>/media/avatars/<?= $follow->avatar; ?>" />
                      </div>
                      <div class="friend-icon-name"><?= $follow->name; ?></div>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require 'partials/footer.php'; ?>