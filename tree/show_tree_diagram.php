<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $final = $_POST['8607'];
  if (!empty($final)) {
    $final=explode("*** Output Tree: ***", $final);
    $final=explode("********************", $final[1]);
    $arr=explode("\r", $final[0]);
    $tree=array();
    $spaces="        ";
    $four="    ";
    $i=-1;
    $k=0;
    foreach ($arr as $value) {
      if(strpos($value,$spaces)!==false) {
        array_push($tree,$value);
        $i++;
      } else if (strpos($value," ")!==false && $k>=3) {
        $tree[$i].=$value;
        echo $value;
        echo "neco";

      }
      $k++;
    }

    print_r($tree);
  }
}
//print_r($tree);
?>
