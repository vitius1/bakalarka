// this floor, floors to hide, id
function groups(floor, floors, th) {
  var id = th.id.split("button_for_")[1];
  // remove all active button style which is below
  $(".groups").removeClass("active_button");
  // add active button style to this element
  $(th).addClass("active_button");
  // hide diagrams in floor
  $(floor + " ." + id.split("-")[0]).hide();
  alert(floor + " ." + id.split("-")[0]);
  // remove all active field style which is below
  $(".subgroups").removeClass('active_field');
  // remove content which is below
  $(floors).html('<div class="replace-dialog" style="display: none;"><H1>Replace</H1><div class="replace-dialog-content"></div></div>');
  // show one diagram
  $(floor + " ." + id).show();
}

$('#floor1').on('click', '.groups', function() {
  groups("#floor1", '#floor2, #floor3, #floor4, #floor5', this);
});
$('#floor2').on('click', '.groups', function() {
  groups("#floor2", '#floor3, #floor4, #floor5', this);
});
$('#floor3').on('click', '.groups', function() {
  groups("#floor3", '#floor4, #floor5', this);
});
$('#floor4').on('click', '.groups', function() {
  groups("#floor4", '#floor5', this);
});

// this floor+1, floors to hide, active field from floors, id
function subgroups(floor, floors, remove, id2) {
  var id = "#value_" + id2.split("for_")[1];
  // remove all active field style which is below
  $(remove).removeClass('active_field');
  // add active style to this element
  $(this).addClass('active_field');
  var content = '<div class="replace-dialog" style="display: none;"><H1>Replace</H1><div class="replace-dialog-content"></div></div>' + $(id).html();
  // hide all diagram which is below
  $(floors).html("");
  // show diagram
  $(floor).html(content);
  // show active button style
  $(floor + " #button_for_" + id2.split("for_")[1]).addClass("active_button");
}

$('#floor1').on('click', '.subgroups', function() {
  subgroups("#floor2", '#floor2, #floor3, #floor4, #floor5', ".subgroups", this.id);
});
$('#floor2').on('click', '.subgroups', function() {
  subgroups("#floor3", '#floor3, #floor4, #floor5', "#floor2 .subgroups, #floor3 .subgroups, #floor4 .subgroups, #floor5 .subgroups", this.id);
});
$('#floor3').on('click', '.subgroups', function() {
  subgroups("#floor4", '#floor4, #floor5', "#floor3 .subgroups, #floor4 .subgroups, #floor5 .subgroups", this.id);
});
$('#floor4').on('click', '.subgroups', function() {
  subgroups("#floor5", '#floor5', "#floor4 .subgroups, #floor5 .subgroups", this.id);
});

// transformation rules - show clicked rule
$('.transformation-rules').on('click', '.rules', function() {
  var id = this.id.split("rule_for_")[1];
  $(".rules").removeClass("active_button");
  $(this).addClass("active_button");
  $(".rule").hide();
  $(".rule_" + id).show();
});

// show transformation rules page
$("#rules").click(function() {
  $(".memo-diagram").hide();
  $(".transformation-rules").show();
  $("#memo").removeClass("active");
  $(this).addClass("active");
});

// memo diagram page
$("#memo").click(function() {
  $(".transformation-rules").hide();
  $(".memo-diagram").show();
  $("#rules").removeClass("active");
  $(this).addClass("active");
});



//middleclick

$("body").click(function(event) {
  if (!$(event.target).is(".replace-dialog")) {
    $(".replace-dialog").hide();
  }
});

function scrollClick(floor, e, id) {
  if (e.which == 2) {
    $(floor + " .replace-dialog").show();
    var html = $(".buttons-replace-diagram-" + id.split("for_")[1]).html();
    $(floor + " .replace-dialog-content").html(html);
  }
}

function replaceGroups(floor, t) {
  var id = $(t).attr("class").split(" ")[1].split("button-replace-diagram-")[1];
  $(floor + " .for-replace-root-" + id.split("-")[0]).hide();
  $(floor + " .replace-dialog").hide();
  $(floor + " .replace-diagram-" + id).show();
}

$('#floor1').on('mousedown', '.subgroups', function(e) {
  scrollClick("#floor1", e, this.id);
});
$('#floor1').on('click', '.replace-groups', function() {
  replaceGroups("#floor1", this);
});
$('#floor2').on('mousedown', '.subgroups', function(e) {
  scrollClick("#floor2", e, this.id);
});
$('#floor2').on('click', '.replace-groups', function() {
  replaceGroups("#floor2", this);
});
$('#floor3').on('mousedown', '.subgroups', function(e) {
  scrollClick("#floor3", e, this.id);
});
$('#floor3').on('click', '.replace-groups', function() {
  replaceGroups("#floor3", this);
});
$('#floor4').on('mousedown', '.subgroups', function(e) {
  scrollClick("#floor4", e, this.id);
});
$('#floor4').on('click', '.replace-groups', function() {
  replaceGroups("#floor4", this);
});
$('#floor5').on('mousedown', '.subgroups', function(e) {
  scrollClick("#floor5", e, this.id);
});
$('#floor5').on('click', '.replace-groups', function() {
  replaceGroups("#floor5", this);
});