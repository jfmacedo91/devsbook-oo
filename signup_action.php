<?php
  require 'config.php';
  require 'models/Auth.php';

  $name = filter_input(INPUT_POST, 'name');
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $password = filter_input(INPUT_POST, 'password');
  $birthdate = filter_input(INPUT_POST, 'birthdate');

  if($name && $email && $password && $birthdate) {
    $auth = new Auth($pdo, $baseURL);

    [$day, $month, $year] = explode('/', $birthdate);
    if(count(explode('/', $birthdate)) != 3) {
      $_SESSION['flash'] = 'Data de nascimento inválida!';
      header("Location: $baseURL/signup.php");
      exit;
    }

    $birthdate = "$year-$month-$day";
    if(strtotime($birthdate) === false) {
      $_SESSION['flash'] = 'Data de nascimento inválida!';
      header("Location: $baseURL/signup.php");
      exit;
    }

    if($auth->emailExists($email)) {
      $_SESSION['flash'] = 'Email já cadastrado!';
      header("Location: $baseURL/signup.php");
      exit;
    }

    $auth->registerUser($name, $email, $password, $birthdate);
    header("Location: $baseURL");
    exit;
  }

  $_SESSION['flash'] = 'Preencha todos os compos corretamente!';
  header("Location: $baseURL/signup.php");
  exit;
?>