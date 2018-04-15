<?php

$courseName = $_GET["course"];

$lektion = $_GET["level"];

$username = $_GET["username"];

$courseRaw = json_decode(file_get_contents("Ressourcen/".$courseName.".json"), true);
$userRaw = json_decode(file_get_contents("Userdata/".$username.".json"), true);

$level_content = $courseRaw["data"][$lektion];

$minimumPhase = 100000; //Kay..
$currentVok = null;


  foreach($level_content as $vok) {

    $single_user_data = $userRaw["data"][$courseName][$lektion][$vok["spa"]];
    
    
    if (!isset($single_user_data["phase"])) {
      
      //echo json_encode($vok);
      //echo "TESTKACK!!!";
      
      
      //$x2 = $vok["spa"];
      //echo $x2;
      //$test = $userRaw["data"][$courseName][$lektion][$x2];
      $vok["debug"] = "single_user_data leer";
      $vok["userdata"]["success_rate"] = 0;
			$vok["tts-language"] = $courseRaw["meta"]["tts-language"];
      echo json_encode($vok);
      
      die();
      
    }
    
    else {

      
      if (($single_user_data["phase"] < $minimumPhase) && $vok["spa"] != $_GET["last"]) {
        $currentVok = $vok;
        $minimumPhase = $single_user_data["phase"];
				$currentVok["userdata"]["hint"] = $single_user_data["hint"];
									//TODO ineffizient as hell??
      }
      
    }      
    
   
    
  }



$currentVok["userdata"]["success_rate"] = $minimumPhase;
$currentVok["tts-language"] = $courseRaw["meta"]["tts-language"];
echo json_encode($currentVok);

?>
