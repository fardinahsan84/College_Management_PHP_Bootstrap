<?php
require_once('tcpdf/tcpdf.php');


$sId = $_GET["sId"] ;
// extend TCPF with custom functions
class MYPDF extends TCPDF {

    // Load table data from file
    public function LoadData($sId) {
        // Read file lines
        include 'model/dataaccess.php';
        $sql = "SELECT * FROM enrolledcourse WHERE sId = '$sId'";
        $result = $connection->query($sql);

        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $rows[] = $row;
            }
        }
        else{
          $courseErr = "No course registered yet!!";
        }
        return $rows;
    }

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        include 'students/gradeCalculate.php';

        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(80, 35, 35, 35);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $course) {
          $midTotal = $course["midQuiz1"]+$course["midQuiz2"]+$course["midPerformance"]+ $course["midAttendence"]+$course["midExam"];
    			$finalTotal = $course["finalQuiz1"]+$course["finalQuiz2"]+$course["finalPerformance"]+ $course["finalAttendence"]+$course["finalExam"];
    			$total = ($midTotal*0.4)+($finalTotal*0.6);

            $this->Cell($w[0], 6, $course["cName"], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, gradeCalculate($midTotal), 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, gradeCalculate($finalTotal), 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, gradeCalculate($total), 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('Grade Report');
$pdf->SetAuthor('FAI');
$pdf->SetTitle('FAI College Dhaka');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

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
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// column titles
$header = array('Course Title', 'Midterm grade', 'Final Term grade', 'Final grade');

// data loading
$data = $pdf->LoadData($sId);

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('gradeReport.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
