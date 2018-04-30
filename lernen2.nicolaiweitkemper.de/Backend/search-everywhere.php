<?php

$searchTerm = $_GET["q"];

$files = array_diff(scandir("Ressourcen"), array('..', '.'));

$results = [];

foreach ($files as $singleCourse) {
  $courseID = explode(".",$singleCourse)[0];
  $json = json_decode(file_get_contents("Ressourcen/".$singleCourse), true);
  $meta = $json["meta"];

  $levels = $json["data"];
  
  foreach ($levels as $singleLevelName => $singleLevel) {
//    echo $singleLevelName;
    foreach($singleLevel as $singleVok) {
      if (strpos($singleVok["spa"], $searchTerm) !== false || strpos($singleVok["ger"], $searchTerm) !== false) { //oder preg_match
        $single = [];
        $single["course-id"] = $courseID;
        $single["course-title"] = $meta["title"];
        $single["language"] = $meta["language"];
        $single["level"] = $singleLevelName;
        $single["spa"] = $singleVok["spa"];
        $single["ger"] = $singleVok["ger"];
        array_push($results, $single);
      }
    }
  }
  
}

echo json_encode($results);

?>