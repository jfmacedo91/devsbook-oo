<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/UserDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();

  $userDao = new UserDaoMysql($pdo);

  $name = filter_input(INPUT_POST, 'name');
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $birthdate = filter_input(INPUT_POST, 'birthdate');
  $city = filter_input(INPUT_POST, 'city');
  $work = filter_input(INPUT_POST, 'work');
  $password = filter_input(INPUT_POST, 'password');
  $password_confirmation = filter_input(INPUT_POST, 'password_confirmation');

  if($name && $email) {
    $user->name = $name;
    $user->city = $city;
    $user->work = $work;

    if($user->email != $email) {
      if($userDao->findByEmail($email) === false) {
        $user->email = $email;
      } else {
        $_SESSION['flash'] = "Email já cadastrado!";
        header("Location: $baseURL/settings.php");
        exit;
      }
    }

    [$day, $month, $year] = explode('/', $birthdate);
    if(count(explode('/', $birthdate)) != 3) {
      $_SESSION['flash'] = 'Data de nascimento inválida!';
      header("Location: $baseURL/settings.php");
      exit;
    }

    $birthdate = "$year-$month-$day";
    if(strtotime($birthdate) === false) {
      $_SESSION['flash'] = 'Data de nascimento inválida!';
      header("Location: $baseURL/settings.php");
      exit;
    }

    $user->birthdate = $birthdate;

    if(!empty($password)) {
      if($password === $password_confirmation) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $user->password = $hash;
      } else {
        $_SESSION['flash'] = 'As senhas estão diferentes!';
        header("Location: $baseURL/settings.php");
        exit;
      }
    }

    if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])) {
      $newAvatar = $_FILES['avatar'];
      if(in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
        $avatarWidth = 200;
        $avatarHeight = 200;

        [$originalWidth, $originalHeight] = getimagesize($newAvatar['tmp_name']);
        $ratio = $originalWidth / $originalHeight;

        $newWidth = $avatarWidth;
        $newHeight = $newWidth / $ratio;

        if($newHeight < $avatarHeight) {
          $newHeight = $avatarHeight;
          $newWidth = $newHeight * $ratio;
        }

        $x = $avatarWidth - $newWidth;
        $y = $avatarHeight - $newHeight;

        $x = $x < 0 ? $x / 2 : $x;
        $y = $y < 0 ? $y / 2 : $y;

        $finalImage = imagecreatetruecolor($avatarWidth, $avatarHeight);
        switch($newAvatar['type']) {
          case 'image/jpeg':
          case 'image/jpg':
            $image = imagecreatefromjpeg($newAvatar['tmp_name']);
          break;
          case 'image/png':
            $image = imagecreatefrompng($newAvatar['tmp_name']);
          break;
        }

        imagecopyresampled(
          $finalImage, $image,
          $x, $y, 0, 0,
          $newWidth, $newHeight, $originalWidth, $originalHeight
        );

        $avatarName = md5(time().mt_rand(0, 9999)).'.jpg';

        imagejpeg($finalImage, './media/avatars/'.$avatarName, 100);

        $user->avatar = $avatarName;
      }
    }

    if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])) {
      $newCover = $_FILES['cover'];
      if(in_array($newCover['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
        $coverWidth = 850;
        $coverHeight = 310;

        [$originalWidth, $originalHeight] = getimagesize($newCover['tmp_name']);
        $ratio = $originalWidth / $originalHeight;

        $newWidth = $coverWidth;
        $newHeight = $newWidth / $ratio;

        if($newHeight < $coverHeight) {
          $newHeight = $coverHeight;
          $newWidth = $newHeight * $ratio;
        }

        $x = $coverWidth - $newWidth;
        $y = $coverHeight - $newHeight;

        $x = $x < 0 ? $x / 2 : $x;
        $y = $y < 0 ? $y / 2 : $y;

        $finalImage = imagecreatetruecolor($coverWidth, $coverHeight);
        switch($newCover['type']) {
          case 'image/jpeg':
          case 'image/jpg':
            $image = imagecreatefromjpeg($newCover['tmp_name']);
          break;
          case 'image/png':
            $image = imagecreatefrompng($newCover['tmp_name']);
          break;
        }

        imagecopyresampled(
          $finalImage, $image,
          $x, $y, 0, 0,
          $newWidth, $newHeight, $originalWidth, $originalHeight
        );

        $coverName = md5(time().mt_rand(0, 9999)).'.jpg';

        imagejpeg($finalImage, './media/covers/'.$coverName, 100);

        $user->cover = $coverName;
      }
    }

    $userDao->update($user);
  }

  header("Location: $baseURL/settings.php");
  exit;
?>