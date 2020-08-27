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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Who's Available</title>
<?php 	require_once('includes.php'); ?>
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
</script>
</head>
<body>
<div id="holder" class="holder">
<div id="wid_wa_controls">
<form>
<input type="date" id="date" name="date" />
<input type="date" name="date2" id="date2" hidden />
<select id="IN1" name="IN1" style="width:75px;">
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
              </select>
<div style="display: inline;color: white;font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;">:</div>
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
              </select>
<select id="OUT1" name="OUT1" style="width:75px;">
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
              </select>
              <div style="display: inline;color: white;  font-family: Helvetica, Arial, sans-serif;text-shadow: 0 1px 0 #000;">:</div>
<select id="OUT2" name="OUT2" style="width:50px;">
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
              </select>
</form>
</div>
    <div id="wid_wa_controls" data-location="widget_wa">
    
    </div>
<script>
	$("#date").change(function(){
		var IN1 = $('select[name=IN1]').val();
		var OUT1 = $('select[name=OUT1]').val();
		var date = $('#date').val();
		var date2 = $('#date2').val();
		if (IN1 >= 16 && OUT1 <= 12){
			var initial = $('#date').val();
			var d1 = new Date(initial);
			var now = new Date(d1.getUTCFullYear(), d1.getUTCMonth(), d1.getUTCDate(),  d1.getUTCHours(), d1.getUTCMinutes(), d1.getUTCSeconds());
			var today = now.getTime();
			var nextday = new Date(today+86400000);
			var tomorrow = nextday.toDateInputValue();
			$('#date2').val(tomorrow);
		}
		else {
			$('#date2').val(date);
		}
		var IN1 = $('#IN1').val();
		var IN2 = $("#IN2").val();
		var OUT1 = $('#OUT1').val();
		var OUT2 = $("#OUT2").val();
		$("div[data-location='widget_wa']").load('available_check.php?date='+date+'&date2='+date2+'&s='+IN1+'&s2='+IN2+'&e='+OUT1+'&e2='+OUT2+'');
	}
	);
	$("#IN1").change(function(){
		var date = $('#date').val();
		var date2 = $('#date2').val();
		var IN1 = $('#IN1').val();
		var IN2 = $("#IN2").val();
		var OUT1 = $('#OUT1').val();
		var OUT2 = $("#OUT2").val();
		$("div[data-location='widget_wa']").load('available_check.php?date='+date+'&date2='+date2+'&s='+IN1+'&s2='+IN2+'&e='+OUT1+'&e2='+OUT2+'');
	}
	);
	$("#IN2").change(function(){
		var date = $('#date').val();
		var date2 = $('#date2').val();
		var IN1 = $('#IN1').val();
		var IN2 = $("#IN2").val();
		var OUT1 = $('#OUT1').val();
		var OUT2 = $("#OUT2").val();
		$("div[data-location='widget_wa']").load('available_check.php?date='+date+'&date2='+date2+'&s='+IN1+'&s2='+IN2+'&e='+OUT1+'&e2='+OUT2+'');
	}
	);
	$("#OUT1").change(function(){
		var date = $('#date').val();
		var date2 = $('#date2').val();
		var IN1 = $('#IN1').val();
		var IN2 = $("#IN2").val();
		var OUT1 = $('#OUT1').val();
		var OUT2 = $("#OUT2").val();
		$("div[data-location='widget_wa']").load('available_check.php?date='+date+'&date2='+date2+'&s='+IN1+'&s2='+IN2+'&e='+OUT1+'&e2='+OUT2+'');
	}
	);
	$("#OUT2").change(function(){
		var date = $('#date').val();
		var date2 = $('#date2').val();
		var IN1 = $('#IN1').val();
		var IN2 = $("#IN2").val();
		var OUT1 = $('#OUT1').val();
		var OUT2 = $("#OUT2").val();
		$("div[data-location='widget_wa']").load('available_check.php?date='+date+'&date2='+date2+'&s='+IN1+'&s2='+IN2+'&e='+OUT1+'&e2='+OUT2+'');
	}
	);
$('#IN1').change(function(){
	var IN1 = $('select[name=IN1]').val();
	var OUT1 = $('select[name=OUT1]').val();
	var initial = $('#date').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('#date2').val(tomorrow);
	}
});
$('#OUT1').change(function(){
	var IN1 = $('select[name=IN1]').val();
	var OUT1 = $('select[name=OUT1]').val();
	var initial = $('#date').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('#date2').val(tomorrow);
	}
});
$('#OUT1').change(function(){
	var IN1 = $('select[name=IN1]').val();
	var OUT1 = $('select[name=OUT1]').val();
	var initial = $('#date').val();
	if (OUT1 >= 13 && OUT1 <= 24){
		var thisday = $('#date').val();
		$('#date2').val(thisday);
	}
});
</script> 

<script>
document.getElementById('date').value = new Date().toDateInputValue();
document.getElementById('date2').value = new Date().toDateInputValue();
</script> 
</div>
</body>
</html>