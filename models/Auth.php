<?php
  require_once 'dao/UserDaoMysql.php';

  class Auth {
    private $pdo;
    private $baseURL;

    public function __construct(PDO $pdo, $baseURL) {
      $this->pdo = $pdo;
      $this->baseURL = $baseURL;
    }

    public function checkToken() {
      if(!empty($_SESSION['token'])) {
        $token = $_SESSION['token'];
        $userDao = new UserDaoMysql($this->pdo);
        $user = $userDao->findByToken($token);

        if($user) {
          return $user;
        }
      }

      header("Location: $this->baseURL/login.php");
      exit;
    }

    public function validateLogin($email, $password) {
      $userDao = new UserDaoMysql($this->pdo);
      $user = $userDao->findByEmail($email);
      if($user) {
        if(password_verify($password, $user->password)) {
          $token = md5(time().mt_rand(0, 9999));
          $user->token = $token;
          $userDao->update($user);
          $_SESSION['token'] = $token;

          return true;
        }

        $_SESSION['flash'] = 'Senha incorreta!';

        return false;
      }

      $_SESSION['flash'] = 'E-mail não encontrado!';

      return false;
    }
  }
?>