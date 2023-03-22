<?php
  session_start();

  $parsed = parse_ini_file('./environment.ini', true);
  $_ENV['ENVIRONMENT'] = $parsed['ENVIRONMENT'];
  foreach($parsed[$parsed['ENVIRONMENT']] as $key => $value) {
    $_ENV[$key] = $value;
  }

  $baseURL = $_ENV['BASE_URL'];
  $db_name = $_ENV['DB_NAME'];
  $db_host = $_ENV['DB_HOST'];
  $db_user = $_ENV['DB_USER'];
  $db_pass = $_ENV['DB_PASS'];

  $pdo = new PDO("mysql:dbname=$db_name;host=$db_host", $db_user, $db_pass);
?>