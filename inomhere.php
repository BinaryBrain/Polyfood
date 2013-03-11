<?php session_start();
require_once("mysql.php");

// FACEBOOK API
require_once("fb/facebook.php");

$config = array();
require_once(".facebooksecret.php");
$config['fileUpload'] = false; // optional

$facebook = new Facebook($config);

$uid = $facebook->getUser();
$isConnected = ($uid != 0);

if(isset($_GET['place'])) {
  if($isConnected) {
    echo "Adding a nom place ".$_GET['place'];
    $db = new DB();
    $db->inomhere($uid, $_GET['place']);
  }
  else
    echo "Not connected";
}
else
  echo "no nom place";
