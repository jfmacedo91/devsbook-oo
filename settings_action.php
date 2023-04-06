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

    $userDao->update($user);
  }

  header("Location: $baseURL/settings.php");
  exit;
?>