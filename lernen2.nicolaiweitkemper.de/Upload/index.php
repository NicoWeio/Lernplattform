<?php

if ($_FILES) {
    /*echo "<pre>\r\n";
    echo htmlspecialchars(print_r($_FILES,1));
    echo "</pre>\r\n";
    die();*/
  
  echo "TODO ;)";
  
}

else echo 
  '<form method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit">
    </form>';

?>

