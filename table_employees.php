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
<script src='http://staffingpanel.x10.mx/js/Histex.js'></script>
    <center><h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);">Employees</h2></center>
<center>    <table class="flatTable">
      <tr class="headingTr">
        <td>Name</td>
        <td>Phone</td>
        <td>Alternate</td>
        <td>Address</td>
        <td>Intersection</td>
        <td></td>
      </tr>
      <?php
$qry = "SELECT * FROM employee ORDER BY sname,fname ASC";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
while($row = mysqli_fetch_assoc($result)){
	$type = $row['is_type'];
	if($type=='false'){
	$phone = preg_replace("/[^0-9]/","",$row['phone']);
	$alt = preg_replace("/[^0-9]/","",$row['alternate']);
	echo(
	'<tr class="'.$row['euid'].'">
	<td><a href="/Staff/List/Profile/'.$row['euid'].'" class="pel-t" data-profile-title="'.$row['fname'].' '.$row['sname'].'\'s Profile" onclick="profile(&quot;'.$row['euid'].'&quot;)">'.$row['sname'].', '.$row['fname'].'</a></td>
	<td><a href="tel:+'.$phone.'">'.$row['phone'].'</a></td>
	<td><a href="tel:+'.$alt.'">'.$row['alternate'].'</a></td>
	<td>'.$row['street'].'</td>
	<td>'.$row['intersection'].'</td>
	<td class="controlTd controlEL">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			<div class="settingsIcon" onclick="editPE(&quot;'.$row['euid'].'&quot;,&quot;employee&quot;)">Edit</div>
		</div> 
	</td>
	</tr>');
	}
	if($type=='true'){
	$phone = preg_replace("/[^0-9]/","",$row['phone']);
	$alt = preg_replace("/[^0-9]/","",$row['alternate']);
	echo(	
	'<tr class="'.$row['euid'].'">
	<td><a href="/Staff/List/Profile/'.$row['euid'].'" class="pel-t" data-profile-title="'.$row['fname'].' '.$row['sname'].'\'s Profile" onclick="profile(&quot;'.$row['euid'].'&quot;)">'.$row['sname'].', '.$row['fname'].'</a></td>
	<td><a href="tel:+'.$phone.'">'.$row['phone'].'</a></td>
	<td><a href="tel:+'.$alt.'">'.$row['alternate'].'</a></td>
	<td>'.$row['street'].'<br/> ('.$row['type'].' #'.$row['type_number'].')</td>
	<td>'.$row['intersection'].'</td>
	<td class="controlTd controlEL">
		<div class="settingsIcons">
			<span class="settingsIcon"><img src="http://i.imgur.com/nnzONel.png" alt="X" /></span>
			<div class="settingsIcon" onclick="editPE(&quot;'.$row['euid'].'&quot;,&quot;employee&quot;)">Edit</div>
		</div> 
	</td>
	</tr>');
	}
}
?>
    </table></center>
      <script>
$(document).ready(function () {
$(".controlTd").click(function () {
  var span=$(this).children(".settingsIcons");
  span.toggleClass("display"); 
  span.children(".settingsIcon").toggleClass("openIcon"); 
});	
});
</script> 