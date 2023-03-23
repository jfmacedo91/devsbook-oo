<?php
  $firstName = current(explode(' ', $user->name));
?>

<div class="box feed-new">
  <div class="box-body">
    <div class="feed-new-editor m-10 row">
      <div class="feed-new-avatar">
        <img src="<?= $baseURL; ?>/media/avatars/<?= $user->avatar; ?>" />
      </div>
      <div class="feed-new-input-placeholder">
        O que você está pensando, <?= $firstName; ?>?
      </div>
      <div class="feed-new-input" contenteditable="true"></div>
      <div class="feed-new-send">
        <img src="<?= $baseURL; ?>/assets/images/send.svg" />
      </div>
      <form class="feed-new-form" action="<?= $baseURL; ?>/feed_editor_action.php" method="POST">
        <input type="hidden" name="body" />
      </form>
    </div>
  </div>
</div>

<script>
  const feedInput = document.querySelector('.feed-new-input');
  const feedSubmit = document.querySelector('.feed-new-send');
  const feedForm = document.querySelector('.feed-new-form');

  feedSubmit.addEventListener('click', () => {
    const value = feedInput.innerHTML.trim();
    feedForm.querySelector('input[name=body]').value = value;
    feedForm.submit();
  })
</script>