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
<title>Shifts</title>
<?php require_once('includes.php'); ?>
<script src="http://staffingpanel.x10.mx/js/Histex.js"></script>
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
<div id="holder" class="root" data-mcs-theme="light-thick" data-title-location="Staff Log - Always Care Staffing Panel" data-root-location="/Staff/Log">
<script>
	$("#all").click(function(){
        $("div[data-location='shifts']").load(''+root+'shift_tables.php?sort=all');
	});
	$("#filled").click(function(){
        $("div[data-location='shifts']").load(''+root+'shift_tables.php?sort=filled');
	});
	$("#unfilled").click(function(){
        $("div[data-location='shifts']").load(''+root+'shift_tables.php?sort=unfilled');
	});
	$("#cancelled").click(function(){
		var secondcss = $('.secondary_nav').css('display');
		if (secondcss == 'none') {
		$('.secondary_nav').slideDown().show();
		}
		if (secondcss == 'block') {
		$('.secondary_nav').slideUp();
		}
	});
	$("#c_all").click(function(){
        $("div[data-location='shifts']").load(''+root+'shift_tables.php?sort=cancelled&sub=all');
	});
	$("#c_filled").click(function(){
        $("div[data-location='shifts']").load(''+root+'shift_tables.php?sort=cancelled&sub=filled');
	});
	$("#c_unfilled").click(function(){
        $("div[data-location='shifts']").load(''+root+'shift_tables.php?sort=cancelled&sub=unfilled');
	});
</script>

    <div id="ui">
        <ul id="blacknav">
            <li class="first"><a  class="first psl-t" href="/Staff/Log/All" data-shift-title="All Shifts" id="all">All</a></li>
            <li><a href="/Staff/Log/Filled" data-shift-title="Filled Shifts" class="psl-t" id="filled">Filled</a></li>
            <li><a href="/Staff/Log/Unfilled" data-shift-title="Unfilled Shifts" class="psl-t" id="unfilled">Unfilled</a></li>
            <li><a href ="/Staff/Log/Cancelled" data-shift-title="Cancelled Shifts"class="last rednav psl-t" id="cancelled">Cancelled</a></li>
        </ul>
        <div id="ui" class='secondary_nav' style="display:none;right:0px;">
            <ul id="rednav">
                <li class="first"><a  class="first psl-t" href="/Staff/Log/Cancelled/All" data-shift-title="All Cancelled Shifts" id="c_all">All</a></li>
                <li><a href="/Staff/Log/Cancelled/Filled" data-shift-title="Filled Cancelled Shifts" class="psl-t" id="c_filled">Filled</a></li>
                <li><a href="/Staff/Log/Cancelled/Unfilled" data-shift-title="Unfilled Cancelled Shifts" id="c_unfilled" class="last psl-t">Unfilled</a></li>
            </ul>
        </div>
    </div>
  <div id="box" data-location="shifts">
    <center><h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);">Loading<marquee>...</marquee></h2></center>
</div>
<script type="text/javascript">
    $(document).ready(function(){
      FilledShiftsAuto();
    });

    function FilledShiftsAuto(){
        $("div[data-location='shifts']").load(''+root+'shift_tables.php?sort=filled', function(){
          Shifts = setInterval(FilledShifts, 60000);
        });
    }
    function FilledShifts(){
        $("div[data-location='shifts']").load(''+root+'shift_tables.php?sort=filled');
    }
</script>
</div>
</body>