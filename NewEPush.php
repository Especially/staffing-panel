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
    $fname        = filter_var($_POST["fname"], FILTER_SANITIZE_STRING);
	$sname        = filter_var($_POST["sname"], FILTER_SANITIZE_STRING);
	$gender       = filter_var($_POST["gender"], FILTER_SANITIZE_STRING);
	$position       = filter_var($_POST["position"], FILTER_SANITIZE_STRING);
	$date         = date("M d, Y h:i ");
    $subunits     = filter_var($_POST["check1"], FILTER_SANITIZE_STRING);
	$login  	  = $_SESSION['SESS_CONTROL_LOGIN'];
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
    $name = "$sname, $fname";
	$postal = strtoupper($postal);
    //additional php validation
	if ($additional=='true'){
		if(strlen($comments)<5) //check emtpy message
		{
			$output = json_encode(array('type'=>'error', 'text' => 'Comment is too short, ensure proper formatting!'));
			die($output);
		}
	}
    function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
	}
	$eUID = generateRandomString(10);
    //proceed with PHP mysqli Query.
	
	$qry = "INSERT INTO employee(eUID, login, fname, sname, gender, position, phone, alternate, type, type_number, street, postal, city, intersection, comments, is_type, is_alternate, is_additional, added_date) VALUES('ACE-$eUID','$login','$fname','$sname','$gender','$position','$number','$alternate','$type','$tnum','$street','$postal','$city','$major','$comments','$subunits','$alt','$comments','$date')";
	//Check whether the query was successful or not
	$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
    if(!$result)
    {
		$output = json_encode(array('type'=>'error', 'text' => "Could not add employee! Please contact an IT Specialist."));
		die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => 'Hi '.$login .', the following employee has been added: <b>'.$name.'</b> click the away if you are finished adding employees.' ));
        die($output);
    }
} else {
	header("location: /login");
}
?>