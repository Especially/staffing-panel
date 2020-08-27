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

<title>Home</title>
<?php 
$floor = true;
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
<body class="mCustomScrollbar light" data-mcs-theme="minimal">
<div style="display:none;">
<input type="text" class="focused" value="">
</div>
<script>
/* JS File */

// Start Ready
$(document).ready(function() {  
	// Icon Click Focus
	$('div.icon').click(function(){
		$('input#search').focus();
	});

	// Live Search
	// On Search Submit and Get Results
	function search() {
		var query_value = $('input#search').val();
		$('b#search-string').html(query_value);
		if(query_value !== ''){
			$.ajax({
				type: "POST",
				url: "findr_search.php",
				data: { query: query_value },
				cache: false,
				success: function(html){
					$("ul#results").html(html);
				}
			});
		}return false;    
	}

	$("input#search").on("keyup", function(e) {
		// Set Timeout
		clearTimeout($.data(this, 'timer'));

		// Set Search String
		var search_string = $(this).val();

		// Do Search
		if (search_string == '') {
			$("ul#results").fadeOut();
			$('h4#results-text').fadeOut();
		}else{
			$("ul#results").fadeIn();
			$('h4#results-text').fadeIn();
			$(this).data('timer', setTimeout(search, 100));
		};
	});

});
$('#leftBox, .webui-popover').hover(function(ev){
    clearInterval(Refresh);
	console.log ('Cleared refresh on hover');
}, function(ev){
	AutoRefresh();
});
$(".shift-swap").click( function(){
	var tex = $("#holder #box h2").text();
	if (tex == "Add a New Shift"){
		$("#holder #box h2").text("Add a New Filled Shift");
		$(".new_shift").slideUp();
		$(".new_filled_shift").slideDown();
	}
	if (tex == "Add a New Filled Shift"){
		$("#holder #box h2").text("Add a New Shift");
		$(".new_filled_shift").slideUp();
		$(".new_shift").slideDown();
	}
});
function myVar(input){
	var myval = $(input).val();
	$(input).find("option[value=\""+myval+"\"]").attr("selected",true);
}
</script>
<div id="holder" data-mcs-theme="light-thick" class="root" data-title-location="Home - Always Care Staffing Panel" data-root-location="/Home">
<div class="center">  <!-- Start Center Div -->
<i class="fa fa-refresh shift-swap" style="font-size:12px;padding-left:3px;cursor:pointer;position:relative;left:0px;color:#FFF;"></i>
  <div id="box" data-location="new shifts" style="display:inline-block;">

    <h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);">Add a New Shift</h2>
<div class="new_shift" data-shift-count="1">
<input type="button" class="red remove" value="-" style="
    position: absolute;
    left: 0px;
    margin-top: 42px;
    width: 0px!important;
    border-radius: 50px;
    min-width: 35px;
	width:auto!important;
    display:none;
">
      <form class="nav" action="javascript:void(0);" id="shift">
        <table class="counterTable">
          <tr>
            <td><select name="location" id="location" onChange="myVar(this)">
                <option value="none">Location</option>
                <?php
$locnew = "SELECT * FROM location ORDER BY name";
$res = mysqli_query($GLOBALS["___mysqli_ston"], $locnew);
while($row1 = mysqli_fetch_assoc($res)){
	$type = $row1['is_type'];
	if($type=='false'){
	echo('<option value="'.$row1['code'].'">'.$row1['name'].'</option>');
	}
	if($type=='true'){
	echo('<option value="'.$row1['code'].'">'.$row1['name'].' ('.$row1['type'].' #'.$row1['type_number'].')</option>');
	}
}
?>
              </select></td>
            <td><input type="date" name="date" id="date" class="date" style="width:150px;"> <input type="date" name="date2" id="date2" class="date2" hidden /></td>
            <td><input type="text" name="caller" id="caller" style="width:150px;" placeholder="Caller (Optional)"></td>
            <td><select id="gender" name="gender" style="width:45px;" onChange="myVar(this)">
                <option value="O">*</option>
                <option value="F">F</option>
                <option value="M">M</option>
              </select></td>
          </tr>
        </table>
        <table class="counterTable">
          <tr>
            <td><select id="IN1" name="IN1" class="IN1" style="width:75px;" onChange="myVar(this)">
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
              </select></td>
            <td><div style="
    display: inline;
    color: white;  font-family: Helvetica, Arial, sans-serif;        text-shadow: 0 1px 0 #000;
">:</div></td>
            <td>
              <select id="IN2" name="IN2" class="IN2" style="width:50px;" onChange="myVar(this)">
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
              </select></td>
            <td><div style="
    display: inline;
    color: white;  font-family: Helvetica, Arial, sans-serif;        text-shadow: 0 1px 0 #000;
"></div></td>
            <td><select id="OUT1" name="OUT1" class="OUT1" style="width:75px;" onChange="myVar(this)">
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
              </select></td>
            <td><div style="
    display: inline;
    color: white;  font-family: Helvetica, Arial, sans-serif;        text-shadow: 0 1px 0 #000;
">:</div></td>
            <td><select id="OUT2" name="OUT2" class="OUT2" style="width:50px;" onChange="myVar(this)">
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
              </select></td>
            <td><input id="additional" name="additional" placeholder="Requested staff, etc. (Optional)" style="width:199px;"></td>
            <td><input type="button" class="blue duplicate" title="Add another shift" value="Duplicate" style="padding:9px!important;width:auto!important;"></td>
            <td><input type="button" class="add green-btn" id="add" value="Add" style="width:70px;"></button></td>
          </tr>
        </table>
      </form>
    </div> 

<!-- NEW FILLED SHIFT BLOCK -->
<div class="new_filled_shift" data-new-shift-count="1" style="display:none;">
<input type="button" class="red remove_fill" value="-" style="
    position: absolute;
    left: 0px;
    margin-top: 42px;
    width: 0px!important;
    border-radius: 50px;
    min-width: 35px;
	width:auto!important;
    display:none;
">
      <form class="nav" action="javascript:void(0);" id="shift">
        <table class="counterTable">
          <tr>
            <td><select name="employee" id="employee" onChange="myVar(this)">
                <option value="none">Employee</option>
                <?php
$employee = "SELECT * FROM employee ORDER BY sname";
$employeeres = mysqli_query($GLOBALS["___mysqli_ston"], $employee);
while($row3 = mysqli_fetch_assoc($employeeres)){
	echo('<option value="'.$row3['euid'].'">'.$row3['sname'].', '.$row3['fname'].'</option>');
}
?>
              </select></td>
            <td><select name="location" id="location" onChange="myVar(this)">
                <option value="none">Location</option>
                <?php
$locnew = "SELECT * FROM location ORDER BY name";
$res = mysqli_query($GLOBALS["___mysqli_ston"], $locnew);
while($row1 = mysqli_fetch_assoc($res)){
	$type = $row1['is_type'];
	if($type=='false'){
	echo('<option value="'.$row1['code'].'">'.$row1['name'].'</option>');
	}
	if($type=='true'){
	echo('<option value="'.$row1['code'].'">'.$row1['name'].' ('.$row1['type'].' #'.$row1['type_number'].')</option>');
	}
}
?>
              </select></td>
            <td><input type="date" name="date" id="date_fill" class="date_fill" style="width:150px;"> <input type="date" name="date2" id="date2_fill" class="date2_fill" hidden /></td>
          </tr>
        </table>
        <table class="counterTable">
          <tr>
            <td><input type="text" name="caller" id="caller" style="width:150px;" placeholder="Caller (Optional)"></td>
            <td><select id="gender" name="gender" style="width:45px;" onChange="myVar(this)">
                <option value="O">*</option>
                <option value="F">F</option>
                <option value="M">M</option>
              </select></td>
            <td><select id="IN1" name="IN1" class="IN1_fill" style="width:75px;" onChange="myVar(this)">
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
              </select></td>
            <td><div style="
    display: inline;
    color: white;  font-family: Helvetica, Arial, sans-serif;        text-shadow: 0 1px 0 #000;
">:</div></td>
            <td>
              <select id="IN2" name="IN2" class="IN2_fill" style="width:50px;" onChange="myVar(this)">
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
              </select></td>
            <td><div style="
    display: inline;
    color: white;  font-family: Helvetica, Arial, sans-serif;        text-shadow: 0 1px 0 #000;
"></div></td>
            <td><select id="OUT1" name="OUT1" class="OUT1_fill" style="width:75px;" onChange="myVar(this)">
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
              </select></td>
            <td><div style="
    display: inline;
    color: white;  font-family: Helvetica, Arial, sans-serif;        text-shadow: 0 1px 0 #000;
">:</div></td>
            <td><select id="OUT2" name="OUT2" class="OUT2_fill" style="width:50px;" onChange="myVar(this)">
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
              </select></td>
            <td><input type="button" class="blue duplicate_fill" title="Add another shift" value="Duplicate" style="padding:9px!important;width:auto!important;"></td>
            <td><input type="button" class="add_fill green-btn" id="add" value="Add" style="width:70px;"></button></td>
          </tr>
        </table>
      </form>
    </div> 
  </div>
</div> <!-- End Center Div -->
  <break></break>
  <div id="leftBox" data-location="Unfilled Home">
  
  </div>
<script>window.jQuery || document.write('<script src="./js/minified/jquery-1.11.0.min.js"><\/script>')</script> 
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script> 
<script tyle="text/javascript">
$('.duplicate').click(function() {
	$(".add").unbind();
	$(".remove").unbind();
	var form_id = $(this).closest('.new_shift').data('shift-count');
	var table_id = $(this).closest('.new_shift');
	$(this).closest('.new_shift').clone().attr('data-shift-count',form_id+1).appendTo('#box');
	$('div[data-shift-count="'+(form_id+1)+'"] .remove').fadeIn();
	$(this).fadeOut().remove();	
	redupe();
	create();
}); 
$('.duplicate_fill').click(function() {
	$(".add_fill").unbind();
	$(".remove_fill").unbind();
	var form_id = $(this).closest('.new_filled_shift').data('new-shift-count');
	var table_id = $(this).closest('.new_filled_shift');
	$(this).closest('.new_filled_shift').clone().attr('data-new-shift-count',form_id+1).appendTo('#box');
	$('div[data-new-shift-count="'+(form_id+1)+'"] .remove_fill').fadeIn();
	$(this).fadeOut().remove();	
	redupe_fill();
	create_fill();
}); 
function redupe(){
	$('.duplicate').click(function() {
	$(".add").unbind();
	$(".remove").unbind();
	var form_id = $(this).closest('.new_shift').data('shift-count');
	var table_id = $(this).closest('.new_shift');
	$(this).closest('.new_shift').clone().attr('data-shift-count',form_id+1).appendTo('#box');
	$('div[data-shift-count="'+(form_id+1)+'"] .remove').fadeIn();
	$(this).fadeOut().remove();	
	redupe();
	create();
	}); 
}
function redupe_fill(){
	$('.duplicate_fill').click(function() {
	$(".add_fill").unbind();
	$(".remove_fill").unbind();
	var form_id = $(this).closest('.new_filled_shift').data('new-shift-count');
	var table_id = $(this).closest('.new_filled_shift');
	$(this).closest('.new_filled_shift').clone().attr('data-new-shift-count',form_id+1).appendTo('#box');
	$('div[data-new-shift-count="'+(form_id+1)+'"] .remove_fill').fadeIn();
	$(this).fadeOut().remove();	
	redupe_fill();
	create_fill();
	}); 
}
</script>
  <script type="text/javascript">
$(document).ready(function () {
    //reset previously set border colors and hide all message on .keyup()
    $('#shift input,#shift textarea').keyup(function () {
        $('#shift input, #shift textarea, #shift select').css('border-color', '');
    }).change(function () {
		$('#shift select').css('border-color', '');
		});

});
function create() {
	$(".remove").click( function(){
		var scount = $(this).parents('.new_shift').data('shift-count');
		if (scount !== 1){
			$('div[data-shift-count="'+scount+'"] .duplicate').insertBefore('div[data-shift-count="'+(scount-1)+'"] .add');
			$(this).parents('.new_shift').fadeOut().remove();
		}
	});
    $(".add").click(function () {
		var add_btn = $(this);
		$(add_btn).prop("disabled","disabled");
		var scount = $(this).parents('.new_shift').data('shift-count');
        //get input field values
        var location = $('div[data-shift-count="'+scount+'"] select[name=location]').val();
		var caller = $('div[data-shift-count="'+scount+'"] input[name=caller]').val();
		var gender = $('div[data-shift-count="'+scount+'"] select[name=gender]').val();
		var date = $('div[data-shift-count="'+scount+'"] input[name=date]').val();
		var date2 = $('div[data-shift-count="'+scount+'"] input[name=date2]').val();
		var result = $('div[data-shift-count="'+scount+'"] #result').css('display');
        var IN1 = $('div[data-shift-count="'+scount+'"] select[name=IN1]').val();
        var IN2 = $('div[data-shift-count="'+scount+'"] select[name=IN2]').val();
        var OUT1 = $('div[data-shift-count="'+scount+'"] select[name=OUT1]').val();
        var OUT2 = $('div[data-shift-count="'+scount+'"] select[name=OUT2]').val();
        var additional = $('div[data-shift-count="'+scount+'"] input[name=additional]').val();
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (date == "") {
            $('div[data-shift-count="'+scount+'"] input[name=date]').css('border-color', 'red');
            proceed = false;
			$(add_btn).prop("disabled","");
        }
        if (location == "none") {
            $('div[data-shift-count="'+scount+'"] select[name=location]').css('border-color', 'red');
            proceed = false;
			$(add_btn).prop("disabled","");
        }
        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'location': location, 'date2': date2, 'caller': caller, 'gender': gender, 'date': date, 'IN1': IN1, 'IN2': IN2, 'OUT1': OUT1, 'OUT2': OUT2, 'additional': additional};

            //Ajax post data to server
            $.post('NewSPush.php', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
					$(add_btn).prop("disabled","");
					puno(""+pmsg+"",""+presp+"");
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';

					$(add_btn).prop("disabled","");
					$('div[data-shift-count="'+scount+'"] input[type=text]').val('');
					$('div[data-shift-count="'+scount+'"] select[name=location]').val('none');
					$('div[data-shift-count="'+scount+'"] select[name=gender]').val('O');
					$('div[data-shift-count="'+scount+'"] select[name=IN1]').val('00');
					$('div[data-shift-count="'+scount+'"] select[name=IN2]').val('00');
					$('div[data-shift-count="'+scount+'"] select[name=OUT1]').val('00');
					$('div[data-shift-count="'+scount+'"] select[name=OUT2]').val('00');
					puno(""+pmsg+"",""+presp+"");
					refreshTable();
					if (scount !== 1){
						$('div[data-shift-count="'+scount+'"] .duplicate').insertBefore('div[data-shift-count="'+(scount-1)+'"] .add');
						$('div[data-shift-count="'+scount+'"]').remove();
					}
                }
            }, 'json');

        }
    });
    //reset previously set border colors and hide all message on .keyup()
    $('#shift input,#shift textarea').keyup(function () {
        $('#shift input, #shift textarea, #shift select').css('border-color', '');
    })
	$('#shift select').change(function () {
		$('#shift select').css('border-color', '');
		});
$(".date").change(function(){
		var scount = $(this).parents('.new_shift').data('shift-count');
		var IN1 = $('div[data-shift-count="'+scount+'"] select[name=IN1]').val();
		var OUT1 = $('div[data-shift-count="'+scount+'"] select[name=OUT1]').val();
		var date = $('div[data-shift-count="'+scount+'"] .date').val();
		if (IN1 >= 16 && OUT1 <= 12){
			var initial = $('div[data-shift-count="'+scount+'"] .date').val();
			var d1 = new Date(initial);
			var now = new Date(d1.getUTCFullYear(), d1.getUTCMonth(), d1.getUTCDate(),  d1.getUTCHours(), d1.getUTCMinutes(), d1.getUTCSeconds());
			var today = now.getTime();
			var nextday = new Date(today+86400000);
			var tomorrow = nextday.toDateInputValue();
			$('div[data-shift-count="'+scount+'"] .date2').val(tomorrow);
		}
		else {
			$('div[data-shift-count="'+scount+'"] .date2').val(date);
		}
});
$('.IN1').change(function(){
	var scount = $(this).parents('.new_shift').data('shift-count');
	var IN1 = $('div[data-shift-count="'+scount+'"] select[name=IN1]').val();
	if (IN1 <= 18){
		$('div[data-shift-count="'+scount+'"] select[name="OUT1"] option').removeAttr("hidden");
		$('div[data-shift-count="'+scount+'"] select[name="OUT1"] option:lt('+IN1+')').attr("hidden","hidden");
		$('div[data-shift-count="'+scount+'"] select[name="OUT1"] option[hidden!="hidden"]').first().attr("selected","selected");;		
	} else {
		$('div[data-shift-count="'+scount+'"] select[name="OUT1"] option').removeAttr("hidden");	
	}
	var OUT1 = $('div[data-shift-count="'+scount+'"] select[name=OUT1]').val();
	var initial = $('div[data-shift-count="'+scount+'"] .date').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('div[data-shift-count="'+scount+'"]  .date2').val(tomorrow);
	}
});
$('.OUT1').change(function(){
	var scount = $(this).parents('.new_shift').data('shift-count');
	var IN1 = $('div[data-shift-count="'+scount+'"] select[name=IN1]').val();
	var OUT1 = $('div[data-shift-count="'+scount+'"] select[name=OUT1]').val();
	var initial = $('div[data-shift-count="'+scount+'"] .date').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('div[data-shift-count="'+scount+'"] .date2').val(tomorrow);
	}
	if (OUT1 >= 13 && OUT1 <= 24){
		var thisday = $('div[data-shift-count="'+scount+'"] .date').val();
		$('div[data-shift-count="'+scount+'"] .date2').val(thisday);
	}
});
};
function create_fill() {
	$(".remove_fill").click( function(){
		var scount = $(this).parents('.new_filled_shift').data('new-shift-count');
		if (scount !== 1){
			$('div[data-new-shift-count="'+scount+'"] .duplicate_fill').insertBefore('div[data-new-shift-count="'+(scount-1)+'"] .add_fill');
			$(this).parents('.new_filled_shift').remove();
		}
	});
    $(".add_fill").click(function () {
		var add_btn = $(this);
		$(add_btn).prop("disabled","disabled");
		var scount = $(this).parents('.new_filled_shift').data('new-shift-count');
        //get input field values
        var euid       = $('div[data-new-shift-count="'+scount+'"] select[name=employee]').val();
        var location   = $('div[data-new-shift-count="'+scount+'"] select[name=location]').val();
		var caller     = $('div[data-new-shift-count="'+scount+'"] input[name=caller]').val();
		var gender     = $('div[data-new-shift-count="'+scount+'"] select[name=gender]').val();
		var date 	   = $('div[data-new-shift-count="'+scount+'"] input[name=date]').val();
		var date2	   = $('div[data-new-shift-count="'+scount+'"] input[name=date2]').val();
		var result	   = $('div[data-new-shift-count="'+scount+'"] #result').css('display');
        var IN1 	   = $('div[data-new-shift-count="'+scount+'"] select[name=IN1]').val();
        var IN2 	   = $('div[data-new-shift-count="'+scount+'"] select[name=IN2]').val();
        var OUT1 	   = $('div[data-new-shift-count="'+scount+'"] select[name=OUT1]').val();
        var OUT2 	   = $('div[data-new-shift-count="'+scount+'"] select[name=OUT2]').val();
        var additional = '';
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (date == "") {
            $('div[data-new-shift-count="'+scount+'"] input[name=date]').css('border-color', 'red');
            proceed = false;
			$(add_btn).prop("disabled","");
        }
        if (euid == "none") {
            $('div[data-new-shift-count="'+scount+'"] select[name=employee]').css('border-color', 'red');
            proceed = false;
			$(add_btn).prop("disabled","");
        }
        if (location == "none") {
            $('div[data-new-shift-count="'+scount+'"] select[name=location]').css('border-color', 'red');
            proceed = false;
			$(add_btn).prop("disabled","");
        }
        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'action':'new_fill','euid':euid,'location': location, 'date2': date2, 'caller': caller, 'gender': gender, 'date': date, 'IN1': IN1, 'IN2': IN2, 'OUT1': OUT1, 'OUT2': OUT2, 'additional': additional};

            //Ajax post data to server
            $.post('NewSPush.php', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
					$(add_btn).prop("disabled","");
					puno(""+pmsg+"",""+presp+"");
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';

                    //reset values in all input fields
				    refreshTable();
					$(add_btn).prop("disabled","");
					$('div[data-new-shift-count="'+scount+'"] input[type=text]').val('');
					$('div[data-new-shift-count="'+scount+'"] select').val('none');
					$('div[data-new-shift-count="'+scount+'"] select[name=gender]').val('O');
					$('div[data-new-shift-count="'+scount+'"] select[name=IN1]').val('00');
					$('div[data-new-shift-count="'+scount+'"] select[name=IN2]').val('00');
					$('div[data-new-shift-count="'+scount+'"] select[name=OUT1]').val('00');
					$('div[data-new-shift-count="'+scount+'"] select[name=OUT2]').val('00');
					puno(""+pmsg+"",""+presp+"");
					if (scount !== 1){
						$('div[data-shift-count="'+scount+'"] .duplicate').insertBefore('div[data-shift-count="'+(scount-1)+'"] .add');
						$('div[data-new-shift-count="'+scount+'"]').remove();
					}
                }
            }, 'json');

        }
    });
    //reset previously set border colors and hide all message on .keyup()
    $('#shift input,#shift textarea').keyup(function () {
        $('#shift input, #shift textarea, #shift select').css('border-color', '');
    })
	$('#shift select').change(function () {
		$('#shift select').css('border-color', '');
		});
$(".date_fill").change(function(){
		var scount = $(this).parents('.new_filled_shift').data('new-shift-count');
		var IN1 = $('div[data-new-shift-count="'+scount+'"] select[name=IN1]').val();
		var OUT1 = $('div[data-new-shift-count="'+scount+'"] select[name=OUT1]').val();
		var date = $('div[data-new-shift-count="'+scount+'"] .date_fill').val();
		if (IN1 >= 16 && OUT1 <= 12){
			var initial = $('div[data-new-shift-count="'+scount+'"] .date_fill').val();
			var d1 = new Date(initial);
			var now = new Date(d1.getUTCFullYear(), d1.getUTCMonth(), d1.getUTCDate(),  d1.getUTCHours(), d1.getUTCMinutes(), d1.getUTCSeconds());
			var today = now.getTime();
			var nextday = new Date(today+86400000);
			var tomorrow = nextday.toDateInputValue();
			$('div[data-new-shift-count="'+scount+'"] .date2_fill').val(tomorrow);
		}
		else {
			$('div[data-new-shift-count="'+scount+'"] .date2_fill').val(date);
		}
});
$('.IN1_fill').change(function(){
	var scount = $(this).parents('.new_filled_shift').data('new-shift-count');
	var IN1 = $('div[data-new-shift-count="'+scount+'"] select[name=IN1]').val();
	if (IN1 <= 18){
		$('div[data-new-shift-count="'+scount+'"] select[name="OUT1"] option').removeAttr("hidden");
		$('div[data-new-shift-count="'+scount+'"] select[name="OUT1"] option:lt('+IN1+')').attr("hidden","hidden");
		$('div[data-new-shift-count="'+scount+'"] select[name="OUT1"] option[hidden!="hidden"]').first().attr("selected","selected");;		
	} else {
		$('div[data-shift-count="'+scount+'"] select[name="OUT1"] option').removeAttr("hidden");	
	}
	var OUT1 = $('div[data-new-shift-count="'+scount+'"] select[name=OUT1]').val();
	var initial = $('div[data-new-shift-count="'+scount+'"] .date_fill').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('div[data-new-shift-count="'+scount+'"]  .date2_fill').val(tomorrow);
	}
});
$('.OUT1_fill').change(function(){
	var scount = $(this).parents('.new_filled_shift').data('new-shift-count');
	var IN1 = $('div[data-new-shift-count="'+scount+'"] select[name=IN1]').val();
	var OUT1 = $('div[data-new-shift-count="'+scount+'"] select[name=OUT1]').val();
	var initial = $('div[data-new-shift-count="'+scount+'"] .date_fill').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('div[data-new-shift-count="'+scount+'"] .date2_fill').val(tomorrow);
	}
	if (OUT1 >= 13 && OUT1 <= 24){
		var thisday = $('div[data-new-shift-count="'+scount+'"] .date_fill').val();
		$('div[data-new-shift-count="'+scount+'"] .date2_fill').val(thisday);
	}
});
};
</script> 
<script type="text/javascript">
    $(document).ready(function(){
      AutoRefresh();
    });
    $('.new_shift').ready(function(){
	  create();
	  create_fill();
    });

    function AutoRefresh(){
		if (!AutoRAlive){
			AutoRAlive = true;
			$("div[data-location='Unfilled Home']").load(''+root+'unfilled_5.php', function(){
			 Refresh = setInterval(refreshTable, 5000);
        });
		} else {
			clearInterval(Refresh);
			AutoRAlive = false;
			AutoRefresh();
			console.log('AutoRAlive Refreshed Successfully');
		}
    }
    function refreshTable(){
		if(AutoRAlive){
        $("div[data-location='Unfilled Home']").load(''+root+'unfilled_5.php');
		}
    }
</script> 
<script>
document.getElementById('date').value = new Date().toDateInputValue();
document.getElementById('date2').value = new Date().toDateInputValue();
document.getElementById('date_fill').value = new Date().toDateInputValue();
document.getElementById('date2_fill').value = new Date().toDateInputValue();
</script> 
</div>
</body>
</html>