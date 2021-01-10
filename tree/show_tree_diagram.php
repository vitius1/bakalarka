<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $final = $_POST['8607'];
  if (!empty($final)) {
    $final=explode("*** Output Tree: ***", $final);
    $final=explode("********************", $final[1]);
    $arr=explode("\r", $final[0]);
    $tree=array();
    $string="";
    foreach ($arr as $value) {
      if(strlen(trim($value)) == 0 && $string!="") {
        array_push($tree,$string);
        $string="";
      } else {
        $string.=$value;
      }
    }

    print_r($tree);
  }
}
//print_r($tree);
?>
