<?php

session_start();

use app\library\Authenticate;
use app\library\GoogleClient;

require '../vendor/autoload.php';

$googleClient = new GoogleClient;
$googleClient->init();
$auth = new Authenticate;

if($googleClient->authorized()){
    $auth->authGoogle(data: $googleClient->getData());
}

if(isset($_GET['logout'])){
    $auth->logout();
}

$authUrl = $googleClient->generateAuthLink();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Olá,</h3>
    <div>
        <?php
        if(isset($_SESSION['user'], $_SESSION['auth'])):
            echo $_SESSION['user']->firstName . ' ' . $_SESSION['user']->lastName;
            ?>
        <a href="?logout=true">Logout</a>
        <?php else: ?>
            <h3>Visitante</h3>
        <?php endif ?>
        </div>
    <form action="">
        <input type="text" name="email" placeholder="email" />
        <input type="text" name="password" placeholder="password" />
        <button type="submit">Login</button>
        <a href="<?php echo $authUrl ?>">Login with google</a>
    </form>
</body>
</html>