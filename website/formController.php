<?php 
include('auth.php');
include('db.php');
if(!isset($_POST['steam']) || !isset($_POST['age'])  || !isset($_POST['rolePlayDefinition']) || !isset($_POST['charName']) || !isset($_POST['charDesc']) || !isset($_POST['charJob']) || !isset($_POST['mg'])) return header("Location: index.php");

$username = $_SESSION['username'];
$user_tag = $_SESSION['user_tag'];
$user_id = $_SESSION['user_id'];
$steam = $_POST['steam'];
$age = $_POST['age'];
$rolePlayDefinition = $_POST['rolePlayDefinition'];
$charName = $_POST['charName'];
$charDesc = $_POST['charDesc'];
$charJob = $_POST['charJob'];
$mg = $_POST['mg'];
$meDo = $_POST['meDo'];
$fear = $_POST['fear'];
$date = date("Y-m-d")." ".date("H:i:s");

if($age < 10 || $age > 100) $_SESSION['error'] = "Niepoprawny wiek.";
if(!preg_match('[0-9a-zA-Z]+', $steam))  $_SESSION['error'] = "Niepoprawny steam HEX.";
if(strlen($rolePlayDefinition) < 50) $_SESSION['error'] = "Za mała ilośc znaków w polu o trybie RolePlay";
if(strlen($charName) < 3 || strlen($charName) > 55) $_SESSION['error'] = "Niepoprawna nazwa postaci";
if(strlen($charDesc) < 750) $_SESSION['error'] = "Opis postaci zawiera za mało znaków";
if(strlen($charJob) < 10) $_SESSION['error'] = 'Rozpisz się bardziej na temat postaci, którą chcesz odgrywać.';
if(strlen($mg) < 15) $_SESSION['error'] = "Wyjaśnij szerzej czym jest Metagaming";
if(strlen($meDo) < 15) $_SESSION['error'] = "Wyjaśnij szerzej różnicę między /me i /do";
if(strlen($fear) < 15) $_SESSION['error'] = "Wyjaśnij szerzej czym jest nieposzanowanie życia";
if(isset($_SESSION['error'])) header("Location: application.php");
$dbCheck = $sql->prepare("SELECT * FROM `applications` WHERE `discordID` = ?");
$dbCheck->execute(array($user_id));
$rows = $dbCheck->rowCount();

if($rows <= 0 ) {
    $insertData = $sql->prepare("INSERT INTO `applications` VALUES(NULL,  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?)");
        if ($insertData->execute(array($user_id, $user_tag, $username, $age, $rolePlayDefinition, $charName, $charDesc, $charJob, $mg, $steam, $date, $meDo, $fear))) {
            header("Location: status.php");
        } else $_SESSION['error'] = "Wystąpił błąd, spróbuj ponownie później"; header("Location: application.php");
    } else {$_SESSION['error'] = "Twoje podanie zostało już złożone, oczekuj na rozpatrzenie.";  header("Location: status.php");}

?>