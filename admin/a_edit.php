<?php 
ini_set("log_errors", 1);
	require_once('cFigure.php');	
	require_once('auth.php');	
	include('base64_upld.php');	
	
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
 	
$title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
$category = filter_var($_POST["category"], FILTER_SANITIZE_STRING);
$content = $_POST["content"];
$content = preg_replace_callback('/src="data([^"]+)"/', "base64_to_jpeg", $content);
$content = base64_encode($content);
if (!isset($_POST["article"])){
	$article = filter_var($_GET["article"], FILTER_SANITIZE_STRING);	
} else {
	$article = filter_var($_POST["article"], FILTER_SANITIZE_STRING);
}
if (!isset($_POST["action"])){
	$action = filter_var($_GET["action"], FILTER_SANITIZE_STRING);
} else {
	$action = filter_var($_POST["action"], FILTER_SANITIZE_STRING);
}
$date	= date('Y-m-d G:i:s');
$login = $_SESSION['SESS_CONTROL_LOGIN'];
if($action == 'a_edit'){
	$qry = "SELECT * FROM knowledge_base WHERE kb_id='$article'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
	while($row = mysqli_fetch_assoc($result)){
		$a_title = $row['kb_title'];
		$a_id = $row['kb_id'];
		$a_category = $row['kb_category'];
		$a_content = base64_decode($row['kb_content']);
		echo('<form name="edit article" action="javascript:void(0);">
                            <div id="tab_holder">
                            	<div id="tab_items">
                                    <div id="tab_items">Article Title:</div>
                                    <div id="tab_items"><input type="text" name="a_title" value="'.$a_title.'"></div>
                                </div>
                            </div>
                            <div id="tab_holder">
                            	<div id="tab_items">
                                    <div id="tab_items">Category:</div>
                                    <div id="tab_items"><select name="a_category"><option value="1">Shifts</option><option value="2">Employees</option><option value="3">Locations</option><option value="4">Settings</option><option value="5">Miscellaneous</option></select></div>
                                </div>
                            </div>
							<div id="tab_holder">
                            	<div id="tab_items">
                                    <div id="tab_items"><input type="button" value="Delete Article" data-article-id="'.$a_id.'" class="add red" id="delete_article" style="width:102px;position: relative;z-index: 10;"></div>
                                    <div id="tab_items"><input type="button" value="Save Edits" data-article-id="'.$a_id.'" class="add blue" id="save_article" style="width:102px;position: relative;z-index: 10;"></div>
                                </div>
                            </div>
                            <div id="tab_holder">
                            	<div id="tab_items">
                                    <div id="tab_items">Article Content:</div>
                                    <div id="tab_items"><div id="a_content" contenteditable="true" style="text-shadow:none;line-height:24px;width:500px;height:350px;">'.$a_content.'</div></div>
                                </div>
                            </div>
                        </form>
				<script>
					$(document).ready( function() {
						$("form[name=\'edit article\'] input[name=\'a_category\']").val(\''.$a_category.'\');

						$("#delete_article").click(function (){
							var article_id = $(this).data(\'article-id\');
							$("#overlay").fadeIn();
							$("#overlay").after("<div id=\'notif\'></div>");
							$("#notif").load("notif.php?action=delete&form=article&id='.$a_id.'");
						});
						$("#save_article").click(function (){

						});
					});
				</script>');
	}
}
if($action == 'new_a'){	
	if(!isset($_POST['title']) || !isset($_POST['category']) || !isset($_POST['content'])){
		$output = json_encode(array('type'=>'message', 'text' => 'Error of some sort'));
		die($output);
	}

		$code = generateRandomString(8);
		$qry = "INSERT INTO knowledge_base(kb_id, kb_title, kb_category, kb_content, kb_date, kb_poster) VALUES('$code','$title','$category','$content','$date','$login')";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if(!$result)
		{
			$output = json_encode(array('type'=>'error', 'text' => 'Could not add article '.$login.'! Fix it!'));
			die($output);
		}else{
			$output = json_encode(array('type'=>'message', 'text' => 'Hi '.$login.', the following article has been added: <b>'.$title.'</b>.'));
			die($output);
		}
}
if($action == 'save_a'){	
	if(!isset($_GET['title']) || ($_GET['category']) || ($_GET['content'])){
		$output = json_encode(array('type'=>'message', 'text' => 'Error of some sort'));
		die($output);
	}
			
		$code = generateRandomString(8);
		$qry = "INSERT INTO knowledge_base(kb_id, kb_title, kb_category, kb_content, kb_date, kb_poster) VALUES('$code','$title','$category','$content','$date','$login')";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if(!$result)
		{
			$output = json_encode(array('type'=>'error', 'text' => 'Could not add article '.$login.'! Fix it!'));
			die($output);
		}else{
			$output = json_encode(array('type'=>'message', 'text' => 'Hi '.$login.', the following article has been added: <b>'.$title.'</b>.'));
			die($output);
		}
}
if($action == 'delete_a'){	
/*	if(!isset($_GET['title']) || ($_GET['category']) || ($_GET['content'])){
		$output = json_encode(array('type'=>'message', 'text' => 'Error of some sort'));
		die($output);
	}
*/
	$qry = "SELECT * FROM knowledge_base WHERE kb_id='$article'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $qry);
	while($row = mysqli_fetch_assoc($result)){
		$a_title = $row['kb_title'];
	}
		$qry = "DELETE FROM knowledge_base WHERE kb_id='$article'";
		//Check whether the query was successful or not
		$result = @mysqli_query($GLOBALS["___mysqli_ston"], $qry);
		if(!$result)
		{
			$output = json_encode(array('type'=>'error', 'text' => "There was an error in deleting this article."));
			die($output);
		}else{
			$output = json_encode(array('type'=>'message', 'text' => "The article <b>$a_title</b> has successfully been deleted."));
			die($output);
		}
}
?>