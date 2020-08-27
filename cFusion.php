<?php
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
	$email = clean($_POST['email']);
	$fname = clean($_POST['fname']); 
	$sname = clean($_POST['sname']);
	$ip = clean($_POST['ip']);
	$login = clean($_POST['login']);
	$type = clean($_POST['type']);
	$euid = clean($_POST['euid']); 
	$password = clean($_POST['password']);
	$cpassword = clean($_POST['cpassword']);
	$cdate = date("M d, Y h:i ");
function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $vCode = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
  $vCode = generateRandomString(40);
  $uid = generateRandomString(10);
	
	//Input Validations
	if($email == '') {
		$errmsg_arr[] = 'Email missing';
		$errflag = true;
	}
	if($sname == '') {
		$errmsg_arr[] = 'Surname name missing';
		$errflag = true;
	}
//	if($euid == '') {
//		$errmsg_arr[] = 'Unique Employee ID Mising!';
//		$errflag = true;
//	}
	if($login == '') {
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	if($ip == '') {
		$errmsg_arr[] = 'Error! Please reload.';
		$errflag = true;
	}
	if($fname == '') {
		$errmsg_arr[] = 'First name missing';
		$errflag = true;
	}
	if($type == '') {
		$errmsg_arr[] = 'Account type missing.'; //If type=='2' for regular users; render error!//
		$errflag = true;
	}
	if($cpassword == '') {
		$errmsg_arr[] = 'Please confirm your password';
		$errflag = true;
	}
	if( strcmp($password, $cpassword) != 0 ) {
		$errmsg_arr[] = 'Passwords do not match';
		$errflag = true;
	}
	
	//Check for duplicate login ID
	if($login != '') {
		$qry = "SELECT * FROM control WHERE login='$login'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errmsg_arr[] = 'Login ID already in use';
				$errflag = true;
			}
			@((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
		}
		else {
				$errmsg_arr[] = 'Invalid Login ID';
				$errflag = true;
		}
	}
	
	//Check for duplicate Unique Employee ID
	if($euid != '') {
		$qry = "SELECT * FROM employees WHERE euid='$euid'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errmsg_arr[] = 'An account with this Unique Employee ID has already been created! Please contact an administrator for assistance.';
				$errflag = true;
			}
			@((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
		}
		else {
				$errmsg_arr[] = 'Query Failed (515)';
				$errflag = true;
		}
	}

	
	//Check for duplicate username
	if($uname != '') {
		$qry = "SELECT * FROM control WHERE username='$uname'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errmsg_arr[] = 'Username already in use';
				$errflag = true;
			}
			@((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
		}
		else {
				$errmsg_arr[] = 'Invalid Username';
				$errflag = true;
		}
	}
	//Check for duplicate username
	if($email != '') {
		$qry = "SELECT * FROM control WHERE email='$email'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errmsg_arr[] = 'Email is already in use';
				$errflag = true;
			}
			@((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
		}
		else {
				$errmsg_arr[] = 'Invalid Email';
				$errflag = true;
		}
	}


	//Check for duplicate IP
	if($ip != '') {
		$qry1 = "SELECT * FROM control WHERE ip='$ip'";
		$result1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1);
		if($result) {
			if(mysqli_num_rows($result1) > 0) {
				$errmsg_arr[] = 'You already created an account with this IP.';
				$errflag = true;
			}
			@((mysqli_free_result($result1) || (is_object($result1) && (get_class($result1) == "mysqli_result"))) ? true : false);
		}
		else {
				$errmsg_arr[] = 'Query Failed (525)';
				$errflag = true;
		}
	}
	//Check for duplicate uID
	if($uid != '') {
		$qry = "SELECT * FROM control WHERE uID='$uid'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errmsg_arr[] = 'An account with this Unique ID has already been made, please refresh the page to set a new one before continuing your registration.';
				$errflag = true;
			}
			@((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
		}
		else {
				$errmsg_arr[] = 'Query Failed (535)';
				$errflag = true;
		}
	}
	
	//If there are input validations, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: /create");
		exit();
	}

	//Create INSERT query
	$qryy = "INSERT INTO control (login, vcode, passwd, ip, cDate, first_name, surname, uID, email, type) 
			VALUES ('$login','$vCode','".md5($_POST['password'])."','$ip','$cdate','$fname','$sname','AC-$uid','$email','$type')";
	$resultt = @mysqli_query($GLOBALS["___mysqli_ston"], $qryy);
	//Check whether the query was successful or not
	if($resultt) {
					  $emailSubject = 'Verify Your Blockr Account';
					  $fromPerson = '"Blockr" <accounts@blockr.ca>';
					  $DNR = 'no-reply@blockr.ca';
					  $user_Message = ("<center>
        	<table border='0' cellpadding='0' cellspacing='0' height='100%' width='100%' id='bodyTable' style='border-collapse: collapse;margin: 0;padding: 0;background-color: #f0f3f6;height: 100% !important;width: 100% !important;'>
            	<tbody><tr>
                	<td align='center' valign='top' style='border-collapse: collapse;'>
                    	<!-- // BEGIN CONTAINER -->
                        <table border='0' cellpadding='0' cellspacing='0' width='600' id='templateContainer' style='border-collapse: collapse;'>
                        	<tbody><tr>
                            	<td align='center' valign='top' bgcolor='#40505F' style='border-collapse: collapse;'>
                                    <!-- // BEGIN HEADER -->
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' id='templateHeader' style='border-collapse: collapse;'>
									    <tbody>
									    <tr>
                                            <td align='center' valign='top' style='border-collapse: collapse;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%' bgcolor='#40505F' style='border-collapse: collapse;margin: 10px 0px 10px 0px;'>
                                                    <tbody><tr>
                                                        <td style='border-collapse: collapse;font-family: Helvetica,Arial,Georgia;font-size: 12px;color: #616161;text-align: center;'><a href='http://snarl.x10.mx/blockr'><img src='http://snarl.x10.mx/blockr/images/blockr_strike_w2WHITE2.png' style='height: 50px;'></a></td>
														
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
										
                                        
                                    </tbody></table>
                                    <!-- END HEADER \\ -->
                                </td>
                            </tr>
                            <tr>
                                <td align='center' valign='top' class='templateBody_not_header' style='border-collapse: collapse;border-left: 1px solid #dddddd;border-right: 1px solid #dddddd;'>
                                    <!-- // BEGIN BODY -->
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' id='templateBody' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>
                                        <tbody><tr>
                                            <td align='center' valign='top' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>
                                                <table border='0' cellpadding='20' cellspacing='0' width='100%' class='bodyContentBlock' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;background-color: #fff;border-top: 0;border-bottom: 0;'>
                                                    <tbody><tr>
                                                        <td align='center' valign='top' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>
                                                            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>
                                                                <tbody><tr>
																    <td width='55' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>&nbsp;</td>
                                                                    <td valign='top' class='bodyContent' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;color: #a5a5a5;font-family: Arial;font-size: 16px;line-height: 150%;text-align: left;'><div style='color: rgb(34, 34, 34); font-family: arial, sans-serif; line-height: normal;'><span style='color:#808080'><strong style='line-height:1.15'><span style='font-family:arial,helvetica neue,helvetica,sans-serif'>Hey <span style='line-height:normal'>$first</span></span></strong><span style='line-height:1.15'><strong><span style='font-family:arial,helvetica neue,helvetica,sans-serif'>!</span></strong></span></span></div>

<div style='word-wrap: break-word;'>
<p dir='ltr' style='color: rgb(34, 34, 34); font-family: arial, sans-serif; margin-top: 0pt; margin-bottom: 0pt;'><br>
<span style='color:#696969'>Thanks for registering for a Blockr account!<br>
&nbsp;<br>
Before you can start blocking your worst enemies, we ask that you verify your email address so we know that we're keeping the right person up to date! Click the button below to verify your account.</span><br>
<br>
<br>
<center><a href='http://snarl.x10.mx/verify?token=$email_code' style='text-decoration:none;'><span style='color: #FFFFFF;padding: 14px;font-size: 25px;background-color: #40505F;border-radius: 4px;-webkit-border-radius: 4px;-moz-border-radius: 4px;'>Verify Account</span></a></center><br>
<br>
<span style='color:#696969'>If you didn't create an account simply ignore this email and continue on with your day</span>

<p dir='ltr' style='color: rgb(34, 34, 34); font-family: arial, sans-serif; margin-top: 0pt; margin-bottom: 0pt;'><br>
<br>
<strong style='color:rgb(128, 128, 128); font-family:calibri,sans-serif; font-size:14px; line-height:normal'><span style='font-size:18px'>With love,</span></strong></p>
</div>

<div style='word-wrap: break-word;'><strong style='color:rgb(128, 128, 128); font-family:calibri,sans-serif; font-size:18px; line-height:20px'>The Blockr Team&nbsp;</strong><br>
&nbsp;</div>
</td>
																	<td width='55' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>&nbsp;</td>
                                                                </tr>
                                                            </tbody></table>
                                                       </td>   
                                                    </tr>
												</tbody></table>
                                             </td>
										</tr>
									</tbody></table>
								</td>
							</tr>
                                            
                                        
                                    
                                    <!-- END BODY \\ -->
                                
                            
							<tr>
								<td bgcolor='#263340' style='border-collapse: collapse;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>
									    <tbody><tr><td height='25' style='font-size: 15px;line-height: 1;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>&nbsp;</td></tr>
										<tr>
											<td width='80' style='border-collapse: collapse;'>&nbsp;</td>
											<td style='border-collapse: collapse;'>
												
												
												
												
												
												
												
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;'>
													<tbody><tr>
													    <td width='140' style='border-collapse: collapse;'>&nbsp;</td>
														<td class='footer-link' style='border-collapse: collapse;font-family: Helvetica,Arial;font-size: 12px;color: #C7C3C3;text-decoration: none;'>Copyright © 2015 JEVEL Labs</td>
														<td width='80' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>&nbsp;</td>
													</tr>
													<tr><td height='25' style='font-size: 0px;line-height: 1;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>&nbsp;</td></tr>
												</tbody></table>
											</td>
											<td width='60' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>&nbsp;</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
                        </tbody></table> 
                        <!-- END CONTAINER \\ -->
                 </td>
							</tr>
                        </tbody></table> 
                
            
        </center>");
    
    //proceed with PHP email.

    /*
    Incase your host only allows emails from local domain, 
    you should un-comment the first line below, and remove the second header line. 
    Of-course you need to enter your own email address here, which exists in your cp.
    */
    //$headers = 'From: info@alwayscare.net' . "\r\n" .
    $headers = 'From: '.$fromPerson.'' . "\r\n" . //remove this line if line above this is un-commented
    'Reply-To: '.$DNR.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion() . "\r\n" .
	'Content-type: text/html; charset=iso-8859-1';
    
        // send mail
    $headers = 'From: '.$fromPerson.'' . "\r\n" . //remove this line if line above this is un-commented
    'Reply-To: '.$DNR.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion() . "\r\n" .
	'Content-type: text/html; charset=iso-8859-1';
    $sentMail = mail($email, $emailSubject, $user_Message, $headers);
	if ($sentMail) {
		// Success
	} else {
		// Failure
	}
		header("location: /created");
		exit();
	}else {
		die("Query Failed2 $resultt");
	}
?>