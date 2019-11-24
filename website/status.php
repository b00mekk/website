<?php 
include('auth.php');
include('db.php');

    $applicationState = $sql->prepare('SELECT `status` FROM `applications` WHERE discordID = ?');
    $applicationState->execute(array($_SESSION['user_id']));
    
    $rows = $applicationState->rowCount();
    if($rows > 0) {
        $status = $applicationState->fetchAll();
        switch($status[0]['status']) {
            case 1: $status = "The application is checked"; break;
            case 2: $status = "The application got accepted."; break;
            case 3: $status = "The application was rejected"; break;
        }
    } else {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <?php include('head.php')?>
    <link rel="stylesheet" href="./css/status.css" type="text/css">
</head>

<body>
    <main>
        <?php if(isset($_SESSION['error'])) {
        echo '<div class="error">Wystąpił błąd: '.$_SESSION['error'].'</div>';
        unset($_SESSION['error']);
        }
        if(isset($_GET['logout'])) {
            unset($_SESSION['username']);
            unset($_SESSION['user_tag']);
            unset($_SESSION['user_id']);
            unset($_SESSION['access_token']);
            header("Location: index.php");
        }
        ?>
        <a href="?logout" class="logout">Logout</a>
        <div class="logo">
            <img src="./img/logo.png" alt="YourServer">
        </div>
        <div class="statusContainer">
            <p>Status of your application: <?php echo $status?></p>
        </div>

    </main>
</body>

</html>
