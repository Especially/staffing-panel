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
    


    //Sanitize input data using PHP filter_var().
    $code         = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
	$login  	  = $_SESSION['SESS_CONTROL_LOGIN'];
    
    //proceed with PHP mysqli Query.
	
	$qry = "DELETE FROM shifts WHERE code = '$code'";
	//Check whether the query was successful or not
	$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
    if(!$result)
    {
        $output = json_encode(array('type'=>'error', 'text' => "Error! Could not delete data entry."));
        die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => 'Data entry removed.'));
        die($output);
    }
} else {
	header("location: /login");
}
?>