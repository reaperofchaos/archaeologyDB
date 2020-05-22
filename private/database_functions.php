<?php

function db_connect() {
  $connection = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
  confirm_db_connect($connection);
  return $connection;
}

function confirm_db_connect($connection) {
  try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
  }
}

function db_disconnect($connection) {
  if(isset($connection)) {
    $connection = null;
  }
}

?>
