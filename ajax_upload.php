<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/PostDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $postDao = new PostDaoMysql($pdo);

  $user = $auth->checkToken();

  $maxWidth = 800;
  $maxHeight = 800;

  $files = ['error' => ''];

  if(isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
    $photo = $_FILES['photo'];

    if(in_array($photo['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {
      [$originalWidth, $originalHeight] = getimagesize($photo['tmp_name']);
      $ratio = $originalWidth / $originalHeight;

      $newWidth = $maxWidth;
      $newHeight = $newWidth / $ratio;

      if($newHeight > $maxHeight) {
        $newHeight = $maxHeight;
        $newWidth = $newHeight * $ratio;
      }

      $finalImage = imagecreatetruecolor($newWidth, $newHeight);
      switch($photo['type']) {
        case 'image/jpeg':
        case 'image/jpg':
          $image = imagecreatefromjpeg($photo['tmp_name']);
        break;
        case 'image/png':
          $image = imagecreatefrompng($photo['tmp_name']);
        break;
      }

      imagecopyresampled(
        $finalImage, $image,
        0, 0, 0, 0,
        $newWidth, $newHeight, $originalWidth, $originalHeight
      );

      $photoName = md5(time().mt_rand(0, 9999).'.jpg');
      imagejpeg($finalImage, "media/uploads/$photoName");

      $newPost = new Post();
      $newPost->user_id = $user->id;
      $newPost->type = 'photo';
      $newPost->created_at = date('Y-m-d H:i:s');
      $newPost->body = $photoName;

      $postDao->insert($newPost);
    } else {
      $files['error'] = 'Arquivo não suportado!';
    }
  } else {
    $files['error'] = 'Nenhuma imagem enviada!';
  }

  header("Content-Type: application/json");
  echo json_encode($files);
  exit;
?>