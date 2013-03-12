<?php session_start();
require_once("mysql.php");

// FACEBOOK API
require_once("fb/facebook.php");

$config = array();

require_once(".facebooksecret.php");
// $config['appId'] = ... ;
// $config['secret'] = ... ;

$config['fileUpload'] = false; // optional

$facebook = new Facebook($config);

$uid = $facebook->getUser();
$isConnected = ($uid != 0);

$user = $facebook->api('/me','GET');

if(isset($_GET['place']) && isset($_GET['hour'])) {
  if($isConnected) {
    echo "Adding a nom place: '".$_GET['place']."'";
    $db = new DB();
    $db->inomhere($uid, $user['name'], $_GET['place'], $_GET['hour']);
  }
  else
    echo "Not connected";
}
else
  echo "no nom place";
