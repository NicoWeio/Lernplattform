<?php

echo '<meta charset="utf8">';

//$username = $_GET["username"];
$username = "nicolai";

$courseName= "spanisch-2";

$string = file_get_contents("../Userdata/".$username.".json");
$course = json_decode($string, true);


$course = $course["data"][$courseName];
//var_dump($course);







$courseRaw = json_decode(file_get_contents("../Ressourcen/".$courseName.".json"), true);

$allVoks = array();

foreach($courseRaw as $levelRaw) {
  
  foreach($levelRaw as $vokRaw) {
    array_push($allVoks, $vokRaw);
  }
  
}










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
        
             
        foreach($allVoks as $singleVok) {
          if ($error == $singleVok["spa"]) {
            
            
            foreach($allVoks as $singleVok2) {
              if ($vok_name == $singleVok2["spa"]) {
                echo "Du hast <b>".$vok_name."</b> (\"".$singleVok2["ger"]."\") ".$error_count." mal mit <b>".$singleVok["spa"]."</b> (\"".$singleVok["ger"]."\") verwechselt! <br><br>";
              }
            }
          }
        }
        
        
        
        
        
        
        
      }
      
    }
    
  }
    
  }
  
}

?>