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

        //PhyOp_Range TBL: dbo.oddeleni(alias TBL: o)(0) ASC  Bmk ( COL: Bmk1000 ) IsRow: COL: IsBaseRow1001
        if(strpos($string, " TBL: ")) {
          $pom=explode("TBL: ", $string);
          $final=$pom[0];
          $pom2=explode(" Bmk",$string);
          $final.=$pom2[0];
          array_push($tree,$final);
        } else {
          array_push($tree,$string);
        }
        $string="";
      } else {
        $string.=$value;
      }
    }
  }
}

//print_r($tree);
?>
