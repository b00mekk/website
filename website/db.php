<?php 
require_once('config.php');
DEFINE("db_host", $config['db']['db_host']);
DEFINE("db_user", $config['db']['db_user']);
DEFINE("db_name", $config['db']['db_name']);
DEFINE("db_password", $config['db']['db_password']);
$sql = new PDO('mysql:host='.db_host.';dbname='.db_name, db_user, db_password);


?>