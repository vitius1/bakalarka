<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@350&display=swap" rel="stylesheet">
<?php
// require $resultArray array of memo structure
require "get_memo_array.php"; //$resultArray
require "get_tree_array.php"; //$tree

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

// update name
// return array
function update_array($resultArray, $group, $subgroup, $name) {
  
  for ($i=0; $i < count($resultArray); $i++) {
    if(isset ($resultArray[$group]["subgroup"][$i][$subgroup]["name"])) {
      $resultArray[$group]["subgroup"][$i][$subgroup]["name"]=$name;
    }
  }
  return $resultArray;
}

function find_cost($resultArray, $group, $subgroup) {
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    if(isset ($pom[$subgroup]["name"])) {
      return ($pom[$subgroup]["cost"]);
    }
  }
}

function find_minimum_cost($resultArray, $group) {
  $subgroups=[];
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
      if(isset($value["cost"])) {
        if($value["cost"]=="") {
          $cost=10000000000000;
        } else {
          $cost=$value["cost"];
        }
        array_push($subgroups,$key);
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
  return ["minimum"=>$min_gr,"all"=>$subgroups];
}

function find_tree($name, $tree, $key, $i) {
    $tree_name=explode(" ", $tree[$key+1]);
    if(isset($tree_name[$i])) {
      
      if ($tree_name[$i]!= "" && (strpos($name,$tree_name[$i])!==false || strpos($tree_name[$i],$name)!==false)) {
        //echo $key+1;
        return array($key+1,$tree[$key+1]);
      }
    }
  return array($key,$name);
}

function create_buttons($buttons, $max, $min, $root) {
  $resultArray=[];
  usort($buttons, function($a, $b) {
    return $a['cost'] <=> $b['cost'];
  });
  
  usort($buttons, function($a, $b) {
    return $a['type'] <=> $b['type'];
  });
  foreach ($buttons as $button) {
    if($button["type"]!="") {
      $class=$button["class"];
      if($button["type"]==1 && $max!=$min) {
        $opacity=(($button["cost"]-$max)/($min-$max)*70)+30;
        //echo $opacity;
        $number = round($opacity, -1);
        $class.=" opacity".$number;
      } 
      
      if($button["active"]==1) {
        $class.=" active_button";
        if(isset($root["array"])) {
          $resultArray=add_tree_to_memo($root["array"], $root["root"], $root["key"], $root["tree"], 0, 12)["array"];
        }
      } 
      
      ?><button class='<?php echo $class; ?>' id='<?php echo $button["id"]; ?>'>
        <span><?php echo $button["name"]; ?></span>
      </button><?php
    }
  }
  return $resultArray;
}


// if leaf have multiple leafs
function create_all_diagrams($resultArray, $group2, $subgroup2, $pom2){
  ?>
    <div style="display: none;" id="value_<?php echo $group2.'-'.$subgroup2 ?>">
  <?php
  // buttons
  $buttons=[];
  $max=-1;
  $min=10000000000000;
  foreach ($pom2["all"] as $sg) {
    $class="groups";
    $active=0;
    $type=0;      
    $button_id="button_for_".$group2."-".$sg;
    $name=find_name($resultArray, $group2, $sg);
    $cost=find_cost($resultArray, $group2, $sg);
    if(strpos($name,"Phy")!==false) {
      $type=1;
      $class.= " phy-button";
      if($cost>$max) {
        $max=$cost;
      } 
      if($cost<$min) {
        $min=$cost;
      }
    } elseif(strpos($name,"Log")!==false) {
      $type=2;
      $class.= " log-button";
    }
    if($sg==$subgroup2) 
    {
      $active=1; 
      $class.=" active_button";
    } 
    
    $pom=[
      "active"=>$active,
      "id"=>$button_id,
      "name"=>$name,
      "cost"=>$cost,
      "type"=>$type,
      "class"=>$class
    ];
    array_push($buttons, $pom);
  }
  
  create_buttons($buttons, $max, $min, 0);

  // diagrams
  foreach ($pom2["all"] as $sg) {
    $cost=find_cost($resultArray, $group2, $sg);
    $name=find_name($resultArray, $group2, $sg);
    ?><ul class="tree <?php echo $group2." ".$group2."-".$sg; ?>" <?php if($sg!=$subgroup2){ echo 'style="display: none;"'; } ?> >
    <li><span><?php echo $group2.".".$sg." Cost: ".$cost."</br>".$name; ?>
    </span><ul> <?php
    find_child($resultArray, $group2, $sg);
    ?></ul></li></ul><?php
  }
  ?>
  </div>
  <?php
}


// memo array, memo group, memo subgroup, tree array, tree key, number of spaces
function find_child($resultArray, $group, $subgroup) {
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    if(isset($pom[$subgroup]["groups"])){
      foreach ($pom[$subgroup]["groups"] as $value) {
        // get minimum cost value
        $style='';
        if(strpos($value,".")) {
          $pom=explode(".",$value);
          $group2=$pom[0];
          $subgroup2=$pom[1];
        } else {
          $group2=$value;
          $pom2=find_minimum_cost($resultArray, $value);
          $subgroup2=$pom2["minimum"];
          if(count($pom2["all"])>1){
            $style=' id="for_'.$group2.'-'.$subgroup2.'" class="subgroups"';
          }
          $value=$group2.".".$subgroup2;
        }

        $father_name=find_name($resultArray, $group, $subgroup);
        $name=find_name($resultArray, $group2, $subgroup2);
        $cost=find_cost($resultArray, $group2, $subgroup2);
      
        // exception, bad qcol if is not ScaOp_Comp
        if(!strpos($father_name, "ScaOp_Comp") && strpos($name, "ScaOp_Identifier")) {
          $name=explode("QCOL", $name)[0];
        } 

        if(child_exists($resultArray, $group2, $subgroup2)) {
            ?><li class="for-replace-root-<?php echo $group2; ?>"><span<?php echo $style; ?>><?php echo $value." Cost: ".$cost."</br>".$name; ?>
            </span>
            <?php if($style!=""){
              create_all_diagrams($resultArray, $group2, $subgroup2, $pom2);
            } ?>
            <ul><?php
            //find_child($resultArray, $group2, $subgroup2);
            find_child($resultArray, $group2, $subgroup2);
            ?></ul></li><?php
            // for replace diagram
            if($style!=""){
              ?>
              <div class="replace-buttons" id="buttons-replace-diagram-<?php echo $group2."-".$subgroup2; ?>" style="display: none;">
                <?php 
                $buttons=[];
                $max=-1;
                $min=10000000000000;
                // buttons for replace
                foreach ($pom2["all"] as $sg) {
                  $class="replace-groups button-replace-diagram-".$group2."-".$sg;
                  $active=0;
                  $type=0;      
                  $button_id="";
                  $name=find_name($resultArray, $group2, $sg);
                  $cost=find_cost($resultArray, $group2, $sg);
                  if(strpos($name,"Phy")!==false) {
                    $type=1;
                    $class.= " phy-button";
                    if($cost>$max) {
                      $max=$cost;
                    } 
                    if($cost<$min) {
                      $min=$cost;
                    }
                  } elseif(strpos($name,"Log")!==false) {
                    $type=2;
                    $class.= " log-button";
                  }
                  if($sg==$subgroup2) 
                  {
                    $active=1; 
                    $class.=" active_button";
                  } 
                  $pom3=[
                    "active"=>$active,
                    "id"=>$button_id,
                    "name"=>$name,
                    "cost"=>$cost,
                    "type"=>$type,
                    "class"=>$class
                  ];
                  array_push($buttons, $pom3);

                } 
                create_buttons($buttons, $max, $min, 0);
                ?>
              </div> <?php
              // hidden diagrams
            foreach ($pom2["all"] as $sg) {
              $cost=find_cost($resultArray, $group2, $sg);
              $name=find_name($resultArray, $group2, $sg);
              ?><li style=" display: none;" class="for-replace-root-<?php echo $group2; ?>" id="replace-diagram-<?php echo $group2."-".$sg; ?>">
                <span id="for_<?php echo $group2."-".$subgroup2; ?>" class="subgroups"><?php echo $group2.".".$sg." Cost: ".$cost."</br>".$name; ?>
              </span>
              <?php
              ?><ul> <?php
              find_child($resultArray, $group2, $sg);
              ?></ul></li><?php
              }
            }
        } else {
            ?><li><span><?php echo $value." Cost: ".$cost."</br>".$name; ?></span></li><?php
        }
      }
    }
  }
}


function add_tree_to_memo($resultArray, $group, $subgroup, $tree, $key, $i){
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    if(isset($pom[$subgroup]["groups"])){
      foreach ($pom[$subgroup]["groups"] as $value) {

        // get minimum cost value
        if(strpos($value,".")) {
          $pom=explode(".",$value);
          $group2=$pom[0];
          $subgroup2=$pom[1];
        } else {
          $group2=$value;
          $subgroup2=find_minimum_cost($resultArray, $value)["minimum"];
        }

        $name=find_name($resultArray, $group2, $subgroup2);
        $cost=find_cost($resultArray, $group2, $subgroup2);
        $pom2=find_tree($name, $tree, $key, $i);
        $key=$pom2[0];
        $name=$pom2[1];
        $resultArray=update_array($resultArray, $group2, $subgroup2, $name);

        if(child_exists($resultArray, $group2, $subgroup2)) {
          //find_child($resultArray, $group2, $subgroup2);
          $pom3=add_tree_to_memo($resultArray, $group2, $subgroup2, $tree, $key, $i+4);
          $key=$pom3["key"];
          $resultArray=$pom3["array"];
        }
      }
    }
  }
  return ["key"=>$key,"array"=>$resultArray];
}


function floor1($resultArray, $tree, $root) {
  // fill memo with tree and show button
  $buttons=[];
  $max=-1;
  $min=10000000000000;
  foreach ($resultArray[$root]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
      $tree_name=explode(" ", $tree[0]);
      $class="groups";
      $active=0;
      $type=0;      
      $button_id="button_for_".$root."-".$key;
      $cost=find_cost($resultArray, $root, $key);
      if(strpos($value["name"],"Phy")!==false) {
        $type=1;
        $class.= " phy-button";
        if($cost>$max) {
          $max=$cost;
        } 
        if($cost<$min) {
          $min=$cost;
        }
      } elseif(strpos($value["name"],"Log")!==false) {
        $type=2;
        $class.= " log-button";
      }
      if(strpos($tree_name[8],$value["name"])!==false) 
      {
        $active=1; 
        $class.=" active_button";
      } 
      $pom=[
        "active"=>$active,
        "id"=>$button_id,
        "name"=>$value["name"],
        "cost"=>$cost,
        "type"=>$type,
        "class"=>$class
      ];
      array_push($buttons, $pom);
    }
  }
  $pom3=[
    "array"=>$resultArray,
    "root"=>$root,
    "key"=>$key,
    "tree"=>$tree
  ];
  
  $resultArray=create_buttons($buttons, $max, $min, $pom3);

  // show diagram
  foreach ($resultArray[$root]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
      $tree_name=explode(" ", $tree[0]);
      // if in tree
      if(strpos($tree_name[8],$value["name"])!==false) {
        ?><div class="center"><ul class="tree <?php echo $root." ".$root."-".$key ?>"><li><span><?php echo "Group: ".$root.".".$key."  Cost: ".$value["cost"]."</br>".$tree[0] ?></span><ul><?php
        find_child($resultArray, $root, $key);
        ?></ul></li><?php
      } else {
        ?><div class="center"><ul class="tree <?php echo $root." ".$root."-".$key; ?>" style="display:none;"><li><span><?php echo "Group: ".$root.".".$key."  Cost: ".$value["cost"]."</br>".$value["name"] ?></span><ul><?php
        find_child($resultArray, $root, $key, ["tree"=>"", "key"=>0, "i"=>0]);
        ?></ul></li><?php
      }
      ?></ul></div><?php
    }
  }
  return $resultArray;
}

require "all_diagrams.php";
