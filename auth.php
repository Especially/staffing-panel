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
		 if ($return_to == 'unfilled_5.php'){
			 $return_to = 'Home';
			 echo("<script>window.location.href = '/login?return_to=$return_to';</script>");
		 }
		 elseif ($return_to == 'unfilled_5.php'){
			 $return_to = 'Home';
			 echo("<script>window.location.href = '/login?return_to=$return_to';</script>");
		 } else {
		 	echo("<script>window.location.href = '/login?return_to=Home';</script>");
		 }
//         header("Location: login?return_to=$return_to");
         //stop the script
         exit();
       }
   else
      {
        // Re-assign value to inactive
        $_SESSION['Inactive'] = time(); 
 
      } 
 
}
	//Check whether the session variable SESS_UID is present or not
	if(!isset($_SESSION['SESS_CONTROL_ID']) || (trim($_SESSION['SESS_CONTROL_ID']) == '')) {
		 $return_to = $_SERVER['REQUEST_URI'];
		 if ($return_to == 'unfilled_5.php'){
			 $return_to = 'Home';
			 echo("<script>window.location.href = '/login?return_to=$return_to';</script>");
		 }
		 elseif ($return_to == 'unfilled_5.php'){
			 $return_to = 'Home';
			 echo("<script>window.location.href = '/login?return_to=$return_to';</script>");
		 } else {
		 	echo("<script>window.location.href = '/login?return_to=Home';</script>");
		 }
//         header("Location: login?return_to=$return_to");
		exit();
	}
	$header_info = 
	"<header id='namespace'>
  <h1>Always Care Nursing Agency</h1>
  <p>203-10216 Yonge Street<br/>Richmond Hill, ON L4C 3B6<br/><b>Phone:</b> 905-770-8511 | <b>Fax:</b> 905-770-7073</p>
</header>	
	";
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