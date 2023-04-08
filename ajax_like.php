<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/PostLikeDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();

  $id = filter_input(INPUT_GET, 'id');

  if(!empty($id)) {
    $postLikeDao = new PostLikeDaoMysql($pdo);
    $postLikeDao->toggleLike($id, $user->id);
  }
?>