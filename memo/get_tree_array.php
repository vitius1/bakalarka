<?php
// edit leaf name of tree
function edit_name($string) {
  //PhyOp_Range TBL: dbo.oddeleni(alias TBL: o)(0) ASC  Bmk ( COL: Bmk1000 ) IsRow: COL: IsBaseRow1001
  if(strpos($string, " TBL: ")) {
    $pom=explode("TBL: ", $string);
    $final=$pom[0]."<br>";
    $pom2=explode("(",$pom[1]);
    $final.=$pom2[0];
    $pom3=explode("(alias TBL: ",$string);
    $pom4=explode(" Bmk ",$pom3[1]);
    $final.=" alias(".$pom4[0];
  //PhyOp_StreamGbAgg( QCOL: [c].display_name) SORT-REQUEST( QCOL: [c].display_name)
  } elseif(strpos($string, "(  QCOL: ")){
    $pom=explode("(  QCOL: ", $string);
    $final=$pom[0]."<br>";
    $pom2=explode(") ",$pom[1]);
    $final.="col: ".$pom2[0]."<br>";
    $pom3=explode("SORT-REQUEST(  QCOL: ",$string);
    $pom4=explode(")",$pom3[1]);
    $final.="sort: ".$pom4[0];
  } else {
    $pom=explode(" ", trim($string));
    $pom2=explode($pom[0], $string);
    $string=str_replace($pom2[1]," ",$string);
    $final=$string."<br>".$pom2[1];
  }
  return $final;
}

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
        array_push($tree,edit_name($string));
        $string="";
      } else {
        //after empty row save leaf of tree
        $string.=$value;
      }
    }
  }
}

//print_r($tree);
?>
