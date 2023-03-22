<?php
  session_start();

  $parsed = parse_ini_file('./environment.ini', true);

  $baseURL = $parsed[$parsed['ENVIRONMENT']]['BASE_URL'];
  $db_name = $parsed[$parsed['ENVIRONMENT']]['DB_NAME'];
  $db_host = $parsed[$parsed['ENVIRONMENT']]['DB_HOST'];
  $db_user = $parsed[$parsed['ENVIRONMENT']]['DB_USER'];
  $db_pass = $parsed[$parsed['ENVIRONMENT']]['DB_PASS'];

  $pdo = new PDO("mysql:dbname=$db_name;host=$db_host", $db_user, $db_pass);
?>