<?php
// require $memo array of memo structure
require_once "get_memo_array.php"; // return $memo
require_once "get_tree_array.php"; // return $tree

define("unknow_cost", 10000000000000);
define("minimum_opacity", 30);
define("first_tree_offset", 12);

// if child exists
// return true/false
function child_exists($memo, $group, $subgroup) {
  foreach ($memo[$group]["subgroup"] as $pom) {
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
function find_name($memo, $group, $subgroup) {
  foreach ($memo[$group]["subgroup"] as $pom) {
    if(isset ($pom[$subgroup]["name"])) {
      return ($pom[$subgroup]["name"]);
    }
  }
}

// update name
// return memo array with updated name from tree
function update_array($memo, $group, $subgroup, $name) {
  for ($i=0; $i < count($memo); $i++) {
    if(isset ($memo[$group]["subgroup"][$i][$subgroup]["name"])) {
      $memo[$group]["subgroup"][$i][$subgroup]["name"]=$name;
    }
  }
  return $memo;
}

// find cost of group.subgroup
// return cost
function find_cost($memo, $group, $subgroup) {
  foreach ($memo[$group]["subgroup"] as $pom) {
    if(isset ($pom[$subgroup]["name"])) {
      return ($pom[$subgroup]["cost"]);
    }
  }
}

// find minimum cost of group
// return minimum cost and all subgroup keys
function find_minimum_cost($memo, $group) {
  $subgroups=[];
  foreach ($memo[$group]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
      if(isset($value["cost"])) {
        if($value["cost"]=="") {
          $cost=unknow_cost;
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

// if tree with index $i is like name than go next index
// return name and key
function update_tree_index($name, $tree, $key, $i) {
    // remove trash from tree name
    if(isset($tree[$key+1])){
      $tree_name=explode(" ", $tree[$key+1]);
      if(isset($tree_name[$i])) {
        // if tree name LIKE memo name
        if ($tree_name[$i]!= "" && (strpos($name,$tree_name[$i])!==false || strpos($tree_name[$i],$name)!==false)) {
          //echo $key+1;
          return array($key+1,$tree[$key+1]);
        }
      }
    }
  return array($key,$name);
}

// create buttons (its not for scroll click)
// and add tree to memo
// return memo
function create_buttons($buttons, $max, $min, $root) {
  $memo=[];
  
  // sort buttons by cost
  usort($buttons, function($a, $b) {
    return $a['cost'] <=> $b['cost'];
  });
  
  // sort buttons by type (phy/log)
  usort($buttons, function($a, $b) {
    return $a['type'] <=> $b['type'];
  });
  
  // set opacity foreach button based on min max cost
  foreach ($buttons as $button) {
    if($button["type"]!="") {
      $class=$button["class"];
      if($button["type"]==1 && $max!=$min) {
        $opacity=(($button["cost"]-$max)/($min-$max)*(100-minimum_opacity))+minimum_opacity;
        //echo $opacity;
        $number = round($opacity, -1);
        $class.=" opacity".$number;
      } 
      if($button["active"]==1) {
        $class.=" active_button";
        if(isset($root["array"])) {
          // add name from tree to memo array
          $memo=add_tree_to_memo($root["array"], $root["root"], $root["key"], $root["tree"], 0, first_tree_offset)["array"];
        }
      } 
      
      // show button 
      ?><button class='<?php echo $class; ?>' id='<?php echo $button["id"]; ?>'>
        <span><?php echo $button["name"]; ?></span>
      </button><?php
    }
  }
  return $memo;
}

// add tree names to memo array
// recursive function
// return memo array
function add_tree_to_memo($memo, $group, $subgroup, $tree, $key, $i){
  foreach ($memo[$group]["subgroup"] as $pom) {
    if(isset($pom[$subgroup]["groups"])){
      foreach ($pom[$subgroup]["groups"] as $value) {    
        // get minimum cost value
        if(strpos($value,".")) {
          $pom=explode(".",$value);
          $child_group=$pom[0];
          $child_subgroup=$pom[1];
        } else {
          $child_group=$value;
          $child_subgroup=find_minimum_cost($memo, $value)["minimum"];
        }
              
        $name=find_name($memo, $child_group, $child_subgroup);
        $cost=find_cost($memo, $child_group, $child_subgroup);
        
        // return key, name
        // if $name LIKE $tree[$i] than $key++
        $tree_key_name=update_tree_index($name, $tree, $key, $i);
        $name2=$name;
        $key=$tree_key_name[0];
        $name=$tree_key_name[1];
        // return memo array
        $memo=update_array($memo, $child_group, $child_subgroup, $name);
        if(child_exists($memo, $child_group, $child_subgroup)) {
          // return key, memo array
          $tree_key_array=add_tree_to_memo($memo, $child_group, $child_subgroup, $tree, $key, $i+4);
          $key=$tree_key_array["key"];
          $memo=$tree_key_array["array"];
        }
      }
    }
  }
  return ["key"=>$key,"array"=>$memo];
}

// if leaf have multiple leafs
// create all diagram foreach leaf. everyone have display: none
function create_all_diagrams($memo, $group, $subgroup, $array){
  ?>
    <div style="display: none;" id="value_<?php echo $group.'-'.$subgroup ?>">
  <?php
  // prepare buttons
  $buttons=[];
  $max=-1;
  $min=unknow_cost;
  foreach ($array["all"] as $sg) {
    $class="groups";
    $active=0;
    $type=0;      
    $button_id="button_for_".$group."-".$sg;
    $name=find_name($memo, $group, $sg);
    $cost=find_cost($memo, $group, $sg);
    $design=log_phy_design($name, $button_id, $class, $cost, $min, $max, $active, $subgroup, $sg);
    $button=$design["button"];
    $min=$design["min"];
    $max=$design["max"];
    array_push($buttons, $button);
  }
  
  create_buttons($buttons, $max, $min, 0);

  // diagrams
  foreach ($array["all"] as $sg) {
    $cost=find_cost($memo, $group, $sg);
    $name=find_name($memo, $group, $sg);
    ?><ul class="tree <?php echo $group." ".$group."-".$sg; ?>" <?php if($sg!=$subgroup){ echo 'style="display: none;"'; } ?> >
    <li><span><?php echo $group.".".$sg." Cost: ".$cost."</br>".$name; ?>
    </span><ul> <?php
    find_child($memo, $group, $sg);
    ?></ul></li></ul><?php
  }
  ?>
  </div>
  <?php
}

// create diagrams, buttons for scroll click
function create_scroll_click($memo, $child_group, $child_subgroup, $groups_cost){
  ?>
  <div class="replace-buttons buttons-replace-diagram-<?php echo $child_group."-".$child_subgroup; ?>" style="display: none;">
    <?php 
    $buttons=[];
    $max=-1;
    $min=unknow_cost;
    // buttons for replace
    foreach ($groups_cost["all"] as $sg) {
      $class="replace-groups button-replace-diagram-".$child_group."-".$sg;
      $active=0;
      $type=0;      
      $button_id="";
      $name=find_name($memo, $child_group, $sg);
      $cost=find_cost($memo, $child_group, $sg);
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
      if($sg==$child_subgroup) 
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
  foreach ($groups_cost["all"] as $sg) {
    $cost=find_cost($memo, $child_group, $sg);
    $name=find_name($memo, $child_group, $sg);
    ?><li style=" display: none;" class="for-replace-root-<?php echo $child_group; ?> replace-diagram-<?php echo $child_group."-".$sg; ?>">
      <span id="for_<?php echo $child_group."-".$child_subgroup; ?>" class="subgroups"><?php echo $child_group.".".$sg." Cost: ".$cost."</br>".$name; ?>
    </span>
    <?php
    ?><ul> <?php
    find_child($memo, $child_group, $sg);
    ?></ul></li><?php
    }
}

// recursive function 
// find all child and create diagram foreach child with every buttons and everything
function find_child($memo, $group, $subgroup) {
  foreach ($memo[$group]["subgroup"] as $pom) {
    if(isset($pom[$subgroup]["groups"])){
      foreach ($pom[$subgroup]["groups"] as $value) {
        // get minimum cost value
        $style='';
        if(strpos($value,".")) {
          $pom=explode(".",$value);
          $child_group=$pom[0];
          $child_subgroup=$pom[1];
        } else {
          $child_group=$value;
          $groups_cost=find_minimum_cost($memo, $value);
          $child_subgroup=$groups_cost["minimum"];
          if(count($groups_cost["all"])>1){
            $style=' id="for_'.$child_group.'-'.$child_subgroup.'" class="subgroups"';
          }
          $value=$child_group.".".$child_subgroup;
        }

        $father_name=find_name($memo, $group, $subgroup);
        $name=find_name($memo, $child_group, $child_subgroup);
        $cost=find_cost($memo, $child_group, $child_subgroup);
      
        // exception, bad qcol if is not ScaOp_Comp
        if(!strpos($father_name, "ScaOp_Comp") && strpos($name, "ScaOp_Identifier")) {
          $name=explode("QCOL", $name)[0];
        } 

        if(child_exists($memo, $child_group, $child_subgroup)) {
            ?><li class="for-replace-root-<?php echo $child_group; ?>"><span<?php echo $style; ?>><?php echo $value." Cost: ".$cost."</br>".$name; ?>
            </span>
            <?php if($style!=""){
              create_all_diagrams($memo, $child_group, $child_subgroup, $groups_cost);
            } ?>
            <ul><?php
            //find_child($memo, $child_group, $child_subgroup);
            find_child($memo, $child_group, $child_subgroup);
            ?></ul></li><?php
            // for replace diagram
            if($style!=""){
              create_scroll_click($memo, $child_group, $child_subgroup, $groups_cost);
            }
        } else {
            ?><li><span><?php echo $value." Cost: ".$cost."</br>".$name; ?></span></li><?php
        }
      }
    }
  }
}

// find min, max of group and button design
// return min, max, button array
function log_phy_design($name, $button_id, $class, $cost, $min, $max, $active, $subgroup, $sg) {
  if(strpos($name,"Phy")!==false) {
    $type=1;
    $class.= " phy-button";
    if($cost>$max) {
      $max=$cost;
    } elseif ($cost<$min) {
      $min=$cost;
    }
  } elseif(strpos($name,"Log")!==false) {
    $type=2;
    $class.= " log-button";
  }
  if($sg==$subgroup) 
  {
    $active=1; 
    $class.=" active_button";
  } 
  
  $button=[
    "active"=>$active,
    "id"=>$button_id,
    "name"=>$name,
    "cost"=>$cost,
    "type"=>$type,
    "class"=>$class
  ];
  return array("min"=>$min,"max"=>$max,"button"=>$button);
}
// find min, max of group and button design
// return min, max, button array
function log_phy_design_root($value, $button_id, $class, $cost, $min, $max, $active, $key, $tree_name, $rootkey) {
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
  
  // if name is like root tree name, than set diagram as active
  if(strpos($tree_name[8],$value["name"])!==false || strpos($value["name"],$tree_name[8])!==false) 
  {
    $active=1; 
    $class.=" active_button";
    if($rootkey==0 || $cost2>$cost) {
      $rootkey=$key;
      $cost2=$cost;
    }
  } 
  $button=[
    "active"=>$active,
    "id"=>$button_id,
    "name"=>$value["name"],
    "cost"=>$cost,
    "type"=>$type,
    "class"=>$class
  ];
  return array("min"=>$min,"max"=>$max,"button"=>$button,"key"=>$rootkey);
}

// show diagram with buttons to floor1
// default diagram
function floor1($memo, $tree, $root) {
  // fill memo with tree and show button
  $buttons=[];
  $max=-1;
  $min=unknow_cost;
  $rootkey=0;
  $cost2=unknow_cost;
  foreach ($memo[$root]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
      $tree_name=explode(" ", $tree[0]);
      $class="groups";
      $active=0;
      $type=0;      
      $button_id="button_for_".$root."-".$key;
      $cost=find_cost($memo, $root, $key);
      
      // design for physical and logical
      $design=log_phy_design_root($value, $button_id, $class, $cost, $min, $max, $active, $key, $tree_name, $rootkey);
      $button=$design["button"];
      $min=$design["min"];
      $max=$design["max"];
      $rootkey=$design["key"];
      array_push($buttons, $button);      
    }
  }
  
  $array=[
    "array"=>$memo,
    "root"=>$root,
    "key"=>$rootkey,
    "tree"=>$tree
  ];
  // create html buttons and update memo array 
  $memo=create_buttons($buttons, $max, $min, $array);
  

  // show diagram
  foreach ($memo[$root]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
      $tree_name=explode(" ", $tree[0]);
      // if in tree
      if(strpos($tree_name[8],$value["name"])!==false) {
        ?><div class="center"><ul class="tree <?php echo $root." ".$root."-".$key ?>"><li><span><?php echo "Group: ".$root.".".$key."  Cost: ".$value["cost"]."</br>".$tree[0] ?></span><ul><?php
        // create diagram foreach child, recursive function
        find_child($memo, $root, $key);
        ?></ul></li><?php
      } else {
        ?><div class="center"><ul class="tree <?php echo $root." ".$root."-".$key; ?>" style="display:none;"><li><span><?php echo "Group: ".$root.".".$key."  Cost: ".$value["cost"]."</br>".$value["name"] ?></span><ul><?php
        // create diagram foreach child, recursive function
        find_child($memo, $root, $key, ["tree"=>"", "key"=>0, "i"=>0]);
        ?></ul></li><?php
      }
      ?></ul></div><?php
    }
  }
  return $memo;
}

