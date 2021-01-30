<?php

// write rule diagram to html
function RuleToHtml($resultArray, $name, $group, $subg1, $subg2, $name1, $name2, $description){
  ?>
  <div class="rule center rule_<?php echo $group.'_'.$subg1.'_'.$subg2; ?>" style="display: none;">
    <h1><?php echo $name; ?></h1>
    <p style="margin-top: -20px;"><?php echo $description; ?></p>
    <div>
      <ul class="tree"><li><span><?php echo "Group: ".$group.".".$subg1."</br>".$name1; ?></span><ul><?php
      find_child($resultArray, $group, $subg1);
      ?></ul></li>
    </div>
    <div class="arrow down">
    </div>
    <div>
      <ul class="tree"><li><span><?php echo "Group: ".$group.".".$subg2."</br>".$name2; ?></span><ul><?php
      find_child($resultArray, $group, $subg2);
      ?></ul></li>
    </div>
  </div>
  <?php
}

// find group and subgroup number based on name
function FindGroupName($resultArray, $name) {
  $array=[];
  for ($i=0; $i < count($resultArray); $i++) {
    foreach ($resultArray[$i]["subgroup"] as $pom) {
      foreach ($pom as $key => $subgroups) {
        if(strpos($subgroups["name"], $name) !== false){
          array_push($array, ["group"=>$i, "subgroup" => $key, "name" => $subgroups["name"]]);
        }
      }
    }
  }
  return $array;
}

// find all transformation rules in our diagram
function Rules($resultArray) {
  // load rules
  $string = file_get_contents("json/transformation_rules.json");
  $json_a = json_decode($string, true);
  $rule=[];
  foreach ($json_a as $json) {
    $description=$json["description"];
    $log_join=FindGroupName($resultArray, $json["first"]);
    $phy_join=FindGroupName($resultArray, $json["second"]);
    $group="";
    foreach ($log_join as $log) {
      foreach ($phy_join as $phy) {
        // we wouldnt display multiple same rules in one group. Only one same rule for one group
        if($group!=$log["group"]) {
          if($log["group"]==$phy["group"] && $log["subgroup"]!=$phy["subgroup"]) {
            $group=$log["group"];
            ?> <button class="rules" id="rule_for_<?php echo $log["group"].'_'.$log["subgroup"].'_'.$phy["subgroup"]; ?>"><span><?php echo $json["name"]; ?></span></button> <?php
            array_push($rule, ["name" => $json["name"], "group" => $log["group"], "sub1" => $log["subgroup"], "sub2" => $phy["subgroup"], "name1" => $log["name"], "name2" => $phy["name"], "description" => $description]);
          }
        }
      }
    }
  }
  return $rule;
}

 $rules=[Rules($resultArray)];
 foreach ($rules as $pom) {
    foreach ($pom as $rule) {
      RuleToHtml($resultArray, $rule["name"], $rule["group"], $rule["sub1"], $rule["sub2"], $rule["name1"], $rule["name2"], $rule["description"]);
  }
}
?>
