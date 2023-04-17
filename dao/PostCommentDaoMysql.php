<?php
  require_once 'dao/UserDaoMysql.php';
  require_once 'models/PostComment.php';

  class PostCommentDaoMysql implements PostCommentDAO {
    private $pdo;

    public function __construct(PDO $driver) {
      $this->pdo = $driver;
    }

    public function getComments($postId) {
      $comments = [];

      $sql = $this->pdo->prepare("SELECT * FROM postcomments WHERE post_id = :post_id");
      $sql->bindValue(':post_id', $postId);
      $sql->execute();

      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        $userDaoMysql = new UserDaoMysql($this->pdo);

        foreach($data as $comment) {
          $user = $userDaoMysql->findById($comment['user_id']);

          $commentItem = new PostComment();
          $commentItem->id = $comment['id'];
          $commentItem->postId = $comment['post_id'];
          $commentItem->userId = $comment['user_id'];
          $commentItem->userAvatar = $user->avatar;
          $commentItem->userName = $user->name;
          $commentItem->createdAt = $comment['created_at'];
          $commentItem->body = $comment['body'];

          $comments[] = $commentItem;
        }
      }

      return $comments;
    }

    public function addComments(PostComment $postComment) {
      $sql = $this->pdo->prepare("INSERT INTO postcomments
      (post_id, user_id, created_at, body) VALUES (:post_id, :user_id, NOW(), :body)");
      $sql->bindValue(':post_id', $postComment->postId);
      $sql->bindValue(':user_id', $postComment->userId);
      $sql->bindValue(':body', $postComment->body);
      $sql->execute();
    }

    public function deleteFromPost($postId) {
      $sql = $this->pdo->prepare("DELETE FROM postcomments WHERE post_id = :post_id");
      $sql->bindValue(':post_id', $postId);
      $sql->execute();
    }
  }
?>