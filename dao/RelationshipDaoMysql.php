<?php
  require_once 'models/Relationship.php';

  class RelationshipDaoMysql implements RelationshipDAO {
    private $pdo;

    public function __construct(PDO $driver) {
      $this->pdo = $driver;
    }

    public function insert(Relationship $relationship) {

    }

    public function getFollowers($userId) {
      $users = [];

      $sql = $this->pdo->prepare('SELECT user_from FROM relationships WHERE user_to = :user_to');
      $sql->bindValue(':user_to', $userId);
      $sql->execute();

      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll();
        foreach($data as $item) {
          $users[] = $item['user_from'];
        }
      }

      return $users;
    }

    public function getFollowing($userId) {
      $users = [];

      $sql = $this->pdo->prepare('SELECT user_to FROM relationships WHERE user_from = :user_from');
      $sql->bindValue(':user_from', $userId);
      $sql->execute();

      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll();
        foreach($data as $item) {
          $users[] = $item['user_to'];
        }
      }

      return $users;
    }
  }
?>