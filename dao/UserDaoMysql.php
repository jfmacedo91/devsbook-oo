<?php
  require_once 'models/User.php';

  class UserDaoMysql implements UserDAO {
    private $pdo;

    public function __construct(PDO $driver) {
      $this->pdo = $driver;
    }

    private function generateUser($array) {
      $user = new User();
      $user->id = $array['id'] ?? 0;
      $user->email = $array['email'] ?? '';
      $user->name = $array['name'] ?? '';
      $user->birthdate = $array['birthdate'] ?? '';
      $user->city = $array['city'] ?? '';
      $user->work = $array['work'] ?? '';
      $user->avatar = $array['avatar'] ?? '';
      $user->cover = $array['cover'] ?? '';
      $user->token = $array['token'] ?? '';
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
    }
  }
?>