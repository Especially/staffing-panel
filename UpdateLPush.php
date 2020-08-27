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
    
    //check $_POST vars are set, exit if any missing
    if(!isset($_POST["INAP"]) || !isset($_POST["code"]) || !isset($_POST["OUTAP"]) || !isset($_POST["OUT1"]) || !isset($_POST["IN1"]) || !isset($_POST["IN2"]) || !isset($_POST["OUT2"]) || !isset($_POST["caller"]) || !isset($_POST["date"]))
    {
        $output = json_encode(array('type'=>'error', 'text' => "Input fields are empty!1"));
        die($output);
    }


    //Sanitize input data using PHP filter_var().
    $name         = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $subunits     = filter_var($_POST["check1"], FILTER_SANITIZE_STRING);
    $alt          = filter_var($_POST["check2"], FILTER_SANITIZE_STRING);
    $additional   = filter_var($_POST["check3"], FILTER_SANITIZE_STRING);
	$type         = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
	$tnum         = filter_var($_POST["tnum"], FILTER_SANITIZE_NUMBER_INT);
	$number       = filter_var($_POST["number"], FILTER_SANITIZE_STRING);
	$alternate    = filter_var($_POST["alternate"], FILTER_SANITIZE_STRING);
	$street       = filter_var($_POST["street"], FILTER_SANITIZE_STRING);
	$postal       = filter_var($_POST["postal"], FILTER_SANITIZE_STRING);
	$city         = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
	$major        = filter_var($_POST["majint"], FILTER_SANITIZE_STRING);
	$comments     = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);

		$locnew = "SELECT * FROM location WHERE code='$location'";
		$ress = mysqli_query($GLOBALS["___mysqli_ston"], $locnew);
		
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
    //proceed with PHP mysqli Query.
	
	$qry = "UPDATE shifts SET location='$location', name='$name', caller='$caller', gender='$gender', date='$date', additional='$additional', IN1='$IN1', IN2='$IN2', INAP='$INAP', OUT1='$OUT1', OUT2='$OUT2', OUTAP='$OUTAP' WHERE code='$code'";
	//Check whether the query was successful or not
	$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
    if(!$result)
    {
		$output = json_encode(array('type'=>'error', 'text' => "Could not update this shift! Please contact an IT Specialist."));
		die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => ''.$name.' for '.$IN1.':'.$IN2.' '.$INAP.' to '.$OUT1.':'.$OUT2.' '.$OUTAP.' has been updated.' ));
        die($output);
    }
} else {
}
?>