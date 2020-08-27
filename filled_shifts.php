 <?php 
	require_once('cFigure.php');	
	
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
<title>New Shifts</title>
<link rel="stylesheet" type="text/css" href="./css/Xufax.css">
<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css">
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<style type="text/css">
.success{ background: #CFFFF5;padding: 10px; margin-bottom: 10px; border: 1px solid #B9ECCE; border-radius: 5px; font-weight: normal; }
.error{ background: #FFDFDF; padding: 10px; margin-bottom: 10px; border: 1px solid #FFCACA; border-radius: 5px; font-weight: normal;}
/* Table Stuff */
.nav button {
	overflow: hidden;
	display: block;
	float: left;
	height:17px;
	width: 17px;
	margin-right: 7px;
	font: bold 14px/14px 'Helvetica', 'Arial';
	text-align: center;
	color: #FFF;

	-moz-box-shadow: 0 -1px 1px 0 rgba(0, 0, 0, 0.3) inset, 0 1px 3px 0 rgba(0, 0, 0, 0.80) inset, 0 1px 0px 0 rgba(255, 255, 255, 0.40); /* Firefox */
	-webkit-box-shadow: 0 -1px 1px 0 rgba(0, 0, 0, 0.3) inset, 0 1px 3px 0 rgba(0, 0, 0, 0.80) inset, 0 1px 0px 0 rgba(255, 255, 255, 0.40); /* Safari + Chrome */
	box-shadow: 0 -1px 1px 0 rgba(0, 0, 0, 0.3) inset, 0 1px 3px 0 rgba(0, 0, 0, 0.80) inset, 0 1px 0px 0 rgba(255, 255, 255, 0.40);

	-moz-border-radius: 7px;
	-webkit-border-radius: 7px;
	border-radius: 7px;

}.nav button:after {
	content: '';
	line-height: 2px;
	width: 12px;
	height: 12px;
	position: absolute;
	left: 50%;
	margin-left: -6px;
	bottom: -4px;
	opacity:0.55;
	background: -moz-radial-gradient(50% 50% 90deg,ellipse contain, rgba(255,255,255,1), rgba(255,255,255,0) 100%); /* Firefox */
}
.nav button.close {
	background: #f12519;
	background: -moz-linear-gradient(top, #f12519 0%, #ff8684 100%); /* Firefox */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f12519), to(#ff8684)); /* Safari + Chrome */

	color: #630f0a;
}
.nav button.minimize {
	background: #da8e28;
	background: -moz-linear-gradient(top, #e59130 0%, #ffdf4b 100%); /* Firefox */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#e59130), to(#ffdf4b)); /* Safari + Chrome */
	color: #742a08;
}
.nav button.expand {
	background: #67982f;
	background: -moz-linear-gradient(top, #70a847 0%, #a1e268 100%);
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#70a847), to(#a1e268)); /* Safari + Chrome */
	color: #093b00;
}
.nav button:before {
	content: '';
	width: 6px;
	height: 3px;
	background: -moz-radial-gradient(50% 50% 90deg,ellipse contain, rgba(255,255,255,1), rgba(255,255,255,0) 100%); /* Firefox */
	position: absolute;
	left: 50%;
	top: 1px;
	margin-left: -3px;
}
.nav button.close:hover:after {
	content: 'x';
}
.nav button.minimize:hover:after {
	content: '-';
}
.nav button.expand:hover:after {
	content: '+';
}
.flatTable{  
  width:100%;
  min-width:500px;
  border-collapse:collapse;  
  font-weight:bold;
  color:#6b6b6b;
}
  
  tr{
    height:50px;
    background:#f6f3f7;
    border-bottom:rgba(0,0,0,.05) 1px solid;
  }
  
  td{    
    box-sizing:border-box;
    padding-left:30px;

    

  }

.titleTr{
  height:70px;  
  color:#f6f3f7; 
  background:#418a95;  
  border:0px solid;
}

.plusTd{
    background:url(http://i.imgur.com/3hSkhay.png) center center no-repeat, rgba(0,0,0,.1);
}

.controlTd{  
  position:relative;
  width:80px;
  background:url(http://i.imgur.com/9Q5f6cv.png) center center no-repeat;
  cursor:pointer;
}

.headingTr{
    height:30px;
    color:#f6f3f7; 
    font-size:8pt;
	border-bottom: 1px solid #828282;
	padding: 20px;
	background-color: #151515 !important;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#151515), to(#404040)) !important;
	background-image: -webkit-linear-gradient(top, #151515, #404040) !important;
	background-image: -moz-linear-gradient(top, #151515, #404040) !important;
	background-image: -ms-linear-gradient(top, #151515, #404040) !important;
	background-image: -o-linear-gradient(top, #151515, #404040) !important;
	background-image: linear-gradient(top, #151515, #404040) !important;
	color: #fff !important;
	font-weight: normal;
}  
}

.button{
  text-align:center;
  cursor:pointer;
}

.sForm{
  position:absolute;
  top:0;
  right:-400px;
  width:400px;
  height:100%; 
  background:#f6f3f7;  
  overflow:hidden;  
  transition:width 1s, right .3s;
  padding:0px;
  box-sizing:border-box;
}
  .close{
    float:right; 
    height:70px;
    width:80px;
    padding-top:25px;    
    box-sizing:border-box;
    background:rgba(255,0,0,.4);
      
  }
  
  .title{
    width:100%;
    height:70px;
    padding-top:20px;
    padding-left:20px;
    box-sizing:border-box;
    background:rgba(0,0,0,.1);
  }
}
.open{  
  right:0;
  width:400px !important;
}

.settingsIcons{
  position:absolute; 
  top:0;
  right:0;
  width:0;

  overflow:hidden;

}

.display{

  width:300px;
}

.settingsIcon{
  float:right; 
  background:#418a95;
  color:#f6f3f7;
  height:50px;
  width:80px;
  padding-top:15px;
  box-sizing:border-box;
  text-align:center;
  overflow:hidden;
  transition:width 1s;
}

.settingsIcon:hover{
  background:#387881;
}

tr:nth-child(3){
   .settingsIcon{
    height:51px;
  }
}

.openIcon{
   width:80px; 
}
/* Table Stuff */
</style>
</head>
<body>
    <div id="holder" class="mCustomScrollbar light holder" data-mcs-theme="light-thick">
<div id="box"><h2 style="color: rgba(39, 40, 40, 0.33);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);">New Shifts</h2>
<table class="flatTable">
  <tr class="headingTr">
    <td>Date</td>
    <td>Location</td>
    <td>Time In</td>
    <td>Time Out</td>
    <td>Comments</td>
    <td></td>
  </tr>
<?php
$qry = "SELECT * FROM shifts WHERE filled='0' ORDER BY shift_count DESC LIMIT 5 ";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
while($row = mysqli_fetch_assoc($result)){
    $in = $row['IN1'];
		$hour = $row['IN1'];
		$minute = $row['IN2'];
		$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
		$hour2 = $row['OUT1'];
		$minute2 = $row['OUT2'];
		$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
	if ($in < 8) {
	echo (
	'<tr class="mshift">
	<td>'.$row['date'].'</td>
	<td>'.$row['location'].'</td>
	<td>'.$time_12_hour_IN.'</td>
	<td>'.$time_12_hour_OUT.'</td>
	<td>'.$row['additional'].'</td>
	<td class="controlTd">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			<span class="settingsIcon"><img src="http://i.imgur.com/UAdSFIg.png" alt="placeholder icon" /></span>
			<div class="settingsIcon"><img src="http://i.imgur.com/UAdSFIg.png" alt="placeholder icon" /></div>
		</div> 
	</td>
	</tr>'
	);
	}
	if ($in > 8 && $in < 16) {
	echo (
	'<tr class="ashift">
	<td>'.$row['date'].'</td>
	<td>'.$row['location'].'</td>
	<td>'.$time_12_hour_IN.'</td>
	<td>'.$time_12_hour_OUT.'</td>
	<td>'.$row['additional'].'</td>
	<td class="controlTd">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			<span class="settingsIcon"><img src="http://i.imgur.com/UAdSFIg.png" alt="placeholder icon" /></span>
			<div class="settingsIcon"><img src="http://i.imgur.com/UAdSFIg.png" alt="placeholder icon" /></div>
		</div> 
	</td>
	</tr>'
	);
	}
	if ($in > 16 && $in < 24) {
	echo (
	'<tr class="nshift">
	<td>'.$row['date'].'</td>
	<td>'.$row['location'].'</td>
	<td>'.$time_12_hour_IN.'</td>
	<td>'.$time_12_hour_OUT.'</td>
	<td>'.$row['additional'].'</td>
	<td class="controlTd">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			<span class="settingsIcon"><img src="http://i.imgur.com/UAdSFIg.png" alt="placeholder icon" /></span>
			<div class="settingsIcon"><img src="http://i.imgur.com/UAdSFIg.png" alt="placeholder icon" /></div>
		</div> 
	</td>
	</tr>'
	);
	}
}
?>

</table>
        </div>
    	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="./js/minified/jquery-1.11.0.min.js"><\/script>')</script>
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script>
		(function($){
			$(window).load(function(){
				$("#holder").mCustomScrollbar({
					theme:"minimal"
				});
				
			});
		})(jQuery);
	</script>
    <script>
$(".button").click(function () {
  $("#sForm").toggleClass("open");   
});

$(".controlTd").click(function () {
  $(this).children(".settingsIcons").toggleClass("display"); 
  $(this).children(".settingsIcon").toggleClass("openIcon"); 
});
	</script>
    <script>
map={}//I know most use an array, but the use of string indexes in arrays is questionable
onkeydown=onkeyup=function(e){
    e=e||event//to deal with IE
    map[e.keyCode]=e.type=='keydown'?true:false;
    if(map[17]&&map[16]&&map[85]){//CTRL+SHIFT+U
    alert('New Update');
            map = [];
    return false;
}else if(map[17]&&map[16]&&map[66]){//CTRL+SHIFT+B
    alert('Control Shift B');
        map = [];
    return false;
}else if(map[17]&&map[16]&&map[67]){//CTRL+SHIFT+C
    alert('Control Shift C');
        map = [];
    return false;
}
}
</script>
<script type="text/javascript">
$(document).ready(function () {
    $("#add").click(function () {
        //get input field values
        var location = $('select[name=location]').val();
		var caller = $('input[name=caller]').val();
		var gender = $('select[name=gender]').val();
		var date = $('input[name=date]').val();
        var IN1 = $('select[name=IN1]').val();
        var IN2 = $('select[name=IN2]').val();
        var OUT1 = $('select[name=OUT1]').val();
        var OUT2 = $('select[name=OUT2]').val();
        var INAP = $('select[name=INAP]').val();
        var OUTAP = $('select[name=OUTAP]').val();
        var additional = $('input[name=additional]').val();

        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
		if (result == "block") {
			proceed = false;
		}
        if (date == "") {
            $('input[name=date]').css('border-color', 'red');
            proceed = false;
        }
        if (caller == "") {
            $('input[name=caller]').css('border-color', 'red');
            proceed = false;
        }

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'location': location, 'caller': caller, 'gender': gender, 'date': date, 'IN1': IN1, 'IN2': IN2, 'OUT1': OUT1, 'OUT2': OUT2, 'INAP': INAP, 'OUTAP': OUTAP, 'additional': additional};

            //Ajax post data to server
            $.post('NewSPush.php', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {

                    presp = 'success';
					pmsg  = '' + response.text + '';

                    //reset values in all input fields
                    $('#shift input').val('');
                    $('#shift textarea').val('');
                }

				puno(""+pmsg+"",""+presp+"");	
            }, 'json');

        }
    });

    //reset previously set border colors and hide all message on .keyup()
    $("#shift input, #shift textarea").keyup(function () {
        $("#shift input, #shift textarea, #shift select").css('border-color', '');
    });

});
</script>
    </div>
</body>
</html>