<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@350&display=swap" rel="stylesheet">
<?php
function error_found(){
  // uncomment for debuging
  header("Location: index.php");
}
set_error_handler('error_found');

  if(!isset($_POST['8615']) || !isset($_POST['8607'])) {
    header('Location: index.php');
  }
  if(str_replace(' ', '', $_POST['8615'])=="" || str_replace(' ', '', $_POST['8607'])=="") {
    header('Location: index.php');
  }
  require "show_diagram.php";
?>

<div id="menu">
  <ul>
    <li id="memo" class="active"><a>Memo diagram</a></li>
    <li id="rules"><a>Transformation rules</a></li>
    <li id="rules"><a href="index.php" onclick="return confirm('All unsave diagrams will be lost. Do you want leave?')">New diagram</a></li>
  </ul>
</div>
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

