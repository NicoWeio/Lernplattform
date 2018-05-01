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
    
		if (!isset($single_user_data["phase"])) $single_user_data["phase"] = 0;
      
      if (($single_user_data["phase"] < $minimumPhase) && $vok["spa"] != $_GET["last"]) {
        $currentVok = $vok;
        $minimumPhase = $single_user_data["phase"];
				$currentVok["userdata"]["hint"] = $single_user_data["hint"];
									//TODO ineffizient as hell??
      }
      
  }


$currentVok["userdata"]["success_rate"] = $minimumPhase;
//$currentVok["tts-language"] = $courseRaw["meta"]["tts-language"];
$currentVok["meta"] = $courseRaw["meta"];
echo json_encode($currentVok);

?>
