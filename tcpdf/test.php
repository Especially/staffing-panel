<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
/************************************************
	MySQL Connect
************************************************/
session_start();
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
$location = filter_var($_GET["location"], FILTER_SANITIZE_STRING);
$sort = filter_var($_GET["sort"], FILTER_SANITIZE_STRING);
$sub = filter_var($_GET["sub"], FILTER_SANITIZE_STRING);
$term = filter_var($_GET["term"], FILTER_SANITIZE_STRING);
$month = filter_var($_GET["mo"], FILTER_SANITIZE_STRING);
$year = filter_var($_GET["ye"], FILTER_SANITIZE_STRING);
if ($term=='true'){
	$start_date = $year.'-'.$month.'-01';
	$end_date = $year.'-'.$month.'-15';
	$start_expand = date("D M jS, Y", strtotime($start_date));
	$end_expand = date("D M jS, Y", strtotime($end_date));
}
if ($term=='false'){
	$last = cal_days_in_month(CAL_GREGORIAN, $month, $year);;
	$start_date = $year.'-'.$month.'-16';
	$end_date = $year.'-'.$month.'-'.$last;
	$start_expand = date("D M jS, Y", strtotime($start_date));
	$end_expand = date("D M jS, Y", strtotime($end_date));
}
if ($sort=='all'){
	$sort_type='All';
	$sorting="";
}
if ($sort=='filled'){
	$sort_type='Filled';
	$sorting="filled='1' AND cancelled='0' AND";
}
if ($sort=='unfilled'){
	$sort_type='Unfilled';
	$sorting="filled='0' AND cancelled='0' AND";
}
if ($sort=='cancelled'){
	if ($sub=='all'){
		$sort_type='All Cancelled';
		$sorting="cancelled='1' AND";
	}
	if ($sub=='filled'){
		$sort_type='Cancelled & Filled';
		$sorting="cancelled='1' AND filled='1' AND";
	}
	if ($sub=='unfilled'){
		$sort_type='Cancelled & Unfilled';
		$sorting="cancelled='1' AND filled='0' AND";
	}
}
$loc = "SELECT * FROM location WHERE code='$location'";
$resultLoc = $mysqli->query($loc);
while ($rowLoc = $resultLoc->fetch_assoc()) {
	$type = $rowLoc['is_type'];
	if($type=='false'){
	$SESSION_LOCATION_NAME = $rowLoc['name'];
	$name = $SESSION_LOCATION_NAME;
	}
	if($type=='true'){
	$SESSION_LOCATION_NAME = $rowLoc['name'].' ('.$rowLoc['type'].' #'.$rowLoc['type_number'].')';
	$name = $SESSION_LOCATION_NAME;
	}
}

if ($sort=='all'){
	$one = '<td>Date</td><td>Location</td><td>Caller</td><td>Time In</td><td>Time Out</td><td title="Filled|Cancelled">Activity</td>		
        <td></td>';
}
$query = "SELECT * FROM shifts WHERE $sorting location='$location' AND date >= '$start_date' and date <= '$end_date' ORDER BY date ASC, IN1 ASC LIMIT 5";
$result = $tutorial_db->query($query);

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'logo_example.jpg';
		$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		// Title
		$this->Cell(0, 15, "$name Hi", 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Always Care Nursing Agency');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('Bi-Weekly');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'B', 12);

// add a page
$pdf->AddPage();
$two = '';
// set some text to print
$txt = <<<EOD
TCPDF Example 003
$one
Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOD;

// print a block of text using Write()
$pdf->writeHTML($one, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');
/* $pdf->Output('yourfilename.pdf', 'D');             OUTPUTS TO DIRECT DOWNLOAD.*/

//============================================================+
// END OF FILE
//============================================================+
?>
