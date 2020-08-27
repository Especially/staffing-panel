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
}
if ($edit=='employee') {
	$title = 'Update Employee';
}

	?>
    <html>
<head>
<style>
.success {
	background: #CFFFF5;
	padding: 10px;
	margin-bottom: 10px;
	border: 1px solid #B9ECCE;
	border-radius: 5px;
	font-weight: normal;
}
.error {
	background: #FFDFDF;
	padding: 10px;
	margin-bottom: 10px;
	border: 1px solid #FFCACA;
	border-radius: 5px;
	font-weight: normal;
}
#dialogbox{
	display: block;
	position: fixed;
	background: #000;
	border-radius:7px; 
	width:550px;
	z-index: 10;
}
#dialogboxhead{ background: #666; font-size:19px; padding:10px; color:#CCC; }
#dialogboxbody{ background:#333; padding:20px; color:#FFF; }
#dialogboxfoot{ background: #666; padding:10px; text-align:right; }
</style>
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
</head>
<body>
<div id="dialogbox">
<div id="dialogboxbody" style="padding:0px;">
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
<style>
html, body {
margin: 0;
padding: 0;
background-attachment: fixed;
background-position: 50% 50%;
background-size: cover;
}
#location_form{ 
margin: 0;
outline: none;
box-shadow: 0 0 20px rgba(0,0,0,.3);
font: 13px/1.55 "Open Sans", Helvetica, Arial, sans-serif;
color: #666;
max-width: 450px;
margin: 0 auto;
padding: 40px;
}
.bg-purple {
background-image: url(../img/misc/NewLocation.jpg);
}
#location_form legend{
display: block;
padding: 20px 30px;
border-bottom: 1px solid rgba(0,0,0,.1);
background: rgba(22, 21, 21, 0.9);
font-size: 25px;
font-weight: 300;
color: #FFFFFF;
box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
outline: none;
}
#location_form fieldset{
display: block;
padding: 25px 30px 5px;
border: none;
background: rgba(255,255,255,.9);
}
#location_form label{display: block; margin-bottom:5px;overflow:hidden;}
#location_form label span{float:left; width:150px; color:#666666;}
#location_form input{height: 25px; border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px; color: #666; width: 180px; font-family: Arial, Helvetica, sans-serif;}
#location_form textarea{border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px;color: #666; height:100px; width: 180px; font-family: Arial, Helvetica, sans-serif;}
/*(.submit_btn { border: 1px solid #D8D8D8; padding: 5px 15px 5px 15px; color: #8D8D8D; text-shadow: 1px 1px 1px #FFF; border-radius: 3px; background: #F8F8F8;}
.submit_btn:hover { background: #ECECEC;} */
.success{ background: #CFFFF5;padding: 10px; margin-bottom: 10px; border: 1px solid #B9ECCE; border-radius: 5px; font-weight: normal; }
.error{ background: #FFDFDF; padding: 10px; margin-bottom: 10px; border: 1px solid #FFCACA; border-radius: 5px; font-weight: normal;}
.submit_btn{
  width:100%;
  padding:15px;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#000000), to(#636363));
  background-image: -webkit-linear-gradient(#000000 0%, #636363 100%);
  background-image: -moz-linear-gradient(#000000 0%, #636363 100%);
  background-image: -o-linear-gradient(#000000 0%, #636363 100%);
  background-image: linear-gradient(#000000 0%, #636363 100%);
  color:#FFF;
  text-transform:uppercase;
  text-shadow:#000 0px 1px 5px;
  border:1px solid #000;
  opacity:0.7;
	-webkit-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
  -moz-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
	box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
  border-top:1px solid #000)!important;
  -webkit-box-reflect: below 0px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(50%, transparent), to(rgba(255,255,255,0.2)));
}
.submit_btn:hover{
  opacity:1;
  cursor:pointer;
}
#location_form .input input,
#location_form .select,
#location_form .textarea textarea,
#location_form .radio i,
#location_form .checkbox i,
#location_form .toggle i,
#location_form .icon-append,
#location_form .icon-prepend {
	border-color: #e5e5e5;
	transition: border-color 0.3s;
	-o-transition: border-color 0.3s;
	-ms-transition: border-color 0.3s;
	-moz-transition: border-color 0.3s;
	-webkit-transition: border-color 0.3s;
}
#location_form .toggle i:before {
	background-color: #2da5da;	
}
#location_form .rating label {
	color: #ccc;
	transition: color 0.3s;
	-o-transition: color 0.3s;
	-ms-transition: color 0.3s;
	-moz-transition: color 0.3s;
	-webkit-transition: color 0.3s;
}


/**/
/* hover state */
/**/
#location_form .input:hover input,
#location_form .select:hover select,
#location_form .textarea:hover textarea,
#location_form .radio:hover i,
#location_form .checkbox:hover i,
#location_form .toggle:hover i {
	border-color: #8dc9e5;
}
#location_form .rating input + label:hover,
#location_form .rating input + label:hover ~ label {
	color: #2da5da;
}
#location_form .button:hover {
	opacity: 1;
}


/**/
/* focus state */
/**/
#location_form .input input:focus,
#location_form .select select:focus,
#location_form .textarea textarea:focus,
#location_form .radio input:focus + i,
#location_form .checkbox input:focus + i,
#location_form .toggle input:focus + i {
	border-color: #2da5da;
}


/**/
/* checked state */
/**/
#location_form .radio input + i:after {
	background-color: #2da5da;	
}
#location_form .checkbox input + i:after {
	color: #2da5da;
}
#location_form .radio input:checked + i,
#location_form .checkbox input:checked + i,
#location_form .toggle input:checked + i {
	border-color: #2da5da;	
}
#location_form .rating input:checked ~ label {
	color: #2da5da;	
}
* {
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: -moz-none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}
</style>
    <div id="holder" style="background-image: url(../img/misc/NewLocation.jpg);margin: 0;
padding: 0;
background-attachment: fixed;
background-position: 50% 50%;
background-size: cover;">
<form id="location_form" name="location_form" action="javascript:void(0);">
    <fieldset>
    <legend>'.$title.'</legend>
    <div id="result"></div>
        <label for="name"><span>Location Name</span>
        <input type="text" name="name" id="name" placeholder="Location Name" value="'.$row1['name'].'" />
        </label>
        
        <label for="subu"><span>Are there multiple units/appartments?</span>
        <input type="checkbox" name="subu" id="subu" class="checkbox1" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;"'); if($is_type=='false'){
																																																echo(''); }
																																															 if ($is_type=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_type=='') {
																																																echo('');}
 echo('" />
        </label>
        
        <div id="subloc" style="display:none;">
        <label for="type"><span>Sub Location Type</span>
        <select id="type" name="type" class="select">
			<option value="'.$row1['type'].'" selected="selected">'.$row1['type'].'</option>
        	<option value="None">None</option>
        	<option value="Unit">Unit</option>
            <option value="Appt">Appartment</option>
            <option value="Floor">Floor</option>
        </select>
        </label>
        <label for="tnum"><span>Type Number</span>
        <input type="number" name="tnum" id="tnum" placeholder="If Unit 43, put 43" value="'.$row1['type_number'].'" />
        </label>
        </div>
        
        <label for="phone"><span>Phone</span>
        <input type="text" name="number" id="number" placeholder="Phone Number" value="'.$row1['phone'].'"/>
        </label>
       
        <label for="alter"><span>Is there an alternate number?</span>
        <input type="checkbox" name="alter" id="alter" class="checkbox2" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;"'); if($is_alternate=='false'){
																																																echo(''); }
																																															 if ($is_alternate=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_alternate=='') {
																																																echo('');}
 echo('" />
        </label>
        <div id="alt" style="display:none;">
        <label for="alternate"><span>Alternate Phone</span>
        <input type="text" name="alternate" id="alternate" placeholder="Alternate Phone Number" value="'.$row1['alternate'].'"/>
        </label>
        </div>
        
        <label for="street"><span>Street</span>
        <input type="text" name="street" id="street" placeholder="123 Address Lane" value="'.$row1['street'].'" />
        </label>
        
        <label for="postal"><span>Postal Code</span>
        <input type="text" name="postal" id="postal" placeholder="X5X 5X5" onBlur="checkPostal(postal)" style="text-transform:uppercase;" value="'.$row1['postal'].'" />
        </label>

        <label for="city"><span>City</span>
<select name="city" id="city" class="city">
							<option value="'.$row1['city'].'" selected="selected">'.$row1['city'].'</option>
							<option value="City">City</option>
							<optgroup class="main" label="Main cities"><option value="Barrie">Barrie</option><option value="Hamilton">Hamilton</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Mississauga">Mississauga</option><option value="Oakville">Oakville</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Toronto">Toronto</option><option value="Windsor">Windsor</option></optgroup>
							<optgroup class="all" label="All cities"><option value="Ajax">Ajax</option><option value="Arnprior">Arnprior</option><option value="Aurora">Aurora</option><option value="Barrie">Barrie</option><option value="Barry&#39;s Bay">Barry&#39;s Bay</option><option value="Belleville">Belleville</option><option value="Bowmanville">Bowmanville</option><option value="Bracebridge">Bracebridge</option><option value="Brampton">Brampton</option><option value="Brantford">Brantford</option><option value="Brockville">Brockville</option><option value="Burlington">Burlington</option><option value="Cambridge">Cambridge</option><option value="Casselman">Casselman</option><option value="Chelmsford">Chelmsford</option><option value="Cobourg">Cobourg</option><option value="Collingwood">Collingwood</option><option value="Cornwall">Cornwall</option><option value="Dundas">Dundas</option><option value="East York">East York</option><option value="Etobicoke">Etobicoke</option><option value="Gananoque">Gananoque</option><option value="Georgetown">Georgetown</option><option value="Gloucester">Gloucester</option><option value="Guelph">Guelph</option><option value="Hamilton">Hamilton</option><option value="Huntsville">Huntsville</option><option value="Kanata">Kanata</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Milton">Milton</option><option value="Mississauga">Mississauga</option><option value="Napanee">Napanee</option><option value="Nepean">Nepean</option><option value="Newmarket">Newmarket</option><option value="North Bay">North Bay</option><option value="North York">North York</option><option value="Oakville">Oakville</option><option value="Orangeville">Orangeville</option><option value="Orillia">Orillia</option><option value="Orleans">Orleans</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Owen Sound">Owen Sound</option><option value="Perth">Perth</option><option value="Peterborough">Peterborough</option><option value="Pickering">Pickering</option><option value="Picton">Picton</option><option value="Port Hope">Port Hope</option><option value="Renfrew">Renfrew</option><option value="Richmond Hill">Richmond Hill</option><option value="Sarnia">Sarnia</option><option value="Sault Ste. Marie">Sault Ste. Marie</option><option value="Scarborough">Scarborough</option><option value="South Porcupine">South Porcupine</option><option value="St. Catharines">St. Catharines</option><option value="St. Thomas">St. Thomas</option><option value="Stouffville">Stouffville</option><option value="Sturgeon Falls">Sturgeon Falls</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Tillsonburg">Tillsonburg</option><option value="Timmins">Timmins</option><option value="Toronto">Toronto</option><option value="Trenton">Trenton</option><option value="Val Caron">Val Caron</option><option value="Whitby">Whitby</option><option value="Windsor">Windsor</option><option value="Woodbridge">Woodbridge</option><option value="York">York</option></optgroup>
						</select>
        </label>
        
        <label for="majint"><span>Major Intersection</span>
        <input type="text" name="majint" id="majint" placeholder="S1/S2" value="'.$row1['intersection'].'"/>
        </label>
        
        <label for="add"><span>Any additional comments?</span>
        <input type="checkbox" name="add" id="add" class="checkbox3" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;";'); if($is_additional=='false'){
																																																echo(''); }
																																															 if ($is_additional=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_additional=='') {
																																																echo('');}
 echo('" />
        </label>
        <div id="comm" style="display:none;">
        <label for="additional"><span>Comments</span>
        <textarea name="additional" id="additional" placeholder="Additional information... Use proper text formatting!" value="'.$row1['comments'].'">'.$row1['comments'].'</textarea>
        </label>
        </div>
        
        <label><span>&nbsp;</span>
        <button id="update_location" type="submit" class="submit_btn">Update Location</button>
        </label>
    </fieldset>
    </form>
    </div>
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
					echo('
<style>
html, body {
margin: 0;
padding: 0;
background-attachment: fixed;
background-position: 50% 50%;
background-size: cover;
}
#employee_form{ 
margin: 0;
outline: none;
box-shadow: 0 0 20px rgba(0,0,0,.3);
font: 13px/1.55 "Open Sans", Helvetica, Arial, sans-serif;
color: #666;
max-width: 450px;
margin: 0 auto;
padding: 40px;
}
.bg-purple {
background-image: url(../img/misc/NewEmployee.jpg);
}
#employee_form legend{
display: block;
padding: 20px 30px;
border-bottom: 1px solid rgba(0,0,0,.1);
background: rgba(22, 21, 21, 0.9);
font-size: 25px;
font-weight: 300;
color: #FFFFFF;
box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
outline: none;
}
#employee_form fieldset{
display: block;
padding: 25px 30px 5px;
border: none;
background: rgba(255,255,255,.9);
}
#employee_form label{display: block; margin-bottom:5px;overflow:hidden;}
#employee_form label span{float:left; width:150px; color:#666666;}
#employee_form input{height: 25px; border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px; color: #666; width: 180px; font-family: Arial, Helvetica, sans-serif;}
#employee_form textarea{border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px;color: #666; height:100px; width: 180px; font-family: Arial, Helvetica, sans-serif;}
/*(.submit_btn { border: 1px solid #D8D8D8; padding: 5px 15px 5px 15px; color: #8D8D8D; text-shadow: 1px 1px 1px #FFF; border-radius: 3px; background: #F8F8F8;}
.submit_btn:hover { background: #ECECEC;} */
.success{ background: #CFFFF5;padding: 10px; margin-bottom: 10px; border: 1px solid #B9ECCE; border-radius: 5px; font-weight: normal; }
.error{ background: #FFDFDF; padding: 10px; margin-bottom: 10px; border: 1px solid #FFCACA; border-radius: 5px; font-weight: normal;}
.submit_btn{
  width:100%;
  padding:15px;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#000000), to(#636363));
  background-image: -webkit-linear-gradient(#000000 0%, #636363 100%);
  background-image: -moz-linear-gradient(#000000 0%, #636363 100%);
  background-image: -o-linear-gradient(#000000 0%, #636363 100%);
  background-image: linear-gradient(#000000 0%, #636363 100%);
  color:#FFF;
  text-transform:uppercase;
  text-shadow:#000 0px 1px 5px;
  border:1px solid #000;
  opacity:0.7;
	-webkit-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
  -moz-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
	box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
  border-top:1px solid #000)!important;
  -webkit-box-reflect: below 0px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(50%, transparent), to(rgba(255,255,255,0.2)));
}
.submit_btn:hover{
  opacity:1;
  cursor:pointer;
}
#employee_form .input input,
#employee_form .select,
#employee_form .textarea textarea,
#employee_form .radio i,
#employee_form .checkbox i,
#employee_form .toggle i,
#employee_form .icon-append,
#employee_form .icon-prepend {
	border-color: #e5e5e5;
	transition: border-color 0.3s;
	-o-transition: border-color 0.3s;
	-ms-transition: border-color 0.3s;
	-moz-transition: border-color 0.3s;
	-webkit-transition: border-color 0.3s;
}
#employee_form .toggle i:before {
	background-color: #2da5da;	
}
#employee_form .rating label {
	color: #ccc;
	transition: color 0.3s;
	-o-transition: color 0.3s;
	-ms-transition: color 0.3s;
	-moz-transition: color 0.3s;
	-webkit-transition: color 0.3s;
}


/**/
/* hover state */
/**/
#employee_form .input:hover input,
#employee_form .select:hover select,
#employee_form .textarea:hover textarea,
#employee_form .radio:hover i,
#employee_form .checkbox:hover i,
#employee_form .toggle:hover i {
	border-color: #8dc9e5;
}
#employee_form .rating input + label:hover,
#employee_form .rating input + label:hover ~ label {
	color: #2da5da;
}
#employee_form .button:hover {

	opacity: 1;
}


/**/
/* focus state */
/**/
#employee_form .input input:focus,
#employee_form .select select:focus,
#employee_form .textarea textarea:focus,
#employee_form .radio input:focus + i,
#employee_form .checkbox input:focus + i,
#employee_form .toggle input:focus + i {
	border-color: #2da5da;
}


/**/
/* checked state */
/**/
#employee_form .radio input + i:after {
	background-color: #2da5da;	
}
#employee_form .checkbox input + i:after {
	color: #2da5da;
}
#employee_form .radio input:checked + i,
#employee_form .checkbox input:checked + i,
#employee_form .toggle input:checked + i {
	border-color: #2da5da;	
}
#employee_form .rating input:checked ~ label {
	color: #2da5da;	
}
* {
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: -moz-none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}
</style>
    <div id="holder" style="background-image: url(../img/misc/NewEmployee.jpg);margin: 0;
padding: 0;
background-attachment: fixed;
background-position: 50% 50%;
background-size: cover;">
<form id="employee_form" name="employee_form" action="javascript:void(0);">
    <fieldset>
    <legend>Update Employee</legend>
    <div id="result"></div>
        <label for="fname"><span>First Name</span>
        <input type="text" name="fname" id="fname" placeholder="First Name" value="'.$row1['fname'].'" />
        </label>
        
        <label for="fname"><span>Surname</span>
        <input type="text" name="sname" id="sname" placeholder="Surname" value="'.$row1['sname'].'"/>
        </label>
        
        <label for="gender"><span>Gender</span>
        <select id="gender" name="gender" class="select">
			<option value="'.$row1['gender'].'" selected="selected">'.$row1['gender'].'</option>
        	<option value="Male">Male</option>
        	<option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        </label>
        
        <label for="positon"><span>Position</span>
        <select id="position" name="position" class="select">
			<option value="'.$row1['position'].'" selected="selected">'.$row1['position'].'</option>
        	<option value="RN">RN</option>
        	<option value="RPN">RPN</option>
            <option value="PSW" selected>PSW</option>
        </select>
        </label>
        
        <label for="subu"><span>Do they reside in an appartment/complex?</span>
        <input type="checkbox" name="subu" id="subu" class="checkbox1" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;"'); if($is_type=='false'){
																																																echo(''); }
																																															 if ($is_type=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_type=='') {
																																																echo('');}
 echo('" />
        </label>
        
        <div id="subloc" style="display:none;">
        <label for="type"><span>Unit/Appartment</span>
        <select id="type" name="type" class="select">
			<option value="'.$row1['type'].'" selected="selected">'.$row1['type'].'</option>
        	<option value="None">None</option>
        	<option value="Unit">Unit</option>
            <option value="Appt">Appartment</option>
        </select>
        </label>
        <label for="tnum"><span>Number</span>
        <input type="number" name="tnum" id="tnum" placeholder="If Unit 43, put 43" value="'.$row1['type_number'].'"/>
        </label>
        </div>
        
        <label for="phone"><span>Phone</span>
        <input type="text" name="number" id="number" placeholder="Phone Number" value="'.$row1['phone'].'"/>
        </label>
       
        <label for="alter"><span>Is there an alternate number?</span>
        <input type="checkbox" name="alter" id="alter" class="checkbox2" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;"'); if($is_alternate=='false'){
																																																echo(''); }
																																															 if ($is_alternate=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_alternate=='') {
																																																echo('');}
 echo('" />
        </label>
        <div id="alt" style="display:none;">
        <label for="alternate"><span>Alternate Phone</span>
        <input type="text" name="alternate" id="alternate" placeholder="Alternate Phone Number" value="'.$row1['alternate'].'"/>
        </label>
        </div>
        
        <label for="street"><span>Street</span>
        <input type="text" name="street" id="street" placeholder="123 Address Lane" value="'.$row1['street'].'"/>
        </label>
        
        <label for="postal"><span>Postal Code</span>
        <input type="text" name="postal" id="postal" placeholder="X5X 5X5" onBlur="checkPostal(postal)" style="text-transform:uppercase;" value="'.$row1['postal'].'"/>
        </label>

        <label for="city"><span>City</span>
<select name="city" id="city" class="city">
			<option value="'.$row1['city'].'" selected="selected">'.$row1['city'].'</option>
							<option value="City">City</option>
							<optgroup class="main" label="Main cities"><option value="Barrie">Barrie</option><option value="Hamilton">Hamilton</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Mississauga">Mississauga</option><option value="Oakville">Oakville</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Toronto">Toronto</option><option value="Windsor">Windsor</option></optgroup>
							<optgroup class="all" label="All cities"><option value="Ajax">Ajax</option><option value="Arnprior">Arnprior</option><option value="Aurora">Aurora</option><option value="Barrie">Barrie</option><option value="Barry&#39;s">Barry&#39;s</option><option value="Belleville">Belleville</option><option value="Bowmanville">Bowmanville</option><option value="Bracebridge">Bracebridge</option><option value="Brampton">Brampton</option><option value="Brantford">Brantford</option><option value="Brockville">Brockville</option><option value="Burlington">Burlington</option><option value="Cambridge">Cambridge</option><option value="Casselman">Casselman</option><option value="Chelmsford">Chelmsford</option><option value="Cobourg">Cobourg</option><option value="Collingwood">Collingwood</option><option value="Cornwall">Cornwall</option><option value="Dundas">Dundas</option><option value="Etobicoke">Etobicoke</option><option value="Gananoque">Gananoque</option><option value="Georgetown">Georgetown</option><option value="Gloucester">Gloucester</option><option value="Guelph">Guelph</option><option value="Hamilton">Hamilton</option><option value="Huntsville">Huntsville</option><option value="Kanata">Kanata</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Milton">Milton</option><option value="Mississauga">Mississauga</option><option value="Napanee">Napanee</option><option value="Nepean">Nepean</option><option value="Newmarket">Newmarket</option><option value="North Bay">North Bay</option><option value="North York">North York</option><option value="Oakville">Oakville</option><option value="Orangeville">Orangeville</option><option value="Orillia">Orillia</option><option value="Orleans">Orleans</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Owen Sound">Owen Sound</option><option value="Perth">Perth</option><option value="Peterborough">Peterborough</option><option value="Pickering">Pickering</option><option value="Picton">Picton</option><option value="Port Hope">Port Hope</option><option value="Renfrew">Renfrew</option><option value="Richmond Hill">Richmond Hill</option><option value="Sarnia">Sarnia</option><option value="Sault Ste. Marie">Sault Ste. Marie</option><option value="Scarborough">Scarborough</option><option value="South Porcupine">South Porcupine</option><option value="St. Catharines">St. Catharines</option><option value="St. Thomas">St. Thomas</option><option value="Stouffville">Stouffville</option><option value="Sturgeon Falls">Sturgeon Falls</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Tillsonburg">Tillsonburg</option><option value="Timmins">Timmins</option><option value="Toronto">Toronto</option><option value="Trenton">Trenton</option><option value="Val Caron">Val Caron</option><option value="Whitby">Whitby</option><option value="Windsor">Windsor</option><option value="Woodbridge">Woodbridge</option></optgroup>
						</select>
        </label>
        
        <label for="majint"><span>Major Intersection</span>
        <input type="text" name="majint" id="majint" placeholder="S1/S2" value="'.$row1['intersection'].'"/>
        </label>
        
        <label for="add"><span>Any additional comments?</span>
        <input type="checkbox" name="add" id="add" class="checkbox3" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;"'); if($is_additional=='false'){
																																																echo(''); }
																																															 if ($is_additional=='true'){
																																																echo('checked="checked"'); }
																																															 if ($is_additional=='') {
																																																echo('');}
 echo('" />
        </label>
        <div id="comm" style="display:none;">
        <label for="additional"><span>Comments</span>
        <textarea name="additional" id="additional" placeholder="Additional information... Use proper text formatting!" value="'.$row1['comments'].'">'.$row1['comments'].'</textarea>
        </label>
        </div>
        
        <label><span>&nbsp;</span>
        <button id="update_employee" type="submit" class="submit_btn">Update Employee</button>
        </label>
    </fieldset>
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
</div>
</div>
    <script>
$(".checkbox1").click(function()  {
	subloc = $("#subloc").css('display');
	if (subloc == 'block'){
		$("#subloc").slideUp();
	}
	if (subloc == 'none') {
		$("#subloc").slideDown();
	}
	});
$(".checkbox2").click(function()  {
	alter = $("#alt").css('display');
	if (alter == 'block'){
		$("#alt").slideUp();
	}
	if (alter == 'none') {
		$("#alt").slideDown();
	}
	});
$(".checkbox3").click(function()  {
	comm = $("#comm").css('display');
	if (comm == 'block'){
		$("#comm").slideUp();
	}
	if (comm == 'none') {
		$("#comm").slideDown();
	}
	});
	function checkPostal(postal) {
    var regex = new RegExp(/^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/i);
	var outputin = '<div class="error">Invalid Postal Code</div>';
    if (regex.test(postal.value))
        $("#result").hide().html().slideUp();
    else 
		$("#result").hide().html(outputin).slideDown();
	}	
	
		var c1 = $(".checkbox1").is(":checked");
		var c2 = $(".checkbox2").is(":checked");
		var c3 = $(".checkbox3").is(":checked");
		if (c1===true){
			$("#subloc").slideDown();
		}
		if (c2===true){
			$("#alt").slideDown();
		}
		if (c3===true){
			$("#comm").slideDown();
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
		var result = $('form[name="location_form"] #result').css('display');
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
        if (result == "block") {
			proceed = false;
		}
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
				else {
					proceed = true;
				}
		}

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'code': <?php echo('"'.$code.'"'); ?>, 'name': name, 'check1': check1, 'check2': check2, 'check3': check3, 'type': type, 'tnum': tnum, 'number': number, 'alternate': alternate, 'street': street, 'postal': postal, 'city': city, 'majint': majint, 'comments': comments};

            //Ajax post data to server
            $.post('UpdateFusion.php?action=<?php echo($edit); ?>', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    output = '<div class="error">' + response.text + '</div>';
                } else {

                    output = '<div class="success">' + response.text + '</div>';

                    //reset values in all input fields
				  $('#overlay, #dialogboxholder').delay(3000).fadeOut();
				  $('#dialogboxholder').delay(3000).queue(function() {
				 	 $(this).html('');
				 	 });
                }
				refreshTable();
                $('form[name="location_form"] #result').hide().html(output).slideDown();
            }, 'json');

        }
 	   });
    $("#location_form input, #location_form textarea").keyup(function () {
        $("#location_form input, #location_form textarea, #location_form select").css('border-color', '');
        $("#result").slideUp();
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
		var result = $('form[name="employee_form"] #result').css('display');
        var check1 = $('form[name="employee_form"] .checkbox1').is(":checked");
		var check2 = $('form[name="employee_form"] .checkbox2').is(":checked");
		var check3 = $('form[name="employee_form"] .checkbox3').is(":checked");
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
		if (result == "block") {
			proceed = false;
		}
        if (fname == "") {
            $('form[name="employee_form"] input[name=fname]').css('border-color', 'red');
            proceed = false;
        }
        if (sname == "") {
            $('form[name="employee_form"] input[name=sname]').css('border-color', 'red');
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
            post_data = {'code': <?php echo('"'.$code.'"'); ?>, 'fname': fname, 'sname': sname, 'gender': gender, 'check1': check1, 'check2': check2, 'check3': check3, 'type': type, 'tnum': tnum, 'number': number, 'alternate': alternate, 'street': street, 'postal': postal, 'city': city, 'majint': majint, 'comments': comments};

            //Ajax post data to server
            $.post('UpdateFusion.php?action=<?php echo($edit); ?>', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    output = '<div class="error">' + response.text + '</div>';
                } else {

                    output = '<div class="success">' + response.text + '</div>';

                    //reset values in all input fields
				  $('#overlay, #dialogboxholder').delay(3000).fadeOut();
				  $('#dialogboxholder').delay(3000).queue(function() {
				 	 $(this).html('');
				 	 });
                }
				refreshTable();
                $('form[name="employee_form"] #result').hide().html(output).slideDown();
            }, 'json');

        }
 	   });
    $("#employee_form input, #employee_form textarea").keyup(function () {
        $("#employee_form input, #employee_form textarea, #employee_form select").css('border-color', '');
        $("#result").slideUp();
    });
});
</script>  
  </body>
  </html>