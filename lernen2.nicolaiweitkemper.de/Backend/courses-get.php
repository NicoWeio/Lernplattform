<?php

/*$kurs = $_GET["course"];

$string = file_get_contents("Ressourcen/".$kurs.".json");
$json = json_decode($string, true);


echo json_encode(array_keys($json));*/

//$files = array_map(function ($single) {if ()});

$files = array_diff(scandir("Ressourcen"), array('..', '.'));

$output = [];

foreach ($files as $singleFile) {
  $id = explode(".",$singleFile)[0];
  $meta = json_decode(file_get_contents("Ressourcen/".$singleFile), true)["meta"];
  $single = [];
  $single["id"] = $id;
  $single["title"] = $meta["title"];
  $single["language"] = $meta["language"];
  array_push($output, $single);
}

echo json_encode($output);


//echo '[{"title":"Spanisch Q1", "id":"spanisch-q1"}]';

?>