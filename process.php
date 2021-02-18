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
<div class="center" id="image" style="display: none;">
  <ul class="tree">
    <style>
    @charset "UTF-8";body{font-family:'Roboto Slab',serif}.tree,.tree li,.tree ul{list-style:none;margin:0;padding:0;position:relative}.tree{margin:0 0 1em;text-align:center}.tree,.tree ul{display:table}.tree ul{width:100%}.tree li{display:table-cell;padding:.5em 0;vertical-align:top}.tree li:before{outline:solid 1px #666;content:"";left:0;position:absolute;right:0;top:0}.tree li:first-child:before{left:50%}.tree li:last-child:before{right:50%}.tree code,.tree span{border:solid .1em #666;border-radius:.2em;display:inline-block;margin:0 .2em .5em;padding:.2em .5em;position:relative;white-space:nowrap}.tree code:before,.tree span:before,.tree ul:before{outline:solid 1px #666;content:"";height:.5em;left:50%;position:absolute}.tree ul:before{top:-.5em}.tree code:before,.tree span:before{top:-.55em}.tree>li{margin-top:0}.tree>li:after,.tree>li:before,.tree>li>code:before,.tree>li>span:before{outline:0}.subgroups{background-color:#add8e6;cursor:pointer}.groups,.replace-groups,.rules{display:inline-block;border-radius:4px;background-color:#87cefa;border:none;color:#fff;text-align:center;font-size:24px;padding:10px;width:auto;transition:all .5s;cursor:pointer;margin:5px}.groups span,.replace-groups span,.rules span{cursor:pointer;display:inline-block;position:relative;transition:.5s}.groups span:after,.replace-groups span:after,.rules span:after{content:'\00bb';position:absolute;opacity:0;top:0;right:-20px;transition:.5s}.groups:hover span,.replace-groups:hover span,.rules:hover span{padding-right:25px}.groups:hover span:after,.replace-groups:hover span:after,.rules:hover span:after{opacity:1;right:0}.active_field{color:#fff;background-color:#1e90ff}.active_button{color:#ff0}.center{display:grid;place-items:center;width:100%}.arrow{border:solid #000;border-width:0 12px 12px 0;display:inline-block;padding:12px;margin-top:-40px;margin-bottom:20px}.right{transform:rotate(-45deg);-webkit-transform:rotate(-45deg)}.left{transform:rotate(135deg);-webkit-transform:rotate(135deg)}.up{transform:rotate(-135deg);-webkit-transform:rotate(-135deg)}.down{transform:rotate(45deg);-webkit-transform:rotate(45deg)}.replace-dialog{position:absolute;background-color:#fff;border:1px #000 solid;border-radius:5px;z-index:1;top:15%;height:40%;left:0;right:0;margin-left:auto;margin-right:auto;width:70%;text-align:center}.phy-button{background-color:#00f}.log-button{background-color:red}.opacity10{opacity:.1}.opacity20{opacity:.2}.opacity30{opacity:.3}.opacity40{opacity:.4}.opacity50{opacity:.5}.opacity60{opacity:.6}.opacity70{opacity:.7}.opacity80{opacity:.8}.opacity90{opacity:.9}
    </style>
    <li><span>ROOT</span>
      <ul>
        <?php $resultArray=allDiagrams($resultArray, $tree, $root); ?>
      </ul>
    </li>
  </ul>
</div>
<script src="js/js.js"></script>

<div id="download" class="groups">stáhnout html</div>
If you want download svg use download html and use this page: <a href="https://www.hiqpdf.com/demo/ConvertHtmlToSvg.aspx" target="_blank">link</a>
<script src="js/FileSaver.js"></script>
<script>
$("#download").click(function(){
  var html = $("#image").html();
  var blob = new Blob([html], {type: "text/plain;charset=utf-8"});
  saveAs(blob, "index.html");
});

</script>
