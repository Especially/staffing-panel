<?php
	if($_POST){
		//Include database connection details
		require_once('cFigure.php');
		require_once('auth.php');
		//Connect to mysql server
		$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST,  DB_USER,  DB_PASSWORD));
		
		if(!$link) {
			die('Failed to connect to server: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) :
			(($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res :
			false)));
		}

		//Select database
		$db = ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . constant('DB_DATABASE')));
		
		if(!$db) {
			die("Unable to select database");
		}


		$action = filter_var($_POST["action"], FILTER_SANITIZE_STRING);
		$filled = filter_var($_POST["fill"], FILTER_SANITIZE_STRING);
		
		if(!isset ($_POST['action'])) {
			$output = json_encode(array('type'=>'error', 'text' => "Action not set!"));
			die($output);
		}

		
		if ($action=='primary'){
			//check $_POST vars are set, exit if any missing
			
			if(!isset($_POST["first"]) || !isset($_POST["last"]) || !isset($_POST["login"]))    {
				$output = json_encode(array('type'=>'error', 'text' => "Input fields are empty!1"));
				die($output);
			}

			//Sanitize input data using PHP filter_var().
			$first       = filter_var($_POST["first"], FILTER_SANITIZE_STRING);
			$last         = filter_var($_POST["last"], FILTER_SANITIZE_STRING);
			$login           = filter_var($_POST["login"], FILTER_SANITIZE_STRING);
			$email           = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
			$uid = $_SESSION['SESS_CONTROL_ID'];
			
	//Check for duplicate uID
	if(($login != '') && ($login != ''.$_SESSION['SESS_CONTROL_LOGIN'].'')) { //Have to make sure it doesnt check against old login
		$qry = "SELECT * FROM control WHERE login='$login'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$output = json_encode(array('type'=>'error', 'text' => "An account with this login name already exists, please try a different one"));
				die($output);
			}
			@((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
		}else {
				$output = json_encode(array('type'=>'error', 'text' => "Error 7021"));
				die($output);
		}
	}

			//additional php validation
			
			if((strlen($login)>=1)  & (strlen($login)<=3)) //check emtpy message
				{
				$output = json_encode(array('type'=>'error', 'text' => 'Your login name is too short! Try a different one'));
				die($output);
			}

			//proceed with PHP mysqli Query.
			$qry = "UPDATE control SET first_name='$first', surname='$last', email='$email', login='$login' WHERE uid='$uid'";
			//Check whether the query was successful or not
			$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
			
			if(!$result)    {
				$output = json_encode(array('type'=>'error', 'text' => "$first I couldn't update your info! Please contact an IT Specialist."));
				die($output);
			} else {
				session_start();
				$_SESSION['SESS_CONTROL_FIRST'] = $first;
				$_SESSION['SESS_CONTROL_SURNAME'] = $last;
				$_SESSION['SESS_CONTROL_LOGIN'] = $login;
				$_SESSION['SESS_CONTROL_EMAIL'] = $email;
				session_write_close();
				$output = json_encode(array('type'=>'message', 'text' => ''.$first.' your information has been updated successfully.' ));
				die($output);
			}

		}
		if ($action=='secondary'){
			//check $_POST vars are set, exit if any missing
			
			if(!isset($_POST["old"]) || !isset($_POST["new"]) || !isset($_POST["renew"]))    {
				$output = json_encode(array('type'=>'error', 'text' => "Input fields are empty!2"));
				die($output);
			}

			//Sanitize input data using PHP filter_var().
			$old       = md5(filter_var($_POST["old"], FILTER_SANITIZE_STRING));
			$new         = filter_var($_POST["new"], FILTER_SANITIZE_STRING);
			$verify           = filter_var($_POST["renew"], FILTER_SANITIZE_STRING);
			$uid = $_SESSION['SESS_CONTROL_ID']; 
			


			//additional php validation
		$qry = "SELECT * FROM control WHERE uid='$uid' and passwd='$old'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				//
			}else {
				$output = json_encode(array('type'=>'error', 'text' => 'Your old password does not match'));
				die($output);
			}
		}
			if((strlen($new)>=1)  & (strlen($new)<=5)) //check short password
				{
				$output = json_encode(array('type'=>'error', 'text' => 'Password is too short, ensure that it\'s greater than 5 characters!'));
				die($output);
			}
			if( strcmp($new, $verify) != 0 ) {
				$output = json_encode(array('type'=>'error', 'text' => 'Passwords don\'t match!'));
				die($output);
			}
			//proceed with PHP mysqli Query.
			$qry = "UPDATE control SET passwd='".md5($new)."' WHERE uid='$uid'";
			//Check whether the query was successful or not
			$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
			
			if(!$result)    {
				$output = json_encode(array('type'=>'error', 'text' => "$first I couldn't update your password! Please contact an IT Specialist."));
				die($output);
			} else {
				$output = json_encode(array('type'=>'message', 'text' => ''.$_SESSION['SESS_CONTROL_FIRST'].' your password has been updated.' ));
				die($output);
			}

}
	}
?>