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
if(!isset ($_GET['code']) || !isset ($_GET['edit'])) {
echo ('Variables not set!');
}
$edit = filter_var($_GET["edit"], FILTER_SANITIZE_STRING);
if ($edit=='location') {
	$title = 'Update Location';
	$image = 'url(../img/misc/NewLocation.jpg)';
}
if ($edit=='employee') {
	$title = 'Update Employee';
	$image = 'url(../img/misc/NewEmployee.jpg)';
}

	?>
    <html>
<head>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<?php $widget = true; include('includes.php'); ?>
<link rel="stylesheet" type="text/css" href="./css/Xufax.css">
<style>
#tab_items {
	max-height:50px;	
}
</style>
</head>
<body>
<div id="dialogbox">
<div id="dialogboxhead"><?php echo($title); ?></div>
<div id="dialogboxbody" style="background-image: <?php echo($image); ?>;background-attachment: fixed;background-position: 90% 90%;background-size: cover;">
<?php
if ($edit=='location'){
$code = filter_var($_GET["code"], FILTER_SANITIZE_STRING);
if(isset ($_GET['code'])) {
		$qry = "SELECT * FROM location WHERE code='$code'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if ($result){
			if(mysqli_num_rows($result) > 0){
					while($row1 = mysqli_fetch_assoc($result)){
						$is_additional = $row1['is_additional'];
						$is_alternate = $row1['is_alternate'];
						$is_type = $row1['is_type'];
					echo('
    <div id="holder" style="position:relative">
<form class ="nav holder" id="location_form" name="location_form" action="javascript:void(0);">
    <fieldset id="tab_holder" style="width:450px;border:none;">
        <div id="tab_items">
		<input type="text" name="name" id="name" placeholder="Location Name" value="'.$row1['name'].'" />
        </div>        
        <div id="tab_items">
        <input type="text" style="width:130px;" name="number" id="number" placeholder="Phone Number" value="'.$row1['phone'].'"/>
		</div>
        <div id="tab_items">
        <input type="text" name="street" id="street" placeholder="123 Address Lane" value="'.$row1['street'].'" />
        </div>
        
        <div id="tab_items">
        <input type="text" name="postal" id="postal" placeholder="X5X 5X5" onBlur="checkPostal(postal)" style="width:75px;text-transform:uppercase;" value="'.$row1['postal'].'" />
        </div>

        <div id="tab_items">
<select name="city" id="city" class="city" style="width:auto;">
							<option value="'.$row1['city'].'" selected="selected">'.$row1['city'].'</option>
							<option value="City">City</option>
							<optgroup class="main" label="Main cities"><option value="Barrie">Barrie</option><option value="Hamilton">Hamilton</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Mississauga">Mississauga</option><option value="Oakville">Oakville</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Toronto">Toronto</option><option value="Windsor">Windsor</option></optgroup>
							<optgroup class="all" label="All cities"><option value="Ajax">Ajax</option><option value="Arnprior">Arnprior</option><option value="Aurora">Aurora</option><option value="Barrie">Barrie</option><option value="Barry&#39;s Bay">Barry&#39;s Bay</option><option value="Belleville">Belleville</option><option value="Bowmanville">Bowmanville</option><option value="Bracebridge">Bracebridge</option><option value="Brampton">Brampton</option><option value="Brantford">Brantford</option><option value="Brockville">Brockville</option><option value="Burlington">Burlington</option><option value="Cambridge">Cambridge</option><option value="Casselman">Casselman</option><option value="Chelmsford">Chelmsford</option><option value="Cobourg">Cobourg</option><option value="Collingwood">Collingwood</option><option value="Cornwall">Cornwall</option><option value="Dundas">Dundas</option><option value="East York">East York</option><option value="Etobicoke">Etobicoke</option><option value="Gananoque">Gananoque</option><option value="Georgetown">Georgetown</option><option value="Gloucester">Gloucester</option><option value="Guelph">Guelph</option><option value="Hamilton">Hamilton</option><option value="Huntsville">Huntsville</option><option value="Kanata">Kanata</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Milton">Milton</option><option value="Mississauga">Mississauga</option><option value="Napanee">Napanee</option><option value="Nepean">Nepean</option><option value="Newmarket">Newmarket</option><option value="North Bay">North Bay</option><option value="North York">North York</option><option value="Oakville">Oakville</option><option value="Orangeville">Orangeville</option><option value="Orillia">Orillia</option><option value="Orleans">Orleans</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Owen Sound">Owen Sound</option><option value="Perth">Perth</option><option value="Peterborough">Peterborough</option><option value="Pickering">Pickering</option><option value="Picton">Picton</option><option value="Port Hope">Port Hope</option><option value="Renfrew">Renfrew</option><option value="Richmond Hill">Richmond Hill</option><option value="Sarnia">Sarnia</option><option value="Sault Ste. Marie">Sault Ste. Marie</option><option value="Scarborough">Scarborough</option><option value="South Porcupine">South Porcupine</option><option value="St. Catharines">St. Catharines</option><option value="St. Thomas">St. Thomas</option><option value="Stouffville">Stouffville</option><option value="Sturgeon Falls">Sturgeon Falls</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Tillsonburg">Tillsonburg</option><option value="Timmins">Timmins</option><option value="Toronto">Toronto</option><option value="Trenton">Trenton</option><option value="Val Caron">Val Caron</option><option value="Whitby">Whitby</option><option value="Windsor">Windsor</option><option value="Woodbridge">Woodbridge</option><option value="York">York</option></optgroup>
						</select>
        </div>
        
        <div id="tab_items">
        <input type="text" name="majint" id="majint" placeholder="S1/S2" value="'.$row1['intersection'].'"/>
        </div>
    </fieldset>

	        <div id="tab_items" style="right:0px;position:absolute;top:0px;">
        <label for="subu">
        <input type="checkbox" name="subu" id="subu" class="checkbox1" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;box-shadow:none;border:none;"'); if($is_type=='false'){
																																																echo(''); }
																																															 if ($is_type=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_type=='') {
																																																echo('');}
 echo(' />
        </label>
		</div>
		
		
		<div id="tab_items" style="right:0px;position:absolute;top:50px;">
        <label for="alter">
        <input type="checkbox" name="alter" id="alter" class="checkbox2" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;box-shadow:none;border:none;"'); if($is_alternate=='false'){
																																																echo(''); }
																																															 if ($is_alternate=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_alternate=='') {
																																																echo('');}
 echo(' />
        </label>
		</div>   
		
		<div id="tab_items" style="right:0px;position:absolute;top:100px;">
        <label for="add">
        <input type="checkbox" name="add" id="add" class="checkbox3" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;box-shadow:none;border:none;"'); if($is_additional=='false'){
																																																echo(''); }
																																															 if ($is_additional=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_additional=='') {
																																																echo('');}
 echo(' />
        </label>
		</div>
	
		
		<div class="flyout_1" style="position:fixed;left:550px;top:60px;">
	     <div id="subloc" style="width:0px;overflow:hidden;display:none;">
        <label for="type">
        <select id="type" name="type" class="select" style="width:75px;">
			<option value="'.$row1['type'].'" selected="selected">'.$row1['type'].'</option>
        	<option value="None">None</option>
        	<option value="Unit">Unit</option>
            <option value="Appt">Appartment</option>
            <option value="Floor">Floor</option>
        </select>
        </label>
        <label for="tnum">
        <input type="number" name="tnum" style="width:80px;" id="tnum" placeholder="If Unit 43, put 43" value="'.$row1['type_number'].'" />
        </label>
        </div>
		</div>
		
		<div class="flyout_2" style="position:fixed;left:550px;top:110px;">
		<div id="alt" style="width:0px;overflow:hidden;display:none;">
        <label for="alternate">
        <input type="text" name="alternate" id="alternate" placeholder="Alternate Phone Number" value="'.$row1['alternate'].'"/>
        </label>
        </div>
		</div>
		
		<div class="flyout_3" style="position:fixed;left:550px;top:150px;">
		<div id="comm" style="width:0px;overflow:hidden;display:none;">
        <label for="additional">
        <textarea name="additional" style="padding:5px;" id="additional" placeholder="Additional information... Use proper text formatting!" value="'.$row1['comments'].'">'.$row1['comments'].'</textarea>
        </label>
        </div>
		</div>
    </form>
    </div>
           ');
										}
				}
			else {
			// If Shift Code Doesn't Exist (Less than 0 Values in Table)
				echo ('This location code doesnt exist!');
			}
		}
		else {
			header("location: /login");
		}
}
}
if ($edit=='employee'){
$code = filter_var($_GET["code"], FILTER_SANITIZE_STRING);
if(isset ($_GET['code'])) {
		$qry = "SELECT * FROM employee WHERE euid='$code'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if ($result){
			if(mysqli_num_rows($result) > 0){
					while($row1 = mysqli_fetch_assoc($result)){
						$is_additional = $row1['is_additional'];
						$is_alternate = $row1['is_alternate'];
						$is_type = $row1['is_type'];
						$rate = $row1['rate'];
						if ($_SESSION['SESS_CONTROL_TYPE'] >= 2){
							$rte = '
        <div id="tab_items" style="height:50px;">
        <input type="number" step="0.05" name="rate" style="height: 32px;width:auto;"  id="rate" placeholder="11.00" value="'.$rate.'" />
        </div>
							';
						}
					echo('
<div id="holder" style="position:relative">
<form class="nav holder" id="employee_form" name="employee_form" action="javascript:void(0);">
    <fieldset id="tab_holder" style="width:450px;border:none;">
        <div id="tab_items" style="height:50px;">
        <input type="text" name="fname" style="height: 32px;width:auto;"  id="fname" placeholder="First Name" value="'.$row1['fname'].'" />
        </div>
        
        <div id="tab_items" style="height:50px;">
        <input type="text" name="sname" style="height: 32px;width:auto;"  id="sname" placeholder="Surname" value="'.$row1['sname'].'"/>
        </div>
        
        <div id="tab_items">
        <select id="gender" name="gender" class="select" style="width:78px;">
			<option value="'.$row1['gender'].'" selected="selected">'.$row1['gender'].'</option>
        	<option value="Male">Male</option>
        	<option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        </div>
        
        <div id="tab_items">
        <select id="position" name="position" class="select" style="width:66px;">
			<option value="'.$row1['position'].'" selected="selected">'.$row1['position'].'</option>
        	<option value="RN">RN</option>
        	<option value="RPN">RPN</option>
            <option value="PSW" selected>PSW</option>
        </select>
        </div>
        
        <div id="tab_items">
        <input type="text" style="width:130px;" style="height: 32px;" name="number" id="number" placeholder="Phone Number" value="'.$row1['phone'].'"/>
        </div>
       
        
        <div id="tab_items">
        <input type="text" name="street" id="street" style="height: 32px;width:auto;" placeholder="123 Address Lane" value="'.$row1['street'].'"/>
        </div>
        
        <div id="tab_items">
        <input type="text" name="postal" id="postal" placeholder="X5X 5X5" style="width: 75px; text-transform: uppercase; height:32px;" onBlur="checkPostal(postal)" style="style="75px;"text-transform:uppercase;" value="'.$row1['postal'].'"/>
        </div>

        <div id="tab_items">
<select name="city" id="city" class="city" style="width:auto;">
			<option value="'.$row1['city'].'" selected="selected">'.$row1['city'].'</option>
							<option value="City">City</option>
							<optgroup class="main" label="Main cities"><option value="Barrie">Barrie</option><option value="Hamilton">Hamilton</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Mississauga">Mississauga</option><option value="Oakville">Oakville</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Toronto">Toronto</option><option value="Windsor">Windsor</option></optgroup>
							<optgroup class="all" label="All cities"><option value="Ajax">Ajax</option><option value="Arnprior">Arnprior</option><option value="Aurora">Aurora</option><option value="Barrie">Barrie</option><option value="Barry&#39;s">Barry&#39;s</option><option value="Belleville">Belleville</option><option value="Bowmanville">Bowmanville</option><option value="Bracebridge">Bracebridge</option><option value="Brampton">Brampton</option><option value="Brantford">Brantford</option><option value="Brockville">Brockville</option><option value="Burlington">Burlington</option><option value="Cambridge">Cambridge</option><option value="Casselman">Casselman</option><option value="Chelmsford">Chelmsford</option><option value="Cobourg">Cobourg</option><option value="Collingwood">Collingwood</option><option value="Cornwall">Cornwall</option><option value="Dundas">Dundas</option><option value="Etobicoke">Etobicoke</option><option value="Gananoque">Gananoque</option><option value="Georgetown">Georgetown</option><option value="Gloucester">Gloucester</option><option value="Guelph">Guelph</option><option value="Hamilton">Hamilton</option><option value="Huntsville">Huntsville</option><option value="Kanata">Kanata</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Milton">Milton</option><option value="Mississauga">Mississauga</option><option value="Napanee">Napanee</option><option value="Nepean">Nepean</option><option value="Newmarket">Newmarket</option><option value="North Bay">North Bay</option><option value="North York">North York</option><option value="Oakville">Oakville</option><option value="Orangeville">Orangeville</option><option value="Orillia">Orillia</option><option value="Orleans">Orleans</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Owen Sound">Owen Sound</option><option value="Perth">Perth</option><option value="Peterborough">Peterborough</option><option value="Pickering">Pickering</option><option value="Picton">Picton</option><option value="Port Hope">Port Hope</option><option value="Renfrew">Renfrew</option><option value="Richmond Hill">Richmond Hill</option><option value="Sarnia">Sarnia</option><option value="Sault Ste. Marie">Sault Ste. Marie</option><option value="Scarborough">Scarborough</option><option value="South Porcupine">South Porcupine</option><option value="St. Catharines">St. Catharines</option><option value="St. Thomas">St. Thomas</option><option value="Stouffville">Stouffville</option><option value="Sturgeon Falls">Sturgeon Falls</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Tillsonburg">Tillsonburg</option><option value="Timmins">Timmins</option><option value="Toronto">Toronto</option><option value="Trenton">Trenton</option><option value="Val Caron">Val Caron</option><option value="Whitby">Whitby</option><option value="Windsor">Windsor</option><option value="Woodbridge">Woodbridge</option></optgroup>
						</select>
        </div>
        
        <div id="tab_items">
        <input type="text" name="majint" id="majint" placeholder="S1/S2" style="width:auto;" value="'.$row1['intersection'].'"/>
        </div>
        '.$rte.'
    </fieldset>

	        <div id="tab_items" style="right:0px;position:absolute;top:0px;">
        <label for="subu">
        <input type="checkbox" name="subu" id="subu" class="checkbox1" style="box-shadow:none;border:none;height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;"'); if($is_type=='false'){
																																																echo(''); }
																																															 if ($is_type=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_type=='') {
																																																echo('');}
 echo(' />
        </label>
		</div>
		
		
		<div id="tab_items" style="right:0px;position:absolute;top:50px;">
        <label for="alter">
        <input type="checkbox" name="alter" id="alter" class="checkbox2" style="box-shadow:none;border:none;height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;"'); if($is_alternate=='false'){
																																																echo(''); }
																																															 if ($is_alternate=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_alternate=='') {
																																																echo('');}
 echo(' />
        </label>
		</div>   
		
		<div id="tab_items" style="right:0px;position:absolute;top:100px;">
        <label for="add">
        <input type="checkbox" name="add" id="add" class="checkbox3" style="box-shadow:none;border:none;height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;"'); if($is_additional=='false'){
																																																echo(''); }
																																															 if ($is_additional=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_additional=='') {
																																																echo('');}
 echo(' />
        </label>
		</div>
	
		
		<div class="flyout_1" style="position:fixed;left:550px;top:60px;">
	     <div id="subloc" style="width:0px;overflow:hidden;display:none;">
        <label for="type">
        <select id="type" name="type" class="select" style="width:75px;">
			<option value="'.$row1['type'].'" selected="selected">'.$row1['type'].'</option>
        	<option value="None">None</option>
        	<option value="Unit">Unit</option>
            <option value="Appt">Appartment</option>
            <option value="Floor">Floor</option>
        </select>
        </label>
        <label for="tnum">
        <input type="number" name="tnum" style="width:80px;" id="tnum" placeholder="If Unit 43, put 43" value="'.$row1['type_number'].'" />
        </label>
        </div>
		</div>
		
		<div class="flyout_2" style="position:fixed;left:550px;top:110px;">
		<div id="alt" style="width:0px;overflow:hidden;display:none;">
        <label for="alternate">
        <input type="text" name="alternate" id="alternate" placeholder="Alternate Phone Number" value="'.$row1['alternate'].'"/>
        </label>
        </div>
		</div>
		
		<div class="flyout_3" style="position:fixed;left:550px;top:150px;">
		<div id="comm" style="width:0px;overflow:hidden;display:none;">
        <label for="additional">
        <textarea name="additional" style="padding:5px;" id="additional" placeholder="Additional information... Use proper text formatting!" value="'.$row1['comments'].'">'.$row1['comments'].'</textarea>
        </label>
        </div>
		</div>
    </form>
    </div>');
										}
				}
			else {
			// If Shift Code Doesn't Exist (Less than 0 Values in Table)
				echo ('This employee doesnt exist!');
			}
		}
		else {
			header("location: /login");
		}
}
}
?>
</div>
<div id="dialogboxfoot">
<?php 
if ($edit=='location') {
echo('<div id="tab_items" style="float:right;"><input type="button" class="dialog-button" id="update_location" value="Update"></div>
<div id="tab_items" style="float:right;"><input type="button" class="dialog-button cancel" id="cancel" value="Cancel"></div>
          </div>
        </div>
      </form>
    </center>');
}
if ($edit=='employee') {
echo('<div id="tab_items" style="float:right;"><input type="button" class="dialog-button" id="update_employee" Value="Update"></div>
<div id="tab_items" style="float:right;"><input type="button" class="dialog-button cancel" id="cancel" value="Cancel"></div>
          </div>
        </div>
      </form>
    </center>');
}
	?>
</div>
</div>
    <script>
$(".checkbox1").click(function()  {
	subloc = $("#subloc").css('width');
	if (subloc == '0px'){
		$("#subloc").show().animate({ 'width' : '300px'}, 300);
	}
	if (subloc == '300px') {
		$("#subloc").animate({ 'width' : '0px'}, 300, function(){ $(this).hide();}
		);
		$("input[name=tnum]").val('');
		$("#type").val('None');
	}
	});
$(".checkbox2").click(function()  {
	alter = $("#alt").css('width');
	if (alter == '0px'){
		$("#alt").show().animate({ 'width' : '300px'}, 300);
	}
	if (alter == '300px') {
		$("#alt").animate({ 'width' : '0px'}, 300, function(){ $(this).hide();}
		);
		$("input[name=alternate]").val('');
	}
	});
$(".checkbox3").click(function()  {
	comm = $("#comm").css('width');
	if (comm == '0px'){
		$("#comm").show().animate({ 'width' : '300px'}, 300);
	}
	if (comm == '300px') {
		$("#comm").animate({ 'width' : '0px'}, 300, function(){ $(this).hide();}
		);
		$("textarea[name=additional]").val('');
	}
	});
	function checkPostal(postal) {
    var regex = new RegExp(/^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/i);
	var pmsg = 'Invalid Postal Code';
    if (regex.test(postal.value)){
        //Do nothing but clear error msg when not busy
	}else {
		puno(""+pmsg+"","error");
	}	}
	
		var c1 = $(".checkbox1").is(":checked");
		var c2 = $(".checkbox2").is(":checked");
		var c3 = $(".checkbox3").is(":checked");
		if (c1===true){
			$("#subloc").show().animate({ 'width' : '300px'}, 300);
		}
		if (c2===true){
			$("#alt").show().animate({ 'width' : '300px'}, 300);
		}
		if (c3===true){

			$("#comm").show().animate({ 'width' : '300px'}, 300);
		}
	
	$('input[type="text"]').keyup(function(evt){
    var txt = $(this).val();

    // Regex taken from php.js (http://phpjs.org/functions/ucwords:569)
    $(this).val(txt.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); }));
});
	</script>
<script>
function deDuplicate(select){
  [].slice.call(select.options)
    .map(function(a){
      if(this[a.value]){
        select.removeChild(a); 
      } else {
        this[a.value]=1; 
      }
    },{});
}
var idList= ["type"<?php if ($action==='employee'){echo(',"gender"');} ?>].map(function(id){return document.getElementById(id)});    
idList.forEach(function(select){ deDuplicate(select); });
  </script>
  <script>
/* FORMAT PHONE BEHAVIOR MASK */ 
function FormatPhone (e,input) { 
    /* to prevent backspace, enter and other keys from  
     interfering w mask code apply by attribute  
     onkeydown=FormatPhone(control) 
    */ 
    evt = e || window.event; /* firefox uses reserved object e for event */ 
    var pressedkey = evt.which || evt.keyCode; 
    var BlockedKeyCodes = new Array(8,27,13,9); //8 is backspace key 
    var len = BlockedKeyCodes.length; 
    var block = false; 
    var str = ''; 
    for (i=0; i<len; i++){ 
       str=BlockedKeyCodes[i].toString(); 
       if (str.indexOf(pressedkey) >=0 ) block=true;  
    } 
    if (block) return true; 

   s = input.value; 
   if (s.charAt(0) =='+') return false; 
   filteredValues = '"`!@#$%^&*()_+|~-=\QWERT YUIOP{}ASDFGHJKL:ZXCVBNM<>?qwertyuiop[]asdfghjkl;zxcvbnm,./\\\'';  
   var i; 
   var returnString = ''; 

   /* Search through string and append to unfiltered values  
      to returnString. */ 

   for (i = 0; i < s.length; i++) {  
         var c = s.charAt(i); 

         //11-Digit number format if leading number is 1

         if (s.charAt(0) == 1){
            if ((filteredValues.indexOf(c) == -1) & (returnString.length <  14 )) { 
                if (returnString.length==1) returnString +='('; 
                if (returnString.length==5) returnString +=')'; 
                if (returnString.length==6) returnString +='-'; 
                if (returnString.length==10) returnString +='-'; 
                returnString += c; 
            } 
         }

        //10-digit number format 
         else{
             if ((filteredValues.indexOf(c) == -1) & (returnString.length <  13 )) { 
                    if (returnString.length==0) returnString +='('; 
                    if (returnString.length==4) returnString +=')'; 
                    if (returnString.length==5) returnString +='-'; 
                    if (returnString.length==9) returnString +='-'; 
                    returnString += c; 
                }
         } 

    } 
   input.value = returnString; 

    return false}
        
 document.getElementById('number').onkeydown = function (e) { FormatPhone(e, this) }
  document.getElementById('alternate').onkeydown = function (e) { FormatPhone(e, this) }
  </script>
 <script type="text/javascript">
$(document).ready(function () {
    $("#update_location").click(function () {
        //get input field values
        var name = $('form[name="location_form"] input[name=name]').val();
        var check1 = $('form[name="location_form"] .checkbox1').is(":checked");
		var check2 = $('form[name="location_form"] .checkbox2').is(":checked");
		var check3 = $('form[name="location_form"] .checkbox3').is(":checked");
        var type = $('form[name="location_form"] select[name=type]').val();
        var tnum = $('form[name="location_form"] input[name=tnum]').val();
        var number = $('form[name="location_form"] input[name=number]').val();
        var alternate = $('form[name="location_form"] input[name=alternate]').val();
        var street = $('form[name="location_form"] input[name=street]').val();
        var postal = $('form[name="location_form"] input[name=postal]').val();
        var city = $('form[name="location_form"] select[name=city]').val();
        var majint = $('form[name="location_form"] input[name=majint]').val();
        var comments = $('form[name="location_form"] textarea[name=additional]').val();

        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (name==="") {
            $('input[name=name]').css('border-color', 'red');
            proceed = false;
        }
		if (name==="") {
            $('input[name=name]').css('border-color', 'red');
            proceed = false;
        }
        if (check1===true) {
            if (type==="None") {
                $('select[name=type]').css('border-color', 'red');
                proceed = false;
            }
            if (tnum==="") {
                $('input[name=tnum]').css('border-color', 'red');
                proceed = false;
            }
        }
        if (number==="") {
            $('input[name=number]').css('border-color', 'red');
            proceed = false;
        }
        if (check2===true) {
		        if(alternate==="") {                                             
                    $('input[name=alternate]').css('border-color','red'); 
                    proceed = false;
                }
		}
        if (street == "") {
            $('input[name=street]').css('border-color', 'red');
            proceed = false;
        }
        if (city==="City") {
            $('select[name=city]').css('border-color', 'red');
            proceed = false;
        }
        if (postal==="") {
            $('input[name=postal]').css('border-color', 'red');
            proceed = false;
        }
        if (city==="") {
            $('input[name=city]').css('border-color', 'red');
            proceed = false;
        }
        if (majint==="") {
            $('input[name=majint]').css('border-color', 'red');
            proceed = false;
        }
        if (check3===true) {
		        if(comments==="") {                                           
                    $('textarea[name=additional]').css('border-color','red'); 
                    proceed = false;
                }
		}

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'code': <?php echo('"'.$code.'"'); ?>, 'name': name, 'check1': check1, 'check2': check2, 'check3': check3, 'type': type, 'tnum': tnum, 'number': number, 'alternate': alternate, 'street': street, 'postal': postal, 'city': city, 'majint': majint, 'comments': comments};

            //Ajax post data to server
            $.post(''+root+'UpdateFusion.php?action=<?php echo($edit); ?>', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
                    //reset values in all input fields
				  $('#overlay, #dialogboxholder').delay(3000).fadeOut().dequeue();
				  $('#dialogboxholder').delay(3000).queue(function() {
				 	 $(this).html('');
				 	 }).dequeue();
                }
				LocationsTable();
				puno(""+pmsg+"",""+presp+"");
            }, 'json');

        }
 	   });
    $("#location_form input, #location_form textarea").keyup(function () {
        $("#location_form input, #location_form textarea, #location_form select").css('border-color', '');
    });
});
</script>
<script type="text/javascript">
$(document).ready(function () {
    $("#update_employee").click(function () {
        //get input field values
        var fname = $('form[name="employee_form"] input[name=fname]').val();
		var sname = $('form[name="employee_form"] input[name=sname]').val();
		var gender = $('form[name="employee_form"] select[name=gender]').val();
		var position = $('form[name="employee_form"] select[name=position]').val();
        var check1 = $('form[name="employee_form"] .checkbox1').is(":checked");
		var check2 = $('form[name="employee_form"] .checkbox2').is(":checked");
		var check3 = $('form[name="employee_form"] .checkbox3').is(":checked");
<?php
        if ($_SESSION['SESS_CONTROL_TYPE'] >= 2){
			echo("var rate = $('form[name=\"employee_form\"] input[name=rate]').val();");
		}
?>
        var type = $('form[name="employee_form"] select[name=type]').val();
        var tnum = $('form[name="employee_form"] input[name=tnum]').val();
        var number = $('form[name="employee_form"] input[name=number]').val();
        var alternate = $('form[name="employee_form"] input[name=alternate]').val();
        var street = $('form[name="employee_form"] input[name=street]').val();
        var postal = $('form[name="employee_form"] input[name=postal]').val();
        var city = $('form[name="employee_form"] select[name=city]').val();
        var majint = $('form[name="employee_form"] input[name=majint]').val();
        var comments = $('form[name="employee_form"] textarea[name=additional]').val();

        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (fname == "") {
            $('form[name="employee_form"] input[name=fname]').css('border-color', 'red');
            proceed = false;
        }
        if (sname == "") {
            $('form[name="employee_form"] input[name=sname]').css('border-color', 'red');
            proceed = false;
        }
        if (rate == "") {
            $('form[name="employee_form"] input[name=rate]').css('border-color', 'red');
            proceed = false;
        }
        if (check1===true) {
            if (type==="None") {
                $('form[name="employee_form"] select[name=type]').css('border-color', 'red');
                proceed = false;
            }
            if (tnum == "") {
                $('form[name="employee_form"] input[name=tnum]').css('border-color', 'red');
                proceed = false;
            }
        }
        if (number == "") {
            $('form[name="employee_form"] input[name=number]').css('border-color', 'red');
            proceed = false;
        }
        if (check2===true) {
		        if(alternate=="") {                                             
                    $('form[name="employee_form"] input[name=alternate]').css('border-color','red'); 
                    proceed = false;
                }
		}
        if (street == "") {
            $('form[name="employee_form"] input[name=street]').css('border-color', 'red');
            proceed = false;
        }
        if (city==="City") {
            $('form[name="employee_form"] select[name=city]').css('border-color', 'red');
            proceed = false;
        }
        if (postal == "") {
            $('form[name="employee_form"] input[name=postal]').css('border-color', 'red');
            proceed = false;
        }
        if (city == "") {
            $('form[name="employee_form"] input[name=city]').css('border-color', 'red');
            proceed = false;
        }
        if (majint == "") {
            $('form[name="employee_form"] input[name=majint]').css('border-color', 'red');
            proceed = false;
        }
        if (check3===true) {
		        if(comments=="") {                                           
                    $('form[name="employee_form"] textarea[name=additional]').css('border-color','red'); 
                    proceed = false;
                }
		}

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'code': <?php echo('"'.$code.'"'); ?>,
			'fname': fname,
			'sname': sname,
			'gender': gender,
			'check1': check1,
			'check2': check2,
			'check3': check3,
<?php
        if ($_SESSION['SESS_CONTROL_TYPE'] >= 2){
			echo("			'rate': rate,");
		}
?>

			'type': type,
			'tnum': tnum,
			'number': number,
			'alternate': alternate,
			'street': street,
			'postal': postal,
			'city': city,
			'majint': majint,
			'comments': comments};

            //Ajax post data to server
            $.post(''+root+'UpdateFusion.php?action=<?php echo($edit); ?>', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
                    //reset values in all input fields
				  $('#overlay, #dialogboxholder').delay(3000).fadeOut().dequeue();
				  $('#dialogboxholder').delay(3000).queue(function() {
				 	 $(this).html('');
				 	 }).dequeue();
                }
				EmployeesTable();
				puno(""+pmsg+"",""+presp+"");
            }, 'json');

        }
 	   });
    $("#employee_form input, #employee_form textarea").keyup(function () {
        $("#employee_form input, #employee_form textarea, #employee_form select").css('border-color', '');
    });
});
    $('.cancel').each(function () {
        $(this).click(function () {
			var a = $("#v_cal").css('display');
			var b = $("#widget_ep").css('display');
			if ((a == 'block' || b == 'block')){
            $('#dialogboxholder').delay(3000).fadeOut().dequeue();
            $('#dialogboxholder').delay(3000).queue(function () {
                $(this).html('');
            }).dequeue();
			}
			else {
		$('#overlay, #dialogboxholder').delay(3000).fadeOut().dequeue();
            $('#dialogboxholder').delay(3000).queue(function () {
                $(this).html('');
            }).dequeue();
			}
        });
    });
</script>  
  </body>
  </html>