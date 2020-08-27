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
$action    = filter_var($_GET["action"], FILTER_SANITIZE_STRING);
$shift_id  = filter_var($_GET["shift_id"], FILTER_SANITIZE_STRING);
$location  = filter_var($_GET["location"], FILTER_SANITIZE_STRING);
if ($action == 'recommend'){
	echo "<h2 class=\"recom-title\">Recommended Staff</h2>";
	$rec_staff_query = "SELECT DISTINCT euid, (SELECT COUNT(*) FROM shifts as b WHERE b.euid=a.euid AND b.location='$location') as total FROM shifts as a WHERE location='$location' AND filled='1' AND cancelled='0' ORDER BY total DESC LIMIT 10";
	$rec_staff_resul = mysqli_query($GLOBALS["___mysqli_ston"], $rec_staff_query);
	if(mysqli_num_rows($rec_staff_resul)>0){ 
		echo "<ul class='recom_staff'>";
		while($row = mysqli_fetch_assoc($rec_staff_resul)){
			$total = $row['total'];
			$euid  = $row['euid'];
			$emp_qry = "SELECT fname,sname FROM employee WHERE euid='$euid'";
			$emp_result = mysqli_query($GLOBALS["___mysqli_ston"], $emp_qry);
			while($emp_row = mysqli_fetch_assoc($emp_result)){
				$first = $emp_row['fname'];
				$last = $emp_row['sname'];
			}
			echo "<a target='_blank' onclick='profile(\"".$euid."\")'><li data-total='".$total."' title='Worked here ".$total." times'>$first $last</li></a>";
		}
		echo "</ul>";
	} else {
		echo "<p class=\"recom-text\">We're sorry, there are no recommended staff at this time.</p>";
	}
}
if ($action == 'exclamation'){
	echo "<h2 class=\"recom-title\">Comments</h2>";
	$shift_query = "SELECT additional FROM shifts WHERE code='$shift_id'";
	$shift_resul = mysqli_query($GLOBALS["___mysqli_ston"], $shift_query);
	while($row = mysqli_fetch_assoc($shift_resul)){
		$comments = $row['additional'];
		echo "<p class=\"recom-text\">$comments</p>";
	}
	echo "<break></break>";
	echo "<h2 class=\"recom-title\">Recommended Staff</h2>";
	$rec_staff_query = "SELECT DISTINCT euid, (SELECT COUNT(*) FROM shifts as b WHERE b.euid=a.euid AND b.location='$location') as total FROM shifts as a WHERE location='$location' AND filled='1' AND cancelled='0' ORDER BY total DESC LIMIT 10";
	$rec_staff_resul = mysqli_query($GLOBALS["___mysqli_ston"], $rec_staff_query);
	if(mysqli_num_rows($rec_staff_resul)>0){ 
		echo "<ul class='recom_staff'>";
		while($row = mysqli_fetch_assoc($rec_staff_resul)){
			$total = $row['total'];
			$euid  = $row['euid'];
			$emp_qry = "SELECT fname,sname FROM employee WHERE euid='$euid'";
			$emp_result = mysqli_query($GLOBALS["___mysqli_ston"], $emp_qry);
			while($emp_row = mysqli_fetch_assoc($emp_result)){
				$first = $emp_row['fname'];
				$last = $emp_row['sname'];
			}
			echo "<a target='_blank' onclick='profile(\"".$euid."\")'><li data-total='".$total."' title='Worked here ".$total." times'>$first $last</li></a>";
		}
		echo "</ul>";
	} else {
		echo "<p class=\"recom-text\">We're sorry, there are no recommended staff at this time.</p>";
	}
}
?>