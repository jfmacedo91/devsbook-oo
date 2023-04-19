<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/PostDaoMysql.php';
  require_once 'dao/RelationshipDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();
  $activeMenu = '';

  $id = filter_input(INPUT_GET, 'id');
  $page = filter_input(INPUT_GET, 'page');
  if($page < 1) {
    $page = 1;
  }

  if(!$id) {
    $id = $user->id;
  }

  if($id == $user->id) {
    $activeMenu = 'profile';
  }

  $postDao = new PostDaoMysql($pdo);
  $userDao = new UserDaoMysql($pdo);
  $relationshipDao = new RelationshipDaoMysql($pdo);

  $profileUser = $userDao->findById($id, true);

  if(!$profileUser) {
    header("Location: $baseURL");
    exit;
  }

  $dateFrom = new DateTime($profileUser->birthdate);
  $dateTo = new DateTime('today');
  $profileUserAge = $dateFrom->diff($dateTo)->y;

  $feedContent = $postDao->getUserFeed($id, $user->id, $page);
  $feed = $feedContent['feed'];
  $pages = $feedContent['pages'];
  $currentPage = $feedContent['currentPage'];

  $isFollowing = $relationshipDao->isFollowing($user->id, $id);

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
            <?php if($id != $user->id): ?>
              <div class="profile-info-item m-width-10">
                <a href="follow_action.php?id=<?= $id; ?>" class="button"><?= $isFollowing ? "Seguindo" : "Seguir"; ?></a>
              </div>
            <?php endif; ?>
            <div class="profile-info-item m-width-10">
              <div class="profile-info-item-n"><?= count($profileUser->followers); ?></div>
              <div class="profile-info-item-s">Seguidores</div>
            </div>
            <div class="profile-info-item m-width-10">
              <div class="profile-info-item-n"><?= count($profileUser->following); ?></div>
              <div class="profile-info-item-s">Seguindo</div>
            </div>
            <div class="profile-info-item m-width-10">
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
          <?php foreach($profileUser->following as $key => $following): ?>
            <?php if($key < 9): ?>
              <div class="friend-icon">
                <a href="<?= $baseURL; ?>/perfil.php?id=<?= $following->id ?>">
                  <div class="friend-icon-avatar">
                    <img src="<?= $baseURL; ?>/media/avatars/<?= $following->avatar; ?>" />
                  </div>
                  <div class="friend-icon-name"><?= $following->name; ?></div>
                </a>
              </div>
            <?php endif; ?>
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
              foreach($profileUser->photos as $key => $photo):
                if($key < 4):
          ?>
            <div class="user-photo-item">
              <a href="#modal-<?= $photo->id; ?>" data-modal-open>
                <img src="<?= $baseURL; ?>/media/uploads/<?= $photo->body; ?>" />
              </a>
              <div id="modal-<?= $photo->id; ?>" style="display: none">
                <img src="<?= $baseURL; ?>/media/uploads/<?= $photo->body; ?>" />
              </div>
            </div>
          <?php
                endif;
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

      <div class="feed-pagination">
        <?php for($index = 0; $index < $pages; $index++): ?>
          <a class="<?= $index + 1 == $currentPage ? 'active' : '' ?>" href="<?= $baseURL; ?>/perfil.php?id=<?= $id ?>&page=<?= $index + 1 ?>"><?= $index + 1 ?></a>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>

<script>
  window.onload = () => {
    const modal = new VanillaModal.default();
  }
</script>

<?php require 'partials/footer.php'; ?>