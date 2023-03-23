<?php
  require 'config.php';
  require 'models/Auth.php';
  require 'dao/PostDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();

  $body = filter_input(INPUT_POST, 'body');

  if($body) {
    $postDao = new PostDaoMysql($pdo);

    $newPost = new Post();
    $newPost->user_id = $user->id;
    $newPost->type = 'text';
    $newPost->created_at = date('Y-m-d H:i:s');
    $newPost->body = $body;

    $postDao->insert($newPost);
  }

  header("Location: $baseURL");
  exit;
?>