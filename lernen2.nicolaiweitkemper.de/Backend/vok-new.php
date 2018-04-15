<?php

$kurs = $_GET["course"];

$lektion = $_GET["level"];

$string = file_get_contents("Ressourcen/".$kurs.".json");
$json = json_decode($string, true);

$random = rand(0, sizeof($json[$lektion])-1);

//echo $json[$lektion][$random]["spa"];
echo json_encode($json[$lektion][$random]);
//echo $kurs." - ".$lektion;

//var_dump($json);

//echo $json["Unidad 1"][0]["spa"];

$log = fopen("log.txt", "a");

fwrite($log, date("d.m.Y-h:i:s").' - Abfrage von: "'.$json[$lektion][$random]["spa"].'"'."\n");

fclose($log);

?>