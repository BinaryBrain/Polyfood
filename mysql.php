<?php
class DB {
  function __construct() {
    require(".mysqlpassword");
    $this->pdo = new PDO('mysql:host=localhost; dbname=polyfood;', "polyfood", $mysqlpassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  }
  
  function inomhere($fbid, $restaurant) {
    echo " | DB: ".$fbid." ".$restaurant;
    $query = $this->pdo->prepare('INSERT INTO whereyounom VALUES (, :fbid, :restaurant)');
    $query->execute(array(':fbid' => $fbid, ':restaurant' => $restaurant));
  }
}
