<?php
  require_once 'models/User.php';
  require_once 'dao/PostDaoMysql.php';
  require_once 'dao/RelationshipDaoMysql.php';

  class UserDaoMysql implements UserDAO {
    private $pdo;

    public function __construct(PDO $driver) {
      $this->pdo = $driver;
    }

    private function generateUser($array, $full = false) {
      $user = new User();
      $user->id = $array['id'] ?? 0;
      $user->email = $array['email'] ?? '';
      $user->name = $array['name'] ?? '';
      $user->password = $array['password'] ?? '';
      $user->birthdate = $array['birthdate'] ?? '';
      $user->city = $array['city'] ?? '';
      $user->work = $array['work'] ?? '';
      $user->avatar = $array['avatar'] ?? '';
      $user->cover = $array['cover'] ?? '';
      $user->token = $array['token'] ?? '';

      if($full) {
        $relationshipDao = new RelationshipDaoMysql($this->pdo);
        $postDao = new PostDaoMysql($this->pdo);

        $user->followers = $relationshipDao->getFollowers($user->id);
        foreach ($user->followers as $key => $follower) {
          $newFollower = $this->findById($follower);
          $user->followers[$key] = $newFollower;
        }
        $user->following = $relationshipDao->getFollowing($user->id);
        foreach ($user->following as $key => $follow) {
          $newFollow = $this->findById($follow);
          $user->following[$key] = $newFollow;
        }

        $user->photos = $postDao->getUserPhotos($user->id);
      }

      return $user;
    }

    public function findByToken($token) {
      if(!empty($token)) {
        $sql = $this->pdo->prepare('SELECT * FROM users WHERE token = :token');
        $sql->bindValue(':token', $token);
        $sql->execute();

        if($sql->rowCount() > 0) {
          $data = $sql->fetch(PDO::FETCH_ASSOC);
          $user = $this->generateUser($data);

          return $user;
        }
      }

      return false;
    }

    public function findByEmail($email) {
      if(!empty($email)) {
        $sql = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $sql->bindValue(':email', $email);
        $sql->execute();

        if($sql->rowCount() > 0) {
          $data = $sql->fetch(PDO::FETCH_ASSOC);
          $user = $this->generateUser($data);

          return $user;
        }
      }

      return false;
    }

    public function findById($id, $full = false) {
      if(!empty($id)) {
        $sql = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
          $data = $sql->fetch(PDO::FETCH_ASSOC);
          $user = $this->generateUser($data, $full);

          return $user;
        }
      }

      return false;
    }

    public function findByName($name) {
      $users = [];

      if(!empty($name)) {
        $sql = $this->pdo->prepare('SELECT * FROM users WHERE name LIKE :name');
        $sql->bindValue(':name', "%$name%");
        $sql->execute();

        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(PDO::FETCH_ASSOC);
          foreach($data as $user) {
            $users[] = $this->generateUser($user);
          }

          return $users;
        }
      }

      return $users;
    }

    public function insert(User $user) {
      $sql = $this->pdo->prepare('INSERT INTO users (
        email, password, name, birthdate, token
      ) VALUES (
        :email, :password, :name, :birthdate, :token
      )');
      $sql->bindValue(':email', $user->email);
      $sql->bindValue(':password', $user->password);
      $sql->bindValue(':name', $user->name);
      $sql->bindValue(':birthdate', $user->birthdate);
      $sql->bindValue(':token', $user->token);
      $sql->execute();

      return true;
    }

    public function update(User $user) {
      $sql = $this->pdo->prepare('UPDATE users SET
        email = :email,
        password = :password,
        name = :name,
        birthdate = :birthdate,
        city = :city,
        work = :work,
        avatar = :avatar,
        cover = :cover,
        token = :token
      WHERE id = :id');
      $sql->bindValue(':email', $user->email);
      $sql->bindValue(':password', $user->password);
      $sql->bindValue(':name', $user->name);
      $sql->bindValue(':birthdate', $user->birthdate);
      $sql->bindValue(':city', $user->city);
      $sql->bindValue(':work', $user->work);
      $sql->bindValue(':avatar', $user->avatar);
      $sql->bindValue(':cover', $user->cover);
      $sql->bindValue(':token', $user->token);
      $sql->bindValue(':id', $user->id);
      $sql->execute();

      return true;
    }
  }
?>