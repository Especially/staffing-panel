<?php
if($_POST)
{
    session_start();	
	//Include database connection details
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
	//check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    
        //exit script outputting json data
        $output = json_encode(
        array(
            'type'=>'error', 
            'text' => 'Request must come from Ajax'
        ));
        
        die($output);
    } 
    if(!isset($_POST["action"])){
		//check $_POST vars are set, exit if any missing
		if(!isset($_POST["OUT1"]) || !isset($_POST["IN1"]) || !isset($_POST["IN2"]) || !isset($_POST["OUT2"]) || !isset($_POST["caller"]) || !isset($_POST["date"]) || !isset($_POST["date2"]))
		{
			$output = json_encode(array('type'=>'error', 'text' => "Input fields are empty!1"));
			die($output);
		}
	
	
		//Sanitize input data using PHP filter_var().
		$location       = filter_var($_POST["location"], FILTER_SANITIZE_STRING);
		$caller         = filter_var($_POST["caller"], FILTER_SANITIZE_STRING);
		if (!$caller){
			$caller = "Unknown";
		}
		$gender    	    = filter_var($_POST["gender"], FILTER_SANITIZE_STRING);
		$login          = $_SESSION['SESS_CONTROL_LOGIN'];
		$euid           = filter_var($_POST["euid"], FILTER_SANITIZE_STRING);
		$ename     	    = filter_var($_POST["ename"], FILTER_SANITIZE_STRING);
		$fill_login     = $_SESSION['SESS_CONTROL_LOGIN'];
		$fill_date		= date('Y-m-d G:i:s');
		$date     		= filter_var($_POST["date"], FILTER_SANITIZE_STRING);
		$date2     		= filter_var($_POST["date2"], FILTER_SANITIZE_STRING);
		$additional  	= filter_var($_POST["additional"], FILTER_SANITIZE_STRING);
		$IN1            = filter_var($_POST["IN1"], FILTER_SANITIZE_NUMBER_INT);
		$IN2   			= filter_var($_POST["IN2"], FILTER_SANITIZE_NUMBER_INT);
		$OUT1           = filter_var($_POST["OUT1"], FILTER_SANITIZE_NUMBER_INT);
		$OUT2           = filter_var($_POST["OUT2"], FILTER_SANITIZE_NUMBER_INT);
		$hour = $IN1;
		$minute = $IN2;
		$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
		$hour2 = $OUT1;
		$minute2 = $OUT2;
		$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
		$dt_1 = "$date $IN1:$IN2:00";
		$dt_2 = "$date2 $OUT1:$OUT2:00";
		$hours = ((strtotime($dt_2) - strtotime($dt_1))/(60*60));
		if($hours < 1){
			$output = json_encode(array('type'=>'error', 'text' => "Employees don't have the ability to work negative hours, unfortunately. Fix the time."));
			die($output);
		}
			$locnew = "SELECT * FROM location WHERE code='$location'";
			$ress = mysqli_query($GLOBALS["___mysqli_ston"], $locnew);
			
			if(!$ress) {
				echo('Error');
			} else {
				while($row1 = mysqli_fetch_assoc($ress)){
					$type = $row1['is_type'];
					$n = $row1['name'];
					$t = $row1['type'];
					$tn = $row1['type_number'];
					
					if($type=='false'){
						$_SESSION['SESS_TYPE'] = ($n);
						$name = $_SESSION['SESS_TYPE'];
					}
	
					elseif($type=='true'){
						$_SESSION['SESS_TYPE'] = ($n.' ('.$t.' #'.$tn.')');
						$name = $_SESSION['SESS_TYPE'];
					}
	
				}
	
			}
	
		
		//additional php validation
			if((strlen($comments)>1)  & (strlen($comments)<5)) //check emtpy message
			{
				$output = json_encode(array('type'=>'error', 'text' => 'Comment is too short, ensure proper formatting!'));
				die($output);
			}
		function generateRandomString($length = 15) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
		}
		$code = generateRandomString(7);
		//proceed with PHP mysqli Query.
		
		$qry = "INSERT INTO shifts(code, hours, location, name, caller, euid, gender, ename, login, fill_login, date, dt_1, dt_2, additional, IN1, IN2, OUT1, OUT2) VALUES('$code','$hours','$location','$name','$caller','$euid','$gender','$ename','$login','$fill_login','$date','$dt_1','$dt_2','$additional','$IN1','$IN2','$OUT1','$OUT2')";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if(!$result)
		{
			$output = json_encode(array('type'=>'error', 'text' => "Could not add shift! Please contact an IT Specialist."));
			die($output);
		}else{
			$output = json_encode(array('type'=>'message', 'text' => 'The shift at '.$name.' for '.$time_12_hour_IN.' to '.$time_12_hour_OUT.' has been created.' ));
			die($output);
		}
	}
	if (($_POST["action"])=="new_fill"){
		//check $_POST vars are set, exit if any missing
		if(!isset($_POST["OUT1"]) || !isset($_POST["IN1"]) || !isset($_POST["IN2"]) || !isset($_POST["OUT2"]) || !isset($_POST["caller"]) || !isset($_POST["date"]) || !isset($_POST["date2"]))
		{
			$output = json_encode(array('type'=>'error', 'text' => "Input fields are empty!1"));
			die($output);
		}
	
	
		//Sanitize input data using PHP filter_var().
		$location       = filter_var($_POST["location"], FILTER_SANITIZE_STRING);
		$caller         = filter_var($_POST["caller"], FILTER_SANITIZE_STRING);
		if (!$caller){
			$caller = "Unknown";
		}
		$gender    	    = filter_var($_POST["gender"], FILTER_SANITIZE_STRING);
		$login          = $_SESSION['SESS_CONTROL_LOGIN'];
		$euid           = filter_var($_POST["euid"], FILTER_SANITIZE_STRING);
		$ename     	    = filter_var($_POST["ename"], FILTER_SANITIZE_STRING);
		$fill_login     = $_SESSION['SESS_CONTROL_LOGIN'];
		$fill_date		= date('Y-m-d G:i:s');
		$date     		= filter_var($_POST["date"], FILTER_SANITIZE_STRING);
		$date2     		= filter_var($_POST["date2"], FILTER_SANITIZE_STRING);
		$additional  	= filter_var($_POST["additional"], FILTER_SANITIZE_STRING);
		$IN1            = filter_var($_POST["IN1"], FILTER_SANITIZE_NUMBER_INT);
		$IN2   			= filter_var($_POST["IN2"], FILTER_SANITIZE_NUMBER_INT);
		$OUT1           = filter_var($_POST["OUT1"], FILTER_SANITIZE_NUMBER_INT);
		$OUT2           = filter_var($_POST["OUT2"], FILTER_SANITIZE_NUMBER_INT);
		$hour = $IN1;
		$minute = $IN2;
		$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
		$hour2 = $OUT1;
		$minute2 = $OUT2;
		$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
		$dt_1 = "$date $IN1:$IN2:00";
		$dt_2 = "$date2 $OUT1:$OUT2:00";
		$hours = ((strtotime($dt_2) - strtotime($dt_1))/(60*60));
		if($hours < 1){
			$output = json_encode(array('type'=>'error', 'text' => "Employees don't have the ability to work negative hours, unfortunately. Fix the time."));
			die($output);
		}
		$employee = "SELECT * FROM employee WHERE euid='$euid'";
		$e_ress = mysqli_query($GLOBALS["___mysqli_ston"], $employee);
		
		if(!$e_ress) {
		$output = json_encode(array('type'=>'error', 'text' => "Error!"));
			die($output);
		} else {
			while($row1_e = mysqli_fetch_assoc($e_ress)){
				$f = $row1_e['fname'];
				$s = $row1_e['sname'];
				$_SESSION['SESS_E_NAME'] = ($s.', '.$f);
				$e_name = $_SESSION['SESS_E_NAME'];
			}

		}
			$locnew = "SELECT * FROM location WHERE code='$location'";
			$ress = mysqli_query($GLOBALS["___mysqli_ston"], $locnew);
			
			if(!$ress) {
				echo('Error');
			} else {
				while($row1 = mysqli_fetch_assoc($ress)){
					$type = $row1['is_type'];
					$n = $row1['name'];
					$t = $row1['type'];
					$tn = $row1['type_number'];
					
					if($type=='false'){
						$_SESSION['SESS_TYPE'] = ($n);
						$loc_name = $_SESSION['SESS_TYPE'];
					}
	
					elseif($type=='true'){
						$_SESSION['SESS_TYPE'] = ($n.' ('.$t.' #'.$tn.')');
						$loc_name = $_SESSION['SESS_TYPE'];
					}
	
				}
	
			}
	
		
		//additional php validation
			if((strlen($comments)>1)  & (strlen($comments)<5)) //check emtpy message
			{
				$output = json_encode(array('type'=>'error', 'text' => 'Comment is too short, ensure proper formatting!'));
				die($output);
			}
		function generateRandomString($length = 15) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
		}
		$code = generateRandomString(7);
		//proceed with PHP mysqli Query.
		
		$qry = "INSERT INTO shifts(code, hours, location, name, caller, euid, gender, ename, login, fill_login, fill_timestamp, filled, date, dt_1, dt_2, additional, IN1, IN2, OUT1, OUT2) VALUES('$code','$hours','$location','$loc_name','$caller','$euid','$gender','$e_name','$login','$fill_login','$date','1','$date','$dt_1','$dt_2','$additional','$IN1','$IN2','$OUT1','$OUT2')";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if(!$result)
		{
			$output = json_encode(array('type'=>'error', 'text' => "Could not add shift! Please contact an IT Specialist."));
			die($output);
		}else{
			$output = json_encode(array('type'=>'message', 'text' => 'The shift at '.$name.' for '.$time_12_hour_IN.' to '.$time_12_hour_OUT.' has been filled by '.$e_name.'.' ));
			die($output);
		}
	}
} else {
	header("location: /login");
}
?>