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
$start =  filter_var($_GET["s"], FILTER_SANITIZE_STRING);
$homage = filter_var($_GET["homage"], FILTER_SANITIZE_STRING);
$start2 = filter_var($_GET["s2"], FILTER_SANITIZE_STRING);
$end =  filter_var($_GET["e"], FILTER_SANITIZE_STRING);
$end2 = filter_var($_GET["e2"], FILTER_SANITIZE_STRING);
$date = filter_var($_GET["date"], FILTER_SANITIZE_STRING);
$date2 = filter_var($_GET["date2"], FILTER_SANITIZE_STRING);
if ($homage == 'true'){
	$in = filter_var($_GET["in"], FILTER_SANITIZE_STRING);
	$out = filter_var($_GET["out"], FILTER_SANITIZE_STRING);
	$dt_1 = str_replace("%20"," ",$in);
	$dt_2 = str_replace("%20"," ",$out);
	$shift = filter_var($_GET["shift_id"], FILTER_SANITIZE_STRING);
} else {
	$dt_1 = "$date $start:$start2:00";
	$dt_2 = "$date2 $end:$end2:00";
}
$employee = "SELECT * FROM employee WHERE eUID='$ID'";
$employeeres = mysqli_query($GLOBALS["___mysqli_ston"], $employee);
while($row = mysqli_fetch_assoc($employeeres)){
	$first = $row3['fname'];
	$last = $row3['sname'];
}
$mega = "SELECT * FROM employee WHERE euid NOT IN (SELECT euid FROM shifts WHERE date='$date' and ((dt_1 >= '$dt_1' and dt_1 <= '$dt_2') OR (dt_2 >= '$dt_1' and dt_2 <= '$dt_2') OR (dt_1 >= '$dt_1' and dt_1 <= '$dt_2' and dt_2 >= '$dt_2') OR (dt_2 >= '$dt_1' and dt_2 <= '$dt_2' and dt_1 <= '$dt_1') OR (dt_1 <= '$dt_1' and dt_2 >= '$dt_2')) ) ORDER BY sname";
$ressu = mysqli_query($GLOBALS["___mysqli_ston"], $mega);
if(mysqli_num_rows($ressu)>0){
	echo('<select class="widget_wa_shift">');
	while($row = mysqli_fetch_assoc($ressu)){
		echo('<option value="'.$row['euid'].'">'.$row['sname'].', '.$row['fname'].'</b>');
	}
	echo('</select>');
}
	else{
	echo('No available employees found!');
	}
?>
<script>
$(document).ready( function(){
$('.widget_wa_shift').change(function(){
	var euid = $(this).val();
	fillWA('<?php echo($shift); ?>',euid,0);
}
);});
</script>