<?php

$kurs = $_GET["course"];

$string = file_get_contents("Ressourcen/".$kurs.".json");
$json = json_decode($string, true)["data"];


echo json_encode(array_keys($json));

?>