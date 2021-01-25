<?php

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

function JoinCommute($resultArray){
  $rule=[];
  $description="select from A join B on A=B => select from B join A on A=B";
  $rightouter=FindGroupName($resultArray, "LogOp_RightOuterJoin");
  $leftouter=FindGroupName($resultArray, "LogOp_LeftOuterJoin");
  foreach ($rightouter as $right) {
    foreach ($leftouter as $left) {
      if($right["group"]==$left["group"]) {
        ?> <button class="rules" id="rule_for_<?php echo $right["group"].'_'.$right["subgroup"].'_'.$left["subgroup"]; ?>"><span><?php echo "Join Commute"; ?></span></button> <?php
        array_push($rule, ["name" => "Join Commute", "group" => $right["group"], "sub1" => $right["subgroup"], "sub2" => $left["subgroup"], "name1" => $right["name"], "name2" => $left["name"], "description" => $description]);
      }
    }
  }

  $join=FindGroupName($resultArray, "LogOp_Join");
  foreach ($join as $first) {
    foreach ($join as $second) {
      if($first["group"]==$second["group"] && $first["subgroup"]<$second["subgroup"]) {
        ?> <button class="rules" id="rule_for_<?php echo $second["group"].'_'.$second["subgroup"].'_'.$first["subgroup"]; ?>"><span><?php echo "Join Commute"; ?></span></button> <?php
        array_push($rule, ["name" => "Join Commute", "group" => $second["group"], "sub1" => $second["subgroup"], "sub2" => $first["subgroup"], "name1" => $second["name"], "name2" => $first["name"], "description" => $description]);
      }
    }
  }
  return $rule;
}

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

function JoinToNL($resultArray) {
  $log_join=FindGroupName($resultArray, "LogOp_LeftOuterJoin");
  $phy_join=FindGroupName($resultArray, "PhyOp_LoopsJoinx_jtLeftOuter");
  $rule=[];
  $description="Logical join to physical join";
  foreach ($log_join as $log) {
    foreach ($phy_join as $phy) {
      if($log["group"]==$phy["group"]) {
        ?> <button class="rules" id="rule_for_<?php echo $log["group"].'_'.$log["subgroup"].'_'.$phy["subgroup"]; ?>"><span><?php echo "Join to Nested Loop"; ?></span></button> <?php
        array_push($rule, ["name" => "Join to Nested Loop", "group" => $log["group"], "sub1" => $log["subgroup"], "sub2" => $phy["subgroup"], "name1" => $log["name"], "name2" => $phy["name"], "description" => $description]);
      }
    }
  }
  return $rule;
}

 $rules=[];
 array_push($rules, JoinCommute($resultArray));
 array_push($rules, JoinToNL($resultArray));
 foreach ($rules as $pom) {
    foreach ($pom as $rule) {
      RuleToHtml($resultArray, $rule["name"], $rule["group"], $rule["sub1"], $rule["sub2"], $rule["name1"], $rule["name2"], $rule["description"]);
  }
}
?>
<script>
$('.transformation_rules').on('click', '.rules', function() {
  var id = this.id.split("rule_for_")[1];
  $(".rules").removeClass("active_button");
  $(this).addClass("active_button");
  $(".rule").hide();
  $(".rule_"+id).show();

});
</script>
