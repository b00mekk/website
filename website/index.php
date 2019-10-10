<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('max_execution_time', 300); 
require_once('config.php');
define('OAUTH2_CLIENT_ID', $config['auth']['auth_client_id']);
define('OAUTH2_CLIENT_SECRET', $config['auth']['auth_client_secret']);
$authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
$tokenURL = 'https://discordapp.com/api/oauth2/token';
$apiURLBase = 'https://discordapp.com/api/users/@me';
$redirect_uri = $config['auth']['auth_redirect_index'];
session_start();

if(get('action') == 'login') {
  $params = array(
    'client_id' => OAUTH2_CLIENT_ID,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => 'identify'
  );

  header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params));
  die();
}

if(get('code')) {

  $token = apiRequest($tokenURL, array(
    "grant_type" => "authorization_code",
    'client_id' => OAUTH2_CLIENT_ID,
    'client_secret' => OAUTH2_CLIENT_SECRET,
    'redirect_uri' => $redirect_uri,
    'code' => get('code')
  ));
  $logout_token = $token->access_token;
  $_SESSION['access_token'] = $token->access_token;
  header('Location: ' . $_SERVER['PHP_SELF']);
}
if(session('access_token')) {
    $apiURLBase = 'https://discordapp.com/api/users/@me';
    $user = apiRequest($apiURLBase);
    $_SESSION['username'] = $user->username;
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_tag'] = $user->discriminator;
  header('Location: application.php');
}
if(get('action') == 'logout') {

  $params = array(
    'access_token' => $logout_token
  );

  header('Location: https://discordapp.com/api/oauth2/token/revoke' . '?' . http_build_query($params));
  die();
}
function apiRequest($url, $post=FALSE, $headers=array()) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $response = curl_exec($ch);
  if($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $headers[] = 'Accept: application/json';
  if(session('access_token'))
    $headers[] = 'Authorization: Bearer ' . session('access_token');
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $response = curl_exec($ch);
  return json_decode($response);
}
function get($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}
function session($key, $default=NULL) {
  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="css/index.css" type="text/css">
    <?php include('head.php')?>
    <meta property=”og:title” content="Test server" />
    <meta property=”og:image” content="./img/logo.png" />

    <meta property=”og:image:width” content="1920" />

    <meta property=”og:image:height” content=”1080″ />

    <meta property=”og:url” content="frostedflakes.pl" />

    <meta property=”og:description” content="Test server - Join today." />

</head>

<body>
    <header>
        <div class="logo">
            <img src="./img/logo.png" alt="Test Server">
        </div>
        <div class="btnGroup">
            <a href="admin.php?action=login">Administrator's panel</a>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="wrapper">
                <p class="title">Welcome on <span style="color:tomato">TEST SERVER</span></p>
                <p class="info">Hello welcome on test server, proffesional fivem server login
                    with 
                    discord account and have fun playing on our server.</p>
                <a href="?action=login" class="login">Login with Discord</a>
            </div>
            <div class="wrapper">
                <p class="title">About our <span style="color:tomato">server.</span></p>
                <p class="info white"><span style="color:tomato">Test server</span> is roleplay server on
                    platform FiveM. Our server
                    our server is very good, we have own scripts, theyre really, like really
                    good
                    join us.</p>
                <a href="https://discord.gg/GXuHvrR" class="discord">Join on our Discord</a>
            </div>
        </div>
    </main>
</body>

</html>