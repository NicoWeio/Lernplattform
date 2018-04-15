<?php

//$input = json_decode($_GET["json"], true);

$string = file_get_contents("input.json");
$input = json_decode($string, true);

//var_dump($input);
//echo $input[0]["spa"];

$output = array();

foreach($input as $single) {
  
  $level = isset($single["level"]) ? $single["level"] : "Level unbekannt";
  
  $item["spa"] = $single["spa"];
  $item["ger"] = $single["ger"];
  $item["level"] = $level;
  if (!empty($single["note"])) $item["note"] = $single["note"];
  
  if(!isset($output[$level])) $output[$level] = array();
  array_push($output[$level], $item);
  
  //array_push($output, $single);
}

//sleep(5);

echo json_encode($output);
file_put_contents("output.json", json_encode($output));

?>

