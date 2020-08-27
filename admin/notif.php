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
if ($action == 'delete'){
	$t1 = "Delete";
	if ($form == 'article'){
		$t2 = "the article";
		$qry = "SELECT * FROM knowledge_base WHERE kb_id='$id'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		while($row = mysqli_fetch_assoc($result)){
			$name = $row['kb_title'];
			$t3 = "\"".$row['kb_title']."\"";
		}
		$title = "$t1 $t2 $t3";
		$msg = '<div id="popup-msg-one">
                    <div id="popup-img">'.$icon_bigx.'</div>
					<div id="popup-txt">'.$login.' are you sure that you\'d like to delete the article <i>'.$name.'</i> from the database? This cannot be undone.</div>
                </div>
				<div id="popup-msg-two" style="display:none;">
                    <div id="popup-img">'.$icon_check.'</div>
                </div>';
		$footer = '<div id="popup-msg-foot" style="float:right;">
							<div id="tab_holder" style="float:right;padding:0px;">
                            	<div id="tab_items" style="float:right;">
                                    <div id="tab_items" style="float:left;"><input type="button" value="Cancel" data-article-id="'.$id.'" class="red" id="cancel" style="width:102px;position: relative;z-index: 10;"></div>
                                    <div id="tab_items" style="float:left;"><input type="button" value="Confirm" data-article-id="'.$id.'" class="blue" id="confirm_delete" style="width:102px;position: relative;z-index: 10;"></div>
                                </div>
                            </div>
                	</div>';
		$script = '$(document).ready(function(){
	$("#cancel, #overlay").click(function(){
		var ph = $("#popup-holder").height();
					$("#popup-holder").css(\'height\',ph).delay(100).queue(function(){$(this).addClass("out"); $("#notif").delay(1000).queue(function(){$("#notif").remove()},1000); $("#overlay").fadeOut();},100);
	});
	$("#confirm_delete").click(function(){
        var proceed = true;
        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {\'action\': \'delete_a\', \'article\': \''.$id.'\'};

            //Ajax post data to server
            $.post(\'a_edit.php\', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == \'error\') {
                    presp = \'error\';
					pmsg  = \'\' + response.text + \'\';
                } else {
                    presp = \'success\';
					pmsg  = \'\' + response.text + \'\';
					var ph = $("#popup-holder").height();
					$("#popup-holder").css(\'height\',ph).delay(100).queue(function(){$(this).addClass("out"); $("#notif").delay(1000).queue(function(){$("#notif").remove()},1000); $("#overlay").fadeOut();},100);
					$.get(\'kb_settings.php\', function(result){
						$result = $(result);
						var that = $result.find(\'.edit\');
						$(".bottom_wrap").html(that);
						$result.find(\'.bottom_wrap script\').appendTo(\'.bottom_wrap\');
				}, \'html\');

                }
				puno(""+pmsg+"",""+presp+"");
            }, \'json\');

        }
	});
});';
		
	}
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
			box-shadow: 1px 1px 1px 1px rgb(200, 200, 200);
			border-radius: 6px;
			font-family: Arial;
			color: #FFF;
			text-shadow: 1px 1px rgb(178, 178, 178);
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
			background-color: rgb(218, 218, 218);
			overflow:hidden;
		}
		#popup-body{
			background-color: rgb(237, 237, 237);
			min-height: 100px;
			padding:10px;
			color:#000;
			overflow:hidden;
		}
		#popup-txt{
			text-shadow:none;
			padding:10px;
			color: rgb(126, 126, 126);
			padding-top: 20px;
			overflow:hidden;
		}
		#popup-footer{
			height: 50px;
			border-bottom-left-radius: 5px;
			border-bottom-right-radius: 5px;
			background-color: rgb(218, 218, 218);
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
	$("#notif").css({'left': nnl, 'top' : nnh});
}
npos();
$(window).resize(function(){
	npos();
});
});
<?php echo($script); ?>
</script>
</html>