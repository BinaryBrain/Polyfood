<?php
class DB {
  function __construct() {
    require(".mysqlpassword.php");
    // $mysqlpassword = ... ;
    
    $this->pdo = new PDO('mysql:host=localhost; dbname=polyfood;', "polyfood", $mysqlpassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  
  function inomhere($fbid, $fbname, $restaurant, $hour) {
    try {
      $query = $this->pdo->prepare('INSERT INTO whereyounom (fbid, fbname, restaurant, hour) VALUES (:fbid, :fbname, :restaurant, :hour) ON DUPLICATE KEY UPDATE fbname=:fbname, restaurant=:restaurant, hour=:hour');
      $query->execute(array(':fbid' => $fbid, ':fbname' => $fbname, ':restaurant' => $restaurant, ':hour'=>$hour));
    }
    catch (PDOException $e) {
      echo "\nConnection failed: " . $e->getMessage();
    }
  }
  
  function getfriendsplaces($friendsids) {
    try {
      $parameters = array();

      // Trick for passing an array to PDO
      $c = '';
      for($i=0, $len=sizeof($friendsids); $i<$len; $i++) {
        if($i != 0)
          $c .= ', ';
        $c .= ':friendsids'.$i;
        $parameters[':friendsids'.$i] = $friendsids[$i]; 
      }
      
      $query = $this->pdo->prepare('SELECT * FROM whereyounom WHERE fbid IN ('.$c.') ORDER BY hour');
      $query->execute($parameters);
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
      echo "\nConnection failed: " . $e->getMessage();
    }
  }
}
