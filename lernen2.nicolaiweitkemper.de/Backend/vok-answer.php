<?php

$username = $_GET["username"];
$lektion = $_GET["level"];

$json = json_decode(file_get_contents("Userdata/".$username.".json"), true);

$vok = $json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]];

incrementOr($vok["total"]);

if ($_GET["correct"] == "true") {
  incrementOr($vok["successful"]);
  incrementOr($vok["lauf"]);
}
else {
  $vok["lauf"] = 0;
  incrementOr($vok["errors"][$_GET["input"]]);
}

$absPhase = ($vok["phase"] ?? 0) + ($_GET["correct"] == "true" ? 1 : -1);
$vok["phase"] = $absPhase > -1 ? $absPhase : -1;

//-------

$json["data"][$_GET["course"]][$_GET["level"]][$_GET["spa"]] = $vok;

$log = fopen("../log.txt", "a");
  
$output = json_encode($json);

if (!empty($output)) file_put_contents("Userdata/".$username.".json", $output);
else fwrite($log, date("d.m.Y-h:i:s").' - Fehler!!! (vok-answer)\n');



fwrite($log, date("d.m.Y-h:i:s").' - Versuch für Wort: "'.$_GET["spa"].'"'."\n");

fclose($log);

//var_dump($json);
//echo $output;
echo json_encode($vok);
//echo "okay";

function incrementOr(&$val, $default) {
  $default = $default ?? 0;
  $val = ($val ?? $default) + 1;
}

?>
