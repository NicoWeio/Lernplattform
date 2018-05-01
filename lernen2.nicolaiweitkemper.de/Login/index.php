<?php

$username = $_POST["username"];
$password = $_POST["password"];

if (!isset($username) || !isset($password)) showLogin();



$string = file_get_contents("../Backend/Userdata/".$username.".json");
$json = json_decode($string, true);


if ($string !== false && $password == $json["login"]["password"]) {
  setcookie("Lernplattform-Login", $username, time()+60*60*24*30, "/");
  header('Location: https://lernen2.nicolaiweitkemper.de/');
  die();
}
else showLogin();

function showLogin() {
  echo '<head>
    <title>Login - Vokabelplattform</title>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class="box">
    <form method="post">
    <input type="text" name="username" placeholder="Benutzername">
    <br>
    <input type="password" name="password" placeholder="Passwort">
    <br>
    <div class="buttons">
    <div><span><input type="submit" value="Einloggen"></span></div>
    </div>
    </form>
    </div>
    </body>';
  die();
}

?>
