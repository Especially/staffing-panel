<?php 
	require_once('cFigure.php');	
	require_once('auth.php');	
	
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
$sort = filter_var($_GET["sort"], FILTER_SANITIZE_STRING);	
$sub = filter_var($_GET["sub"], FILTER_SANITIZE_STRING);	
if ($sort=='all'){
	$title ="All Shifts";
	$qcode ="";
		$table_headings = ('
		<tr class="headingTr">
		<td>Date</td>
        <td>Location</td>
        <td>Time In</td>
        <td>Time Out</td>
		<td title="Filled|Cancelled">Activity</td>		
        <td class="ss_controltd"></td>
        </tr>
		');
}
if ($sort=='filled'){
	$title ="Filled Shifts";
	$qcode ="WHERE filled='1' AND cancelled='0'";
		$table_headings = ("
		<tr class='headingTr'>
			<td>Date</td>
			<td>Location</td>
			<td>Filled By</td>
			<td>Time In</td>
			<td>Time Out</td>
			<td></td>
        </tr>
		");
}
if ($sort=='unfilled'){
	$title ="Unfilled Shifts";
	$qcode ="WHERE filled='0' AND cancelled='0'";
		$table_headings = ("
		<tr class='headingTr'>
			<td>Date</td>
			<td>Location</td>
			<td>Caller</td>
			<td>Time In</td>
			<td>Time Out</td>
			<td></td>
        </tr>
		");
}
if ($sort=='cancelled'){
	if ($sub=='all'){
		$title='All Cancelled';
		$qcode ="WHERE cancelled='1'";
		$table_headings = ("
		<tr class='headingTr'>
			<td>Date</td>
			<td>Location</td>
			<td>Date Cancelled</td>
			<td>Cancel Reason</td>
			<td>Caller</td>
			<td>Cancel Caller</td>
			<td>Time In</td>
			<td>Time Out</td>
			<td></td>
        </tr>
		");
	}
	if ($sub=='filled'){
		$title='Cancelled & Filled';
		$qcode ="WHERE cancelled='1' AND filled='1'";
		$table_headings = ("
		<tr class='headingTr'>
			<td>Date</td>
			<td>Location</td>
			<td>Date Cancelled</td>
			<td>Cancel Reason</td>
			<td>Filled By</td>
			<td>Cancel Caller</td>
			<td>Time In</td>
			<td>Time Out</td>
			<td></td>
        </tr>
		");
	}
	if ($sub=='unfilled'){
		$title='Cancelled & Unfilled';
		$qcode ="WHERE cancelled='1' AND filled='0'";
		$table_headings = ("
		<tr class='headingTr'>
			<td>Date</td>
			<td>Location</td>
			<td>Date Cancelled</td>
			<td>Cancel Reason</td>
			<td>Caller</td>
			<td>Cancel Caller</td>
			<td>Time In</td>
			<td>Time Out</td>
			<td></td>
        </tr>
		");
	}
}
?>
<script src="http://staffingpanel.x10.mx/js/Histex.js"></script>
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
</style>
    <h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);"><center><?php echo($title); ?></center></h2>
    <table class="flatTable">
	<?php echo($table_headings); ?>
      <?php
$qry = "SELECT * FROM shifts $qcode ORDER BY date DESC, IN1 DESC, location ASC LIMIT 100";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
if(mysqli_num_rows($result)>0){
while($row = mysqli_fetch_assoc($result)){
    $in = $row['IN1'];
	$locode = $row['location'];
	$date = date("D M jS, Y", strtotime($row['date']));
	$cdate  = date("D M jS, Y", strtotime($row['cancel_timestamp']));
		$hour = $row['IN1'];
		$minute = $row['IN2'];
		$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
		$hour2 = $row['OUT1'];
		$minute2 = $row['OUT2'];
		$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
		$caller = $row['caller'];
		$filled = $row['filled'];
		$cancelled = $row['cancelled'];
		if ($sort == 'unfilled'){
			$UFrow = ('<div class="settingsIcon" onclick="fillRow(&quot;'.$row['code'].'&quot;,&quot;fill&quot;)">Fill</div>');
		}
		if ($sort !== 'unfilled'){
			$UFrow = ('<div class="settingsIcon" onclick="unfillRow(&quot;'.$row['code'].'&quot;,&quot;unfill&quot;)">Unfill</div>');
		}
		$cancelRow = ('<div class="settingsIcon" onclick="cancelRow(&quot;'.$row['code'].'&quot;,&quot;cancel&quot;)">Cancel</div>');
		$deleteDiv = ('<span class="settingsIcon" onclick="deleteRow(&quot;'.$row['code'].'&quot;)">Delete</span>');
			$editRow = ('<div class="settingsIcon" onclick="editRow(&quot;'.$row['code'].'&quot;,&quot;edit&quot;,&quot;'.$row['filled'].'&quot;)">Edit</div>');
		if ($sort == 'cancelled') {
			$cancelRow = ('<span class="settingsIcon" onclick="deleteRow(&quot;'.$row['code'].'&quot;)">Delete</span>');
			$editRow = ('');
			$UFrow = ('');
		}
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
	if ($in <= 10) {
	echo (
	'<tr class="mshift" data-shift-id="'.$row['code'].'">
	<td title="'.$date.'">'.$row['date'].'</td>
	<td><a href="/Locations/List/Calendar/'.$row['location'].'" class="pll-t" onclick="viewCal(&quot;'.$row['location'].'&quot;)">'.$row['name'].'</a></td>');
			if ($sort =='cancelled'){
				echo
				('<td title='.$cdate.'>'.$row['cancel_timestamp'].'</td>
				<td>'.$row['cancel_reason'].'</td>
				');
			}
			if (($sort =='cancelled') && ($sub=='filled')){
				echo
				('<td>'.$row['ename'].'</td>');
			}
			if (($sort=='unfilled') || ($sub=='all') || ($sub=='unfilled')){
			echo
				('<td>'.$caller.'</td>');
			}
			if (($sort =='cancelled') && ($sub=='all') || ($sub == 'filled') || ($sub=='unfilled')){
				echo
				('<td>'.$row['cancel_caller'].'</td>
				');
			}
			if ($sort=='filled'){
			echo
				('<td><a href="/Staff/List/Profile/'.$row['euid'].'" class="pel-t" data-profile-title="'.$row['ename'].'\'s Profile" onclick="profile(&quot;'.$row['euid'].'&quot;)">'.$row['ename'].'</a></td>');
			}
echo('
	<td>'.$time_12_hour_IN.'</td>
	<td>'.$time_12_hour_OUT.'</td>');
			if ($sort=='all'){
			echo
				('<td>'.$fill_sprite.'|'.$cancel_sprite.'</td>');
			}
echo('	<td class="controlTd">
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
	<td><a href="/Locations/List/Calendar/'.$row['location'].'" class="pll-t" onclick="viewCal(&quot;'.$row['location'].'&quot;)">'.$row['name'].'</a></td>');
			if ($sort =='cancelled'){
				echo
				('<td title='.$cdate.'>'.$row['cancel_timestamp'].'</td>
				<td>'.$row['cancel_reason'].'</td>
				');
			}
			if (($sort =='cancelled') && ($sub=='filled')){
				echo
				('<td>'.$row['ename'].'</td>');
			}
			if (($sort=='unfilled') || ($sub=='all') || ($sub=='unfilled')){
			echo
				('<td>'.$caller.'</td>');
			}
			if (($sort =='cancelled') && ($sub=='all') || ($sub == 'filled') || ($sub=='unfilled')){
				echo
				('<td>'.$row['cancel_caller'].'</td>
				');
			}
			if ($sort=='filled'){
			echo
				('<td><a href="/Staff/List/Profile/'.$row['euid'].'" class="pel-t" data-profile-title="'.$row['ename'].'\'s Profile" onclick="profile(&quot;'.$row['euid'].'&quot;)">'.$row['ename'].'</a></td>');
			}
echo('
	<td>'.$time_12_hour_IN.'</td>
	<td>'.$time_12_hour_OUT.'</td>');
			if ($sort=='all'){
			echo
				('<td>'.$fill_sprite.'|'.$cancel_sprite.'</td>');
			}
echo('	
	<td class="controlTd">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			'.$cancelRow.'
			'.$editRow.'
			'.$UFrow.'		</div> 
	</td>
	</tr>'
	);
	}
	if ($in >= 17 && $in <= 23) {
	echo (
	'<tr class="nshift" data-shift-id="'.$row['code'].'">
	<td title="'.$date.'">'.$row['date'].'</td>
	<td><a href="/Locations/List/Calendar/'.$row['location'].'" class="pll-t" onclick="viewCal(&quot;'.$row['location'].'&quot;)">'.$row['name'].'</a></td>');
			if ($sort =='cancelled'){
				echo
				('<td title='.$cdate.'>'.$row['cancel_timestamp'].'</td>
				<td>'.$row['cancel_reason'].'</td>
				');
			}
			if (($sort =='cancelled') && ($sub=='filled')){
				echo
				('<td>'.$row['ename'].'</td>');
			}
			if (($sort=='unfilled') || ($sub=='all') || ($sub=='unfilled')){
			echo
				('<td>'.$caller.'</td>');
			}
			if (($sort =='cancelled') && ($sub=='all') || ($sub == 'filled') || ($sub=='unfilled')){
				echo
				('<td>'.$row['cancel_caller'].'</td>
				');
			}
			if ($sort=='filled'){
			echo
				('<td><a href="/Staff/List/Profile/'.$row['euid'].'" class="pel-t" data-profile-title="'.$row['ename'].'\'s Profile" onclick="profile(&quot;'.$row['euid'].'&quot;)">'.$row['ename'].'</a></td>');
			}
echo('
	<td>'.$time_12_hour_IN.'</td>
	<td>'.$time_12_hour_OUT.'</td>');
			if ($sort=='all'){
			echo
				('<td>'.$fill_sprite.'|'.$cancel_sprite.'</td>');
			}
echo('	
	<td class="controlTd">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			'.$cancelRow.'
			'.$editRow.'
			'.$UFrow.'		</div> 
	</td>
	</tr>'
	);
	}
}
}
else {
	echo('<tr><td colspan="10">No <b style="text-transform:lowercase;">'.$title.'</b> shifts found.</td></tr>');	
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