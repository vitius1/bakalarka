
<?php 
// memo array, memo group, memo subgroup, tree array, tree key, number of spaces
function find_child_all($resultArray, $group, $subgroup) {
  foreach ($resultArray[$group]["subgroup"] as $pom) {
    if(isset($pom[$subgroup]["groups"])){
      foreach ($pom[$subgroup]["groups"] as $value) {
        // get minimum cost value
        $more_child=0;
        if(strpos($value,".")) {
          $pom=explode(".",$value);
          $group2=$pom[0];
          $subgroup2=$pom[1];
        } else {
          $group2=$value;
          $pom2=find_minimum_cost($resultArray, $value);
          $subgroup2=$pom2["minimum"];
          if(count($pom2["all"])>1){
            $more_child=1;
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
          if($more_child==1) {
            ?><li><span>Group: <?php echo $group2; ?></span><ul>
              <?php
              foreach($pom2["all"] as $key) {
                $name = find_name($resultArray, $group2, $key);
                $cost = find_cost($resultArray, $group2, $key);
                if(child_exists($resultArray, $group2, $key)) {
                  ?>
                    <li><span><?php echo $group2.".".$key." Cost: ".$cost."</br>".$name; ?>
                    </span>
                    <ul>
                  <?php
                  //find_child($resultArray, $group2, $subgroup2);
                  find_child_all($resultArray, $group2, $key);
                  ?></ul></li>
                <?php
                } else {
                  ?><li><span><?php echo $group2.".".$key." Cost: ".$cost."</br>".$name; ?></span></li><?php
                }          
             } ?>
          </ul></li><?php
          } else {
            ?><li><span><?php echo $value." Cost: ".$cost."</br>".$name; ?>
            </span>
            <ul><?php
            //find_child($resultArray, $group2, $subgroup2);
            find_child_all($resultArray, $group2, $subgroup2);
            ?></ul></li><?php
          }
        } else {
            ?><li><span><?php echo $value." Cost: ".$cost."</br>".$name; ?></span></li><?php
        }
      }
    }
  }
}

function allDiagrams($resultArray, $tree, $root) {
  // show diagram
  foreach ($resultArray[$root]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
      $tree_name=explode(" ", $tree[0]);
      // if in tree

        ?><li><span><?php echo "Group: ".$root.".".$key."  Cost: ".$value["cost"]."</br>".$tree[0] ?></span><ul><?php
        find_child_all($resultArray, $root, $key);
        ?></li><?php
      
      ?></ul><?php
    }
  }
  return $resultArray;
}
?>