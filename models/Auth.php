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
  }
?>