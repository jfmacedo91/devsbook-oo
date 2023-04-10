<?php
  require_once 'models/Relationship.php';

  class RelationshipDaoMysql implements RelationshipDAO {
    private $pdo;

    public function __construct(PDO $driver) {
      $this->pdo = $driver;
    }

    public function insert(Relationship $relationship) {
      $sql = $this->pdo->prepare("INSERT INTO relationships
      (user_from, user_to) VALUES (:user_from, :user_to)");
      $sql->bindValue(':user_from', $relationship->userFrom);
      $sql->bindValue(':user_to', $relationship->userTo);
      $sql->execute();
    }

    public function delete(Relationship $relationship) {
      $sql = $this->pdo->prepare("DELETE FROM relationships
      WHERE user_from = :user_from AND user_to = :user_to");
      $sql->bindValue(':user_from', $relationship->userFrom);
      $sql->bindValue(':user_to', $relationship->userTo);
      $sql->execute();
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

    public function isFollowing($loggedUser, $userId) {
      $sql = $this->pdo->prepare("SELECT * FROM relationships
      WHERE user_from = :user_from AND user_to = :user_to");
      $sql->bindValue(':user_from', $loggedUser);
      $sql->bindValue(':user_to', $userId);
      $sql->execute();

      if($sql->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }
  }
?>