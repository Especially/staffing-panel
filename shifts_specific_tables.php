<?php 
	require_once('cFigure.php');	
	
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
$sort = filter_var($_GET["sort"], FILTER_SANITIZE_STRING);
$sub = filter_var($_GET["sub"], FILTER_SANITIZE_STRING);
$term = filter_var($_GET["term"], FILTER_SANITIZE_STRING);
$month = filter_var($_GET["mo"], FILTER_SANITIZE_STRING);
$year = filter_var($_GET["ye"], FILTER_SANITIZE_STRING);
if ($term=='true'){
	$start_date = $year.'-'.$month.'-01';
	$end_date = $year.'-'.$month.'-15';
	$start_expand = date("D M jS, Y", strtotime($start_date));
	$end_expand = date("D M jS, Y", strtotime($end_date));
}
if ($term=='false'){
	$last = cal_days_in_month(CAL_GREGORIAN, $month, $year);;
	$start_date = $year.'-'.$month.'-16';
	$end_date = $year.'-'.$month.'-'.$last;
	$start_expand = date("D M jS, Y", strtotime($start_date));
	$end_expand = date("D M jS, Y", strtotime($end_date));
}
if ($sort=='all'){
	$sort_type='All';
	$sorting="";
}
if ($sort=='filled'){
	$sort_type='Filled';
	$sorting="filled='1' AND cancelled='0' AND";
}
if ($sort=='unfilled'){
	$sort_type='Unfilled';
	$sorting="filled='0' AND cancelled='0' AND";
}
if ($sort=='cancelled'){
	if ($sub=='all'){
		$sort_type='All Cancelled';
		$sorting="cancelled='1' AND";
	}
	if ($sub=='filled'){
		$sort_type='Cancelled & Filled';
		$sorting="cancelled='1' AND filled='1' AND";
	}
	if ($sub=='unfilled'){
		$sort_type='Cancelled & Unfilled';
		$sorting="cancelled='1' AND filled='0' AND";
	}
}
$loc = "SELECT * FROM location WHERE code='$location'";
$sol = mysqli_query($GLOBALS["___mysqli_ston"], $loc);
while($row1 = mysqli_fetch_assoc($sol)){
	$type = $row1['is_type'];
	if($type=='false'){
	$SESSION_LOCATION_NAME = $row1['name'];
	$name = $SESSION_LOCATION_NAME;
	$address = $row1['street'];
	$address .= "<br/>".$row1['city'].", ON";
	$address .= "<br/>".$row1['postal'];
	}
	if($type=='true'){
	$SESSION_LOCATION_NAME = $row1['name'].' ('.$row1['type'].' #'.$row1['type_number'].')';
	$name = $SESSION_LOCATION_NAME;
	$address = $row1['type_number']."-".$row1['street'];
	$address .= "<br/>".$row1['city'].", ON";
	$address .= "<br/>".$row1['postal'];
	}
}
?>
<script src="http://staffingpanel.x10.mx/js/Histex.js"></script>
<script>
document.title= "<?php echo(''.$sort_type.' at '.$name); ?>";
</script>
<style>
.sprite_check {
	width:18px;
	height:18px;
	background-image:url('/img/misc/check.png');
	background-repeat:no-repeat;
	background-size:18px;
	display:inline-block;
}
.sprite_fail {
	width:18px;
	height:18px;
	background-image:url('/img/misc/fail.png');
	background-repeat:no-repeat;
	background-size:18px;
	display:inline-block;
}
	p.ss_date {
		display:none;
		font-size:12px;
		position:absolute;
		top:108px;
	}
@media print {
	#header {
		display:none;
	}
	#ui {
		display:none;
	}
	.onoffswitch-switch {
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
	#ss_date {
		left:55px;
	}
	#ss_recipient {
		display:block;
	}
	.onoffswitch-label, #month, #year {
		-webkit-box-shadow:none;
		border:none;
		-webkit-appearance: none;
    	-moz-appearance: none;
    	appearance: none;
	}
	#ss_controls {
		display:none!important;
	}
	.shift_type {
		display:none;
	}
	td.ss_controltd {
		display:none;
	}
	p.ss_date {
		display:inline;
	}
	#overlay {
		display:none!important;
	}
	#content {
		display:none!important;
	}
	#v_cal {
		top:0px!important;
		left:0px!important;
		position:relative!important;
		height:auto!important;
	}
}
</style>
    <h2 style="color: rgba(255, 255, 255, 1);text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);">
    <fieldset id="ss_recipient">
    	<legend>Recipient:</legend>
        <p><?php echo($address); ?></p>
    </fieldset>
<center><span class="shift_type"><?php echo($sort_type); ?> Shifts:</span><br/><?php echo($name); ?>
<p class="ss_date"><?php echo ($start_expand.'-'.$end_expand) ?></p></center>
</h2>
    <table class="flatTable">
      <tr class="headingTr <?php if ($sort=='cancelled'){echo('cancel_table');}?>">
<?php
if ($sort=='all'){
	echo
        ('
		<td>Date</td>
        <td>Caller</td>
        <td>Time In</td>
        <td>Time Out</td>
		<td title="Filled|Cancelled">Activity</td>		
        <td class="ss_controltd"></td>');
}
if ($sort=='filled'){
	echo
        ('<td>Date</td>
        <td>Filled By</td>
        <td>Time In</td>
        <td>Time Out</td>
        <td class="ss_controltd"></td>');
}
if ($sort=='unfilled'){
	echo
        ('<td>Date</td>
        <td>Caller</td>
        <td>Time In</td>
        <td>Time Out</td>
        <td class="ss_controltd"></td>');
}
if ($sort=='cancelled'){
		if ($sub=='all'){
		echo
			('<td>Date</td>
			<td>Date Cancelled</td>
			<td>Cancel Reason</td>
			<td>Caller</td>
			<td>Cancel Caller</td>
			<td>Time In</td>
			<td>Time Out</td>
			<td class="ss_controltd"></td>');
		}
		if ($sub=='unfilled'){
		echo
			('<td>Date</td>
			<td>Date Cancelled</td>
			<td>Cancel Reason</td>
			<td>Caller</td>
			<td>Cancel Caller</td>
			<td>Time In</td>
			<td>Time Out</td>
			<td class="ss_controltd"></td>');
		}
		if ($sub=='filled'){
		echo
			('<td>Date</td>
			<td>Date Cancelled</td>
			<td>Cancel Reason</td>
			<td>Filled By</td>
			<td>Cancel Caller</td>
			<td>Time In</td>
			<td>Time Out</td>
			<td class="ss_controltd"></td>');
		}
}
?>
      </tr>
      <?php
$qry = "SELECT * FROM shifts WHERE $sorting location='$location' AND date >= '$start_date' and date <= '$end_date' ORDER BY date ASC, IN1 ASC";
$qry2 = "SELECT SUM(hours) AS hour_count FROM shifts WHERE $sorting location='$location' AND date >= '$start_date' and date <= '$end_date'";
$ress2 = mysqli_query($GLOBALS["___mysqli_ston"], $qry2);
$row2 = mysqli_fetch_assoc($ress2); 
$hours = $row2['hour_count'];
$ressu = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
if(mysqli_num_rows($ressu)>0){
	while($row = mysqli_fetch_assoc($ressu)){
// Gathering Important Variables
	// Date & Time Specific Variables
		$date_title = date("D M jS, Y", strtotime($row['date']));
//		$datefilled = date("Y-M-D g:i A", strtotime($row['fill_timestamp']));
//		$datefilled_title = date("D M jS, Y", strtotime($row['fill_timestamp']));
		$datecancelled = date("Y-M-D g:i A", strtotime($row['cancel_timestamp']));
		$datecancelled_title = date("D M jS, Y", strtotime($row['cancel_timestamp']));
		$timestamp = date("Y-M-D g:i A", strtotime($row['timestamp']));
		$timestamp_title = date("D M jS, Y", strtotime($row['timestamp']));
		$in = $row['IN1'];
		$hour = $row['IN1'];
		$minute = $row['IN2'];
		$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
		$hour2 = $row['OUT1'];
		$minute2 = $row['OUT2'];
		$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
	// Miscellaneous Variables
		// Cancel Variables
		$cancelled = $row['cancelled'];
		$reason = $row['cancel_reason'];
		$cancel_caller = $row['cancel_caller'];
		// Other
		$locode = $row['location'];
		$login = $row['fill_login'];
		$filled = $row['filled'];
// Declare Activity Statements (Sort=All))
		if ($filled=='0'){
			$fill_title = ('Not filled');
			$fill_sprite = ('<div class="sprite_fail" title="'.$fill_title.'"></div>');
		}
		if ($filled=='1'){
			$fill_title = ('Filled');
			$fill_sprite = ('<div class="sprite_check" title="'.$fill_title.'"></div>');
		}
		if ($cancelled=='0'){
			$cancel_title = ('Not cancelled');
			$cancel_sprite = ('<div class="sprite_fail" title="'.$cancel_title.'"></div>');
		}
		if ($cancelled=='1'){
			$cancel_title = ('Cancelled');
			$cancel_sprite = ('<div class="sprite_check" title="'.$cancel_title.'"></div>');
		}
// Declare Unfilled Statements (Sort=Unfilled) or (Sub=Unfilled)
		$caller = $row['caller'];
		if ($caller==' '){
			$caller = 'Unknown';
		}
// Declare Filled Statements (Sort=Filled)) or (Sub=Filled)
		$filled_by = $row['ename'];
				if ($filled == '0'){
			$UFrow = ('<div class="settingsIcon" onclick="fillRow(&quot;'.$row['code'].'&quot;,&quot;fill&quot;)">Fill</div>');
		}
		if ($filled == '1'){
			$UFrow = ('<div class="settingsIcon" onclick="unfillRow(&quot;'.$row['code'].'&quot;,&quot;unfill&quot;)">Unfill</div>');
		}
			$cancelRow = ('<div class="settingsIcon" onclick="cancelRow(&quot;'.$row['code'].'&quot;,&quot;cancel&quot;)">Cancel</div>');
			$deleteDiv = ('<span class="settingsIcon" onclick="deleteRow(&quot;'.$row['code'].'&quot;)">Delete</span>');
			$editRow = ('<div class="settingsIcon" onclick="editRow(&quot;'.$row['code'].'&quot;,&quot;edit&quot;,&quot;'.$row['filled'].'&quot;)">Edit</div>');
// Starting Shift Table Rows
		if ($in <= 10) {
		echo (
		'<tr class="mshift" data-shift-id="'.$row['code'].'">
		<td title="'.$date_title.'">'.$row['date'].'</td>');
			if ($sort=='unfilled' || $sort=='all' || $sub=='all'){
			echo
				('<td>'.$caller.'</td>');
			}
			if ($sort=='filled' || $sub=='filled'){
			echo
				('<td><a href="/Staff/List/Profile/'.$row['euid'].'" class="pel-t" data-profile-title="'.$row['fname'].' '.$row['sname'].'\'s Profile" onclick="profile(&quot;'.$row['euid'].'&quot;)">'.$filled_by.'</a></td>');
			}
echo('
		<td>'.$time_12_hour_IN.'</td>
		<td>'.$time_12_hour_OUT.'</td>');
			if ($sort=='all'){
			echo
				('<td>'.$fill_sprite.'|'.$cancel_sprite.'</td>');
			}
echo('
		<td class="controlTd ss_controltd">
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
		<td title="'.$date_title.'">'.$row['date'].'</td>');
			if ($sort=='unfilled' || $sort=='all' || $sub=='all'){
			echo
				('<td>'.$caller.'</td>');
			}
			if ($sort=='filled' || $sub=='filled'){
			echo
				('<td><a href="/Staff/List/Profile/'.$row['euid'].'" class="pel-t" data-profile-title="'.$row['fname'].' '.$row['sname'].'\'s Profile" onclick="profile(&quot;'.$row['euid'].'&quot;)">'.$filled_by.'</a></td>');
			}
echo('
		<td>'.$time_12_hour_IN.'</td>
		<td>'.$time_12_hour_OUT.'</td>');
			if ($sort=='all'){
			echo
				('<td>'.$fill_sprite.'|'.$cancel_sprite.'</td>');
			}
echo('
		<td class="controlTd ss_controltd">
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
		<td title="'.$date_title.'">'.$row['date'].'</td>');
			if ($sort=='unfilled' || $sort=='all' || $sub=='all'){
			echo
				('<td>'.$caller.'</td>');
			}
			if ($sort=='filled' || $sub=='filled'){
			echo
				('<td><a href="/Staff/List/Profile/'.$row['euid'].'" class="pel-t" data-profile-title="'.$row['fname'].' '.$row['sname'].'\'s Profile" onclick="profile(&quot;'.$row['euid'].'&quot;)">'.$filled_by.'</a></td>');
			}
echo('
		<td>'.$time_12_hour_IN.'</td>
		<td>'.$time_12_hour_OUT.'</td>');
			if ($sort=='all'){
			echo
				('<td>'.$fill_sprite.'|'.$cancel_sprite.'</td>');
			}
echo('
		<td class="controlTd ss_controltd">
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
		echo ('<tr><td colspan="10">No <b style="text-transform:lowercase;">'.$sort_type.'</b> shifts found for '.$name.' between '.$start_expand.' and '.$end_expand.'</td></tr>');
		}

?>
    </table>
      <script>
$(document).ready(function () {
$(".controlTd").click(function () {
  var span=$(this).children(".settingsIcons");
  span.toggleClass("display"); 
  span.children(".settingsIcon").toggleClass("openIcon"); 
});	
});
</script> 