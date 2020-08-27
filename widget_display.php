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
$action = filter_var($_GET["action"], FILTER_SANITIZE_STRING);
$id = filter_var($_GET["id"], FILTER_SANITIZE_STRING);
$d1 = filter_var($_GET["d1"], FILTER_SANITIZE_STRING);
$d2 = filter_var($_GET["d2"], FILTER_SANITIZE_STRING);
$name = filter_var($_GET["name"], FILTER_SANITIZE_STRING);
$name = str_replace("_"," ",$name);
$date = date("D M jS, Y", strtotime($d1));
$date2 = date("D M jS, Y", strtotime($d2));
if($action == 'get_hours'){
	$hq = "SELECT SUM(hours) AS value_sum FROM shifts WHERE euid='$id' AND filled='1' AND cancelled='0' AND date >= '$d1' and date <= '$d2' ";
	$hres = mysqli_query($GLOBALS["___mysqli_ston"], $hq);
	while($hrow = mysqli_fetch_assoc($hres)){
	$hours = $hrow['value_sum'];
	if ($hours > 0){
	echo("$name has $hours hours completed between $date and $date2");
	}
	else {
		echo("$name has 0 hours completed between $date and $date2");
	}
	}
}
if($action == 'get_notifications'){	
	$hq = "SELECT COUNT(*) AS notif_count FROM notifications WHERE ((notif_recipient = 'all') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_TYPE']."') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_ID']."')) AND (notif_id NOT IN (SELECT notif_id FROM notifications_read WHERE notif_recipient_uid = '".$_SESSION['SESS_CONTROL_ID']."')) ORDER BY notif_priority DESC,notif_date DESC LIMIT 3 ";
	$hres = mysqli_query($GLOBALS["___mysqli_ston"], $hq);
	while($hrow = mysqli_fetch_assoc($hres)){
	$count = $hrow['notif_count'];
	if ($count > 0){
	echo("<script>$('.qt_arrow_cover').addClass('qt_arrow_flash blink_me');</script>");
	echo("<div class=\"qt_notif_count\">$count</div>");
	}
	else {
		echo("<script>$('.qt_arrow_cover').removeClass('qt_arrow_flash blink_me');</script>");
		echo(" ");
	}
	}
}
if($action == 'get_notifications_open'){	
	$hq = "SELECT COUNT(*) AS notif_count FROM notifications WHERE ((notif_recipient = 'all') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_TYPE']."') OR (notif_recipient = '".$_SESSION['SESS_CONTROL_ID']."')) AND (notif_id NOT IN (SELECT notif_id FROM notifications_read WHERE notif_recipient_uid = '".$_SESSION['SESS_CONTROL_ID']."')) ORDER BY notif_priority DESC,notif_date DESC LIMIT 3 ";
	$hres = mysqli_query($GLOBALS["___mysqli_ston"], $hq);
	while($hrow = mysqli_fetch_assoc($hres)){
	$count = $hrow['notif_count'];
	if ($count > 0){
	echo("<div class=\"qt_notif_count\" style=\"display:block;\">$count</div>");
	}
	else {
		echo(" ");
	}
	}
}
?>