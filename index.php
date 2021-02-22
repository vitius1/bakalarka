<?php  
require_once 'test.php';
require_once 'load_config.php';
?>
<form action="process.php" method="post">
  Final memo structure 8615 </br>
  <textarea name="8615" id="8615" rows="20" cols="100">
    <?php echo $memo_string; ?>
  </textarea> </br>
  Output Tree 8607 </br>
  <textarea name="8607" id="8607" rows="20" cols="100">
    <?php echo $tree_string; ?>
  </textarea> </br>
  <button id="show" type="submit">Show diagram</button>
</form>

<form action="index.php" method="post" enctype="multipart/form-data">
  Select config to load:
  <input type="file" name="fileToUpload" id="fileToUpload"></br>
  <input type="submit" value="Load config" name="submit">
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script></br></br>
select display_name, count(*) pocet</br>
from contact c</br>
left join relationship r on c.id=r.contact_id_a</br>
left join relationship r2 on c.id=r2.contact_id_b</br>
group by display_name</br>
<div id="1" style="color: blue; cursor: pointer;">Test 1</div></br></br>
select *</br>
from zamestnanec z</br>
join oddeleni o on z.idodd=o.id</br>
<div id="2" style="color: blue; cursor: pointer;">Test 2</div></br>
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





