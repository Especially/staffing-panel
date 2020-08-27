<?php
//ini_set("log_errors", 1);
/************************************************
	The Search PHP File
************************************************/


/************************************************
	MySQL Connect
************************************************/

// Credentials
$dbhost = "localhost";
$dbname = "staffing_panel";
$dbuser = "staffing_admin";
$dbpass = "KrYpTeD89";

//	Connection
global $tutorial_db;

$tutorial_db = new mysqli();
$tutorial_db->connect($dbhost, $dbuser, $dbpass, $dbname);
$tutorial_db->set_charset("utf8");

//	Check Connection
if ($tutorial_db->connect_errno) {
    printf("Connect failed: %s\n", $tutorial_db->connect_error);
    exit();
}

/************************************************
	Search Functionality
************************************************/

// Define Output HTML Formating
$html = '';
$html .= '<a target="_blank" class="clicktype" onclick="clickString">';
$html .= '<li class="result">';
$html .= '<h3>nameString</h3>';
$html .= '<h4><div class="findr-info"><div class="findr-numbers">phoneString</div><div class="findr-address">streetString</div></div></h4>';
//$html .= '<h4><div class="findr-info"><div class="findr-address">streetString</div><div class="findr-middle">|</div><div class="findr-numbers">phoneString</div></div></h4>';
$html .= '</li>';
$html .= '</a>';

// Get Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $tutorial_db->real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ' && $search_string !== '%') {
	// Build Query
//SOUNDEX 	$query = 'SELECT "location" as table_name,code,name,street,null,city,postal,is_type,type,type_number,phone,alternate FROM location WHERE SOUNDEX(name) LIKE SOUNDEX("%'.$search_string.'%") UNION ALL SELECT "employee" as table_name,euid,fname,street,sname,city,postal,is_type,type,type_number,phone,alternate FROM employee WHERE SOUNDEX(fname) LIKE SOUNDEX("%'.$search_string.'%") OR SOUNDEX(sname) LIKE SOUNDEX("%'.$search_string.'%") ORDER BY name,NULL LIMIT 10';
	$query = 'SELECT "location" as table_name,code,name,street,null,city,postal,is_type,type,type_number,phone,alternate FROM location WHERE name LIKE "%'.$search_string.'%" UNION ALL SELECT "employee" as table_name,euid,fname,street,sname,city,postal,is_type,type,type_number,phone,alternate FROM employee WHERE fname LIKE "%'.$search_string.'%" OR sname LIKE "%'.$search_string.'%" ORDER BY name,NULL LIMIT 10';
	// Do Search
	$result = $tutorial_db->query($query);
	while($results = $result->fetch_array()) {
		$result_array[] = $results;
	}

	// Check If We Have Results
	if (isset($result_array)) {
		foreach ($result_array as $result) {
				$type = $result['is_type'];
				$table = $result['table_name'];
				$last = $result['NULL'];
				$typenum = $result['type_number'];
				$typename = $result['name'];
				$nom = ($typename.','.$table);
				$nom2 = ($typename.','.$table);
				$street = $result['street'];
                $code = $result['code'];
				if(strpos("x".$nom,',location') !==false){
					if($type=='false'){
						$nom = strtok($nom, ',');
					}
					if($type=='true'){
						$nom = strtok($nom, ',');
						$nom = ($typename.' ('.$result['type'].' #'.$result['type_number'].')');
					}
				}
				if(strpos("x".$nom,',employee') !==false){
					if($type=='false'){
						$nom = strtok($nom, ',');
						$nom = ($typename.', '.$result['NULL']);
						$steez = "$street<br>$city, ON<br>$postal";
					}
					if($type=='true'){
						$nom = strtok($nom, ',');
						$nom = ($typename.', '.$result['NULL']);
					}
				}
			// Format Output Strings And Hightlight Matches
			$street = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['street']);
			$name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $nom);
			$fname = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['fname']);
			$sname = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['sname']);
			$tnum = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['tnum']);
			$phone = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['phone']);
			$alt = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['alternate']);
//			$display_url = 'http://php.net/manual-lookup.php?pattern='.urlencode($result['function']).'&lang=en';			
			$city = $result['city'];
			$postal = $result['postal'];
			$postal = strtoupper($postal);
			if ($name !== ''){

			// Insert Number
			if ($alt !== ''){
				$num = "<div class='phone'><i class='fa fa-phone'></i>&nbsp;$phone</div><div class='phone'><i class='fa fa-phone'></i>&nbsp;$alt</phone>";
			}
			if ($alt == ''){
				$num = "<div class='phone'><i class='fa fa-phone'></i>&nbsp;$phone</div>";
			}
			$steez = "$street<br>$city, ON<br>$postal";
				if(strpos("x".$nom2,',employee') !==false){
					$display_url = 'profile(&quot;'.$code.'&quot;)';
					$class_type = 'pel-t';
					if($type=='true'){
						$steez = "$typenum-$steez";
					}
                    $sh_q = "SELECT * FROM shifts WHERE euid = '$code' AND filled='1' AND cancelled='0' ORDER BY date DESC LIMIT 3";
                    $re_q = $tutorial_db->query($sh_q);
                    if ($re_q > 0) {
                        while($reqs = $re_q->fetch_array()) {
                            $re_q_array[] = $reqs;
                        }
                        if (isset($re_q_array)) {  
                            foreach ($re_q_array as $re_q) {
                                if ($current !== $re_q['euid']){
                                    $shifts = null;
                                    unset($shifts);
                                }
                                $current = $re_q['euid'];
                                $site = $re_q['name'];
                                $date = date("M jS", strtotime($re_q['date']));
                                $hour = $re_q['IN1'];
                                $minute = $re_q['IN2'];
                                $time_12_hour_IN  = date("g:iA", strtotime("$hour:$minute"));
                                $hour2 = $re_q['OUT1'];
                                $minute2 = $re_q['OUT2'];
                                $time_12_hour_OUT  = date("g:iA", strtotime("$hour2:$minute2"));
                                if ($hour <= 10) {
                                    $shT = 'mshift';
                                }
                                if ($hour >= 11 && $in <= 16) {
                                    $shT = 'ashift';
                                }
                                if ($hour >= 17 && $in <= 23) {
                                    $shT = 'nshift';
                                }
                                $shifts .=  "<div class='$shT'><div class='fss'><i class='fa fa-clock-o'></i>&nbsp;$site</div><div class='fsd'>$date</div><div class='fst'>$time_12_hour_IN-$time_12_hour_OUT</div></div>";
                            }
                            $output = str_replace('streetString', $shifts, $html);// Shift Location, Day (e.g., April 5) @ TimeXM - Time XM
                        } else {
                            $output = str_replace('streetString', $steez, $html);
                        }
                    } else {
                        $output = str_replace('streetString', $steez, $html);
                    }
                    
				}else{
					$display_url = 'viewCal(&quot;'.$result['code'].'&quot;)';
					$class_type = 'pll-t';
                    $output = str_replace('streetString', $steez, $html);
				}
			$output = str_replace('nameString', $name, $output);
			
			// Insert Phone
			$output = str_replace('phoneString', $num, $output);

			// Insert Click Type
			$output = str_replace('clicktype', $class_type, $output);

			// Insert URL
			$output = str_replace('clickString', $display_url, $output);

			// Output
			echo($output);
			}
		}
	}else{

		// Format No Results Output
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('nameString', '<b>No Results Found.</b>', $output);
		$output = str_replace('<div class="findr-info"><div class="findr-address">streetString</div><div class="findr-middle">|</div><div class="findr-numbers">phoneString</div></div>', 'Perhaps try a different spelling?', $output);

		// Output
		echo($output);
	}
}


/*
// Build Function List (Insert All Functions Into DB - From PHP)

// Compile Functions Array
$functions = get_defined_functions();
$functions = $functions['internal'];

// Loop, Format and Insert
foreach ($functions as $function) {
	$function_name = str_replace("_", " ", $function);
	$function_name = ucwords($function_name);

	$query = '';
	$query = 'INSERT INTO search SET id = "", function = "'.$function.'", name = "'.$function_name.'"';

	$tutorial_db->query($query);
}
*/
?>