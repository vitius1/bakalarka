<?php
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $final = $_POST['8615'];
  $original_memo_array=$final;
  $if_multiple=explode("--- Final Memo Structure ---", $final);
  if(count($if_multiple)!=2) {
    $final=$if_multiple[count($if_multiple)-1];
  }
  
  if (!empty($final))  {
    $group = array();
    $final=explode("----------------------------", $final);
    $final=explode("Group ", $final[0]);

    for($i = 1; $i<count($final); $i++){
        $pom=explode(": ", $final[$i]);
        $group_id=$pom[0];
        $pom=explode(PHP_EOL,$pom[1]);
        $detail=$pom[0];

        $subgroup=array();
        for($k=1; $k<count($pom); $k++) {
          if($pom[$k] != "") {
            if($pom[$k] == "Root ") {
              $root = $group_id-1;
            } else {
              $pom2=explode(" ", $pom[$k]);
              $pom3=get_string_between($pom[$k], "= ", " (Dista");
              $groups=array();

              for($j=5; $j<count($pom2); $j++) {
                if(strpos($pom2[$j],"Cost") !== false || strpos($pom2[$j],"(") !== false) {
                  break;
                }
                if($pom2[$j] != "" && $pom2[$j] != "ASC" && (strpos($pom2[$j],".") !== false || (string)(int)$pom2[$j] == $pom2[$j])) {
                  array_push($groups,$pom2[$j]);
                }
              }

              $subgroup_pom=array(
                $pom2[3]=>array(
                "name"=>$pom2[4],
                "groups"=>$groups,
                "cost"=>$pom3
              ));
              array_push($subgroup,$subgroup_pom);

            }
          }
        }
        $array = array($group_id =>
                          array(
                            "detail"=>$detail,
                            "subgroup"=>$subgroup
                          )
                      );

        array_push($group, $array);
    }

    // reverse array
    $newarray=array();
    for($k=count($group)-1; $k>=0;$k--) {
        array_push($newarray, $group[$k]);
    }
    $memo = array_map('current',$newarray);
    }
  }
  //print_r($memo);
?>
