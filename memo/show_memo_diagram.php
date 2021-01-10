<link rel="stylesheet" href="css/style.css">
<?php
// require $resultArray array of memo structure
require "get_memo_array.php"; //$resultArray

// if child exists
// return true/false
function child_exists($resultArray, $group, $subgroup) {
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    if(isset($pom[$subgroup]["groups"])){
      if(empty($pom[$subgroup]["groups"])) {
        return false;
      } else {
        return true;
      }
    }
  }
}

// find name
// return name
function find_name($resultArray, $group, $subgroup) {
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    if(isset ($pom[$subgroup]["name"])) {
      return ($pom[$subgroup]["name"]);
    }
  }
}

function find_cost($resultArray, $group, $subgroup) {
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    if(isset ($pom[$subgroup]["name"])) {
      return ($pom[$subgroup]["cost"]);
    }
  }
}

function find_minimum_cost($resultArray, $group) {
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
      if(isset($value["cost"])) {
        if($value["cost"]=="") {
          $cost=10000000000000;
        } else {
          $cost=$value["cost"];
        }
        if(!isset($minimum)) {
          $minimum=$cost;
          $min_gr=$key;
        } else if($cost<$minimum) {
          $minimum=$cost;
          $min_gr=$key;
        }
      }
    }
  }
  return $min_gr;
}

// find every childs and show in diagram
function find_child($resultArray, $group, $subgroup) {
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    if(isset($pom[$subgroup]["groups"])){
      foreach ($pom[$subgroup]["groups"] as $value) {

        if(strpos($value,".")) {
          $pom=explode(".",$value);
          $group2=$pom[0];
          $subgroup2=$pom[1];
          $style='';
        } else {
          $group2=$value;
          $subgroup2=find_minimum_cost($resultArray, $value);
          $style=' style="background-color: #ADD8E6"';
        }

        if(child_exists($resultArray, $group2, $subgroup2)) {
            ?><li><span<?php echo $style; ?>><?php echo $value." C:".find_cost($resultArray, $group2, $subgroup2)."</br>".find_name($resultArray, $group2, $subgroup2); ?></span><ul><?php
            find_child($resultArray, $group2, $subgroup2);
            ?></ul></li><?php
        } else {
            ?><li><span><?php echo $value." C:".find_cost($resultArray, $group2, $subgroup2)."</br>".find_name($resultArray, $group2, $subgroup2); ?></span></li><?php
        }
      }
    }
  }
}


function find_tree($name, $tree, $key, $i) {

    $tree_name=explode(" ", $tree[$key+1]);
    if(isset($tree_name[$i])) {
      if ($tree_name[$i]!= "" && strpos($name,$tree_name[$i])!==false) {
        //echo $key+1;
        return array($key+1,$tree[$key+1]);
      }
    }

  return array($key,$name);
}

// memo array, memo group, memo subgroup, tree array, tree key, number of spaces
function find_child_with_tree($resultArray, $group, $subgroup, $tree, $key, $i) {
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    if(isset($pom[$subgroup]["groups"])){
      foreach ($pom[$subgroup]["groups"] as $value) {

        if(strpos($value,".")) {
          $pom=explode(".",$value);
          $group2=$pom[0];
          $subgroup2=$pom[1];
          $style='';
        } else {
          $group2=$value;
          $subgroup2=find_minimum_cost($resultArray, $value);
          $style=' style="background-color: #ADD8E6"';
        }

        $name=find_name($resultArray, $group2, $subgroup2);
        $cost=find_cost($resultArray, $group2, $subgroup2);
        $pom2=find_tree($name, $tree, $key, $i);
        $key=$pom2[0];
        $name=$pom2[1];



        if(child_exists($resultArray, $group2, $subgroup2)) {
            ?><li><span<?php echo $style; ?>><?php echo $value." Cost: ".$cost."</br>".$name; ?></span><ul><?php
            //find_child($resultArray, $group2, $subgroup2);
            $key=find_child_with_tree($resultArray, $group2, $subgroup2, $tree, $key, $i+4);
            ?></ul></li><?php
        } else {
            ?><li><span><?php echo $value." Cost: ".$cost."</br>".$name; ?></span></li><?php
        }
      }
    }
  }
  return $key;
}

function root_in_tree($name, $tree, $i) {
  $tree_name=explode(" ", $tree);
  if(strpos($tree_name[$i],$name)!==false) {
    $name=$tree;
  } else {

  }
  return $name;
}

function root($resultArray, $root, $tree) {

  foreach ($resultArray[$root]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
      $tree_name=explode(" ", $tree[0]);

      // if in tree
      if(strpos($tree_name[8],$value["name"])!==false) {
        ?><li><span><?php echo "Group: ".$root.".".$key."  Cost: ".$value["cost"]."</br>".$tree[0] ?></span><ul><?php
        find_child_with_tree($resultArray, $root, $key, $tree, 0, 12);
        ?></ul></li><?php
      } else {
        ?><li><span><?php echo "Group: ".$root.".".$key."  Cost: ".$value["cost"]."</br>".$value["name"] ?></span><ul><?php
        find_child($resultArray, $root, $key);
        ?></ul></li><?php
      }

    }
  }
}
?>
<ul class="tree">
  <li> <span>Root</span>
    <ul>
      <?php root($resultArray, $root, $tree); ?>
    </ul>
  </li>
</ul>
