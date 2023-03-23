<?php
  class User {
    public $id;
    public $email;
    public $password;
    public $name;
    public $birthdate;
    public $city;
    public $work;
    public $avatar;
    public $cover;
    public $token;
  }

  interface UserDAO {
    public function findByToken($token);
    public function findByEmail($token);
    public function update(User $user);
    public function insert(User $user);
  }
?>