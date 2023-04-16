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
      <div class="feed-new-photo">
        <img src="<?= $baseURL; ?>/assets/images/photo.svg" />
        <input type="file" class="feed-new-file" name="photo" id="photo" accept="image/png, image/jpg, image/jpeg" />
      </div>
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
  const feedPhoto = document.querySelector('.feed-new-photo');
  const feedSubmit = document.querySelector('.feed-new-send');
  const feedForm = document.querySelector('.feed-new-form');
  const feedFile = document.querySelector('.feed-new-file');

  feedPhoto.addEventListener('click', () => {
    feedFile.click();
  });

  feedSubmit.addEventListener('click', () => {
    const value = feedInput.innerHTML.trim();
    feedForm.querySelector('input[name=body]').value = value;
    feedForm.submit();
  });

  feedFile.addEventListener('change', async () => {
    const photo = feedFile.files[0];
    const formData = new FormData();

    formData.append('photo', photo);
    const req = await fetch('ajax_upload.php', {
      method: 'POST',
      body: formData
    });

    const json = await req.json();

    if(json.error != '') {
      alert(json.error);
    }

    window.location.href = window.location.href;
  });
</script>