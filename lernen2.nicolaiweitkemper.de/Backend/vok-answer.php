<?php

//$username = "nicolai";
$username = $_GET["username"];

//$lektion = "21 Unidad 6 ¡Bienvenidos a México! - ¡Vamos!";
$lektion = $_GET["level"];

$json = json_decode(file_get_contents("Userdata/".$username.".json"), true);

if (isset($json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]])) {

  $json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["total"]++;
  if ($_GET["correct"] == "true") $json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["successful"]++;
  else {
    if (isset($json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["errors"][$_GET["input"]])) $json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["errors"][$_GET["input"]]++;
    else $json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["errors"][$_GET["input"]] = 1;
  }

}
else {

$json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["total"] = 1;
$json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["successful"] = ($_GET["correct"] == true) ? 1 : 0;

//vllt. unnötig
//$json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["errors"] = array();

}

if (!isset($json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["lauf"])) $json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["lauf"] = ($_GET["correct"] == "true") ? 1 : 0;

if ($_GET["correct"] == "true") $json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["lauf"]++;
else $json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["lauf"] = 0;


//Phase:
if (!isset($json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["phase"])) $json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["phase"] = ($_GET["correct"] == "true") ? 1 : 0;
$json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["phase"] += ($_GET["correct"] == "true") ? 1 : ($json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]]["phase"] > -2 ? -1 : 0);



$log = fopen("../log.txt", "a");
  
$output = json_encode($json);

if (!empty($output)) file_put_contents("Userdata/".$username.".json", $output);
else fwrite($log, date("d.m.Y-h:i:s").' - Fehler!!! (vok-answer)\n');



fwrite($log, date("d.m.Y-h:i:s").' - Versuch für Wort: "'.$_GET["spa"].'"'."\n");

fclose($log);

//var_dump($json);
//echo $output;
echo "okay";

//?>
