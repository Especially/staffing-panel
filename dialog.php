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
$action = filter_var($_GET["action"], FILTER_SANITIZE_STRING);
$form = filter_var($_GET["form"], FILTER_SANITIZE_STRING);
$id = filter_var($_GET["id"], FILTER_SANITIZE_STRING);
$icon_warning = '<div class="icon warning pulseWarning" style="display: block;"> <span class="body pulseWarningIns"></span> <span class="dot pulseWarningIns"></span> </div>';
$icon_check = '<div class="icon success animate"> <span class="line tip animateSuccessTip"></span> <span class="line long animateSuccessLong"></span> <div class="placeholder"></div>  </div>'; 
$icon_bigx = '<div class="icon error animateErrorIcon" style="display: block;"><span class="x-mark animateXMark"><span class="line left"></span><span class="line right"></span></span></div>';
$login = $_SESSION['SESS_CONTROL_LOGIN'];
if ($action == 'payroll'){
	$t1 = "Select a Pay Period";
		$title = "$t1";
		$msg = '<div id="popup-msg-one">
                    <div id="popup-img">'.$none.'</div>
					<div id="popup-txt">
					<p>'.$login.' please select the pay period date you\'d like to view and/or process.</p>
						<div id="tab_holder" style="float:left;padding:0px;width:375px;">
							<div id="tab_items"><input type="date" id="d1"></div>
							<div id="tab_items" style="padding-top:20px;">&nbsp;&nbsp;to&nbsp;&nbsp;</div>
							<div id="tab_items"><input type="date" id="d2"></div>
						</div>
					</div>
                </div>';
		$footer = '<div id="popup-msg-foot" style="float:right;">
							<div id="tab_holder" style="float:right;padding:0px;">
                            	<div id="tab_items" style="float:right;">
                                    <div id="tab_items" style="float:left;"><input type="button" value="Cancel" class="red" id="cancel" style="width:102px;position: relative;z-index: 10;"></div>
                                    <div id="tab_items" style="float:left;"><input type="button" value="Go!" class="blue" id="view_pay-period" style="width:102px;position: relative;z-index: 10;" disabled="disabled"></div>
                                </div>
                            </div>
                	</div>';
		$script = '$(document).ready(function(){
	$("#cancel, #overlay").click(function(){
		var ph = $("#popup-holder").height();
		$("#popup-holder").css(\'height\',ph).delay(100).queue(function(){$(this).addClass("out"); $(".payroll_holder").delay(1000).queue(function(){$(".payroll_holder").remove()},1000); $("#overlay").fadeOut();},100);
		setPage();
	});
	$("#d1").change(function(){
		var d2 = $("#d2").val();
		if (d2 !== ""){
			$("#view_pay-period").prop("disabled","");
		} else {
			$("#view_pay-period").prop("disabled","disabled");
		}
	});
	$("#d2").change(function(){
		var d1 = $("#d1").val();
		if (d1 !== ""){
			$("#view_pay-period").prop("disabled","");
		} else {
			$("#view_pay-period").prop("disabled","disabled");
		}
	});
	$("#view_pay-period").click(function(){
		var d1 = $("#d1").val();
		var d2 = $("#d2").val();
		var ph = $("#popup-holder").height();
		$("#overlay").after("<div id=\"payroll_holder\" style=\"display:none;z-index:1100;position:absolute;\"></div>");
        $("#payroll_holder").load(\'payroll.php?d1=\'+d1+\'&d2=\'+d2+\'%2023:59\', function () {
		$("#popup-holder").css(\'height\',ph).delay(100).queue(function(){$(this).addClass("out"); $(".payroll_holder").delay(1000).queue(function(){$(".payroll_holder").remove()},1000);},100);
		});
		$("#payroll_holder").fadeIn();
	});
});';
} elseif($action == 'shift_conflict'){
	$shift_code = $_GET["sc"];
	$euid =$_GET["euid"];
	$staff_name = filter_var($_GET["en"], FILTER_SANITIZE_STRING);
	$staff_name = str_replace('_',' ',$staff_name);
	$shift_in = filter_var($_GET["in"], FILTER_SANITIZE_STRING);
	$shift_in = date("h:i A",$shift_in);
	$shift_out = filter_var($_GET["out"], FILTER_SANITIZE_STRING);
	$shift_out = date("h:i A",$shift_out);
	$shift_start = filter_var($_GET["nin"], FILTER_SANITIZE_STRING);
	$shift_start = date("h:i A",$shift_start);
	$t1 = "Shift Conflict!";
		$title = "$t1";
		$msg = '<div id="popup-msg-one">
                    <div id="popup-img">'.$icon_warning.'</div>
					<div id="popup-txt">
					<p>'.$login.' it appears that there is a shift conflict!<br/><br/> <b>'.$staff_name.'</b> appears to have a shift from '.$shift_in.' to '.$shift_out.' and the shift that you\'d like them to fill starts at '.$shift_start.'. Please consider time needed for sleep and travel before proceeding.</p>
					</div>
                </div>';
		$footer = '<div id="popup-msg-foot" style="float:right;">
							<div id="tab_holder" style="float:right;padding:0px;">
                            	<div id="tab_items" style="float:right;">
                                    <div id="tab_items" style="float:left;"><input type="button" value="Cancel" class="red" id="cancel" style="width:102px;position: relative;z-index: 10;"></div>
                                    <div id="tab_items" style="float:left;"><input type="button" value="Proceed" class="blue" id="proceed" style="width:102px;position: relative;z-index: 10;" onClick="fillWA(\''.$shift_code.'\',\''.$euid.'\',1)"></div>
                                </div>
                            </div>
                	</div>';
		$script = '$(document).ready(function(){
	$("#cancel, #overlay").click(function(){
		var ph = $("#popup-holder").height();
		$("#popup-holder").css(\'height\',ph).delay(100).queue(function(){$(this).addClass("out"); $(".dialog_holder").delay(1000).queue(function(){$(".dialog_holder").remove()},1000); $("#overlay").fadeOut();},100);
		setPage();
	});
	$("#proceed").click(function(){
		var d1 = $("#d1").val();
		var d2 = $("#d2").val();
		var ph = $("#popup-holder").height();
		$("#popup-holder").css(\'height\',ph).delay(100).queue(function(){$(this).addClass("out"); $(".dialog_holder").delay(1000).queue(function(){$(".dialog_holder").remove()},1000);},100);
	});
});';
}
?>
<html>
    <head>
<!--
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
-->
	<style>
		.out {
			height:0px!important;
			overflow:hidden!important;
			top:0px!important;
			left:0px!important;
			width:0px!important;
			box-shadow:none!important;
			-webkit-transition: 1s ease-in-out!important;
			-moz-transition: 1s ease-in-out!important;
			-o-transition: 1s ease-in-out!important;
			transition: 1s ease-in-out!important;
		}
		#popup-holder{
			width: 550px;
			box-shadow: 1px 1px 1px 1px rgb(53, 53, 53);
			border-radius: 6px;
			font-family: Arial;
			color: #FFF;
			text-shadow: none;
			-webkit-user-select:none;
			-webkit-transition: 1s ease-in-out;
			-moz-transition: 1s ease-in-out;
			-o-transition: 1s ease-in-out;
			transition: 1s ease-in-out;
		}
		#popup-header{
			height: 50px;
			font-weight:bold;
			border-top-left-radius: 5px;
			border-top-right-radius: 5px;
			background-color: rgb(66, 66, 66);
			overflow:hidden;
		}
		#popup-body{
			background-color: rgb(95, 95, 95);
			min-height: 100px;
			padding:10px;
			color:#000;
			overflow:hidden;
		}
		#popup-txt{
			text-shadow:none;
			padding:10px;
			color: rgb(231, 231, 231);
			padding-top: 20px;
			overflow:hidden;
		}
		#popup-footer{
			height: 50px;
			border-bottom-left-radius: 5px;
			border-bottom-right-radius: 5px;
			background-color: rgb(66, 66, 66);
			overflow:hidden;
		}
		#popup-hf-padding{
			padding:16px;
		}
		#popup-close{
			float:right;
			background-color: rgb(229, 128, 128);
			padding: 5px;
			border-radius: 10px;
			font-size: 12px;
			cursor: pointer;
			width: 11px;
			text-align: center;
			margin-top: -10px;
			margin-right: -10px;
			-webkit-transition: 0.3s ease;
			-moz-transition: 0.3s ease;
			-o-transition: 0.3s ease;
			transition: 0.3s ease;
		}
		#popup-close:active{
			background-color: rgb(200, 126, 123);
			-webkit-box-shadow: 0 1px 2px rgba(255,255,255,.1), inset 0 1px 2px rgba(47, 47, 47, 0.4);
		}
		.icon.warning.pulseWarning {
		  border-color: rgb(255,155,0);
		}
		.icon.warning.pulseWarning {
		  border-color: rgb(255,155,0);
		}
		.icon.warning.pulseWarning {
		  width: 40px;
		  height: 40px;
		  border: 4px solid rgb(255,155,0);
		  border-radius: 50%;
		  margin: 10px auto;
		  position: relative;
		}
		span.body.pulseWarningIns {
		  position: absolute;
		  width: 3px;
		  height: 19px;
		  left: 50%;
		  top: 7px;
		  border-radius: 2px;
		  margin-left: -2px;
		  background-color: rgb(255,155,0);
		}
		span.dot.pulseWarningIns {
		  position: absolute;
		  width: 5px;
		  height: 5px;
		  border-radius: 50%;
		  margin-left: -3px;
		  left: 50%;
		  bottom: 5px;
		  background-color: rgb(255,155,0);
		}
		.icon.error.animateErrorIcon {
		  border-color: #F27474;
		  width: 40px;
		  height: 40px;
		  background: none;
		  border: 4px solid #F27474;
		  border-radius: 50%;
		  margin: 10px auto;
		  position: relative;
		}
		span.x-mark.animateXMark {
		  position: relative;
		  display: block;
		}
		span.line.left {
		  -webkit-transform: rotate(45deg);
		  transform: rotate(45deg);
		  left: 9px;
		  position: absolute;
		  height: 5px;
		  width: 23px;
		  background-color: #F27474;
		  display: block;
		  top: 18px;
		  border-radius: 2px;
		}
		span.line.right {
		  position: absolute;
		  height: 5px;
		  width: 23px;
		  background-color: #F27474;
		  display: block;
		  top: 18px;
		  border-radius: 2px;
		  -webkit-transform: rotate(-45deg);
		  transform: rotate(-45deg);
		  right: 8px;
		}
		.icon.success.animate {
		  display: block;
		  width: 40px;
		  height: 40px;
		  border: 4px solid #A5DC86;
		  border-radius: 50%;
		  margin: 10px auto;
		  position: relative;
		  border-color: #A5DC86;
		  padding: 0;
		  background: none;
		}
		span.line.tip.animateSuccessTip {
		  width: 16px;
		  left: 2px;
		  top: 23px;
		  -webkit-transform: rotate(45deg);
		  transform: rotate(45deg);
		  height: 5px;
		  background-color: #A5DC86;
		  display: block;
		  border-radius: 2px;
		  position: absolute;
		  z-index: 2;
		}
		span.line.long.animateSuccessLong {
		  width: 28px;
		  right: 2px;
		  top: 18px;
		  -webkit-transform: rotate(-45deg);
		  transform: rotate(-45deg);
		  height: 5px;
		  background-color: #A5DC86;
		  display: block;
		  border-radius: 2px;
		  position: absolute;
		  z-index: 2;
		}
		.placeholder {
		  width: 40px;
		  height: 40px;
		  border: 4px solid rgba(165, 220, 134, 0.2);
		  border-radius: 50%;
		  position: absolute;
		  left: -4px;
		  top: -4px;
		  z-index: 2;
		}
	</style>
    </head>
<div id="popup-holder" class="out">
        	<div id="popup-header"><div id="popup-hf-padding"><span id="popup-title"><?php echo($title) ?></span><div id="popup-close">-</div></div></div>
        	<div id="popup-body">
				<?php echo($msg); ?>
            </div>
        	<div id="popup-footer"><?php echo($footer); ?></div>
</div>
<script>
$(document).ready(function(){
$("#popup-holder").removeClass("out");
function npos(){
	var wnh = $(window).height();
	var wnw = $(window).width();
	var nw = $("#popup-holder").width();
	var nh = $("#popup-holder").height();
	var nnl = (wnw/2)-(nw/2);
	var nnh = (wnh/2)-(nh/2);
	$(".dialog_holder").css({'left': nnl, 'top' : nnh});
}
npos();
$(window).resize(function(){
	npos();
});
});
<?php echo($script); ?>
</script>
</html>