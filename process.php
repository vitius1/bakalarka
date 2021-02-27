<?php
  require "show_diagram.php";
?>
<div id="memo">Memo diagram</div>
<div id="rules">Transformation rules</div>
<div class="memo-diagram">
  <H1 class="center">Memo diagram</H1>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <div class="floor" id="floor1"><?php $memo=floor1($memo, $tree, $root); ?>
    <div class="replace-dialog" style="display: none;">
      <H1>Replace</H1>
      <div class="replace-dialog-content"></div>
    </div>
  </div>
  <div class="floor" id="floor2"></div>
  <div class="floor" id="floor3"></div>
  <div class="floor" id="floor4"></div>
  <div class="floor" id="floor5"></div>
</div>



<div class="transformation-rules" style="min-height: 600px; display: none;">
  <H1 class="center">Transformation rules</H1>
<?php
  require "transformation_rules.php";
?>
</div>
<?php 
  require_once "download.php"; 
?>

<script src="js/js.js"></script>

