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
	$login = clean($_POST['login']);
	$password = clean($_POST['password']);
	$return_to = ($_POST['return_to']);
	if ($return_to == ''){
		$return_to = '/main';
	}
	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: /login");
		exit();
	}
	
	//Create query
	$qry="
	SELECT * FROM control WHERE login='$login' AND passwd='".md5($_POST['password'])."';";
	$result=mysqli_query($GLOBALS["___mysqli_ston"], $qry);
	
	//Check whether the query was successful or not
	if($result) {
		if(mysqli_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$control = mysqli_fetch_assoc($result);
			$_SESSION['SESS_CONTROL_ID'] = $control['uID'];
			$go ="UPDATE `control` SET last_login=now() WHERE uid =  '".$_SESSION['SESS_CONTROL_ID']."'";
			$status ="UPDATE `control` SET status= '1' WHERE uid =  '".$_SESSION['SESS_CONTROL_ID']."'";
			$goresult = mysqli_query($GLOBALS["___mysqli_ston"], $go);
			$gostatus = mysqli_query($GLOBALS["___mysqli_ston"], $status);
			$_SESSION['SESS_CONTROL_FIRST'] = $control['first_name'];
			$_SESSION['SESS_CONTROL_SURNAME'] = $control['surname'];
			$_SESSION['SESS_CONTROL_LOGIN'] = $control['login'];
			$_SESSION['SESS_CONTROL_TYPE'] = $control['type'];
			$_SESSION['SESS_CONTROL_VERIFY'] = $control['verify'];
			$_SESSION['SESS_CONTROL_STATUS'] = $control['status'];
			$_SESSION['SESS_CONTROL_VCODE'] = $control['vcode'];
			$_SESSION['SESS_CONTROL_CDATE'] = $control['cDate'];
			$_SESSION['SESS_CONTROL_EMAIL'] = $control['email'];
			session_write_close();
			header('location: '.$return_to.'');
			exit();
		}else {
			//Login failed
			$errmsg_arr[] = 'Incorrect username or password click <a href="#" class="forgot">here</a> if you forgot your username or password';
			$errflag = true;
				//If there are input validations, redirect back to the login form
				if($errflag) {
					$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
					session_write_close();
					header("location: /login");
					exit();
				}
		}
	}else {
		die("Error:".((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	}
?>