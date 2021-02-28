<?php 
function show_all_diagrams($memo, $child_group, $child_subgroup, $more_child, $value, $cost, $name) {
  if(child_exists($memo, $child_group, $child_subgroup)) {
    if($more_child==1) {
      ?><li><span>Group: <?php echo $child_group; ?></span><ul>
        <?php
        foreach($groups_cost["all"] as $key) {
          $name = find_name($memo, $child_group, $key);
          $cost = find_cost($memo, $child_group, $key);
          if(child_exists($memo, $child_group, $key)) {
            ?>
              <li><span><?php echo $child_group.".".$key." Cost: ".$cost."</br>".$name; ?>
              </span>
              <ul>
            <?php
            //find_child($memo, $child_group, $child_subgroup);
            find_child_all($memo, $child_group, $key);
            ?></ul></li>
          <?php
          } else {
            ?><li><span><?php echo $child_group.".".$key." Cost: ".$cost."</br>".$name; ?></span></li><?php
          }          
       } ?>
    </ul></li><?php
    } else {
      ?><li><span><?php echo $value." Cost: ".$cost."</br>".$name; ?>
      </span>
      <ul><?php
      //find_child($memo, $child_group, $child_subgroup);
      find_child_all($memo, $child_group, $child_subgroup);
      ?></ul></li><?php
    }
  } else {
      ?><li><span><?php echo $value." Cost: ".$cost."</br>".$name; ?></span></li><?php
  }
}
// memo array, memo group, memo subgroup
function find_child_all($memo, $group, $subgroup) {
  foreach ($memo[$group]["subgroup"] as $pom) {
    if(isset($pom[$subgroup]["groups"])){
      foreach ($pom[$subgroup]["groups"] as $value) {
        // get minimum cost value
        $more_child=0;
        if(strpos($value,".")) {
          $pom=explode(".",$value);
          $child_group=$pom[0];
          $child_subgroup=$pom[1];
        } else {
          $child_group=$value;
          $groups_cost=find_minimum_cost($memo, $value);
          $child_subgroup=$groups_cost["minimum"];
          if(count($groups_cost["all"])>1){
            $more_child=1;
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
        show_all_diagrams($memo, $child_group, $child_subgroup, $more_child, $value, $cost, $name);
      }
    }
  }
}

function allDiagrams($memo, $tree, $root) {
  // show diagram
  foreach ($memo[$root]["subgroup"] as $pom) {
    foreach ($pom as $key => $value) {
        ?><li><span><?php echo "Group: ".$root.".".$key."  Cost: ".$value["cost"]."</br>".$tree[0] ?></span><ul><?php
        find_child_all($memo, $root, $key);
        ?></ul></li><?php
    }
  }
  return $memo;
}
?>

<div class="center" id="diagram-html" style="display: none;">
  <ul class="tree">
    <style>
    @charset "UTF-8";body{font-family:'Roboto Slab',serif}.tree,.tree li,.tree ul{list-style:none;margin:0;padding:0;position:relative}.tree{margin:0 0 1em;text-align:center}.tree,.tree ul{display:table}.tree ul{width:100%}.tree li{display:table-cell;padding:.5em 0;vertical-align:top}.tree li:before{outline:solid 1px #666;content:"";left:0;position:absolute;right:0;top:0}.tree li:first-child:before{left:50%}.tree li:last-child:before{right:50%}.tree code,.tree span{border:solid .1em #666;border-radius:.2em;display:inline-block;margin:0 .2em .5em;padding:.2em .5em;position:relative;white-space:nowrap}.tree code:before,.tree span:before,.tree ul:before{outline:solid 1px #666;content:"";height:.5em;left:50%;position:absolute}.tree ul:before{top:-.5em}.tree code:before,.tree span:before{top:-.55em}.tree>li{margin-top:0}.tree>li:after,.tree>li:before,.tree>li>code:before,.tree>li>span:before{outline:0}.subgroups{background-color:#add8e6;cursor:pointer}.groups,.replace-groups,.rules{display:inline-block;border-radius:4px;background-color:#87cefa;border:none;color:#fff;text-align:center;font-size:24px;padding:10px;width:auto;transition:all .5s;cursor:pointer;margin:5px}.groups span,.replace-groups span,.rules span{cursor:pointer;display:inline-block;position:relative;transition:.5s}.groups span:after,.replace-groups span:after,.rules span:after{content:'\00bb';position:absolute;opacity:0;top:0;right:-20px;transition:.5s}.groups:hover span,.replace-groups:hover span,.rules:hover span{padding-right:25px}.groups:hover span:after,.replace-groups:hover span:after,.rules:hover span:after{opacity:1;right:0}.active_field{color:#fff;background-color:#1e90ff}.active_button{color:#ff0}.center{display:grid;place-items:center;width:100%}.arrow{border:solid #000;border-width:0 12px 12px 0;display:inline-block;padding:12px;margin-top:-40px;margin-bottom:20px}.right{transform:rotate(-45deg);-webkit-transform:rotate(-45deg)}.left{transform:rotate(135deg);-webkit-transform:rotate(135deg)}.up{transform:rotate(-135deg);-webkit-transform:rotate(-135deg)}.down{transform:rotate(45deg);-webkit-transform:rotate(45deg)}.replace-dialog{position:absolute;background-color:#fff;border:1px #000 solid;border-radius:5px;z-index:1;top:15%;height:40%;left:0;right:0;margin-left:auto;margin-right:auto;width:70%;text-align:center}.phy-button{background-color:#00f}.log-button{background-color:red}.opacity10{opacity:.1}.opacity20{opacity:.2}.opacity30{opacity:.3}.opacity40{opacity:.4}.opacity50{opacity:.5}.opacity60{opacity:.6}.opacity70{opacity:.7}.opacity80{opacity:.8}.opacity90{opacity:.9}
    </style>
    <li><span>ROOT</span>
      <ul>
        <?php $memo=allDiagrams($memo, $tree, $root); ?>
      </ul>
    </li>
  </ul>
</div>

<div id="config" style="display: none;">
  ###start-memo###
  <?php echo $original_memo_array; ?>
  ###end-memo###
  ###start-tree###
    <?php echo $original_tree_array; ?>
  ###end-tree###
</div>

<div id="download-config" class="groups">download config</div>
<div id="download-html" class="groups">download html</div>
If you want download svg use download html and use this page: <a href="https://www.hiqpdf.com/demo/ConvertHtmlToSvg.aspx" target="_blank">link</a>

<script src="js/FileSaver.js"></script>
<script>
$("#download-html").click(function(){
  var html = $("#diagram-html").html();
  var blob = new Blob([html], {type: "text/plain;charset=utf-8"});
  saveAs(blob, "index.html");
});

$("#download-config").click(function(){
  var html = $("#config").html();
  var blob = new Blob([html], {type: "text/plain;charset=utf-8"});
  saveAs(blob, "memo/tree.txt");
});
</script>