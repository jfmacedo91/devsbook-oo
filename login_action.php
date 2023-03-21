<?php
  require 'config.php';
  require 'models/Auth.php';

  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $password = filter_input(INPUT_POST, 'password');

  if($email && $password) {
    $auth = new Auth($pdo, $baseURL);

    if($auth->validateLogin($email, $password)) {
      header("Location: $baseURL");
      exit;
    }
  }

  header("Location: $baseURL/login.php");
  exit;
?>