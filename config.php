<?php
  session_start();

  $baseURL = 'http://localhost/devsbook-oo';
  $db_name = 'devsbook';
  $db_host = 'localhost';
  $db_user = 'root';
  $db_pass = '';

  $pdo = new PDO("mysql:dbname=$db_name;host=$db_host", $db_user, $db_pass);
?>