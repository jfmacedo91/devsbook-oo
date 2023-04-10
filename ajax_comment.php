<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'models/PostComment.php';
  require_once 'dao/PostCommentDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();

  $id = filter_input(INPUT_POST, 'id');
  $txt = filter_input(INPUT_POST, 'txt');

  $comment = [];

  if($id && $txt) {
    $postCommentDao = new PostCommentDaoMysql($pdo);
    $newComment = new PostComment();
    $newComment->postId = $id;
    $newComment->userId = $user->id;
    $newComment->body = $txt;

    $postCommentDao->addComments($newComment);

    $comment = [
      'error' => '',
      'link' => "$baseURL/perfil.php?id=$user->id",
      'avatar' => "$baseURL/media/avatars/$user->avatar",
      'name' => $user->name,
      'body' => $txt
    ];
  }

  header("Content-Type: application/json");
  echo json_encode($comment);
  exit;
?>