<?php
	//Start session
	session_start();
	// set maximun inactive time(this time is set in seconds )
	$max_time = 3600;
	// Get current time on server;
	$current = time(); 
	 
	if (!isset ($_SESSION['Inactive']))
	{ // Create session inactive;
	  $_SESSION['Inactive'] = time();
	}
	 
	else
	 
	{
// Extract current time from inactive time.
$session_life = $current - $_SESSION['Inactive'] ;
 
    // Verify if inactive time is greater than maximun allow i
       if ($session_life > $max_time )
        {
        // Send the last page visited by user in the get variables
         $referrer = urlencode ($_SERVER['PHP_SELF']);
		 if (!$_SERVER['PHP_SELF']){
			 $referer = 'no_referer';
		 }
         // this will destroy the session that already exist;
         session_destroy();
         //Redirect user
//         header('Location: logout?session=expired');
	     $return_to = $_SERVER['REQUEST_URI'];
         header("location: /login?return_to=$return_to");
         //stop the script
         exit();
       }
   else
      {
        // Re-assign value to inactive
        $_SESSION['Inactive'] = time(); 
 
      } 
 
}
	$return_to = $_SERVER['REQUEST_URI'];
	//Check whether the session variable SESS_UID is present or not
	if(!isset($_SESSION['SESS_CONTROL_ID']) || (trim($_SESSION['SESS_CONTROL_ID']) == '')) {
		header("location: /login?return_to=$return_to");
		exit();
	}
$acc_type = $_SESSION['SESS_CONTROL_TYPE'];
if ($acc_type < 3) {
	header('Location: /main');
}

$status = $_SESSION['SESS_CONTROL_STATUS'];
if ($status == "2") {
	header('Location: /blocked');
}
$verify = $_SESSION['SESS_CONTROL_VERIFY'];
if ($verify == "0") {
	header('Location: /verify');
}
$domain = 'http://staffingpanel.x10.mx/';
$_SESSION['SESS_GLOBAL_DOMAIN'] = $domain;
?>