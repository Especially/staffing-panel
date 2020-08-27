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
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
</script>
<style>
.qt_ns_form input:not([type='button']), .qt_ns_form select {
	margin:0px!important;
	max-width:193px!important;
	border: 1px solid #4A4A4A!important;
	background-color: transparent!important;
}
</style>
<p style="margin: 1px;font-weight: bold;color: white;text-shadow: 1px 1px 0 rgb(0, 0, 0);">New Shift:</p>
<div id="holder" class ="holder qt_ns_form" style="text-align:left;border:none;background-color:transparent;">
      <form action="javascript:void(0);" id="quick_shift" name="quick_shift">
        <table class="counterTable">
          <tr>
            <td colspan="8"><div id="result" style="display:none;"></div></td>
          </tr>
          <tr>
            <td><select name="location" id="location">
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
	echo('<option value="'.$row1['code'].'">'.$row1['name'].' (#'.$row1['type_number'].')</option>');
	}
}
?>
              </select></td>
              </tr>
              <tr>
            <td><input type="date" name="date" id="date" style="width:150px;"> <input type="date" name="date2" id="date2" hidden /></td>
            </tr>
            <tr>
            <td><input type="text" name="caller" id="caller" style="width:150px;" placeholder="Caller"></td>
            </tr>
          </tr>
          <tr>
            <td><select id="gender" name="gender" style="width:45px;">
                <option value="F">F</option>
                <option value="M">M</option>
                <option value="O">*</option>
              </select></td>
              </tr>
              <tr>
            <td><select id="IN1" name="IN1" style="width:75px;">
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
              </select><div style="
    display: inline;
    color: white;  font-family: Helvetica, Arial, sans-serif;        text-shadow: 0 1px 0 #000;
">:</div>
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
              </select></td>
              </tr>
<tr>
            <td><select id="OUT1" name="OUT1" style="width:75px;">
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
              </select><div style="
    display: inline;
    color: white;  font-family: Helvetica, Arial, sans-serif;        text-shadow: 0 1px 0 #000;
">:</div><select id="OUT2" name="OUT2" style="width:50px;">
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
              </tr>
              <tr>
            <td><input id="additional" name="additional" placeholder="Requested staff, etc. (Optional)"></textarea></td>
             </tr>
             <tr>
            <td><input type="button" id="q_add" value="Add" style="width:70px;"></button></td>
          </tr>
        </table>
      </form>
      </div>
  <script type="text/javascript">
$(document).ready(function () {
    $("#q_add").click(function () {
        //get input field values
        var location = $('form[name="quick_shift"] select[name=location]').val();
		var caller = $('form[name="quick_shift"] input[name=caller]').val();
		var gender = $('form[name="quick_shift"] select[name=gender]').val();
		var date = $('form[name="quick_shift"] input[name=date]').val();
		var date2 = $('form[name="quick_shift"] input[name=date2]').val();
		var result = $('form[name="quick_shift"]  #result').css('display');
        var IN1 = $('form[name="quick_shift"] select[name=IN1]').val();
        var IN2 = $('form[name="quick_shift"] select[name=IN2]').val();
        var OUT1 = $('form[name="quick_shift"] select[name=OUT1]').val();
        var OUT2 = $('form[name="quick_shift"] select[name=OUT2]').val();
        var additional = $('form[name="quick_shift"] input[name=additional]').val();
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
		if (result == "block") {
			proceed = false;
		}
        if (date == "") {
            $('form[name="quick_shift"] input[name=date]').css('cssText','border-color: red!important');
            proceed = false;
        }
//        if (caller == "") {
//            $('form[name="quick_shift"] input[name=caller]').css('cssText','border-color: red!important');
//            proceed = false;
//        }

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
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';

                    //reset values in all input fields
                    $('#quick_shift input:not(#quick_shift #date,#quick_shift #date2,#quick_shift #caller,#quick_shift #q_add)').val('');
                    $('#quick_shift textarea').val('');
                }
				puno(""+pmsg+"",""+presp+"");
            }, 'json');

        }
    });

    //reset previously set border colors and hide all message on .keyup()
    $("#quick_shift input, #shift textarea").keyup(function () {
        $("#quick_shift input, #quick_shift textarea, #quick_shift select").css('border-color', '');
    }).change(function () {
		$("#quick_shift select").css('border-color', '');
		});

});
$("form[name='quick_shift'] #date").change(function(){
		var IN1 = $('form[name="quick_shift"] select[name=IN1]').val();
		var OUT1 = $('form[name="quick_shift"] select[name=OUT1]').val();
		var date = $('form[name="quick_shift"] #date').val();
		if (IN1 <= 18){
			$('form[name="quick_shift"] select[name=OUT1] option').removeAttr("hidden");
			$('form[name="quick_shift"] select[name=OUT1] option:lt('+IN1+')').attr("hidden","hidden");
			$('form[name="quick_shift"] select[name=OUT1] option[hidden!="hidden"]').first().attr("selected","selected");;		
		} else {
			$('form[name="quick_shift"] select[name=OUT1] option').removeAttr("hidden");	
		}
		if (IN1 >= 16 && OUT1 <= 12){
			var initial = $('form[name="quick_shift"] #date').val();
			var d1 = new Date(initial);
			var now = new Date(d1.getUTCFullYear(), d1.getUTCMonth(), d1.getUTCDate(),  d1.getUTCHours(), d1.getUTCMinutes(), d1.getUTCSeconds());
			var today = now.getTime();
			var nextday = new Date(today+86400000);
			var tomorrow = nextday.toDateInputValue();
			$('form[name="quick_shift"] #date2').val(tomorrow);
		}
		else {
			$('form[name="quick_shift"] #date2').val(date);
		}
});
$('form[name="quick_shift"] #IN1').change(function(){
	var IN1 = $('form[name="quick_shift"] select[name=IN1]').val();
	var OUT1 = $('form[name="quick_shift"] select[name=OUT1]').val();
	var initial = $('form[name="quick_shift"] #date').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('form[name="quick_shift"] #date2').val(tomorrow);
	}
});
$('form[name="quick_shift"] #OUT1').change(function(){
	var IN1 = $('form[name="quick_shift"] select[name=IN1]').val();
	var OUT1 = $('form[name="quick_shift"] select[name=OUT1]').val();
	var initial = $('form[name="quick_shift"] #date').val();
	if (IN1 >= 16 && OUT1 <= 12){
		var date = new Date(initial);
		var now = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		var today = now.getTime();
		var nextday = new Date(today+86400000);
		var tomorrow = nextday.toDateInputValue();
		$('form[name="quick_shift"] #date2').val(tomorrow);
	}
});
$('form[name="quick_shift"] #OUT1').change(function(){
	var IN1 = $('form[name="quick_shift"] select[name=IN1]').val();
	var OUT1 = $('form[name="quick_shift"] select[name=OUT1]').val();
	var initial = $('form[name="quick_shift"] #date').val();
	if (OUT1 >= 13 && OUT1 <= 24){
		var thisday = $('form[name="quick_shift"] #date').val();
		$('form[name="quick_shift"] #date2').val(thisday);
	}
});
</script> 

<script>
document.getElementById('date').value = new Date().toDateInputValue();
document.getElementById('date2').value = new Date().toDateInputValue();
</script> 