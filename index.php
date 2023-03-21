<?php
  require 'config.php';
  require 'models/Auth.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();

  echo "index"
?>