<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/PostDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();

  $id = filter_input(INPUT_GET, 'id');

  if($id) {
    $postDao = new PostDaoMysql($pdo);

    $postDao->delete($id, $user->id);
  }

  header("Location: $baseURL");
  exit;
?>