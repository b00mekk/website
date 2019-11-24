<?php 
include('auth.php');
include('db.php');
// Privilage check
$isAdmin = $sql->prepare("SELECT * FROM `admins` WHERE userID = ?");
$isAdmin->execute(array($_SESSION['user_id']));

$rows = $isAdmin->rowCount();
if ($rows <= 0 ) { unset($_SESSION['username']);
    unset($_SESSION['user_tag']);
    unset($_SESSION['user_id']);
    unset($_SESSION['access_token']);
    header("Location: index.php");}

if(isset($_GET['delete'])) {
    $deleteRow = $sql->prepare("DELETE FROM `applications` WHERE id = ?");
    if(!$deleteRow->execute(array($_GET['delete']))) {
        $_SESSION['error'] = "Wystąpił błąd podczas usuwania, spróbuj ponownie";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <?php include('head.php')?>
    <link rel="stylesheet" href="./css/adminPanel.css" type="text/css">
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
        <a href="?logout" class="logout">Wyloguj</a>
        <div class="logo">
            <p>TwojSerwer Panel Administratora</p>
            <img src="./img/logo.png" alt="Twojserwer">
        </div>
        <div class="tableContainer">
            <table>
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Nazwa discord</td>
                        <td>Data</td>
                        <td>Status</td>
                        <td>Zarządzaj</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $loadApplication = $sql->prepare("SELECT * FROM `applications` WHERE `status` = 1");
                    $loadApplication->execute();

                    $rows = $loadApplication->rowCount();
                    if($rows > 0) {
                        $applications = $loadApplication->fetchAll();
                        foreach($applications as $app) {
                            $status = $app['status'];
                            switch ($status) {
                                case 1:$status = 'Do sprawdzenia';
                                break;
                                case 2:$status = 'Zaakceptowane';
                                break;
                                case 3:$status = 'Odrzucone';
                                break;
                            }
                            echo '<tr>';
                            echo '<td>'.$app['id'].'</td>';
                            echo '<td> '.$app['discordName'].'#'.$app['discordTAG'].'</td>';
                            echo '<td>'.$app['date'].'</td>';
                            echo '<td>'.$status.'</td>';
                            echo '<td><a href="manageApplication.php?check='.$app['id'].'" class="checkBtn">Sprawdź</a> <a href="?delete='.$app['id'].'" class="deleteBtn">X</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr>';
                        echo '<td></td>';
                        echo '<td>Brak aplikacji do sprawdzenia.</td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>
        </div>

    </main>
</body>

</html>
