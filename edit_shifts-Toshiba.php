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
if(!isset ($_GET['code']) || !isset ($_GET['action'])) {
echo ('Variables not set!'.$_GET['code'].'Ok'.$_GET['action'].'No');
}
$action = filter_var($_GET["action"], FILTER_SANITIZE_STRING);
$fill = filter_var($_GET["filled"], FILTER_SANITIZE_STRING);
$widget_wa = filter_var($_GET["widget"], FILTER_SANITIZE_STRING);
$bypass = filter_var($_GET["bp"], FILTER_SANITIZE_STRING);
$euid = filter_var($_GET["euid"], FILTER_SANITIZE_STRING);
if ($action == 'fill' && $bypass == false && $euid !== ''){
		$code = filter_var($_GET["code"], FILTER_SANITIZE_STRING);
		// Perform staff check and toggle dialog box
		$qry = "SELECT * FROM shifts WHERE code = '$code'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if ($result){
			if(mysqli_num_rows($result) > 0){
					while($row1 = mysqli_fetch_assoc($result)){
						$new_in = $row1['dt_1'];
						$nin 	= strtotime($new_in);
						$shift_start = $row1['date'];
						$same_check = 'SELECT * FROM shifts WHERE (dt_2 LIKE "%'.$shift_start.'%") AND euid="'.$euid.'" AND filled = "1"';
						$same_result = @mysqli_query($GLOBALS["___mysqli_ston"], $same_check);
						if(mysqli_num_rows($same_result) > 0){
							// There is a shift that ends on the same day that this shift starts
							while($row2 = mysqli_fetch_assoc($same_result)){
								$old_out    = $row2['dt_2'];
								$old_to		= strtotime($old_out);
								$old_in		= $row2['dt_1'];
								$old_ti		= strtotime($old_in);
								$staff_nom	= split(", ",$row2['ename']);
								$staff_name = ''.$staff_nom[1].'_'.$staff_nom[0].'';
								// Calculate time difference. If difference <= 7 hours emit alert, else proceed
								$hours = ceil(((strtotime($new_in) - strtotime($old_out))/(60*60)));
								if ($hours <= 8){
									// Emit alert
									die(
"<script>
	$('#overlay').after(\"<div class='dialog_holder' style='display:none;'></div>\");
	$('.dialog_holder').load(''+root+'dialog.php?action=shift_conflict&en=$staff_name&in=$old_ti&out=$old_to&nin=$nin&sc=$code&euid=$euid');
	$('.dialog_holder').fadeIn();
	$('#dialogboxholder').remove();
</script>");
								} else {
									// Proceed
									die(
									"<script>
										console.log('$hours');
									</script>");
								}
							}
						}
					}
			}
		}
}
if ($action=='edit') {
	$title = 'Edit Shift';
}
if ($action=='fill') {
	$title = 'Fill Shift';
}
if ($action=='unfill') {
	$title = 'Unfill Shift';
}
if ($action=='cancel') {
	$title = 'Cancel Shift';
}
if ($action=='delete') {
	$title = 'Delete Shift';
}

	?>
<html>

<head>

<title><?php echo($title) ?></title>
<?php $widget = true; include('includes.php'); ?>
<meta name="description" content="Robots rule.txt">
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
document.title = "<?php echo($title) ?>";
</script>
<style>
.icon.warning.pulseWarning {
width: 80px;
height: 80px;
border: 4px solid rgb(255,155,0);
border-radius: 50%;
margin: 20px auto;
position: relative;
}
.icon.warning.pulseWarning {
border-color: rgb(255,155,0);
}
span.body.pulseWarningIns {
position: absolute;
width: 5px;
height: 47px;
left: 50%;
top: 10px;
border-radius: 2px;
margin-left: -2px;
background-color: rgb(255,155,0);
}
span.dot.pulseWarningIns {
position: absolute;
width: 7px;
height: 7px;
border-radius: 50%;
margin-left: -3px;
left: 50%;
bottom: 10px;
background-color: rgb(255,155,0);
}
.icon.error.animateErrorIcon {
border-color: #F27474;
width: 80px;
height: 80px;
background: none;
border: 4px solid #F27474;
border-radius: 50%;
margin: 20px auto;
position: relative;
}
span.x-mark.animateXMark {
position: relative;
display: block;
}
span.line.left {
-webkit-transform: rotate(45deg);
transform: rotate(45deg);
left: 17px;
position: absolute;
height: 5px;
width: 47px;
background-color: #F27474;
display: block;
top: 37px;
border-radius: 2px;
}
span.line.right {
position: absolute;
height: 5px;
width: 47px;
background-color: #F27474;
display: block;
top: 37px;
border-radius: 2px;
-webkit-transform: rotate(-45deg);
transform: rotate(-45deg);
right: 16px;
}
.icon.success.animate {
	display: block;
	width: 80px;
	height: 80px;
	border: 4px solid #A5DC86;
	border-radius: 50%;
	margin: 20px auto;
	position: relative;
	border-color: #A5DC86;
	padding: 0;
	background: none;
}
span.line.tip.animateSuccessTip {
	width: 25px;
	left: 14px;
	top: 46px;
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
	width: 47px;
	right: 8px;
	top: 38px;
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
	width: 80px;
	height: 80px;
	border: 4px solid rgba(165, 220, 134, 0.2);
	border-radius: 50%;
	position: absolute;
	left: -4px;
	top: -4px;
	z-index: 2;
}

</style>
</head>

<body>
<div id="dialogbox">
<div id="dialogboxhead"><?php echo($title); ?></div>
<div id="dialogboxbody" <?php if(($action == 'cancel') || ($action == 'unfill')){echo('style="height:261px;"');} ?>>
<?php
if ($action=='edit'){
$code = filter_var($_GET["code"], FILTER_SANITIZE_STRING);
if(isset ($_GET['code'])) {
		$qry = "SELECT * FROM shifts WHERE code = '$code'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if ($result){
			if(mysqli_num_rows($result) > 0){
					while($row1 = mysqli_fetch_assoc($result)){
						$dt_2 = $row1['dt_2'];
						$date2 = date('Y-m-d', strtotime($dt_2));
					echo('
<script id="selected_vals">
$("document").ready(function(){
	$("#shift_edit #location option[value=\''.$row1['location'].'\']").attr("selected","selected");
	$("#shift_edit #gender2 option[value=\''.$row1['gender'].'\']").attr("selected","selected");
	$("#shift_edit #IN1 option[value=\''.$row1['IN1'].'\']").attr("selected","selected");
	$("#shift_edit #IN2 option[value=\''.$row1['IN2'].'\']").attr("selected","selected");
	$("#shift_edit #OUT1 option[value=\''.$row1['OUT1'].'\']").attr("selected","selected");
	$("#shift_edit #OUT2 option[value=\''.$row1['OUT2'].'\']").attr("selected","selected");
	');
	if($fill=='1'){
		echo('	$("#shift_edit #employee option[value=\''.$row1['euid'].'\']").attr("selected","selected");');
	}
	echo('
});
</script>
<form class="nav holder" action="javascript:void(0);" name="shift_edit" id="shift_edit">
        <div id="tab_holder" class="counterTable">
          <div id="tab_items" >
            <div id="tab_items"><div id="result"></div></div>
          </div>
          <div id="tab_items" >
            <div id="tab_items" ><select name="location" id="location" style="height:31px;">');
$locnew = "SELECT * FROM location ORDER BY name";
$res = mysqli_query($GLOBALS["___mysqli_ston"], $locnew);
while($row2 = mysqli_fetch_assoc($res)){
	$type = $row2['is_type'];
	if($type=='false'){
	echo('<option value="'.$row2['code'].'">'.$row2['name'].'</option>');
	}
	if($type=='true'){
	echo('<option value="'.$row2['code'].'">'.$row2['name'].' ('.$row2['type'].' #'.$row2['type_number'].')</option>');
	}
}
echo('
              </select></div>
            <div id="tab_items" ><input type="date" name="date" id="date" style="width:150px;" value="'.$row1['date'].'"> <input type="date" name="date2" id="date2" value="'.$date2.'" hidden /></div>
            <div id="tab_items" ><input type="text" name="caller" id="caller" style="width:150px;height:31px;" placeholder="Caller" value="'.$row1['caller'].'"></div>
            <div id="tab_items" ><select id="gender2" name="gender" style="width:45px;">
				<option value="F">F</option>
                <option value="M">M</option>
                <option value="O">*</option>
              </select></div>
            <div id="tab_items" ><select id="IN1" name="IN1" style="width:50px;"> 
                <option value="00">12 AM</option>
                <option value="01">1 AM</option>
                <option value="02">2 AM</option>
                <option value="03">3 AM</option>
                <option value="04">4 AM</option>
                <option value="05">5 AM</option>
                <option value="06">6 AM</option>
                <option value="07">7 AM</option>
                <option value="08">8 AM</option>
                <option value="09">9 AM</option>
                <option value="10">10 AM</option>
                <option value="11">11 AM</option>
                <option value="12">12 PM</option>
                <option value="13">1 PM</option>
                <option value="14">2 PM</option>
                <option value="15">3 PM</option>
                <option value="16">4 PM</option>
                <option value="17">5 PM</option>
                <option value="18">6 PM</option>
                <option value="19">7 PM</option>
                <option value="20">8 PM</option>
                <option value="21">9 PM</option>
                <option value="22">10 PM</option>
                <option value="23">11 PM</option>
              </select></div>
            <div id="tab_items" ><div id="tab_items"  style="
    display: inline;color: white;  font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;height: 56px;
line-height: 46px;
">:</div></div>
            <div id="tab_items" >
              <select id="IN2" name="IN2" style="width:50px;">
                <optgroup label="Quick">
                <option value="00">00</option>
                <option value="15">15</option>
                <option value="30">30</option>
                </optgroup>
                <optgroup label="Slow">
                <option value="00">00</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
                <option value="32">32</option>
                <option value="33">33</option>
                <option value="34">34</option>
                <option value="33">35</option>
                <option value="36">36</option>
                <option value="37">37</option>
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
                <option value="45">45</option>
                <option value="46">46</option>
                <option value="47">47</option>
                <option value="48">48</option>
                <option value="49">49</option>
                <option value="50">50</option>
                <option value="51">51</option>
                <option value="52">52</option>
                <option value="53">53</option>
                <option value="54">54</option>
                <option value="53">55</option>
                <option value="56">56</option>
                <option value="57">57</option>
                <option value="58">58</option>
                <option value="59">59</option>
                </optgroup>
              </select></div>
			  <div id="tab_items" ><div id="tab_items"  style="
    display: inline;color: white;  font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;height: 56px;
line-height: 46px;
">to</div></div>
            <div id="tab_items" ><div id="tab_items"  style="
    display: inline;color: white;  font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;height: 56px;
line-height: 46px;"></div></div>
            <div id="tab_items" ><select id="OUT1" name="OUT1" style="width:50px;">
                <option value="00">12 AM</option>
                <option value="01">1 AM</option>
                <option value="02">2 AM</option>
                <option value="03">3 AM</option>
                <option value="04">4 AM</option>
                <option value="05">5 AM</option>
                <option value="06">6 AM</option>
                <option value="07">7 AM</option>
                <option value="08">8 AM</option>
                <option value="09">9 AM</option>
                <option value="10">10 AM</option>
                <option value="11">11 AM</option>
                <option value="12">12 PM</option>
                <option value="13">1 PM</option>
                <option value="14">2 PM</option>
                <option value="15">3 PM</option>
                <option value="16">4 PM</option>
                <option value="17">5 PM</option>
                <option value="18">6 PM</option>
                <option value="19">7 PM</option>
                <option value="20">8 PM</option>
                <option value="21">9 PM</option>
                <option value="22">10 PM</option>
                <option value="23">11 PM</option>
              </select></div>
            <div id="tab_items" ><div id="tab_items"  style="
    display: inline;color: white;  font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;height: 56px;
line-height: 46px;
">:</div></div>
            <div id="tab_items" ><select id="OUT2" name="OUT2" style="width:50px;">
                <optgroup label="Quick">
                <option value="00">00</option>
                <option value="15">15</option>
                <option value="30">30</option>
                </optgroup>
                <optgroup label="Slow">
                <option value="00">00</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
                <option value="32">32</option>
                <option value="33">33</option>
                <option value="34">34</option>
                <option value="33">35</option>
                <option value="36">36</option>
                <option value="37">37</option>
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
                <option value="45">45</option>
                <option value="46">46</option>
                <option value="47">47</option>
                <option value="48">48</option>
                <option value="49">49</option>
                <option value="50">50</option>
                <option value="51">51</option>
                <option value="52">52</option>
                <option value="53">53</option>
                <option value="54">54</option>
                <option value="53">55</option>
                <option value="56">56</option>
                <option value="57">57</option>
                <option value="58">58</option>
                <option value="59">59</option>
                </optgroup>
              </select></div>
            <div id="tab_items" ><input id="additional" name="additional" type="text" placeholder="Requested staff, etc. (Optional)" value="'.$row1['additional'].'"  style="height:31px;"></div>
			');
			if ($fill=='1'){ 
				echo(' <div id="tab_items" ><select name="employee" id="employee" style="height:31px;">
							  <option value="none">Employee</option>');
				$employee = "SELECT * FROM employee ORDER BY sname";
				$employeeres = mysqli_query($GLOBALS["___mysqli_ston"], $employee);
				while($row3 = mysqli_fetch_assoc($employeeres)){
					echo('<option value="'.$row3['euid'].'">'.$row3['sname'].', '.$row3['fname'].'</option>');
				}echo('</select></div>');
			}
										}
				}
			else {
			// If Shift Code Doesn't Exist (Less than 0 Values in Table)
				echo ('This shift code doesnt exist!');
			}
		}
		else {
			header("location: /login");
		}
}
}
if ($action=='unfill'){
$code = filter_var($_GET["code"], FILTER_SANITIZE_STRING);
if(isset ($_GET['code'])) {
		$qry = "SELECT * FROM shifts WHERE code = '$code'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if ($result){
			if(mysqli_num_rows($result) > 0){
					while($row1 = mysqli_fetch_assoc($result)){
			$hour = $row1['IN1'];
			$minute = $row1['IN2'];
			$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
			$hour2 = $row1['OUT1'];
			$minute2 = $row1['OUT2'];
			$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
			$date = date("D M jS, Y", strtotime($row1['date']));
			$employee = $row1['ename'];
			$euid = $row1['euid'];
			if($employee !== ''){
					$e_get = "SELECT * FROM employee WHERE euid='$euid' ";
					$result = mysqli_query($GLOBALS["___mysqli_ston"], $e_get);
					while($row6 = mysqli_fetch_assoc($result)){
						$is = $row6['is_alternate'];
						$phone = $row6['phone'];
						$alt = $row6['alternate'];
						if($is == 'true'){
							$numbers = "$phone or $alt";
						}
						if($is == 'false'){
							$numbers = "$phone";
						}
					}
				$alert = "<br/>Please contact <b>$employee</b> at <b>$numbers</b> to alert them that their shift has been removed.";
			}
					echo('
<div class="dialog-msg-one">
<div class="nav holder" action="javascript:void(0);" name="shift_edit" id="shift_edit">
        <div id="tab_holder" class="counterTable">
          <div class="icon warning pulseWarning" style="display: block;"> <span class="body pulseWarningIns"></span> <span class="dot pulseWarningIns"></span> </div>
		  <div id="tab_items" >
            <div id="tab_items"><div id="result"></div></div>
          </div>
          <div id="tab_items" >
            <div id="tab_items">Are you sure that you want to remove '.$row1['ename'].' from the shift at '.$row1['name'].' on '.$date.' from '.$time_12_hour_IN.' to '.$time_12_hour_OUT.'?</div>
</div>
</div>
</div></div>
<div class="dialog-msg-two" style="display:none;">
<div class="nav holder" action="javascript:void(0);" name="shift_edit" id="shift_edit">
<div class="icon success animate"> <span class="line tip animateSuccessTip"></span> <span class="line long animateSuccessLong"></span> <div class="placeholder"></div>  </div>
            	<div id="tab_items">The shift has successfully been unfilled!<br/>'.$alert.'</div>');
										}
				}
			else {
			// If Shift Code Doesn't Exist (Less than 0 Values in Table)
				echo ('This shift code doesnt exist!');
			}
		}
		else {
			header("location: /login");
		}
}
}
if ($action=='cancel'){
$code = filter_var($_GET["code"], FILTER_SANITIZE_STRING);
if(isset ($_GET['code'])) {
		$qry = "SELECT * FROM shifts WHERE code = '$code'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if ($result){
			if(mysqli_num_rows($result) > 0){
					while($row1 = mysqli_fetch_assoc($result)){
			$hour = $row1['IN1'];
			$minute = $row1['IN2'];
			$time_12_hour_IN  = date("g:i A", strtotime("$hour:$minute"));
			$hour2 = $row1['OUT1'];
			$minute2 = $row1['OUT2'];
			$time_12_hour_OUT  = date("g:i A", strtotime("$hour2:$minute2"));
			$date = date("D M jS, Y", strtotime($row1['date']));
			$employee = $row1['ename'];
			$euid = $row1['euid'];
			if($employee !== ''){
					$e_get = "SELECT * FROM employee WHERE euid='$euid' ";
					$result = mysqli_query($GLOBALS["___mysqli_ston"], $e_get);
					while($row6 = mysqli_fetch_assoc($result)){
						$is = $row6['is_alternate'];
						$phone = $row6['phone'];
						$alt = $row6['alternate'];
						if($is == 'true'){
							$numbers = "$phone or $alt";
						}
						if($is == 'false'){
							$numbers = "$phone";
						}
					}
				$alert = "<br/>Please contact <b>$employee</b> at <b>$numbers</b> to alert them that their shift has been cancelled.";
			}
					echo('
<div class="dialog-msg-one">
	<div class="nav holder" action="javascript:void(0);">
		<div class="icon error animateErrorIcon" style="display: block;"><span class="x-mark animateXMark"><span class="line left"></span><span class="line right"></span></span></div>
	        <div id="tab_holder" class="counterTable">
		        <div id="tab_items">
		            <div id="tab_items">
						<div id="result">
						</div>
					</div>
		        </div>
					<div id="tab_items">
						<div id="tab_items" class="dialog">Are you sure that you want to cancel the shift at '.$row1['name'].' on '.$date.' from '.$time_12_hour_IN.' to '.$time_12_hour_OUT.'?</div>
					</div>
			</div>
</div></div>
<div class="dialog-msg-two" style="display:none;">
<form class="nav holder" action="javascript:void(0);" name="shift_cancel" id="shift_cancel">
          <div class="icon warning pulseWarning" style="display: block;"> <span class="body pulseWarningIns"></span> <span class="dot pulseWarningIns"></span> </div>
            	<div id="tab_items">'.$_SESSION['SESS_CONTROL_FIRST'].', please specify who cancelled the shift and the reason for doing so.</div>
				<div id="tab_items" ><input type="text" name="cancel_caller" id="cancel_caller" style="width:150px;height:31px;" placeholder="Cancel Caller"></div>
				<div id="tab_items" ><input type"text" id="cancel_reason" name="cancel_reason" placeholder="Leave blank if not specified" style="height:31px;"></textarea></div>
</div>
<div class="dialog-msg-three" style="display:none;">
<div class="nav holder" action="javascript:void(0);" name="shift_edit" id="shift_edit">
<div class="icon success animate"> <span class="line tip animateSuccessTip"></span> <span class="line long animateSuccessLong"></span> <div class="placeholder"></div>  </div>
            	<div id="tab_items">The shift has successfully been cancelled!<br/>'.$alert.'</div>
						');
										}
				}
			else {
			// If Shift Code Doesn't Exist (Less than 0 Values in Table)
				echo ('This shift code doesnt exist!');
			}
		}
		else {
			header("location: /login");
		}
}
}
if ($action=='fill'){
$code = filter_var($_GET["code"], FILTER_SANITIZE_STRING);
if(isset ($_GET['code'])) {
		$qry = "SELECT * FROM shifts WHERE code = '$code' AND filled = '0'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if ($result){
			if(mysqli_num_rows($result) > 0){
					while($row1 = mysqli_fetch_assoc($result)){
					echo('
<form class="nav holder" action="javascript:void(0);" name="shift_fill" id="shift_fill">
        <div id="tab_holder" class="counterTable">
          <div id="tab_items" >
            <div id="tab_items"><div id="result"></div></div>
          </div>
          <div id="tab_items" >
            <div id="tab_items" ><select name="location" id="location" style="height:31px;" disabled="disabled">
                <option value="'.$row1['location'].'" selected="selected">'.$row1['name'].'</option>
              </select></div>
            <div id="tab_items" ><input type="date" name="date" id="date" style="width:150px;height:31px;" value="'.$row1['date'].'" disabled="disabled"></div>
            <div id="tab_items" ><input type="text" name="caller" id="caller" style="width:150px;height:31px;" placeholder="Caller" value="'.$row1['caller'].'" disabled="disabled"></div>
            <div id="tab_items" ><select id="gender2" name="gender" style="width:45px;" disabled="disabled">
                <option value="'.$row1['gender'].'" selected="selected">'.$row1['gender'].'</option>
				<option value="F">F</option>
                <option value="M">M</option>
                <option value="O">*</option>
              </select></div>
            <div id="tab_items" ><select id="IN1" name="IN1" style="width:50px;" disabled="disabled"> 
				<option value="'.$row1['IN1'].'" selected="selected">'.$row1['IN1'].'</option>
              </select></div>
            <div id="tab_items" ><div id="tab_items"  style="
    display: inline;color: #848484;  font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;height: 56px;
line-height: 46px;
">:</div></div>
            <div id="tab_items" >
              <select id="IN2" name="IN2" style="width:50px;" disabled="disabled">
				<option value="'.$row1['IN2'].'" selected="selected">'.$row1['IN2'].'</option>
              </select></div>
			  <div id="tab_items" ><div id="tab_items"  style="
    display: inline;color: #848484;  font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;height: 56px;
line-height: 46px;
">to</div></div>
            <div id="tab_items" ><div id="tab_items"  style="
    display: inline;color: #848484;  font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;height: 56px;
line-height: 46px;"></div></div>
            <div id="tab_items" ><select id="OUT1" name="OUT1" style="width:50px;" disabled="disabled">
				<option value="'.$row1['OUT1'].'" selected="selected">'.$row1['OUT1'].'</option>
              </select></div>
            <div id="tab_items" ><div id="tab_items"  style="
    display: inline;color: #848484;  font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;height: 56px;
line-height: 46px;
">:</div></div>
            <div id="tab_items" ><select id="OUT2" name="OUT2" style="width:50px;" disabled="disabled">
				<option value="'.$row1['OUT2'].'" selected="selected">'.$row1['OUT2'].'</option>
              </select></div>
            <div id="tab_items" ><input id="additional" name="additional" placeholder="Requested staff, etc. (Optional)" value="'.$row1['additional'].'" style="height:28px;" disabled="disabled"></div>
			  <div id="tab_items" ><select name="employee" id="employee" style="height:31px;">
			  <option value="none">Employee</option>');
$employee = "SELECT * FROM employee ORDER BY sname";
$employeeres = mysqli_query($GLOBALS["___mysqli_ston"], $employee);
while($row3 = mysqli_fetch_assoc($employeeres)){
	echo('<option value="'.$row3['euid'].'">'.$row3['sname'].', '.$row3['fname'].'</option>');
}
echo('</select></div>');
if ($widget_wa == true){
	echo("
	<script>
	$(document).ready( function(){
	$('#employee option[value=\"$euid\"]').attr('selected', 'selected');
});
</script>
	");
}
										}
				}
			else {
			// If Shift Code Doesn't Exist (Less than 0 Values in Table)
				echo ('This shift code doesnt exist!');
			}
		}
		else {
			header("location: /login");
		}
}
}
?>
</div>
</div>
</div>
<div id="dialogboxfoot">
<?php 
if ($action=='edit') {
echo('<div id="tab_items" style="float:right;"><input type="button" class="dialog-button" id="edit" value="Edit"></div>
<div id="tab_items" style="float:right;"><input type="button" class="dialog-button cancel" id="cancel" value="Cancel"></div>
          </div>
        </div>
      </form>
    </center>');
}
if ($action=='fill') {
echo('<div id="tab_items" style="float:right;"><input type="button" class="dialog-button" id="fill" value="Fill"></div>
<div id="tab_items" style="float:right;"><input type="button" class="dialog-button cancel" id="cancel" value="Cancel"></div>
          </div>
        </div>
      </form>
    </center>');
}
if ($action=='unfill') {
echo('<div id="tab_items" style="float:right;"><input type="button" class="dialog-button dialog-btn-one" value="Unfill"><input type="button" style="display:none;" class="dialog-button dialog-btn-two cancel" id="cancel" value="Okay"></div>
<div id="tab_items" style="float:right;"><input type="button" class="dialog-button cancel" id="cancel" value="Cancel"></div>
          </div>
        </div>
      </form>
    </center>');
}
if ($action=='cancel') {
echo('<div id="tab_items" style="float:right;height:55px;overflow:hidden;"><input type="button" style="width:96px;" class="dialog-button dialog-btn-one" id="confirm" value="Yes"><input type="button" style="width:96px;display:none;" class="dialog-button dialog-btn-two" id="cancel_shift" value="Cancel Shift"><input type="button" style="width:96px;display:none;" class="dialog-button dialog-btn-three cancel" id="cancel" value="Okay"></div>
<div id="tab_items" style="float:right;"><input type="button" class="dialog-button cancel" id="cancel" value="Cancel"></div>
          </div>
        </div>
      </form>
    </center>');
}
	?>
</div>
<script>
var action = '<?php echo($action); ?>';

if (!(action == 'cancel' || action == 'unfill')){
[].slice.call(gender2.options)
  .map(function(a){
    if(this[a.innerText]){ 
      if(!a.selected) gender2.removeChild(a); 
    } else { 
      this[a.innerText]=1; 
    } 
  },{}); 
}
  </script>
  <script type="text/javascript">
$(document).ready(function () {
    $("#edit").click(function () {
        //get input field values
        var location = $('form[name="shift_edit"] select[name=location]').val();
		var caller = $('form[name="shift_edit"] input[name=caller]').val();
		var gender = $('form[name="shift_edit"] select[name=gender]').val();
		var date = $('form[name="shift_edit"] input[name=date]').val();
		var date2 = $('form[name="shift_edit"] input[name=date2]').val();
		var result = $('form[name="shift_edit"] #result').css('display');
		<?php if($fill=='1'){
			echo "var euid = $('form[name=\"shift_edit\"] select[name=employee]').val();";
			}; ?>
        
		var IN1 = $('form[name="shift_edit"] select[name=IN1]').val();
        var IN2 = $('form[name="shift_edit"] select[name=IN2]').val();
        var OUT1 = $('form[name="shift_edit"] select[name=OUT1]').val();
        var OUT2 = $('form[name="shift_edit"] select[name=OUT2]').val();
        var additional = $('form[name="shift_edit"] input[name=additional]').val();

        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (date == "") {
            $('form[name="shift_edit"] input[name=date]').css('border-color', 'red');
            proceed = false;
        }
        if (caller == "") {
            $('form[name="shift_edit"] input[name=caller]').css('border-color', 'red');
            proceed = false;
        }

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'location': location, <?php if($fill=='1'){ echo "'euid': euid,"; }; ?> 'code': <?php echo('"'.$code.'"'); ?>, 'caller': caller, 'date2': date2, 'gender': gender, 'date': date, 'IN1': IN1, 'IN2': IN2, 'OUT1': OUT1, 'OUT2': OUT2, 'additional': additional};

            //Ajax post data to server
            $.post(''+root+'UpdateFusion.php?action=<?php echo($action); ?>&fill=<?php echo($fill); ?>', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
                    //reset values in all input fields
                    var a = $("#v_cal").css('display');
                    var b = $("#widget_ep").css('display');
                    if ((a == 'block' || b == 'block')){
                    $('#dialogboxholder').delay(3000).fadeOut().dequeue();
                    $('#dialogboxholder').delay(1000).queue(function () {
                        $(this).html('');
                        $(this).fadeOut();
                        $(this).remove();
                    }).dequeue();
                    }
                    else {
                $('#overlay, #dialogboxholder').delay(3000).fadeOut().dequeue();
                    $('#dialogboxholder').delay(1000).queue(function () {
                        $(this).html('');
                        $(this).fadeOut();
                        $(this).remove();
                    }).dequeue();
                    }
				}
				puno(""+pmsg+"",""+presp+"");
            }, 'json');

        }
    });
    $("#unfill").click(function () {
        //get input field values
        var proceed = true;
        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'code': <?php echo('"'.$code.'"'); ?>};

            //Ajax post data to server
            $.post(''+root+'UpdateFusion.php?action=<?php echo($action); ?>', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
                    //reset values in all input fields
						$('.dialog-msg-one').toggle('slide',{direction:'up'});
						$('.dialog-msg-two').toggle('slide',{direction:'down'});
						$('.dialog-btn-one').toggle('slide',{direction:'left'});
						$('.dialog-btn-two').toggle('slide',{direction:'right'});
                }
				refreshTable();
				puno(""+pmsg+"",""+presp+"");
            }, 'json');

        }
    });
});
</script> 
  <script type="text/javascript">
$(document).ready(function () {
    $("#fill").click(function () {
        //get input field values
        var euid = $('form[name="shift_fill"] select[name=employee]').val();

        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'euid': euid, 'code': <?php echo('"'.$code.'"'); ?>};

            //Ajax post data to server
            $.post(''+root+'UpdateFusion.php?action=<?php echo($action); ?>&filled=<?php echo($fill); ?>', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
                    //reset values in all input fields
                    var a = $("#v_cal").css('display');
                    var b = $("#widget_ep").css('display');
                    if ((a == 'block' || b == 'block')){
                    $('#dialogboxholder').delay(3000).fadeOut().dequeue();
                    $('#dialogboxholder').delay(1000).queue(function () {
                        $(this).html('');
                        $(this).fadeOut();
                        $(this).remove();
                    }).dequeue();
                    }
                    else {
                $('#overlay, #dialogboxholder').delay(3000).fadeOut().dequeue();
                    $('#dialogboxholder').delay(1000).queue(function () {
                        $(this).html('');
                        $(this).fadeOut();
                        $(this).remove();
                    }).dequeue();
                    }
				}
				puno(""+pmsg+"",""+presp+"");
            }, 'json');

        }
    });
});
$("#shift_edit #date").change(function(){
		var IN1 = $('#shift_edit select[name=IN1]').val();
		var OUT1 = $('#shift_edit select[name=OUT1]').val();
		var date = $('#shift_edit #date').val();
		if (IN1 >= 16 && OUT1 <= 12){
			var initial = $('#shift_edit #date').val();
			var d1 = new Date(initial);
			var now = new Date(d1.getUTCFullYear(), d1.getUTCMonth(), d1.getUTCDate(),  d1.getUTCHours(), d1.getUTCMinutes(), d1.getUTCSeconds());
			var today = now.getTime();
			var nextday = new Date(today+86400000);
			var tomorrow = nextday.toDateInputValue();
			$('#shift_edit #date2').val(tomorrow);
		}
		else {
			$('#shift_edit #date2').val(date);
		}
});
$('#shift_edit #IN1').change(function(){
	var IN1 = $('#shift_edit select[name=IN1]').val();
	if (IN1 <= 18){
		$('#shift_edit select[name="OUT1"] option').removeAttr("hidden");
		$('#shift_edit select[name="OUT1"] option:lt('+IN1+')').attr("hidden","hidden");
		$('#shift_edit select[name="OUT1"] option[hidden!="hidden"]').first().attr("selected","selected");	
	} else {
		$('#shift_edit select[name="OUT1"] option').removeAttr("hidden");	
	}
	var OUT1 = $('#shift_edit select[name=OUT1]').val();
	var initial = $('#shift_edit #date').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('#shift_edit #date2').val(tomorrow);
	}
});
$('#shift_edit #OUT1').change(function(){
	var IN1 = $('#shift_edit select[name=IN1]').val();
	var OUT1 = $('#shift_edit select[name=OUT1]').val();
	var initial = $('#shift_edit date').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('#shift_edit #date2').val(tomorrow);
	}
});
$('#shift_edit #OUT1').change(function(){
	var IN1 = $('#shift_edit select[name=IN1]').val();
	var OUT1 = $('#shift_edit select[name=OUT1]').val();
	var initial = $('#shift_edit #date').val();
	if (OUT1 >= 13 && OUT1 <= 24){
		var thisday = $('#date').val();
		$('#shift_edit #date2').val(thisday);
	}
});
$('.dialog-btn-one').click(function() {
//	if (action == 'cancel'){
		$('.dialog-msg-one').toggle('slide',{direction:'up'});
		$('.dialog-msg-two').toggle('slide',{direction:'down'});
		$('.dialog-btn-one').toggle('slide',{direction:'left'});
		$('.dialog-btn-two').toggle('slide',{direction:'right'});
//	}
});
$('.dialog-btn-two').click(function() {
//		if (action == 'cancel'){
    var reason = $('form[name="shift_cancel"] input[name=cancel_reason]').val();
	var caller = $('form[name="shift_cancel"] input[name=cancel_caller]').val();
        var proceed = true;
        if (caller == "") {
            $('form[name="shift_cancel"] input[name=cancel_caller]').css('border-color', 'red');
            proceed = false;
        }
        if (reason == "") {
            reason = "Unknown";
        }
        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'reason': reason, 'code': <?php echo('"'.$code.'"'); ?>, 'caller': caller};

            //Ajax post data to server
            $.post(''+root+'UpdateFusion.php?action=<?php echo($action); ?>', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
                    //reset values in all input fields
			  $('.dialog-msg-two').toggle('slide',{direction:'up'});
			  $('.dialog-msg-three').toggle('slide',{direction:'down'});
		   	  $('.dialog-btn-two').toggle('slide',{direction:'left'});
			  $('.dialog-btn-three').toggle('slide',{direction:'right'});
			  $('.dialogboxholder').delay(3000).queue(function() {
				  $(this).html('');
				  }).dequeue();
                }
            }, 'json');

        }
//		}
    });
    $('.cancel').each(function () {
        $(this).click(function () {
			var a = $("#v_cal").css('display');
			var b = $("#widget_ep").css('display');
			if ((a == 'block' || b == 'block')){
            $('#dialogboxholder').delay(3000).fadeOut().dequeue();
            $('#dialogboxholder').delay(1000).queue(function () {
                $(this).html('');
				$(this).fadeOut();
				$(this).remove();
            }).dequeue();
			}
			else {
		$('#overlay, #dialogboxholder').delay(3000).fadeOut().dequeue();
            $('#dialogboxholder').delay(1000).queue(function () {
                $(this).html('');
				$(this).fadeOut();
				$(this).remove();
            }).dequeue();
			}
        });
    });
</script> 
  </body>
  </html>