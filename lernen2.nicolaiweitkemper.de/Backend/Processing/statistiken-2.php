<?php

echo '<meta charset="utf8">';

//$username = $_GET["username"];
$username = "nicolai";

$courseName= "spanisch-2";

$string = file_get_contents("../Userdata/".$username.".json");
$course = json_decode($string, true);


$course = $course["data"][$courseName];
//var_dump($course);



$arr_success = array();
$arr_success_rate = array();



$courseRaw = json_decode(file_get_contents("../Ressourcen/".$courseName.".json"), true);



foreach($course as $level_name => $level_content) {
  
  //echo $level_name;
  
  foreach($level_content as $vok_name => $vok_content) {

    //echo $vok_name."\n";
    
    $errors = $vok_content["errors"];
    
    //var_dump($errors);
    
    //echo("------------------------------------------------------------------------------------<br><br>");
    
    if (!empty($errors)) {
    
    foreach($errors as $error => $error_count) {
      
      //echo $error." - ".$error_count."\n";
      
      if (!empty($error)) {
        
              //echo $error." - ".$error_count."<br><br>";
        
      }
      
      
    }
    
  }
    
    $single_successful = $vok_content["successful"];
    $single_total = $vok_content["total"];
    $single_success_rate = $single_successful / $single_total;
    
    
      $arr_success[$vok_name] = $single_successful;
    
      if ($single_success_rate < 1) $arr_success_rate[$vok_name] = $single_success_rate;
    
    
  }
  
}




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





//echo "<br><br><br><br><br><br><br><br><br><br>";
//var_dump($arr_success);




?>