<?php
	$type = $_SESSION['SESS_CONTROL_TYPE'];
if($_POST)
{
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
	$action = filter_var($_POST["action"], FILTER_SANITIZE_STRING);
if ($action == 'edit'){
		if ($type !== '3'){
			$output = json_encode(array('type'=>'error', 'text' => "Insufficient tier level!"));
		}
		
		//check $_POST vars are set, exit if any missing
		if(!isset($_POST["notif_content"]) || !isset($_POST["notif_poster"]) || !isset($_POST["notif_recipient"]) || !isset($_POST["notif_priority"]) || !isset($_POST["notif_type"]) || !isset($_POST["notif_id"]))
		{
			$output = json_encode(array('type'=>'error', 'text' => "Notification content empty!"));
			die($output);
		}
	
		//Sanitize input data using PHP filter_var().
		$id			= filter_var($_POST["notif_id"], FILTER_SANITIZE_STRING);
		$date		= filter_var($_POST["notif_date"], FILTER_SANITIZE_STRING);
		$poster		= filter_var($_POST["notif_poster"], FILTER_SANITIZE_STRING);
		$recipient	= filter_var($_POST["notif_recipient"], FILTER_SANITIZE_STRING);
		$type		= filter_var($_POST["notif_type"], FILTER_SANITIZE_STRING);
		$priority	= filter_var($_POST["notif_priority"], FILTER_SANITIZE_STRING);;
		$notif		= addslashes($_POST["notif_content"]);
	
	

		//proceed with PHP mysqli Query.
		
		$qry = "UPDATE notifications SET notif_date='$date', notif_poster='$poster', notif_recipient='$recipient', notif_type='$type', notif_priority='$priority', notif_message='$notif' WHERE notif_id='$id'";
		$qry2 = "UPDATE notifications_read SET notif_priority='$priority' WHERE notif_id='$id'";
		$result2 = @mysqli_query($GLOBALS["___mysqli_ston"], $qry2);
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if(!$result)
		{
			$output = json_encode(array('type'=>'error', 'text' => "Could not update notification! Fix it!"));
			die($output);
		}else{
			$output = json_encode(array('type'=>'message', 'text' => ''.$qry.' Has been updated.'));
			die($output);
		}
	}
if ($action == 'delete'){
		if ($type !== '3'){
			$output = json_encode(array('type'=>'error', 'text' => "Insufficient tier level!"));
		}
		
		//check $_POST vars are set, exit if any missing
		if(!isset($_POST["notif_id"]))
		{
			$output = json_encode(array('type'=>'error', 'text' => "Notification delete ID is empty!"));
			die($output);
		}
	
		//Sanitize input data using PHP filter_var().
		$id	= filter_var($_POST["notif_id"], FILTER_SANITIZE_STRING);
	
	
		//proceed with PHP mysqli Query.
		
		$qry = "DELETE notifications, notifications_read FROM notifications LEFT JOIN notifications_read ON notifications_read.notif_id = notifications.notif_id WHERE notifications.notif_id = '$id'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if(!$result)
		{
			$output = json_encode(array('type'=>'error', 'text' => "Could not delete notification"));
			die($output);
		}else{
			$output = json_encode(array('type'=>'message', 'text' => 'Deleted!'));
			die($output);
		}
	}
	if ($action == 'new'){
		if ($type !== '3'){
			$output = json_encode(array('type'=>'error', 'text' => "Insufficient tier level!"));
		}
		
		//check $_POST vars are set, exit if any missing
		if(!isset($_POST["message"]))
		{
			$output = json_encode(array('type'=>'error', 'text' => "Notification description empty!"));
			die($output);
		}
	
		//Sanitize input data using PHP filter_var().
		$date		= date('Y-m-d G:i:s');
		$from		= filter_var($_POST["from"], FILTER_SANITIZE_STRING);
		$recipient	= filter_var($_POST["recipient"], FILTER_SANITIZE_STRING);
		$type		= filter_var($_POST["type"], FILTER_SANITIZE_STRING);
		$priority	= filter_var($_POST["priority"], FILTER_SANITIZE_STRING);;
		$info		= addslashes($_POST["message"]);
	
	
		function generateRandomString($length = 6) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$vCode = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
		}
		$code = generateRandomString(6);
		//proceed with PHP mysqli Query.
		
		$qry = "INSERT INTO notifications(notif_id, notif_recipient, notif_poster, notif_message, notif_date, notif_priority, notif_type) 
		VALUES('$code','$recipient','$from','$info','$date','$priority','$type')";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if(!$result)
		{
			$output = json_encode(array('type'=>'error', 'text' => "Could not add update! Fix it!"));
			die($output);
		}else{
			$output = json_encode(array('type'=>'message', 'text' => 'Hi '.$login .', the following update has been added:<br/> <b>'.$info.'</b>.'));
			die($output);
		}
	}
} else {
	header("location: /login");
}
?>