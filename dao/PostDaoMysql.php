<?php
  require_once 'models/Post.php';
  require_once 'dao/PostDaoMysql.php';
  require_once 'dao/RelationshipDaoMysql.php';
  require_once 'dao/UserDaoMysql.php';

  class PostDaoMysql implements PostDAO {
    private $pdo;

    public function __construct(PDO $driver) {
      $this->pdo = $driver;
    }

    private function _postListToObject($postList, $userId) {
      $posts = [];

      $userDao = new UserDaoMysql($this->pdo);

      foreach($postList as $post) {
        $newPost = new Post();
        $newPost->id = $post['id'];
        $newPost->type = $post['type'];
        $newPost->created_at = $post['created_at'];
        $newPost->body = $post['body'];
        $newPost->mine = false;

        if($post['user_id'] == $userId) {
          $newPost->mine = true;
        }

        $newPost->user = $userDao->findById($post['user_id']);

        $newPost->likeCount = 0;
        $newPost->liked = false;

        $newPost->comments = [];

        $posts[] = $newPost;
      }

      return $posts;
    }

    public function insert(Post $post) {
      $sql = $this->pdo->prepare('INSERT INTO posts (
        user_id, type, created_at, body
      ) VALUES (
        :user_id, :type, :created_at, :body
      )');
      $sql->bindValue(':user_id', $post->user_id);
      $sql->bindValue(':type', $post->type);
      $sql->bindValue(':created_at', $post->created_at);
      $sql->bindValue(':body', $post->body);
      $sql->execute();
    }

    public function getHomeFeed($userId) {
      $feed = [];

      $relationshipDao = new RelationshipDaoMysql($this->pdo);
      $usersList = $relationshipDao->getFollowing($userId);
      $usersList[] = $userId;

      $sql = $this->pdo->query('SELECT * FROM posts
        WHERE user_id IN ('.implode(',', $usersList).')
        ORDER BY created_at DESC');

      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        $feed = $this->_postListToObject($data, $userId);
      }

      return $feed;
    }

    public function getUserFeed($userId) {
      $feed = [];

      $sql = $this->pdo->prepare("SELECT * FROM posts
        WHERE user_id = :user_id
        ORDER BY created_at DESC");
      $sql->bindValue(':user_id', $userId);
      $sql->execute();

      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        $feed = $this->_postListToObject($data, $userId);
      }

      return $feed;
    }

    public function getUserPhotos($userId) {
      $photos = [];

      $sql = $this->pdo->prepare("SELECT * FROM posts
      WHERE user_id = :user_id AND type = 'photo'
      ORDER BY created_at DESC");
      $sql->bindValue(':user_id', $userId);
      $sql->execute();

      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        $photos = $this->_postListToObject($data, $userId);
      }

      return $photos;
    }
  }
?>