<?php

echo '<meta charset="utf8">';

//$username = $_GET["username"];
$username = "nicolai";

$courseName= "spanisch-2";

$level = json_decode(file_get_contents("../Ressourcen/".$courseName.".json"), true);

$output = array();

foreach($level as $level_name => $level_content) {
  
  //echo $level_name;
  
  foreach($level_content as $vok) {

    //echo $vok["spa"];
    
    $matches = array();
    
    // "/(?<=^|[\s(])(de|a|con|sobre)(?=^|[\s)])/"
    if (preg_match("/(.*)(?<=^|[\s(])(del?|al?|con|sobre|por|en)(?=^|[\s)])(.*)/", $vok["spa"], $matches) == 1) {
    
      $element = array();
      $element["before"] = $matches[1];
      $element["preposition"] = $matches[2];
      $element["after"] = $matches[3];

      $element["ger"] = $vok["ger"];
      $element["level"] = $vok["level"];

      array_push($output, $element);    
  }
    
    //else echo "X";
    
  }
  
  
  //var_dump($output);
  
  
  
}

  echo json_encode($output);


/*


arsort($arr_success);

echo "<ul>";
foreach($arr_success as $X => $Y) {
  echo "<li>".$Y."x richtig: ".$X."</li>";
}
echo "</ul>";


echo "<br><br><br><br><br><br><br><br><br><br>";


arsort($arr_success_rate);

echo "<ul>";
foreach($arr_success_rate as $X => $Y) {
  echo "<li>".round($Y*100)."% richtig: ".$X."</li>";
}
echo "</ul>";


*/


//echo "<br><br><br><br><br><br><br><br><br><br>";
//var_dump($arr_success);




?>