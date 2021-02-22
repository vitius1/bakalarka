<?php 
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

$memo_string="";
$tree_string="";
if(isset($_POST["submit"])) { 
  $string="";
  $fp = fopen($_FILES['fileToUpload']['tmp_name'], 'rb');
    while ( ($line = fgets($fp)) !== false) {
      $string.=$line;
    }
    $memo_string=get_string_between($string, "###start-memo###", "###end-memo###");
    $tree_string=get_string_between($string, "###start-tree###", "###end-tree###");
}
?>