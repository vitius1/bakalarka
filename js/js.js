
$('#floor1').on('click', '.groups', function() {
  var id = this.id.split("button_for_")[1];
  // remove all active button style which is below
  $(".groups").removeClass("active_button");
  // add active button style to this element
  $(this).addClass("active_button");
  // hide diagrams in floor
  $("#floor1 ."+id.split("-")[0]).hide();
  // remove all active field style which is below
  $(".subgroups").removeClass('active_field');
  // remove content which is below
  $('#floor2, #floor3, #floor4, #floor5').html("");
  // show one diagram
  $("#floor1 ."+id).show();
});

$('#floor2').on('click', '.groups', function() {
  var id = this.id.split("button_for_")[1];
  // remove all active button style which is below
  $("#floor2 .groups, #floor3 .groups, #floor4 .groups, #floor5 .groups").removeClass("active_button");
  // add active button style to this element
  $(this).addClass("active_button");
  // hide diagrams in floor
  $("#floor2 ."+id.split("-")[0]).hide();
  // remove all active field style which is below
  $("#floor2 .subgroups, #floor3 .subgroups, #floor4 .subgroups, #floor5 .subgroups").removeClass('active_field');
  // remove content which is below
  $('#floor3, #floor4, #floor5').html("");
  // show one diagram
  $("#floor2 ."+id).show();
});

$('#floor3').on('click', '.groups', function() {
  var id = this.id.split("button_for_")[1];
  // remove all active button style which is below
  $("#floor3 .groups, #floor4 .groups, #floor5 .groups").removeClass("active_button");
  // add active button style to this element
  $(this).addClass("active_button");
  // hide diagrams in floor
  $("#floor3 ."+id.split("-")[0]).hide();
  // remove all active field style which is below
  $("#floor3 .subgroups, #floor4 .subgroups, #floor5 .subgroups").removeClass('active_field');
  // remove content which is below
  $('#floor4, #floor5').html("");
  // show one diagram
  $("#floor3 ."+id).show();
});

$('#floor4').on('click', '.groups', function() {
  var id = this.id.split("button_for_")[1];
  // remove all active button style which is below
  $("#floor4 .groups, #floor5 .groups").removeClass("active_button");
  // add active button style to this element
  $(this).addClass("active_button");
  // hide diagrams in floor
  $("#floor4 ."+id.split("-")[0]).hide();
  // remove all active field style which is below
  $("#floor4 .subgroups, #floor5 .subgroups").removeClass('active_field');
  // remove content which is below
  $('#floor5').html("");
  // show one diagram
  $("#floor4 ."+id).show();
});


$('#floor1').on('click', '.subgroups',function(){
  var id = "#value_"+this.id.split("for_")[1];
  // remove all active field style which is below
  $(".subgroups").removeClass('active_field');
  // add active style to this element
  $(this).addClass('active_field');
  var content = $(id).html();
  // hide all diagram which is below
  $('#floor2, #floor3, #floor4, #floor5').html("");
  // show diagram
  $('#floor2').html(content);
  // show active button style
  $("#floor2 #button_for_"+this.id.split("for_")[1]).addClass("active_button");
});

$('#floor2').on('click', '.subgroups',function(){
  var id = "#value_"+this.id.split("for_")[1];
  // remove all active field style which is below
  $("#floor2 .subgroups, #floor3 .subgroups, #floor4 .subgroups, #floor5 .subgroups").removeClass('active_field');
  // add active style to this element
  $(this).addClass('active_field');
  var content = $(id).html();
  // hide all diagram which is below
  $('#floor3, #floor4, #floor5').html("");
  // show diagram
  $('#floor3').html(content);
  // show active button style
  $("#floor3 #button_for_"+this.id.split("for_")[1]).addClass("active_button");
});

$('#floor3').on('click', '.subgroups',function(){
  var id = "#value_"+this.id.split("for_")[1];
  // remove all active field style which is below
  $("#floor3 .subgroups, #floor4 .subgroups, #floor5 .subgroups").removeClass('active_field');
  // add active style to this element
  $(this).addClass('active_field');
  var content = $(id).html();
  // hide all diagram which is below
  $('#floor4, #floor5').html("");
  // show diagram
  $('#floor4').html(content);
  // show active button style
  $("#floor4 #button_for_"+this.id.split("for_")[1]).addClass("active_button");
});

$('#floor4').on('click', '.subgroups',function(){
  var id = "#value_"+this.id.split("for_")[1];
  // remove all active field style which is below
  $("#floor4 .subgroups, #floor5 .subgroups").removeClass('active_field');
  // add active style to this element
  $(this).addClass('active_field');
  var content = $(id).html();
  // hide all diagram which is below
  $('#floor5').html("");
  // show diagram
  $('#floor5').html(content);
  // show active button style
  $("#floor5 #button_for_"+this.id.split("for_")[1]).addClass("active_button");
});

// transformation rules - show clicked rule
$('.transformation-rules').on('click', '.rules', function() {
  var id = this.id.split("rule_for_")[1];
  $(".rules").removeClass("active_button");
  $(this).addClass("active_button");
  $(".rule").hide();
  $(".rule_"+id).show();
});

// show transformation rules page
$("#rules").click(function(){
  $(".transformation-rules").show();
  $(".memo-diagram").hide();
});

// memo diagram page
$("#memo").click(function(){
  $(".transformation-rules").hide();
  $(".memo-diagram").show();
});
