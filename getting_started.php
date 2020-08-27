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
<?php include('includes.php'); ?>
<meta name="description" content="Robots rule.txt">
<link rel="stylesheet" href="./css/slicebox.css">
<script src="./js/jquery.slicebox.js"></script>
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
</script>
</head>
<div id="holder" data-mcs-theme="light-thick" class="root" data-title-location="Knowledge Base - Always Care Staffing Panel" data-root-location="/KB">
  <div id="box">
    <div style="background: url(../img/misc/bulb_img.png) left 10px center no-repeat;background-size: 90px;height: 100px;float: left;width: 100px;"></div>
    <h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);padding-left:40px;padding-top:10px;padding-bottom:10px;">Getting Started</h2>
    <p style="color:white;"><?php echo(''.$_SESSION['SESS_CONTROL_FIRST'].', heres how to get started with using the Always Care Staffing Panel.'); ?></p>
    <div> </div>
    <div class="gs_holder" style="color: #FFF;">
      <div style="background: url(../img/misc/bulb_img.png) left 10px center no-repeat;background-size: 90px;height: 100px;float: left;width: 100px;"></div>
      <h2 style="color: rgba(255, 255, 255, 1);
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);padding-left:40px;padding-top:10px;padding-bottom:10px;">Knowledge Base</h2>
      <div class="gs_links" style="height:auto;display:inline-block;width:100%;">
        <div class="gs_column" style="float:left;width:33%;display:block;">
          <ul>
          <span style="margin-left:-18px;font-weight:bold;">Employees</span>
          <?php
				$qry = "SELECT * FROM knowledge_base WHERE kb_category='2' ORDER BY kb_title";
				$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
				while($row = mysqli_fetch_assoc($result)){
					$a_title = $row['kb_title'];
					$a_id = $row['kb_id'];
					$a_cat = $row['kb_category'];
					echo("<a href='/KB/$a_cat/$a_id' data-kb-id='$a_id'><li>$a_title</li></a>");
				}
			?>
          <li>Add an employee</li>
          <li>Delete an employee's information</li>
          <li>Edit an employee's information</li>
          <li>Remove an employee from a shift</li>
          </ul>
          <ul>
          <span style="margin-left:-18px;font-weight:bold;">Locations</span>
          <?php
				$qry = "SELECT * FROM knowledge_base WHERE kb_category='3' ORDER BY kb_title";
				$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
				while($row = mysqli_fetch_assoc($result)){
					$a_title = $row['kb_title'];
					$a_id = $row['kb_id'];
					$a_cat = $row['kb_category'];
					echo("<a href='/KB/$a_cat/$a_id' data-kb-id='$a_id'><li>$a_title</li></a>");
				}
			?>
          <li>Add a location</li>
          <li>Delete a location</li>
          <li>View recent shifts for a location</li>
          <li>Remove an employee from a shift</li>
          </ul>
        </div>
        <div class="gs_column" style="float:left;width:33%;display:block;">
        <ul>
        <span style="margin-left:-18px;font-weight:bold;">Shifts</span>
        <?php
				$qry = "SELECT * FROM knowledge_base WHERE kb_category='1' ORDER BY kb_title";
				$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
				while($row = mysqli_fetch_assoc($result)){
					$a_title = $row['kb_title'];
					$a_id = $row['kb_id'];
					$a_cat = $row['kb_category'];
					echo("<a href='/KB/$a_cat/$a_id' data-kb-id='$a_id'><li>$a_title</li></a>");
				}
			?>
        <li>Canceling a shift</li>
        <li>Creating a shift</li>
        <li>Deleting a shift</li>
        <li>Filling a shift</li>
        <li>Unfilling a shift</li>
        <li>View recent shifts</li>
        <li>View shifts by user</li>
        <li>View specific shifts</li>
        <li>View who's available for certain shifts</li>
        </ul>
        </div>
        <div class="gs_column" style="float:left;width:33%;display:block;">
        <ul>
        <span style="margin-left:-18px;font-weight:bold;">Settings</span>
        <?php
				$qry = "SELECT * FROM knowledge_base WHERE kb_category='4' ORDER BY kb_title";
				$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
				while($row = mysqli_fetch_assoc($result)){
					$a_title = $row['kb_title'];
					$a_id = $row['kb_id'];
					$a_cat = $row['kb_category'];
					echo("<a href='/KB/$a_cat/$a_id' data-kb-id='$a_id'><li>$a_title</li></a>");
				}
			?>
        <li>Change my login name</li>
        <li>Change my first/last name</li>
        <li>Change my email</li>
        <li>Change my password</li>
        </ul>
        <ul>
        <span style="margin-left:-18px;font-weight:bold;">Miscellaneous</span>
        <?php
				$qry = "SELECT * FROM knowledge_base WHERE kb_category='5' ORDER BY kb_title";
				$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
				while($row = mysqli_fetch_assoc($result)){
					$a_title = $row['kb_title'];
					$a_id = $row['kb_id'];
					$a_cat = $row['kb_category'];
					echo("<a href='/KB/$a_cat/$a_id' data-kb-id='$a_id'><li>$a_title</li></a>");
				}
			?>
        <li>What are notifications?</li>
        <li>Why are you notifying me who cares?</li>
        <li>I dismissed a notification make it go away!</li>
        <li>Printing (sub li)</li>
        </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</html>