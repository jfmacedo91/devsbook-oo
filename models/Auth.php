<?php
  require_once 'dao/UserDaoMysql.php';

  class Auth {
    private $pdo;
    private $baseURL;
    private $userDao;

    public function __construct(PDO $pdo, $baseURL) {
      $this->pdo = $pdo;
      $this->baseURL = $baseURL;
      $this->userDao = new UserDaoMysql($this->pdo);
    }

    public function checkToken() {
      if(!empty($_SESSION['token'])) {
        $token = $_SESSION['token'];
        $user = $this->userDao->findByToken($token);

        if($user) {
          return $user;
        }
      }

      header("Location: $this->baseURL/login.php");
      exit;
    }

    public function validateLogin($email, $password) {
      $user = $this->userDao->findByEmail($email);
      if($user) {
        if(password_verify($password, $user->password)) {
          $token = md5(time().mt_rand(0, 9999));
          $user->token = $token;
          $this->userDao->update($user);
          $_SESSION['token'] = $token;

          return true;
        }

        $_SESSION['flash'] = 'Senha incorreta!';

        return false;
      }

      $_SESSION['flash'] = 'E-mail não encontrado!';

      return false;
    }

    public function emailExists($email) {
      return $this->userDao->findByEmail($email) ? true : false;
    }

    public function registerUser($name, $email, $password, $birthdate) {
      $newUser = new User();

      $hash = password_hash($password, PASSWORD_DEFAULT);
      $token = md5(time().mt_rand(0, 9999));

      $newUser->name = $name;
      $newUser->email = $email;
      $newUser->password = $hash;
      $newUser->birthdate = $birthdate;
      $newUser->token = $token;

      $newUser = $this->userDao->insert($newUser);

      $_SESSION['token'] = $token;
    }
  }
?>