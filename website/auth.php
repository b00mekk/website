<?php 
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('max_execution_time', 300); 
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['user_tag']) || !isset($_SESSION['user_id'])) header("Location: index.php");
?>