<?php
require 'model/dataaccess.php';
require 'students/gradeCalculate.php';
include('tcpdf/tcpdf.php');

//Get all courses of a student
$rows = [];
$sId = $_GET["sId"] ;
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

//make TCPDF object
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//remove default header footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetFont('helvetica', '', 9);
//add page
$pdf->AddPage();
//add content using cell
$pdf->Cell(190,10,"FAI College Dhaka",1,1,'C');
$total = 0;
$html = ' <table>
            <tr>
              <th >Course Name</th>
              <th >Midterm grade</th>
              <th>Final term grade</th>
              <th>Final Grade</th>
            </tr>
          </table>
          ';
$pdf->WriteHTML($html, true, 0, true, 0);

foreach($rows as $course){
			$midTotal = $course["midQuiz1"]+$course["midQuiz2"]+$course["midPerformance"]+ $course["midAttendence"]+$course["midExam"];
			$finalTotal = $course["finalQuiz1"]+$course["finalQuiz2"]+$course["finalPerformance"]+ $course["finalAttendence"]+$course["finalExam"];
			$total = ($midTotal*0.4)+($finalTotal*0.6);
			$midGrade = gradeCalculate($midTotal);
			$finalGrade = gradeCalculate($finalTotal);

			$html .= '
							<table>
								<tr >
									<td>'. $course["cName"] .'<td>
									<td>'. $midGrade .'<td>
									<td>'. $finalGrade .'<td>
									<td>'. $total .'<td>
								</tr>
						</table>
				' ;
			}

$pdf->WriteHTML($html, true, 0, true, 0);

//output
$pdf->lastPage();

$pdf->Output('gradeReport.pdf','I');

 ?>
