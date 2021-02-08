<?php
  require "show_diagram.php";
?>
<style>


</style>
<div id="memo">Memo diagram</div>
<div id="rules">Transformation rules</div>
<div class="memo-diagram">
  <H1 class="center">Memo diagram</H1>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="floor" id="floor1"><?php $resultArray=floor1($resultArray, $tree, $root); ?>
  <div class="replace-dialog" style="display: none;">
    <H1>Replace</H1>
    <div id="replace-dialog-content"></div>
  </div>
</div>
<div class="floor" id="floor2"></div>
<div class="floor" id="floor3"></div>
<div class="floor" id="floor4"></div>
<div class="floor" id="floor5"></div>

</div>
<script>

$("body").click(function(event) {
  if (!$(event.target).is(".replace-dialog")) {
    $(".replace-dialog").hide();
  }
});

$('#floor1').on('mousedown', '.subgroups', function(e) {
  if(e.which==2) {
    $(".replace-dialog").show();
    var html = $("#buttons-replace-diagram-"+this.id.split("for_")[1]).html();
    $("#replace-dialog-content").html(html);
  }
  
});  

$('#floor1').on('click', '.replace-groups', function() {
  var id = $(this).attr("class").split(" ")[1].split("button-replace-diagram-")[1];
  $(".for-replace-root-"+id.split("-")[0]).hide();
  $("#floor1 .replace-dialog").hide();
  $("#replace-diagram-"+id).show();
});  
</script>


<div class="transformation-rules" style="min-height: 600px; display: none;">
  <H1 class="center">Transformation rules</H1>
<?php
  require "transformation_rules.php";
?>
</div>

<script src="js/js.js"></script>
