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
$d1 = filter_var($_GET["d1"], FILTER_SANITIZE_STRING);	
$d2 = filter_var($_GET["d2"], FILTER_SANITIZE_STRING);	
$d2_stripped = str_replace(" ","%20",$d2);
$d1_str = strtotime($d1);
$d1_words = date("M d, Y", $d1_str);
$d2_str = strtotime($d2);
$d2_words = date("M d, Y", $d2_str);
?><head>
</head>
<?php echo($header_info); ?>
<style>
.sprite_calc {
	width:32px;
	height:32px;
	background-image:url('/img/misc/calc.png');
	background-repeat:no-repeat;
	background-size:32px;
	display:inline-block;
	float:right;
	cursor:pointer;
}
.sprite_calc:hover {
	opacity:0.5;
}
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
<?php 
		echo('<div class="nextor" style="float:left;"><select id="nextor" class="holder">');
		$nextor = "SELECT @row:=@row+1 as rank, a.euid, a.ename FROM (SELECT DISTINCT euid, ename FROM shifts WHERE filled='1' AND cancelled='0' AND dt_1 >= '$d1' AND dt_1<= '$d2') a, (SELECT @row:=0) b ORDER BY a.ename ASC";
$resnext = mysqli_query($GLOBALS["___mysqli_ston"], $nextor);
while($next = mysqli_fetch_assoc($resnext)){
	if ($next['rank'] == 1){
		$_SESSION['FIRST'] = $next['euid'];
	}
	echo('<option data-count="'.$next['rank'].'" value="'.$next['euid'].'">'.$next['ename'].'</option>');
}
		echo('</select></div>');

if (!isset ($_GET["id"])){
	$id = $_SESSION['FIRST'];
}
if (isset ($_GET["id"])){
	$id = filter_var($_GET["id"], FILTER_SANITIZE_STRING);	
}
$employ = "SELECT * FROM employee WHERE euid='$id'";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $employ);
$many = mysqli_num_rows($result);
if ($many < 1){
	die('<script>
	puno("No employees found for this pay period.","error");
	$("#overlay").click();
	$("#payroll_holder").slideUp().delay(1000).queue(function(){$(this).html("").hide().remove().dequeue();});
	</script>');
}
while($row = mysqli_fetch_assoc($result)){
	$first = $row['fname'];
	$id = $row['euid'];
	$last = $row['sname'];
	$rate = $row['rate'];
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
}
$hq = "SELECT SUM(hours) AS value_sum FROM shifts WHERE euid='$id' AND filled='1' AND cancelled='0' AND dt_1 >= '$d1' AND dt_1<= '$d2'";
$hres = mysqli_query($GLOBALS["___mysqli_ston"], $hq);
$hrow = mysqli_fetch_assoc($hres); 
$hours = $hrow['value_sum'];
 ?>
 <script>
 $(document).ready(function(){
	$("#nextor").val('<?php echo($id); ?>'); 
$(".close-widget, #overlay").click(function(){
		$('#overlay').fadeOut().html("");
		$('#payroll_holder').slideUp().delay(1000).queue(function(){$(this).html("").hide().remove().dequeue();});
	});
});
$(".controlTd").click(function () {
  var span=$(this).children(".settingsIcons");
  span.toggleClass("display"); 
  span.children(".settingsIcon").toggleClass("openIcon"); 
});	
 	$("#nextorNext").click(function() {
     if($(this).is(':disabled')) { 
         event.preventDefault();
     } else{
	$('#loader').css("display", "block");
    var werk = $('#nextor option:selected').data('count');
	var len = document.querySelector("#nextor").length;
    if (werk == len){
		$("#nextorNext").prop("disabled",true);
        $('#nextor [data-count="1"]').attr('selected', 'selected');
		var cv = $('#nextor').val();
	$("#payroll_holder").load('payroll.php?<?php echo("d1=$d1&d2=$d2_stripped"); ?>&id='+cv+'', function() {
			$('#loader').css("display", "none");
			});
    }
    else {
	$("#nextorNext").prop("disabled",true);
    $('#nextor option:selected').next().attr('selected', 'selected');
	var cv = $('#nextor').val();
	$("#payroll_holder").load('payroll.php?<?php echo("d1=$d1&d2=$d2_stripped"); ?>&id='+cv+'', function() {
			$('#loader').css("display", "none");
			});
    }
	 }
});
$("#nextorPrev").click(function() {
     if($(this).is(':disabled')) { 
         event.preventDefault();
     }else {
	$('#loader').css("display", "block");
    var werk = $('#nextor option:selected').data('count');
	var len = document.querySelector("#nextor").length;
    if (werk == '1'){
		$("#nextorPrev").prop("disabled",true);
        $('#nextor [data-count="'+len+'"]').attr('selected', 'selected');
		var cv = $('#nextor').val();
		$("#payroll_holder").load('payroll.php?<?php echo("d1=$d1&d2=$d2_stripped"); ?>&id='+cv+'', function() {
			$('#loader').css("display", "none");
			});
    }    
    else {
	$("#nextorPrev").prop("disabled",true);
    $('#nextor option:selected').prev().attr('selected', 'selected');
	var cv = $('#nextor').val();
	$("#payroll_holder").load('payroll.php?<?php echo("d1=$d1&d2=$d2_stripped"); ?>&id='+cv+'', function() {
			$('#loader').css("display", "none");
			});
    }
	 }
});
 </script>
<div id="holder" style="min-width:900px;min-height:600px;">
	<div id="exit"><div class="sprite_fail close-widget" title="Exit"></div></div>
	<div id="box" data-location="Employee Profile">
		<div id="ep_head">
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
                <span class="comments"><p style="margin:0px;"><?php if ($hours > 0){echo("$hours hours successfully completed.");} else{ echo('No hours completed yet'); } ?></p><?php echo("$additional"); ?></span>
            </div>
        </div>
        <break></break>
        <div id="ep_tail">
        <h2>Pay Period: <?php echo($d1_words.' - '.$d2_words); ?></h2>
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
				$qry = "SELECT * FROM shifts WHERE euid='$id' AND filled='1' AND cancelled='0' AND dt_1 >= '$d1' AND dt_1<= '$d2'ORDER BY date";
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
    </div>
