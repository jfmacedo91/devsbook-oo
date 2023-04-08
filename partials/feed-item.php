<?php
  require_once 'feed-item-script.php';

  $postTypePhrase = '';
  $postBody = '';

  switch($feedItem->type) {
    case 'text':
      $postTypePhrase = 'fez um post';
      $postBody = nl2br($feedItem->body);
    break;
    case 'photo':
      $postTypePhrase = 'postou uma foto';
      $postBody = '<img src="'.$baseURL.'/media/uploads/'.$feedItem->body.'">';
    break;
  }
?>

<div class="box feed-item" data-id="<?= $feedItem->id ?>">
  <div class="box-body">
    <div class="feed-item-head row mt-20 m-width-20">
      <div class="feed-item-head-photo">
        <a href="<?= $baseURL; ?>/perfil.php?id=<?= $feedItem->user->id; ?>"><img src="<?= $baseURL; ?>/media/avatars/<?= $feedItem->user->avatar; ?>" /></a>
      </div>
      <div class="feed-item-head-info">
        <a href="<?= $baseURL; ?>/perfil.php?id=<?= $feedItem->user->id; ?>"><span class="fidi-name"><?= $feedItem->user->name; ?></span></a>
        <span class="fidi-action"><?= $postTypePhrase ?></span>
        <br />
        <span class="fidi-date"><?= date('d/m/Y', strtotime($feedItem->created_at)); ?></span>
      </div>

      <?php if($feedItem->mine): ?>
        <div class="feed-item-head-btn">
          <img src="<?= $baseURL; ?>/assets/images/more.svg" />
        </div>
      <?php endif; ?>
    </div>
    <div class="feed-item-body mt-10 m-width-20">
      <?= $postBody; ?>
    </div>
    <div class="feed-item-buttons row mt-20 m-width-20">
      <div class="like-btn <?= $feedItem->liked ? 'on' : '' ?>"><?= $feedItem->likeCount ?></div>
      <div class="msg-btn"><?= count($feedItem->comments); ?></div>
    </div>
    <div class="feed-item-comments">
      <?php foreach($feedItem->comments as $comment): ?>
        <div class="fic-item row m-height-10 m-width-20">
          <div class="fic-item-photo">
            <a href="<?= $baseURL; ?>/perfil.php?id=<?= $comment->user->id; ?>"><img src="<?= $baseURL; ?>/media/avatars/<?= $comment->user->avatar; ?>" /></a>
          </div>
          <div class="fic-item-info">
            <a href="<?= $baseURL; ?>/perfil.php?id=<?= $comment->user->id; ?>"><?= $comment->user->name; ?></a>
            <?= $comment->body; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="fic-answer row m-height-10 m-width-20">
        <div class="fic-item-photo">
          <a href="<?= $baseURL; ?>/perfil.php"><img src="<?= $baseURL; ?>/media/avatars/<?= $user->avatar; ?>" /></a>
        </div>
        <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
        </div>
      </div>
  </div>
</div>