<?php
	if($_POST){
		session_start();
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


		$action = filter_var($_GET["action"], FILTER_SANITIZE_STRING);
		$filled = filter_var($_GET["fill"], FILTER_SANITIZE_STRING);
		
		if(!isset ($_GET['action'])) {
			$output = json_encode(array('type'=>'error', 'text' => "Action not set!"));
			die($output);
		}

		
		if ($action=='edit'){
			//check $_POST vars are set, exit if any missing
			
			if(!isset($_POST["code"]) || !isset($_POST["OUT1"]) || !isset($_POST["IN1"]) || !isset($_POST["IN2"]) || !isset($_POST["OUT2"]) || !isset($_POST["caller"]) || !isset($_POST["date"]) || !isset($_POST["date2"]))    {
				$output = json_encode(array('type'=>'error', 'text' => "Input fields are empty!"));
				die($output);
			}

			//Sanitize input data using PHP filter_var().
			$location       = filter_var($_POST["location"], FILTER_SANITIZE_STRING);
			$caller         = filter_var($_POST["caller"], FILTER_SANITIZE_STRING);
			$code           = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
			$fname          = filter_var($_POST["fname"], FILTER_SANITIZE_STRING);
			$sname          = filter_var($_POST["sname"], FILTER_SANITIZE_STRING);
			$gender         = filter_var($_POST["gender"], FILTER_SANITIZE_STRING);
			$login          = $_SESSION['SESS_CONTROL_LOGIN'];
			$date     		= filter_var($_POST["date"], FILTER_SANITIZE_STRING);
			$date2     		= filter_var($_POST["date2"], FILTER_SANITIZE_STRING);
			$additional  	= filter_var($_POST["additional"], FILTER_SANITIZE_STRING);
			$IN1            = filter_var($_POST["IN1"], FILTER_SANITIZE_NUMBER_INT);
			$IN2  			= filter_var($_POST["IN2"], FILTER_SANITIZE_NUMBER_INT);
			$OUT1           = filter_var($_POST["OUT1"], FILTER_SANITIZE_NUMBER_INT);
			$OUT2           = filter_var($_POST["OUT2"], FILTER_SANITIZE_NUMBER_INT);
			$locnew = "SELECT * FROM location WHERE code='$location'";
			$ress = mysqli_query($GLOBALS["___mysqli_ston"], $locnew);
			$hour = $row['IN1'];
			$minute = $row['IN2'];
			$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
			$hour2 = $row['OUT1'];
			$minute2 = $row['OUT2'];
			$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
			$dt_1 = "$date $IN1:$IN2:00";
			$dt_2 = "$date2 $OUT1:$OUT2:00";
			$hours = ((strtotime($dt_2) - strtotime($dt_1))/(60*60));
			if($hours < 1){
				$output = json_encode(array('type'=>'error', 'text' => "Employees don't have the ability to work negative hours, unfortunately. Fix the time."));
				die($output);
			}
			
			if(!$ress) {
				die('Error');
			} else {
				while($row1 = mysqli_fetch_assoc($ress)){
					$type = $row1['is_type'];
					$_SESSION['NAME'] = fejn;
					$n = $row1['name'];
					$t = $row1['type'];
					$tn = $row1['type_number'];
					
					if($type=='false'){
						$_SESSION['SESS_TYPE'] = ($n);
						$l_name = $_SESSION['SESS_TYPE'];
					}

					elseif($type=='true'){
						$_SESSION['SESS_TYPE'] = ($n.' ('.$t.' #'.$tn.')');
						$l_name = $_SESSION['SESS_TYPE'];
					}

				}

			}
					if ($filled == '1'){
							//Sanitize input data using PHP filter_var().
							$euid           = filter_var($_POST["euid"], FILTER_SANITIZE_STRING);
							$code           = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
							$fill_login     = $_SESSION['SESS_CONTROL_LOGIN'];
							$fill_date 		= date('Y-m-d G:i:s');
							
							$employee = "SELECT * FROM employee WHERE euid='$euid'";
							$req = mysqli_query($GLOBALS["___mysqli_ston"], $employee);
							
							if(!$req) {
							$output = json_encode(array('type'=>'error', 'text' => "Error!"));
								die($output);
							} else {
								while($row1 = mysqli_fetch_assoc($req)){
									$f = $row1['fname'];
									$s = $row1['sname'];
									$_SESSION['SESS_NAME'] = ($s.', '.$f);
									$name = $_SESSION['SESS_NAME'];
								}
				
							}
					}

			//additional php validation
			
			if((strlen($comments)>=1)  & (strlen($comments)<=5)) //check emtpy message
				{
				$output = json_encode(array('type'=>'error', 'text' => 'Comment is too short, ensure proper formatting!'));
				die($output);
			}

			//proceed with PHP mysqli Query.
				if ($filled == '0'){
			$qry = "UPDATE shifts SET location='$location', name='$l_name', dt_1='$dt_1', dt_2='$dt_2', hours='$hours', caller='$caller', gender='$gender', date='$date', additional='$additional', IN1='$IN1', IN2='$IN2', OUT1='$OUT1', OUT2='$OUT2' WHERE code='$code'";
					}
				if ($filled == '1'){
			$qry = "UPDATE shifts SET filled='1', euid='$euid', ename='$name', fill_login='$fill_login', fill_timestamp='$fill_date', location='$location', name='$l_name', dt_1='$dt_1', dt_2='$dt_2', hours='$hours', caller='$caller', gender='$gender', date='$date', additional='$additional', IN1='$IN1', IN2='$IN2', OUT1='$OUT1', OUT2='$OUT2' WHERE code='$code'";
					}
			//Check whether the query was successful or not
			$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
			
			if(!$result)    {
				$output = json_encode(array('type'=>'error', 'text' => "$qry Could not update this shift! Please contact an IT Specialist."));
				die($output);
			} else {
				$output = json_encode(array('type'=>'message', 'text' => ''.$l_name.' for '.$time_12_hour_IN.' to '.$time_12_hour_OUT.' has been updated.' ));
				die($output);
			}

		}

		
		if ($action=='unfill'){
			//check $_POST vars are set, exit if any missing
			
			if(!isset($_POST["code"]))    {
				$output = json_encode(array('type'=>'error', 'text' => "Employee ID or Shift Code is empty!"));
				die($output);
			}

			//Sanitize input data using PHP filter_var().
			$code           = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
			$fill_login     = $_SESSION['SESS_CONTROL_LOGIN'];
			$fill_date 		= date('Y-m-d G:i:s');



			//proceed with PHP mysqli Query.
			$qry = "UPDATE shifts SET filled='0', euid='', ename='', fill_login='$fill_login', fill_timestamp='' WHERE code='$code' AND filled='1'";
			//Check whether the query was successful or not
			$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
			
			if(!$result)    {
				$output = json_encode(array('type'=>'error', 'text' => "Could not unfill this shift! Please contact an IT Specialist."));
				die($output);
			} else {
				$output = json_encode(array('type'=>'message', 'text' => 'This shift has been unfilled' ));
				die($output);
			}

		} 
		if ($action=='cancel'){
			//check $_POST vars are set, exit if any missing
			
			if(!isset($_POST["code"]) || !isset($_POST["caller"]))    {
				$output = json_encode(array('type'=>'error', 'text' => "Employee ID or Shift Code is empty!"));
				die($output);
			}

			//Sanitize input data using PHP filter_var().
			$code           = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
			$cancel_login     = $_SESSION['SESS_CONTROL_LOGIN'];
			$cancel_reason     = filter_var($_POST["reason"], FILTER_SANITIZE_STRING);
			$cancel_caller     = filter_var($_POST["caller"], FILTER_SANITIZE_STRING);
			$cancel_date 		= date('Y-m-d G:i:s');



			//proceed with PHP mysqli Query.
			$qry = "UPDATE shifts SET cancelled='1', cancel_reason='$cancel_reason', cancel_caller='$cancel_caller', fill_login='$cancel_login', cancel_timestamp='$cancel_date' WHERE code='$code'";
			//Check whether the query was successful or not
			$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
			
			if(!$result)    {
				$output = json_encode(array('type'=>'error', 'text' => "Could not cancel this shift! Please contact an IT Specialist."));
				die($output);
			} else {
				$output = json_encode(array('type'=>'message', 'text' => 'This shift has been cancelled' ));
				die($output);
			}

		} 
		if ($action=='fill'){
			//check $_POST vars are set, exit if any missing
			
			if(!isset($_POST["code"]) || !isset($_POST["euid"]))    {
				$output = json_encode(array('type'=>'error', 'text' => "Employee ID or Shift Code is empty!"));
				die($output);
			}

			//Sanitize input data using PHP filter_var().
			$euid           = filter_var($_POST["euid"], FILTER_SANITIZE_STRING);
			$code           = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
			$fill_login     = $_SESSION['SESS_CONTROL_LOGIN'];
			$fill_date 		= date('Y-m-d G:i:s');
			
			$employee = "SELECT * FROM employee WHERE euid='$euid'";
			$ress = mysqli_query($GLOBALS["___mysqli_ston"], $employee);
			
			if(!$ress) {
			$output = json_encode(array('type'=>'error', 'text' => "Error!"));
				die($output);
			} else {
				while($row1 = mysqli_fetch_assoc($ress)){
					$f = $row1['fname'];
					$s = $row1['sname'];
					$_SESSION['SESS_NAME'] = ($s.', '.$f);
					$name = $_SESSION['SESS_NAME'];
				}

			}

			//additional php validation
			
			if((strlen($comments)>=1)  & (strlen($comments)<=5)) //check emtpy message
				{
				$output = json_encode(array('type'=>'error', 'text' => 'Comment is too short, ensure proper formatting!'));
				die($output);
			}

			//proceed with PHP mysqli Query.
			$qry = "UPDATE shifts SET filled='1', euid='$euid', ename='$name', fill_login='$fill_login', fill_timestamp='$fill_date' WHERE code='$code' AND filled='0'";
			//Check whether the query was successful or not
			$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
			
			if(!$result)    {
				$output = json_encode(array('type'=>'error', 'text' => "Could not fill this shift! Please contact an IT Specialist."));
				die($output);
			} else {
				$output = json_encode(array('type'=>'message', 'text' => ''.$name.' has successfully filled this shift!' ));
				die($output);
			}

		} 
		if ($action=='location'){
			
			//check $_POST vars are set, exit if any missing
			if(!isset($_POST["name"]) || !isset($_POST["code"]) || !isset($_POST["number"]) || !isset($_POST["street"]) || !isset($_POST["postal"]) || !isset($_POST["majint"]) || !isset($_POST["city"]))
			{
				$output = json_encode(array('type'=>'error', 'text' => "Input fields are empty!1"));
				die($output);
			}
		
			if(isset($_POST["check1"]) && !isset($_POST["type"]) || !isset($_POST["tnum"]))
			{
				$output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!2'));
				die($output);
			}
		
			if(isset($_POST["check2"]) && !isset($_POST["alternate"]))
			{
				$output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!3'));
				die($output);
			}
			
			if(isset($_POST["check3"]) && !isset($_POST["comments"]))
			{
				$output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!4'));
				die($output);
			}


			//Sanitize input data using PHP filter_var().
			$code           = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
			$name           = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
			$date    	    = date("M d, Y h:i ");
			$subunits 	    = filter_var($_POST["check1"], FILTER_SANITIZE_STRING);
			$login  	    = $_SESSION['SESS_CONTROL_LOGIN'];
			$alt          	= filter_var($_POST["check2"], FILTER_SANITIZE_STRING);
			$additional	    = filter_var($_POST["check3"], FILTER_SANITIZE_STRING);
			$type           = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
			$tnum      	    = filter_var($_POST["tnum"], FILTER_SANITIZE_NUMBER_INT);
			$number         = filter_var($_POST["number"], FILTER_SANITIZE_STRING);
			$alternate	    = filter_var($_POST["alternate"], FILTER_SANITIZE_STRING);
			$street   	    = filter_var($_POST["street"], FILTER_SANITIZE_STRING);
			$postal         = strtoupper(filter_var($_POST["postal"], FILTER_SANITIZE_STRING));
			$city           = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
			$major     	    = filter_var($_POST["majint"], FILTER_SANITIZE_STRING);
			$comments  	    = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);
			$update_date    = date('Y-m-d G:i:s');

			//additional php validation
			if(strlen($name)<4) // If length is less than 4 it will throw an HTTP error.
			{
				$output = json_encode(array('type'=>'error', 'text' => 'Name is too short or empty!'));
				die($output);
			}
			if ($additional===true){
				if((strlen($comments)>=1)  & (strlen($comments)<=5))  //check emtpy message
				{
					$output = json_encode(array('type'=>'error', 'text' => 'Comment is too short, ensure proper formatting!'));
					die($output);
				}
			}

			//proceed with PHP mysqli Query.
			$qry = "UPDATE location SET name='$name', comments='$comments', update_date='$update_date', update_login='$login', intersection='$major', postal='$postal', city='$city', street='$street', phone='$number', alternate='$alternate', is_type='$subunits', is_alternate='$alt', type_number='$tnum', type='$type', is_additional='$additional' WHERE code='$code'";
			//Check whether the query was successful or not
			$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
			
			if(!$result)    {
				$output = json_encode(array('type'=>'error', 'text' => "Could not update this location! Please contact an IT Specialist."));
				die($output);
			} else {
				$output = json_encode(array('type'=>'message', 'text' => ''.$name.' has been updated.' ));
				die($output);
			}

		}
		if ($action=='employee'){
			
		 if(!isset($_POST["fname"]) || !isset($_POST["sname"]) || !isset($_POST["number"]) || !isset($_POST["street"]) || !isset($_POST["postal"]) || !isset($_POST["majint"]) || !isset($_POST["city"]))
			{
				$output = json_encode(array('type'=>'error', 'text' => "Input fields are empty!1"));
				die($output);
			}
		
			if(isset($_POST["check1"]) && !isset($_POST["type"]) || !isset($_POST["tnum"]))
			{
				$output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!2'));
				die($output);
			}
			if ($_SESSION['SESS_CONTROL_TYPE'] >= 2){
				if(!isset($_POST["rate"]))
				{
					$output = json_encode(array('type'=>'error', 'text' => 'Fix the rate!'));
					die($output);
				}
			}
			if(isset($_POST["check2"]) && !isset($_POST["alternate"]))
			{
				$output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!3'));
				die($output);
			}
			
			if(isset($_POST["check3"]) && !isset($_POST["comments"]))
			{
				$output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!4'));
				die($output);
			}


			//Sanitize input data using PHP filter_var().
			$code         = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
			$fname        = filter_var($_POST["fname"], FILTER_SANITIZE_STRING);
			$sname        = filter_var($_POST["sname"], FILTER_SANITIZE_STRING);
			$gender       = filter_var($_POST["gender"], FILTER_SANITIZE_STRING);
			$position     = filter_var($_POST["position"], FILTER_SANITIZE_STRING);
			$date         = date("M d, Y h:i ");
			$subunits     = filter_var($_POST["check1"], FILTER_SANITIZE_STRING);
			$login  	  = $_SESSION['SESS_CONTROL_LOGIN'];
			$alt          = filter_var($_POST["check2"], FILTER_SANITIZE_STRING);
			if ($_SESSION['SESS_CONTROL_TYPE'] >= 2){
				$rate = number_format($_POST["rate"],2);
				$rq = " rate='$rate',";
			}
			$additional   = filter_var($_POST["check3"], FILTER_SANITIZE_STRING);
			$type         = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
			$tnum         = filter_var($_POST["tnum"], FILTER_SANITIZE_NUMBER_INT);
			$number       = filter_var($_POST["number"], FILTER_SANITIZE_STRING);
			$alternate    = filter_var($_POST["alternate"], FILTER_SANITIZE_STRING);
			$street       = filter_var($_POST["street"], FILTER_SANITIZE_STRING);
			$postal       = strtoupper(filter_var($_POST["postal"], FILTER_SANITIZE_STRING));
			$city         = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
			$major        = filter_var($_POST["majint"], FILTER_SANITIZE_STRING);
			$comments     = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);
			$update_date  = date('Y-m-d G:i:s');

			//additional php validation
			if ($additional===true){
				if((strlen($comments)>=1)  & (strlen($comments)<=5))  //check emtpy message
				{
					$output = json_encode(array('type'=>'error', 'text' => 'Comment is too short, ensure proper formatting!'));
					die($output);
				}
			}

			//proceed with PHP mysqli Query.
			$qry = "UPDATE employee SET fname='$fname', sname='$sname', position='$position',$rq update_date='$update_date', update_login='$login', comments='$comments', intersection='$major', postal='$postal', city='$city', street='$street', phone='$number', alternate='$alternate', is_type='$subunits', is_alternate='$alt', type_number='$tnum', type='$type', is_additional='$additional' WHERE euid='$code'";
			//Check whether the query was successful or not
			$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
			
			if(!$result)    {
				$output = json_encode(array('type'=>'error', 'text' => "Could not update this employee! Please contact an IT Specialist."));
				die($output);
			} else {
				$output = json_encode(array('type'=>'message', 'text' => ''.$fname.' '.$sname.' has successfuly been updated.' ));
				die($output);
			}

		}
		else {
			header("location: /login");
			// NOT fill or edit
		}

	} else {
		header("location: /login");
		// NOT POST
	}

	?>