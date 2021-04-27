<?php

// write rule diagram to html
function RuleToHtml($memo, $name, $group, $subg1, $subg2, $name1, $name2, $description){
  ?>
  <div class="rule center rule_<?php echo $group.'_'.$subg1.'_'.$subg2; ?>" style="display: none;">
    <h1><?php echo $name; ?></h1>
    <p style="margin-top: -20px;"><?php echo $description; ?></p>
    <div>
      <ul class="tree"><li><span><?php echo "Group: ".$group.".".$subg1."</br>".$name1; ?></span><ul><?php
      find_child($memo, $group, $subg1);
      ?></ul></li>
    </div>
    <div class="arrow down">
    </div>
    <div>
      <ul class="tree"><li><span><?php echo "Group: ".$group.".".$subg2."</br>".$name2; ?></span><ul><?php
      find_child($memo, $group, $subg2);
      ?></ul></li>
    </div>
  </div>
  <?php
}

// find group and subgroup number based on name
function FindGroupName($memo, $name) {
  $array=[];
  for ($i=0; $i < count($memo); $i++) {
    foreach ($memo[$i]["subgroup"] as $pom) {
      foreach ($pom as $key => $subgroups) {
        if(strpos($subgroups["name"], $name) !== false){
          array_push($array, ["group"=>$i, "subgroup" => $key, "name" => $subgroups["name"]]);
        }
      }
    }
  }
  return $array;
}

// find all child
function FindGroupChild($memo, $group, $subgroup) {
  $array=[];
  foreach ($memo[$group]["subgroup"] as $pom) {
    foreach ($pom[$subgroup]["groups"] as $child) {
      if($child!="") {
        $array[]=$child;
      }
    }
  }
  return $array;
}

function HasSameChilds($log, $phy) {
  $return = true;
  foreach ($log as $child) {
    if(!in_array($child, $phy)) {
      $return = false;
    }
  }
  return $return;
}

// find all transformation rules in our diagram
function Rules($memo) {
  // load rules
  $string = file_get_contents("json/transformation_rules.json");
  $json_a = json_decode($string, true);
  $rule=[];
  foreach ($json_a as $json) {
    $description=$json["description"];
    $log_join=FindGroupName($memo, $json["first"]);
    $phy_join=FindGroupName($memo, $json["second"]);

    $group="";
    
    if($json["additional"]=="commute") {
      
    }
    
    foreach ($log_join as $log) {
      foreach ($phy_join as $phy) {
        // we wouldnt display multiple same rules in one group. Only one same rule for one group
        if($group!=$log["group"]) {
          if($log["group"]==$phy["group"] && $log["subgroup"]!=$phy["subgroup"]) {
            if($json["additional"]=="commute" || $json["additional"]=="associate") {
              $log_childs = FindGroupChild($memo, $log["group"], $log["subgroup"]);
              $phy_childs = FindGroupChild($memo, $phy["group"], $phy["subgroup"]);  
              // if join commute then childs of the operator must be to same 
              // in join associate cant be childs same        
              if((HasSameChilds($log_childs, $phy_childs) && $json["additional"]=="commute") || (!HasSameChilds($log_childs, $phy_childs) && $json["additional"]=="associate")) {
                $group=$log["group"];
                ?> <button class="rules" id="rule_for_<?php echo $log["group"].'_'.$log["subgroup"].'_'.$phy["subgroup"]; ?>"><span><?php echo $json["name"]; ?></span></button> <?php
                array_push($rule, ["name" => $json["name"], "group" => $log["group"], "sub1" => $log["subgroup"], "sub2" => $phy["subgroup"], "name1" => $log["name"], "name2" => $phy["name"], "description" => $description]);
              }
            } else {
              $group=$log["group"];
              ?> <button class="rules" id="rule_for_<?php echo $log["group"].'_'.$log["subgroup"].'_'.$phy["subgroup"]; ?>"><span><?php echo $json["name"]; ?></span></button> <?php
              array_push($rule, ["name" => $json["name"], "group" => $log["group"], "sub1" => $log["subgroup"], "sub2" => $phy["subgroup"], "name1" => $log["name"], "name2" => $phy["name"], "description" => $description]);
            }          
          }
        }
      }
    }
  }
  return $rule;
}

 $rules=[Rules($memo)];
 foreach ($rules as $pom) {
    foreach ($pom as $rule) {
      RuleToHtml($memo, $rule["name"], $rule["group"], $rule["sub1"], $rule["sub2"], $rule["name1"], $rule["name2"], $rule["description"]);
  }
}
?>
