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
<?php $floor = true; include('includes.php'); ?>
<meta name="description" content="Robots rule.txt">
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
</script>
<style type="text/css">
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
/* Table Stuff */
.nav button {
	overflow: hidden;
	display: block;
	float: left;
	height: 17px;
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
}
.nav button:after {
	content: '';
	line-height: 2px;
	width: 12px;
	height: 12px;
	position: absolute;
	left: 50%;
	margin-left: -6px;
	bottom: -4px;
	opacity: 0.55;
	background: -moz-radial-gradient(50% 50% 90deg, ellipse contain, rgba(255,255,255,1), rgba(255,255,255,0) 100%); /* Firefox */
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
	background: -moz-radial-gradient(50% 50% 90deg, ellipse contain, rgba(255,255,255,1), rgba(255,255,255,0) 100%); /* Firefox */
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
.flatTable {
	width: 100%;
	min-width: 500px;
	border-collapse: collapse;
	font-weight: bold;
	color: #6b6b6b;
}
tr {
	height: 50px;
	background: #f6f3f7;
	border-bottom: rgba(0,0,0,.05) 1px solid;
}
td {
	box-sizing: border-box;
	padding-left: 30px;
}
.titleTr {
	height: 70px;
	color: #f6f3f7;
	background: #418a95;
	border: 0px solid;
}
.plusTd {
	background: url(http://i.imgur.com/3hSkhay.png) center center no-repeat, rgba(0,0,0,.1);
}
}
.button {
	text-align: center;
	cursor: pointer;
}
.sForm {
	position: absolute;
	top: 0;
	right: -400px;
	width: 400px;
	height: 100%;
	background: #f6f3f7;
	overflow: hidden;
	transition: width 1s, right .3s;
	padding: 0px;
	box-sizing: border-box;
}
.close {
	float: right;
	height: 70px;
	width: 80px;
	padding-top: 25px;
	box-sizing: border-box;
	background: rgba(255,0,0,.4);
}
.title {
	width: 100%;
	height: 70px;
	padding-top: 20px;
	padding-left: 20px;
	box-sizing: border-box;
	background: rgba(0,0,0,.1);
}
}
.open {
	right: 0;
	width: 400px !important;
}
.settingsIcons {
	position: absolute;
	top: -1px;
	right: 0;
	width: 0;
	overflow: hidden;
}
.display {
	width: 350px;
}
.settingsIcon {
	float: right;
	background: #0D0D0D;
	color: #f6f3f7;
	height: 50px;
	width: 80px;
	padding-top: 15px;
	box-sizing: border-box;
	text-align: center;
	overflow: hidden;
	transition: width 1s;
}
.settingsIcon:hover {
	background: rgba(0, 0, 0, 0.8);
}
tr:nth-child(3) {
 .settingsIcon {
 height:51px;
}
}
.openIcon {
	width: 80px;
}
.counterTable td {
	box-sizing: border-box;
	padding-left: 0;
}
.counterTable tr {
	height: 0;
	background: none;
	border-bottom: none;
}
/* Table Stuff */
</style>
</head>
<body>
<div id="holder" data-mcs-theme="light-thick" class="root" data-title-location="Work Sites - Always Care Staffing Panel" data-root-location="/Locations/List">
  <div id="box" data-location="locations">
    <center><h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);">Loading<marquee>...</marquee></h2></center>
</div>
<script type="text/javascript">
var pathname = window.location.pathname;
var path = window.location.hash;
    $(document).ready(function(){
//      LocationsAuto();
      LocationsTable();
    });

//    function LocationsAuto(){
//        $("div[data-location='locations']").load(''+root+'table_locations.php', function(){
//         Locations = setInterval(LocationsTable, 60000);
//        });
//    }
    function LocationsTable(){
        $("div[data-location='locations']").load(''+root+'table_locations.php');
    }
</script>
</div>
</body>