<link rel="stylesheet" href="css/front-page.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@350&display=swap" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php  
function error_found(){
  // uncomment for debuging
  header("Location: index.php");
}
set_error_handler('error_found');

require_once 'test.php';
require_once 'load_config.php';
?>
<H1>Visualization of memo structure and transformation rules</H1>
<form action="process.php" method="post">
  <p><strong>Memo structure</strong> (QUERYTRACEON 8615)</p> 
  <textarea name="8615" id="8615" rows="20" cols="100" placeholder="Here put your memo structure output from SQL server.
  
You can get the output like that:

SELECT *
FROM A
JOIN B ON A.fkb=B.id
OPTION (
  QUERYTRACEON 3604,
  QUERYTRACEON 8615,
  MAXDOP 1
)"><?php echo $memo_string; ?></textarea> 
</br>
</br>
  <p><strong>Final tree</strong> (QUERYTRACEON 8607)</p> 
  <textarea name="8607" id="8607" rows="20" cols="100" placeholder="Here put your final structure output from SQL server.
  
You can get the output like that:

SELECT *
FROM A
JOIN B ON A.fkb=B.id
OPTION (
  QUERYTRACEON 3604,
  QUERYTRACEON 8607,
  MAXDOP 1
)"><?php echo $tree_string; ?></textarea> 
</br>
</br>
  
  
  <div class="center"><button id="show" type="submit" style="font-size: 25px; padding: 10px 15px;">Show diagram</button></div>
</form>
</br></br>
<form action="index.php" method="post" enctype="multipart/form-data">
  Select your saved diagram to load:
  <input type="file" name="fileToUpload" id="fileToUpload"></br>
  <div class="center"><input type="submit" value="Load diagram settings" name="submit"></div>
</form>

</br>
<H4>Testing input</H4>


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





