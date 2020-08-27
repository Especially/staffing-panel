<?php 
	require_once('cFigure.php');	
	require_once('auth.php');	
	$type = $_SESSION['SESS_CONTROL_TYPE'];
	
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
if ($type == '3'){
	echo('<style>.display{width:450px!important;}</style>');
}
?>
    <h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);">Unfilled Shifts</h2>
<script src="../js/jquery.webui-popover.js"></script>
<script>
$('.whos_available').click( function(){
	$(this).webuiPopover({
                        title:'Who\'s Available',
						style:'inverse',
						cache:'false',
						width:'300',
						type:'async',
						closeable:'true',
                        url:'http://staffingpanel.x10.mx/available_check.php?shift_id='+$(this).attr('data-ID')+'&date='+$(this).attr('data-DATE')+'&in='+$(this).attr('data-TI')+'&homage=true&out='+$(this).attr('data-TO'),
                        content:function(data){
                            {data}
                            return data;
                        }
	});
});
$('.info').click( function(){
	$(this).webuiPopover({
                        title:'Recommendations',
						style:'inverse',
						cache:'false',
						width:'300',
						type:'async',
						closeable:'true',
                        url:'http://staffingpanel.x10.mx/recom.php?shift_id='+$(this).attr('data-ID')+'&location='+$(this).attr('data-location')+'&action=recommend',
                        content:function(data){
                            {data}
                            return data;
                        }
	});
});
$('.exclamation').click( function(){
	$(this).webuiPopover({
                        title:'Comments & Recommendations',
						style:'inverse',
						cache:'false',
						width:'300',
						type:'async',
						closeable:'true',
                        url:'http://staffingpanel.x10.mx/recom.php?shift_id='+$(this).attr('data-ID')+'&location='+$(this).attr('data-location')+'&action=exclamation',
                        content:function(data){
                            {data}
                            return data;
                        }
	});
});
</script>
    <table class="flatTable">
      <tr class="headingTr">
        <td>Date</td>
        <td>Location</td>
        <td>Caller</td>
        <td>Time In</td>
        <td>Time Out</td>
        <td></td>
      </tr>
      <?php
$qry = "SELECT * FROM shifts WHERE filled='0' AND cancelled='0' ORDER BY date ASC, IN1 ASC LIMIT 5";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
if(mysqli_num_rows($result)>0){
while($row = mysqli_fetch_assoc($result)){
    $in = $row['IN1'];
	$locode = $row['location'];
	$date = date("D M jS, Y", strtotime($row['date']));
		$hour = $row['IN1'];
		$minute = $row['IN2'];
		$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
		$hour2 = $row['OUT1'];
		$minute2 = $row['OUT2'];
		$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
		$filled = $row['filled'];
		$comments = $row['additional'];
		if ($comments == ''){
			$ir_type  = 'info';
			$ir_class = 'info';
		} else {
			$ir_type  = 'exclamation';
			$ir_class = 'exclamation blink_me';
		}
		if ($filled == '0'){
			$UFrow = ('<div class="settingsIcon" onclick="fillRow(&quot;'.$row['code'].'&quot;,&quot;fill&quot;)">Fill</div>');
		}
		if ($filled == '1'){
			$UFrow = ('<div class="settingsIcon" onclick="unfillRow(&quot;'.$row['code'].'&quot;,&quot;unfill&quot;)">Unfill</div>');
		}
			$cancelRow = ('<div class="settingsIcon" onclick="cancelRow(&quot;'.$row['code'].'&quot;,&quot;cancel&quot;)">Cancel</div>');
			$deleteDiv = ('<span class="settingsIcon" onclick="deleteRow(&quot;'.$row['code'].'&quot;)">Delete</span>');
			$editRow = ('<div class="settingsIcon" onclick="editRow(&quot;'.$row['code'].'&quot;,&quot;edit&quot;,&quot;'.$row['filled'].'&quot;)">Edit</div>');
	if ($type == '3'){
		$cancelRow = ('<div class="settingsIcon" onclick="cancelRow(&quot;'.$row['code'].'&quot;,&quot;cancel&quot;)">Cancel</div><span class="settingsIcon" onclick="deleteRow(&quot;'.$row['code'].'&quot;)">Delete</span>');
		$style = ('style="width: 450px;"');
	}
	if ($in <= 10) {
	echo (
	'<tr class="mshift" data-shift-id="'.$row['code'].'">
	<td title="'.$date.'"><span style="float:left;">'.$row['date'].'<div class="whos_available" data-ID="'.$row['code'].'" data-DATE="'.$row['date'].'" data-TI="'.$row['dt_1'].'" data-TO="'.$row['dt_2'].'"><i class="fa fa-question-circle"></i></div></span></td>
	<td><div class="info_recommend '.$ir_class.'" data-ID="'.$row['code'].'" data-location="'.$locode.'"><i class="fa fa-'.$ir_type.'-circle"></i></div>'.$row['name'].'</td>
	<td>'.$row['caller'].'</td>
	<td>'.$time_12_hour_IN.'</td>
	<td>'.$time_12_hour_OUT.'</td>
	<td class="controlTd">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			'.$cancelRow.'
			'.$editRow.'
			'.$UFrow.'
		</div> 
	</td>
	</tr>'
	);
	}
	if ($in >= 11 && $in <= 16) {
	echo (
	'<tr class="ashift" data-shift-id="'.$row['code'].'">
	<td title="'.$date.'"><span style="float:left;">'.$row['date'].'<div class="whos_available" data-ID="'.$row['code'].'" data-DATE="'.$row['date'].'" data-TI="'.$row['dt_1'].'" data-TO="'.$row['dt_2'].'"><i class="fa fa-question-circle"></i></div></span></td>
	<td><div class="info_recommend '.$ir_class.'" data-ID="'.$row['code'].'" data-location="'.$locode.'"><i class="fa fa-'.$ir_type.'-circle"></i></div>'.$row['name'].'</td>
	<td>'.$row['caller'].'</td>
	<td>'.$time_12_hour_IN.'</td>
	<td>'.$time_12_hour_OUT.'</td>
	<td class="controlTd">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			'.$cancelRow.'
			'.$editRow.'
			'.$UFrow.'
		</div> 
	</td>
	</tr>'
	);
	}
	if ($in > 16 && $in <= 23) {
	echo (
	'<tr class="nshift" data-shift-id="'.$row['code'].'">
	<td title="'.$date.'"><span style="float:left;">'.$row['date'].'<div class="whos_available" data-ID="'.$row['code'].'" data-DATE="'.$row['date'].'" data-TI="'.$row['dt_1'].'" data-TO="'.$row['dt_2'].'"><i class="fa fa-question-circle"></i></div></span></td>
	<td><div class="info_recommend '.$ir_class.'" data-ID="'.$row['code'].'" data-location="'.$locode.'"><i class="fa fa-'.$ir_type.'-circle"></i></div>'.$row['name'].'</td>
	<td>'.$row['caller'].'</td>
	<td>'.$time_12_hour_IN.'</td>
	<td>'.$time_12_hour_OUT.'</td>
	<td class="controlTd">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			'.$cancelRow.'
			'.$editRow.'
			'.$UFrow.'
		</div> 
	</td>
	</tr>'
	);
	}
}
}
else {
	echo('<tr><td colspan="8">No unfilled shifts found!</td></tr>');
}
?>
    </table>
      <script>
$(document).ready(function () {
$(".controlTd").click(function () {
  var span=$(this).children(".settingsIcons");
  span.toggleClass("display");
  span.children(".settingsIcon").toggleClass("openIcon"); 
});	
});
</script> 