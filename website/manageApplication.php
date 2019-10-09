<?php
include('auth.php');
include('db.php');
if(!isset($_GET['check'])) header("Location: index.php"); else $id = $_GET['check'];
// Privilage check
$isAdmin = $sql->prepare("SELECT * FROM `admins` WHERE userID = ?");
$isAdmin->execute(array($_SESSION['user_id']));

$rows = $isAdmin->rowCount();
if ($rows <= 0 ) header("Location: index.php");

$loadApplication = $sql->prepare("SELECT * FROM `applications` WHERE `id` = ?");
    $loadApplication->execute(array($id));

    $rows = $loadApplication->rowCount();
    if($rows > 0) {
    $application = $loadApplication->fetchAll();
    }
    if(isset($_GET['accept'])) {
        $acceptApplication = $sql->prepare('UPDATE `applications` SET `status` = 2 WHERE id= ?');
        if($acceptApplication->execute(array($_GET['check']))) {
          // webhook send
          $url = "discord_webhook_url";
          $hookObject = json_encode([
              "content" => "<@".$application[0]['discordID']."> Your application was accepted."
          ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
          
          $ch = curl_init();
          
          curl_setopt_array( $ch, [
              CURLOPT_URL => $url,
              CURLOPT_POST => true,
              CURLOPT_POSTFIELDS => $hookObject,
              CURLOPT_HTTPHEADER => [
                  "Length" => strlen( $hookObject ),
                  "Content-Type" => "application/json"
              ]
          ]);
          
          $response = curl_exec( $ch );
          curl_close( $ch );
            
            header("Location: adminPanel.php");} else $_SESSION['error'] = "Im not able to change status, try again later.";

    }
    if(isset($_GET['deny'])) {
        $denyApplication = $sql->prepare('UPDATE `applications` SET `status` = 3 WHERE id= ?');
        if($denyApplication->execute(array($_GET['check']))) {header("Location: adminPanel.php");} else $_SESSION['error'] = "Im not able to change status, try again later.";
    }
    if(isset($_GET['delete'])) {
        $deleteApplication = $sql->prepare('DELETE FROM `applications` WHERE id= ?');
        if($deleteApplication->execute(array($_GET['check']))) {header("Location: adminPanel.php");} else $_SESSION['error'] = "Im not able to change status, try again later.";
    }
?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <?php include('head.php')?>
    <link rel="stylesheet" href="./css/manageApplication.css" type="text/css">
</head>

<body>
    <main>
        <?php if(isset($_SESSION['error'])) {
        echo '<div class="error">Error: '.$_SESSION['error'].'</div>';
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
            <p>Test serwer application [Application #<?php echo $_GET['check']?>]</p>
            <img src="./img/logo.png" alt="AvenueRP">
        </div>
        <div class="infoContainer">
            <div class="row">
                <p class="rowTitle">Applciators info</p>
                <table>
                    <thead>
                        <tr>
                            <td>Discord ID</td>
                            <td>Discord name</td>
                            <td>Discord TAG</td>
                            <td>Steam 64</td>
                            <td>Application creation date</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            echo '<tr>';
                            echo '<td>'.$application[0]['discordID'].'</td>';
                            echo '<td> '.$application[0]['discordName'].'</td>';
                            echo '<td>#'.$application[0]['discordTAG'].'</td>';
                            echo '<td>'.$application[0]['steam'].'</td>';
                            echo '<td>'.$application[0]['date'].'</td>';
                            echo '</tr>';
                ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <p class="rowTitle">Dane postaci</p>
                <table>
                    <thead>
                        <tr>
                            <td>Name and Surname</td>
                            <td>Character age</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            echo '<tr>';
                            echo '<td>'.$application[0]['charName'].'</td>';
                            echo '<td>'.$application[0]['age'].'</td>';
                            echo '</tr>';
                ?>
                    </tbody>
                </table>
                <p class="innerSection">Character description</p>
                <div class="description">
                    <?php
                    echo $application[0]['charDesc'];?>
                </div>
            </div>
            <div class="row">
                <p class="rowTitle">Pytania opisowe</p>
                <p class="innerSection">RolePlay definition</p>
                <div class="description"><?php echo $application[0]['rpDefinition']?></div>
                <p class="innerSection">What character are you going to play</p>
                <div class="description"><?php echo $application[0]['charJob']?></div>
                <p class="innerSection">Rozwiń skrót MG i wytłumacz co to jest</p>
                <div class="description"><?php echo $application[0]['mg']?></div>
                <p class="innerSection">Czym różni się komenda /me od komendy /do. Podaj przykład zastosowania obu
                    komend. </p>
                <div class="description"><?php echo $application[0]['meDo']?></div>
                <p class="innerSection">Czym jest nieposzanowanie życia?</p>
                <div class="description"><?php echo $application[0]['fear']?></div>
            </div>
            <div class="row">
                <p class="rowTitle">Akcje</p>
                <div class="buttonsGroup">
                    <a href="?check=<?php echo $_GET['check']?>&accept" class="acceptBtn">Zaakceptuj</a>
                    <a href="?check=<?php echo $_GET['check']?>&deny" class="denyBtn">Odrzuć</a>
                    <a href="?check=<?php echo $_GET['check']?>&delete" class="deleteBtn">Usuń</a>
                </div>
            </div>
        </div>
        </div>

    </main>
</body>

</html>