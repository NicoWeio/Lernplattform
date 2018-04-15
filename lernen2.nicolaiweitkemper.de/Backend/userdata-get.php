<?php

$username = $_GET["username"];

$string = file_get_contents("Userdata/".$username.".json");
$json = json_decode($string, true);

echo json_encode($json["preferences"]);

?>