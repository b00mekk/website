<?php 
include('auth.php');
include('db.php');
$applicationState = $sql->prepare('SELECT `status` FROM `applications` WHERE discordID = ?');
$applicationState->execute(array($_SESSION['user_id']));

$rows = $applicationState->rowCount();
if($rows > 0) {
    header("Location: status.php");
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <?php include('head.php')?>
    <link rel="stylesheet" href="./css/application.css" type="text/css">
    <script>
    window.addEventListener('load', function() {
        document.getElementsByName('rolePlayDefinition')[0].addEventListener('keypress', event => {
            let value = document.getElementsByName(
                'rolePlayDefinition')[0].value.trim();
            document.getElementsByClassName('lengthCounter')[0].innerHTML = value.length + ' znaków';
        });
        document.getElementsByName('charJob')[0].addEventListener('keypress', event => {
            let value = document.getElementsByName(
                'charJob')[0].value.trim();
            document.getElementsByClassName('lengthCounter')[1].innerHTML = value.length + ' znaków';
        });
        document.getElementsByName('charDesc')[0].addEventListener('keypress', event => {
            let value = document.getElementsByName(
                'charDesc')[0].value.trim();
            document.getElementsByClassName('lengthCounter')[2].innerHTML = value.length +
                '/100 znaków';
        });
        document.getElementsByName('mg')[0].addEventListener('keypress', event => {
            let value = document.getElementsByName(
                'mg')[0].value.trim();
            document.getElementsByClassName('lengthCounter')[3].innerHTML = value.length +
                ' znaków';
        });
    });
    </script>
</head>

<body>
    <main>
        <?php if(isset($_SESSION['error'])) {
        echo '<div class="error">Wystąpił błąd: '.$_SESSION['error'].'</div>';
        echo $_SESSION['error'];
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
        <div class="whitelistContainer">
            <div class="logo">
                <img src="./img/logo.png">
            </div>
            <div class="whitelistBody">
                <form action="formController.php" method="POST">
                    <div class="twoRows">
                        <label for="age">Twój Wiek <span class="yellow">(OOC)</span></label>
                        <label for="steam">STEAM HEX</label>
                    </div>
                    <div class="twoRows">
                        <input type="number" placeholder="24 lata" name="age" min="10" max="100" required>
                        <input type="text" placeholder="76561197960287930" name="steam" required>
                    </div>
                    <label for="charName">Imię i nazwisko twojej postaci</label>
                    <input type="text" placeholder="Imię Nazwisko" name="charName" minlength="5" maxlength="25"
                        required>
                    <label for="rolePlayDefinition">Czym według Ciebie jest Role Play </label>
                    <textarea type="text" placeholder="Czym według Ciebie jest roleplay?" name="rolePlayDefinition"
                        minlength="50" maxlength="15000" required></textarea>
                    <span class="lengthCounter">0 znaków</span>
                    <label for="charJob">Jaką postać zamierzasz odgrywać?</label>
                    <textarea placeholder="Jaką postać zamierzasz odgrywać?" name="charJob" minlength="20"
                        required></textarea>
                    <span class="lengthCounter">0 znaków</span>
                    <label for="charDesc">Przedstaw historię postaci, którą zamierzasz grać. <span
                            class="yellow">(MINIMUM 100 ZNAKÓW)</span></label>
                    <textarea placeholder="Historia postaci" name="charDesc" minlength="100" maxlength="15000"
                        required></textarea>
                    <span class="lengthCounter">0/100 znaków</span>
                    <label for="mg">Rozwiń skrót MG i wytłumacz co to jest <span class="yellow">(MG)</span></label>
                    <textarea placeholder="Rozwiń skrót MG i wytłumacz co to jest" name="mg" minlength="15"
                        required></textarea>
                    <span class="lengthCounter">0 znaków</span>
                    <label for="meDo">Czym różni się komenda /me od komendy /do. Podaj przykład zastosowania obu
                        komend. <span class="yellow">(/me i /do)</span></label>
                    <textarea
                        placeholder="Czym różni się komenda /me od komendy /do. Podaj przykład zastosowania obu komend."
                        name="meDo" minlength="15" required></textarea>
                    <label for="fear">Czym jest nieposzanowanie życia?</label>
                    <textarea placeholder="Czym jest nieposzanowanie życia?" name="fear" minlength="15"
                        required></textarea>
                    <input type="submit" value="Wyślij podanie">
                </form>
            </div>
        </div>
    </main>
</body>

</html>