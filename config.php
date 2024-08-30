<?php
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '1');

// localhost environment
$db_name = "mysql:host=localhost;dbname=zgrocery";
$username = "root";
$password = "";

// // AWS environment
// $db_name = "mysql:host=awseb-e-zpsm9mekgb-stack-awsebrdsdatabase-eqqz85rbw4ei.cn2uk6ma40jr.us-east-1.rds.amazonaws.com;dbname=zgrocery";
// $username = "zzwzzwzz";
// $password = "zzwzzwzz";

$conn = new PDO($db_name, $username, $password);

?>