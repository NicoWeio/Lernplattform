<?php

$username = $_GET["username"];
$password = $_GET["password"];

$string = file_get_contents("Userdata/".$username.".json");
$json = json_decode($string, true);


if ($password == $json["login"]["password"]) {
  setcookie("Lernplattform-Login", $username, time()+60*60*24*30, "/");
  header('Location: https://lernen.nicolaiweitkemper.de/Vokabeln/abfrage.html');
}
else {
  header('Location: https://lernen.nicolaiweitkemper.de/Vokabeln/login.html');
  die();
}

?>
