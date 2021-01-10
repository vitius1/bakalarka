<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<form action="process.php" method="post">
  Final memo structure 8615 </br>
  <textarea name="8615" id="8615" rows="20" cols="100">
  </textarea> </br>
  Output Tree 8617 </br>
  <textarea name="8607" id="8607" rows="20" cols="100">
  </textarea> </br>
  <button id="show" type="submit">Show diagram</button>
</form>


<script>
  $("#show").click(function(){
    var text = $('#8615').val();
    text=text.split("----------------------------");
    text=text[0].split("Group ");
    var group = [];
    var pom;
    var group_id;

    for(var i = 1; i<text.length; i++) {
        pom=text[i].split(": ");
        group_id = pom[0];
        group.push({group_id:{"group_detail":2}});
    }
  });
</script>
