<?php

function joincommute($resultArray){
  $group="";
  $subg1="";
  $subg2="";
  $name1="";
  $name2="";
  foreach ($resultArray as $gkey => $groups) {
    foreach ($groups["subgroup"] as $pom) {
      foreach ($pom as $skey => $subgroups) {
        if(strpos($subgroups["name"], "LogOp_RightOuterJoin") !== false){
          $group=$gkey;
          $subg1=$skey;
          $name1=$subgroups["name"];
        } elseif(strpos($subgroups["name"], "LogOp_LeftOuterJoin") !== false){
          $group=$gkey;
          $subg2=$skey;
          $name2=$subgroups["name"];
        }
      }
    }
    if($name1 != "" && $name2 != ""){
      joincommutehtml($resultArray, $group, $subg1, $subg2, $name1, $name2);
    }
    $group="";
    $subg1="";
    $subg2="";
    $name1="";
    $name2="";
  }
}

function joincommutehtml($resultArray, $group, $subg1, $subg2, $name1, $name2){
  ?>
  <button class="rules" id="commute_for_<?php echo $group; ?>"><span>Join Commute</span></button>
  <div class="joincommute center commute_<?php echo $group; ?>" style="display: none;">
    <h1>Join Commute</h1>
    <p style="margin-top: -20px;">select from A join B on A=B => select from B join A on A=B</p>
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

// 9.0 9.1
 joincommute($resultArray);
//print_r($resultArray);
?>
<script>
$('.transformation_rules').on('click', '.rules', function() {
  var id = this.id.split("commute_for_")[1];
  if($(".commute_"+id).is(':visible')){
    $(".commute_"+id).hide("fast");
    $(this).removeClass("active_button");
  } else {
    $(".commute_"+id).show("fast");
    $(this).addClass("active_button");
  }
});
</script>
