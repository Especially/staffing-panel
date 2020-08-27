<?php 
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
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $str) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	}		
?>
<html>
<head>
<?php $floor = true;
include('includes.php'); ?>
<meta name="description" content="Robots rule.txt">
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
</script>
</head>
<body>
<div id="holder" class="root" data-mcs-theme="light-thick" data-title-location="Staff List - Always Care Staffing Panel" data-root-location="/Staff/List">
  <div id="box" data-location="employees">
    <center><h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);">Loading<marquee>...</marquee></h2></center>
</div>
<script type="text/javascript">
var pathname = window.location.pathname;
var path = window.location.hash;
    $(document).ready(function(){
		jax();
//		EmployeesAuto();
		EmployeesTable();
    });

//    function EmployeesAuto(){
//        $("div[data-location='employees']").load(''+root+'table_employees.php', function(){
//         Employ = setInterval(EmployeesTable, 60000);
//        });
//    }
    function EmployeesTable(){
        $("div[data-location='employees']").load(''+root+'table_employees.php');
	}
</script>
</div>
</body>