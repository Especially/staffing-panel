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
$action = filter_var($_POST["action"], FILTER_SANITIZE_STRING);
if($action == 'shift_data'){
    $code = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
	$qry = "SELECT * FROM shifts WHERE code = '$code'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if ($result){
			if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $data = [];
                    $data['dt_1'] = $row['dt_1'];
                    $data['dt_2'] = $row['dt_2'];
                    $data['date'] = $row['date'];
                    $data['filled_by'] = $row['ename'];
                    $data['date_title'] = date("D M jS, Y", strtotime($row['date']));
                    $data['timestamp']= date("Y-m-d g:i A", strtotime($row['timestamp']));
                    $data['timestamp_title'] = date("D M jS, Y", strtotime($row['timestamp']));
                    $in = $row['IN1'];
                    $hour = $row['IN1'];
                    $minute = $row['IN2'];
                    $data['time_12_hour_IN']  = date("g:i A", strtotime("$hour:$minute"));
                    $hour2 = $row['OUT1'];
                    $minute2 = $row['OUT2'];
                    $data['time_12_hour_OUT']  = date("g:i A", strtotime("$hour2:$minute2"));
                    $data['caller'] = $row['caller'];
                    $data['hours'] = $row['hours'];
                    if ($data['caller'] == ' '){
                        $data['caller'] = 'Unknown';
                    }
                    if ($in <= 10) {
                        $data['type'] = 'mshift';
                    }
                    if ($in >= 11 && $in <= 16) {
                        $data['type'] = 'ashift';
                    }
                    if ($in >= 17 && $in <= 23) {
                        $data['type'] = 'nshift';
                    }
                    echo json_encode($data);
                }
            }
        }
}
?>