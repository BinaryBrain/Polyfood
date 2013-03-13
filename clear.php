<?php
if(php_sapi_name() != "cli") exit;

require_once("mysql.php");

$db = new DB();
$db->clear();
