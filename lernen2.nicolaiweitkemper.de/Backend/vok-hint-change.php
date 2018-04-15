<?php

//$username = "nicolai";
$username = $_GET["username"];

//$lektion = "21 Unidad 6 ¡Bienvenidos a México! - ¡Vamos!";
$lektion = $_GET["level"];

$string = file_get_contents("Userdata/".$username.".json");
$json = json_decode($string, true);

if (isset($json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]])) {
$json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["hint"] = $_GET["hint"];
}

  
$output = json_encode($json);

if (!empty($output)) file_put_contents("Userdata/".$username.".json", $output);

echo "okay";

?>
