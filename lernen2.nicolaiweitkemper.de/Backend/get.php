<?php

$json = json_decode($_GET["request"], true);

$courseRaw = json_decode(file_get_contents("Ressourcen/spanisch-neu.json"), true);

switch ($json["type"]) {
  case "prepositions": {
    /*echo '{
  "before": "a la izquierda (",
  "preposition": "de",
  "after": ")",
  "ger": "links (von)",
  "level": "18 Unidad 5 En Madrid - Paso 1"
}';*/
    
   echo json_encode($courseRaw[array_rand($courseRaw)]);
    
  }
}

?>