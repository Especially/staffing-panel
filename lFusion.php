<?php
	//Start session
	session_start();
	
	//Include database connection details
	require_once('cFigure.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
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
	
	//Sanitize the POST values
	$lname = clean($_POST['lname']);
	$phone = clean ($_POST['phone']);
	$unit = clean ($_POST['unit']);
	$type = clean ($_POST['type']);
	$postal = clean ($_POST['postal']);
	$street = clean ($_POST['street']);
	$city = clean ($_POST['city']);
	$sub = clean ($_POST['sub']);
	$majint = clean ($_POST['intersection']);
	$additional = clean ($_POST['additional']);
	
	
	//Input Validations
	if($lname == '') {
		$errmsg_arr[] = 'Location name missing!';
		$errflag = true;
	}
	if($street == '') {
		$errmsg_arr[] = 'Street missing!';
		$errflag = true;
	}
	if($city == '') {
		$errmsg_arr[] = 'City Mising!';
		$errflag = true;
	}
	if($phone == '') {
		$errmsg_arr[] = 'Phone number missing!';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: lAdd.php");
		exit();
	}

	//Create INSERT query
	$qry = "INSERT INTO location(lname, phone, unit, type, postal, street, city, intersection, additional,sub) VALUES('$lname','$phone','$unit','$type','postal','$street','$city','$majint','$additional','$sub')";
	
	$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
	//Check whether the query was successful or not
	if($result) {
		header("location: cREATED.php");
		exit();
	}else {
		echo("Employee Creation Failure");
	}
?>