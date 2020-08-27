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
$id = filter_var($_GET["id"], FILTER_SANITIZE_STRING);
$employ = "SELECT * FROM employee WHERE euid='$id'";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $employ);
while($row = mysqli_fetch_assoc($result)){
	$first = $row['fname'];
	$id = $row['euid'];
	$last = $row['sname'];
	$phone = $row['phone'];
	$alternate = $row['alternate'];
	$is_type = $row['is_type'];
	$type = $row['type'];
	$tnum = $row['type_number'];
	$is_alternate = $row['is_alternate'];
	$is_additional = $row['is_additional'];
	$street = $row['street'];
	$city = $row['city'];
	$postal = $row['postal'];
    if ($alternate == '') {
        $phone = "<i class='fa fa-phone'></i>&nbsp; $phone";
    } else {
        $phone = "<i class='fa fa-phone'></i>&nbsp; $phone <br/><i class='fa fa-phone'></i>&nbsp; $alternate ";
    }
}
$hq = "SELECT SUM(hours) AS value_sum FROM shifts WHERE euid='$id' AND filled='1' AND cancelled='0'";
$hres = mysqli_query($GLOBALS["___mysqli_ston"], $hq);
$hrow = mysqli_fetch_assoc($hres); 
$hours = $hrow['value_sum'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo($first); ?>'s Profile</title>
<?php $widget = true; include('includes.php'); ?>
<meta name="description" content="Robots rule.txt">
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
document.title = "<?php echo($first.' '.$last.'\'s Profile') ?>";
history.pushState(null,"","/Staff/List/Profile/<?php echo($id); ?>");
</script>
<?php echo($header_info); ?>
<style>
.sprite_fail {
	width:18px;
	height:18px;
	background-image:url('/img/misc/fail.png');
	background-repeat:no-repeat;
	background-size:18px;
	display:inline-block;
}
@media print {
	#header {
		display:none;
	}
	#ui {
		display:none;
	}
	h2 {
		padding-top:23px;
	}
	#holder {
		border:none;
	}
	.onoffswitch {
		width: 40px;
	}
	#overlay {
		display:none!important;
	}
	#content {
		display:none!important;
	}
	#widget_ep {
		top:0px!important;
		left:0px!important;
		position:relative!important;
		height:auto!important;
	}
}
</style>
</head>
<body>
<div id="holder">
	<div id="exit"><div class="sprite_fail close-widget" title="Exit"></div></div>
	<div id="box" data-location="Employee Profile">
		<div id="ep_head">
        <?php
		
		echo('<div class="nextor" style="display:none;"><select id="nextor">');
		$nextor = "SELECT  @row:=@row+1 as rank, a.euid,a.sname FROM employee a, (SELECT @row:=0) b ORDER BY a.sname ASC";
$resnext = mysqli_query($GLOBALS["___mysqli_ston"], $nextor);
while($next = mysqli_fetch_assoc($resnext)){
	echo('<option data-count="'.$next['rank'].'" value="'.$next['euid'].'">'.$next['sname'].'</option>');
}
		echo('</select></div>');
		echo "<script>
$(document).ready( function(){
	$('#nextor option[value=\"$id\"]').attr('selected', 'selected');
});
	$(\"#nextorNext\").click(function() {
     if($(this).is(':disabled')) { 
         event.preventDefault();
     } else{
	$('#loader').css(\"display\", \"block\");
    var werk = $('#nextor option:selected').data('count');
	var len = document.querySelector(\"#nextor\").length;
    if (werk == len){
		$(\"#nextorNext\").prop(\"disabled\",true);
        $('#nextor [data-count=\"1\"]').attr('selected', 'selected');
		var cv = $('#nextor').val();
		$('#widget_ep').load(''+root+'employee_profile?id='+cv+'', function() {
			$('#loader').css(\"display\", \"none\");
			});
    }
    else {
	$(\"#nextorNext\").prop(\"disabled\",true);
    $('#nextor option:selected').next().attr('selected', 'selected');
	var cv = $('#nextor').val();
	$('#widget_ep').load(''+root+'employee_profile?id='+cv+'', function() {
			$('#loader').css(\"display\", \"none\");
			});
    }
	 }
});
$(\"#nextorPrev\").click(function() {
     if($(this).is(':disabled')) { 
         event.preventDefault();
     }else {
	$('#loader').css(\"display\", \"block\");
    var werk = $('#nextor option:selected').data('count');
	var len = document.querySelector(\"#nextor\").length;
    if (werk == '1'){
		$(\"#nextorPrev\").prop(\"disabled\",true);
        $('#nextor [data-count=\"'+len+'\"]').attr('selected', 'selected');
		var cv = $('#nextor').val();
		$('#widget_ep').load(''+root+'employee_profile?id='+cv+'', function() {
			$('#loader').css(\"display\", \"none\");
			});
    }    
    else {
	$(\"#nextorPrev\").prop(\"disabled\",true);
    $('#nextor option:selected').prev().attr('selected', 'selected');
	var cv = $('#nextor').val();
	$('#widget_ep').load(''+root+'employee_profile?id='+cv+'', function() {
			$('#loader').css(\"display\", \"none\");
			});
    }
	 }
});</script>
";
		
		 ?>
        	<div id="ep_avatar">
            	<a href="#" class="avatar"><span class="image employee"></span></a>
            </div>
        	<div id="ep_info">
                <span class="name" style="height:56px;">
                    <div style="float:right;" class="nextor">
                        <input type="button" id="nextorPrev" value="<" style="width:60px;">
                        <input type="button" id="nextorNext" value=">" style="width:60px;">
                    </div>
					<?php echo("$last, $first"); ?>
                </span>
                <span class="address"><?php echo("$street<br>$city, ON<br>$postal"); ?></span>
                <span class="address"><?php echo("$phone"); ?></span>
                <span class="comments"><div class="sprite_calc" title="Calculate the sum of hours between certain dates for this employee"></div><p style="margin:0px;margin-bottom:5px;"><?php if ($hours > 0){echo("$hours hours successfully completed.");} else{ echo('No hours completed yet'); } ?></p><?php echo("$additional"); ?></span>
            </div>
        	<div id="hour_calculator">
                <span class="name">Hour Calculator</span>
                <span class="address" style="display:inline-block;width:335px;"><input style="width: 140px;float:left;" id="date" type="date" name="date" value="" /><p style="display:inline-block;float:left;">to</p><input style="width: 140px;float:left;" id="date2" type="date" name="date2" /></span>
                <span class="comments"><div id="hours" data-location="widget_display_hour"></div></span>
            </div>
        </div>
        <break></break>
        <div id="ep_tail">
        <h2>Recent Shifts</h2>
        <table class="flatTable">
        	<?php 
			echo ("
		<tr class='headingTr'>
			<td>Date</td>
			<td>Location</td>
			<td>Time In</td>
			<td>Time Out</td>
			<td class=\"controls\"></td>
        </tr>
			");
				$qry = "SELECT * FROM shifts WHERE euid='$id' AND filled='1' AND cancelled='0' ORDER BY date DESC LIMIT 25";
				$res =  mysqli_query($GLOBALS["___mysqli_ston"], $qry);
			if(mysqli_num_rows($res)>0){
				while($row = mysqli_fetch_assoc($res)){
					    $in = $row['IN1'];
						$locode = $row['location'];
						$date = date("D M jS, Y", strtotime($row['date']));
						$hour = $row['IN1'];
						$minute = $row['IN2'];
						$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
						$hour2 = $row['OUT1'];
						$minute2 = $row['OUT2'];
						$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
						$caller = $row['caller'];
		$filled = $row['filled'];
				if ($filled == '0'){
			$UFrow = ('<div class="settingsIcon" onclick="fillRow(&quot;'.$row['code'].'&quot;,&quot;fill&quot;)">Fill</div>');
		}
		if ($filled == '1'){
			$UFrow = ('<div class="settingsIcon" onclick="unfillRow(&quot;'.$row['code'].'&quot;,&quot;unfill&quot;)">Unfill</div>');
		}
			$cancelRow = ('<div class="settingsIcon" onclick="cancelRow(&quot;'.$row['code'].'&quot;,&quot;cancel&quot;)">Cancel</div>');
			$deleteDiv = ('<span class="settingsIcon" onclick="deleteRow(&quot;'.$row['code'].'&quot;)">Delete</span>');
			$editRow = ('<div class="settingsIcon" onclick="editRow(&quot;'.$row['code'].'&quot;,&quot;edit&quot;,&quot;'.$row['filled'].'&quot;)">Edit</div>');
							if ($in <= 10) {
							echo (
							'<tr class="mshift" data-shift-id="'.$row['code'].'">
							<td title="'.$date.'">'.$row['date'].'</td>
							<td>'.$row['name'].'</td>
							<td>'.$time_12_hour_IN.'</td>
							<td>'.$time_12_hour_OUT.'</td>
							<td class="controlTd">
								<div class="settingsIcons">
									<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
									'.$cancelRow.'
									'.$editRow.'
									'.$UFrow.'
								</div> 
							</td>
							</tr>'
							);
							}
							if ($in >= 11 && $in <= 16) {
							echo (
							'<tr class="ashift" data-shift-id="'.$row['code'].'">
							<td title="'.$date.'">'.$row['date'].'</td>
							<td>'.$row['name'].'</td>
							<td>'.$time_12_hour_IN.'</td>
							<td>'.$time_12_hour_OUT.'</td>
							<td class="controlTd">
								<div class="settingsIcons">
									<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
									'.$cancelRow.'
									'.$editRow.'
									'.$UFrow.'

								</div> 
							</td>
							</tr>'
							);
							}
							if ($in >= 17 && $in <= 23) {
							echo (
							'<tr class="nshift" data-shift-id="'.$row['code'].'">
							<td title="'.$date.'">'.$row['date'].'</td>
							<td>'.$row['name'].'</td>
							<td>'.$time_12_hour_IN.'</td>
							<td>'.$time_12_hour_OUT.'</td>
							<td class="controlTd">
								<div class="settingsIcons">
									<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
									'.$cancelRow.'
									'.$editRow.'
									'.$UFrow.'
								</div> 
							</td>
							</tr>'
							);
							}					
				}
				echo ("			<tr class='hr_total'><td>&nbsp;</td>
			<td>&nbsp;</td>
			<td class='hr_total_title'>Total:</td>
			<td>".$hours." hours</td>
			<td class=\"controls\"></td></tr>");
			}
				else{
		echo ('<tr><td colspan="10">No recent shifts found for '.$first.' '.$last.'</td></tr>');
		}
			?>
            </table>
        </div>
	</div>
<script>
$("#date").change(function(){
	var d1 = $('#date').val();
	var d2 = $('#date2').val();
	var id = "<?php echo "$id"; ?>";
	var name = "<?php echo ($first.'_'.$last); ?>";
	$("div[data-location='widget_display_hour']").load(''+root+'widget_display.php?d1='+d1+'&d2='+d2+'&id='+id+'&name='+name+'&action=get_hours');
}
);
$("#date2").change(function(){
	var d1 = $('#date').val();
	var d2 = $('#date2').val();
	var id = "<?php echo "$id"; ?>";
	var name = "<?php echo ($first.'_'.$last); ?>";
	$("div[data-location='widget_display_hour']").load(''+root+'widget_display.php?d1='+d1+'&d2='+d2+'&id='+id+'&name='+name+'&action=get_hours');
}
);
$('.sprite_calc').click(function () {
	var h_css = $("#hour_calculator").css('display');
	if (h_css == 'none'){
		$("#hour_calculator").fadeIn();
	}
	if (h_css == 'block'){
		$("#hour_calculator").fadeOut();
	}
});
$(document).ready(function () {
$(".controlTd").click(function () {
  var span=$(this).children(".settingsIcons");
  span.toggleClass("display"); 
  span.children(".settingsIcon").toggleClass("openIcon"); 
});	
$(".close-widget").click(function(){
		$('#overlay').fadeOut().html("");
		$('#v_cal').slideUp().delay(1000).queue(function(){$(this).html("").hide().dequeue();});
		$('#widget_ep').slideUp().delay(1000).queue(function(){$(this).html("").hide().dequeue();});
	});
});
(function($){
		
		$("#widget_ep #holder").mCustomScrollbar({
			theme:"minimal",
			scrollInertia: 0
		});
		
})(jQuery);
</script>
</div>
</body>
</html>