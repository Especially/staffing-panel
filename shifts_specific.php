<?php 
	require_once('cFigure.php');
	require_once('auth.php');		
//if (!$_POST) {
//echo('Invalid request');
//die;
//}
	//Connect to mysql server
	$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST,  DB_USER,  DB_PASSWORD));
	if(!$link) {
		die('Failed to connect to server: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	}
	
	//Select database
	$db = ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . constant('DB_DATABASE')));
	if(!$db) {
		die("Unable to select database");
	}
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $str) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	}	
$location = filter_var($_GET["location"], FILTER_SANITIZE_STRING);
$loc = "SELECT * FROM location WHERE code='$location'";
$sol = mysqli_query($GLOBALS["___mysqli_ston"], $loc);
while($row1 = mysqli_fetch_assoc($sol)){
	$type = $row1['is_type'];
	if($type=='false'){
	$SESSION_LOCATION_NAME = $row1['name'];
	$name = $SESSION_LOCATION_NAME;
	}
	if($type=='true'){
	$SESSION_LOCATION_NAME = $row1['name'].' ('.$row1['type'].' #'.$row1['type_number'].')';
	$name = $SESSION_LOCATION_NAME;
	}
}
?>
<html>
<head>
<title>Shifts</title>
<?php $widget = true; include('includes.php'); ?>
<script src="http://staffingpanel.x10.mx/js/Histex.js"></script>
<meta name="description" content="Robots rule.txt">
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
</script>
</head>
<body>
<div id="holder" class="mCustomScrollbar light holder" data-mcs-theme="light-thick">
<?php echo($header_info); ?>
<div id="ss_controls">
<script>
	$("#myonoffswitch").change(function(){
		var term = $("#myonoffswitch").is(':checked');
		var month = $('#month').val();
		var year = $('#year').val();
		var order = $("#sort_input").val();
		$("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables.php?location=<?php echo($location) ?>&sort='+order+'&term='+term+'&mo='+month+'&ye='+year+'');
	}
	);
	$("#month").change(function(){
		var term = $("#myonoffswitch").is(':checked');
		var month = $('#month').val();
		var year = $('#year').val();
		var order = $("#sort_input").val();
		$("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables.php?location=<?php echo($location) ?>&sort='+order+'&term='+term+'&mo='+month+'&ye='+year+'');
	}
	);
	$("#year").change(function(){
		var term = $("#myonoffswitch").is(':checked');
		var month = $('#month').val();
		var year = $('#year').val();
		var order = $("#sort_input").val();
		$("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables.php?location=<?php echo($location) ?>&sort='+order+'&term='+term+'&mo='+month+'&ye='+year+'');
	}
	);
	$("#all").click(function(){
		var month = $('#month').val();
		var year = $('#year').val();
		var term = $("#myonoffswitch").is(':checked');
		$("#sort_input").val('all');
        $("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables.php?location=<?php echo($location) ?>&sort=all&term='+term+'&mo='+month+'&ye='+year+'');
	});
	$("#filled").click(function(){
		var month = $('#month').val();
		var year = $('#year').val();
		var term = $("#myonoffswitch").is(':checked');
		$("#sort_input").val('filled');
        $("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables?location=<?php echo($location) ?>&sort=filled&term='+term+'&mo='+month+'&ye='+year+'');
	});
	$("#unfilled").click(function(){
		var month = $('#month').val();
		var year = $('#year').val();
		var term = $("#myonoffswitch").is(':checked');
		$("#sort_input").val('unfilled');
        $("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables?location=<?php echo($location) ?>&sort=unfilled&term='+term+'&mo='+month+'&ye='+year+'');
	});
	$("#cancelled").click(function(){
		var secondcss = $('.secondary_nav').css('display');
		if (secondcss == 'none') {
		$('.secondary_nav').slideDown().show();
		}
		if (secondcss == 'block') {
		$('.secondary_nav').slideUp();
		}
	});
	$("#c_all").click(function(){
		var month = $('#month').val();
		var year = $('#year').val();
		var term = $("#myonoffswitch").is(':checked');
		$("#sort_input").val('cancelled&sub=all')
        $("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables?location=<?php echo($location) ?>&sort=cancelled&sub=all&term='+term+'&mo='+month+'&ye='+year+'');
	});
	$("#c_filled").click(function(){
		var month = $('#month').val();
		var year = $('#year').val();
		var term = $("#myonoffswitch").is(':checked');
		$("#sort_input").val('cancelled&sub=filled');
        $("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables?location=<?php echo($location) ?>&sort=cancelled&sub=filled&term='+term+'&mo='+month+'&ye='+year+'');
	});
	$("#c_unfilled").click(function(){
		var month = $('#month').val();
		var year = $('#year').val();
		var term = $("#myonoffswitch").is(':checked');
		$("#sort_input").val('cancelled&sub=unfilled')
        $("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables?location=<?php echo($location) ?>&sort=cancelled&sub=unfilled&term='+term+'&mo='+month+'&ye='+year+'');
	});
</script>
<div class="onoffswitch">
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
    <label class="onoffswitch-label" for="myonoffswitch">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>
<div id="ss_date">
    <select name="month" id="month" style="width:8em;">
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>
    <select name="year" id="year" style="width:5em;">
        <option value="2011">2011</option>
        <option value="2012">2012</option>
        <option value="2013">2013</option>
        <option value="2014">2014</option>
        <option value="2015">2015</option>
        <option value="2016">2016</option>
    </select>
    <input type="hidden" name="sort_input" id="sort_input" value="">
</div>
    <div id="ui">
        <ul id="blacknav">
            <li class="first"><a  class="first psl-t" href="/Locations/List/Calendar/<?php echo($location); ?>/All" data-shift-title="All Shifts at <?php echo($name); ?>" id="all">All</a></li>
            <li><a href="/Locations/List/Calendar/<?php echo($location); ?>/Filled" class="psl-t" data-shift-title="Filled Shifts at <?php echo($name); ?>" id="filled">Filled</a></li>
            <li><a href="/Locations/List/Calendar/<?php echo($location); ?>/Unfilled" class="psl-t" data-shift-title="Unfilled Shifts at <?php echo($name); ?>" id="unfilled">Unfilled</a></li>
            <li><a href ="/Locations/List/Calendar/<?php echo($location); ?>/Cancelled" data-shift-title="Cancelled Shifts at <?php echo($name); ?>" class="last rednav psl-t" id="cancelled">Cancelled</a></li>
        </ul>
        <div id="ui" class='secondary_nav' style="display:none;right:0px;">
            <ul id="rednav">
                <li class="first"><a  class="first psl-t" href="/Locations/List/Calendar/<?php echo($location); ?>/Cancelled/All" data-shift-title="All Cancelled Shifts at <?php echo($name); ?>" id="c_all">All</a></li>
                <li><a href="/Locations/List/Calendar/<?php echo($location); ?>/Cancelled/Filled" class="psl-t" data-shift-title="Cancelled Filled Shifts at <?php echo($name); ?>" id="c_filled">Filled</a></li>
                <li><a href="/Locations/List/Calendar/<?php echo($location); ?>/Cancelled/Unfilled" data-shift-title="Cancelled Unfilled Shifts at <?php echo($name); ?>" id="c_unfilled" class="last psl-t">Unfilled</a></li>
            </ul>
        </div>
    </div>
<div id="exit"><div class="sprite_fail close-widget" title="Exit"></div></div>
</div>
  <div id="box" data-location="calendar shifts">
    <center><h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);">Loading<marquee>...</marquee></h2></center>
</div>
<script type="text/javascript">
    $(document).ready(function(){
      FilledShifts();
    });
	var d = new Date(),
		n = d.getMonth(),
		y = d.getFullYear();
	$('#month option:eq('+n+')').prop('selected', true)	
	$('#year option[value="'+y+'"]').prop('selected', true);
	$('#month_input').val(n);
	$('#year_input').val(y);
	$("#sort_input").val('filled')
    function FilledShifts(){
		var term = $("#myonoffswitch").is(':checked');
		var d = new Date(),
			n = d.getMonth(),
			y = d.getFullYear();
        $("div[data-location='calendar shifts']").load(''+root+'shifts_specific_tables.php?location=<?php echo($location) ?>&sort=filled&term='+term+'&mo='+(n+1)+'&ye='+y+'');
    }
</script>
<script>
$(".close-widget").click(function(){
		$('#overlay').fadeOut().html("");
		$('#v_cal').slideUp().delay(1000).queue(function(){$(this).html("").hide().dequeue();});
		$('#widget_ep').slideUp().delay(1000).queue(function(){$(this).html("").hide().dequeue();});
});
</script>
</div>
</body>