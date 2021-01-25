<?php
  require "show_diagram.php";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="floor" id="floor1"><?php $resultArray=floor1($resultArray, $tree, $root); ?></div>
<div class="floor" id="floor2"></div>
<div class="floor" id="floor3"></div>
<div class="floor" id="floor4"></div>
<div class="floor" id="floor5"></div>

<div class="transformation_rules" style="min-height: 600px;">
  <H1 class="center">Transformation rules</H1>
<?php
  require "transformation_rules.php";
?>
</div>


<script src="js/js.js"></script>
