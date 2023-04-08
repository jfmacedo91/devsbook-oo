<?php
  require_once 'models/PostLike.php';

  class PostLikeDaoMysql implements PostLikeDAO {
    private $pdo;

    public function __construct(PDO $driver) {
      $this->pdo = $driver;
    }

    public function getLikeCount($postId) {
      $sql = $this->pdo->prepare("SELECT COUNT(*) as count FROM postlikes
      WHERE post_id = :post_id");
      $sql->bindValue(':post_id', $postId);
      $sql->execute();
      $data = $sql->fetch();
      return $data['count'];
    }

    public function isLiked($postId, $userId) {
      $sql = $this->pdo->prepare("SELECT * FROM postlikes
      WHERE post_id = :post_id AND user_id = :user_id");
      $sql->bindValue(':post_id', $postId);
      $sql->bindValue(':user_id', $userId);
      $sql->execute();
      if($sql->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

    public function toggleLike($postId, $userId) {
      if($this->isLiked($postId, $userId)) {
        $sql = $this->pdo->prepare("DELETE FROM postlikes
        WHERE post_id = :post_id AND user_id = :user_id");
      } else {
        $sql = $this->pdo->prepare("INSERT INTO postlikes
        (post_id, user_id, created_at) VALUES (:post_id, :user_id, NOW())");
      }
      $sql->bindValue(':post_id', $postId);
      $sql->bindValue(':user_id', $userId);
      $sql->execute();
    }
  }
?>