<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/UserDaoMysql.php';
  require_once 'dao/RelationshipDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();

  $id = filter_input(INPUT_GET, 'id');

  if($id) {
    $userDao = new UserDaoMysql($pdo);
    $relationshipDao = new RelationshipDaoMysql($pdo);
    
    if($userDao->findById($id)) {
      $relation = new Relationship();
      $relation->userFrom = $user->id;
      $relation->userTo = $id;

      if($relationshipDao->isFollowing($user->id, $id)) {
        $relationshipDao->delete($relation);
      } else {
        $relationshipDao->insert($relation);
      }
    }

    header("Location: perfil.php?id=$id");
    exit;
  }

  header("Location: $baseURL");
  exit;
?>