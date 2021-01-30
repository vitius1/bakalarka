<?php  
require 'test.php';
?>
<form action="process.php" method="post">

  Final memo structure 8615 </br>

  <textarea name="8615" id="8615" rows="20" cols="100">

  </textarea> </br>

  Output Tree 8607 </br>

  <textarea name="8607" id="8607" rows="20" cols="100">

  </textarea> </br>

  <button id="show" type="submit">Show diagram</button>

</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div id="1">Test 1</div>
<div id="2">Test 2</div>
<script>
$("#1").click(function(){
  var value1 = `<?php echo $memo1; ?>`;
  var value2 = `<?php echo $tree1; ?>`;
  $("#8615").val(value1);
  $("#8607").val(value2);
});

$("#2").click(function(){
  var value1 = `<?php echo $memo2; ?>`;
  var value2 = `<?php echo $tree2; ?>`;
  $("#8615").val(value1);
  $("#8607").val(value2);
});
</script>





