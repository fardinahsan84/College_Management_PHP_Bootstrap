<?php
session_start();
if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
require '../model/dataaccess.php';
require 'gradeCalculate.php';;
$course = array();
$resultErr = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
		<?php
			if($connection->connect_error){
				die("connection failed:" . $connection->connect_error);
			}
			else{
						$eId = $_GET["eid"] ;
						$sql = "SELECT * FROM enrolledcourse WHERE id = '$eId'";
						$result = $connection->query($sql);

						if($result->num_rows > 0)
						{
								while($row = $result->fetch_assoc())
								{
										$course = $row;
								}
						}
						else{
							$resultErr = "No result Available!!";
						}
			}
		?>
    <title>Home page</title>
</head>
<body>
		<div class="container">
			<?php require 'nav.php'; ?>

			<div class="container my-5">
        <div class="card">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a href="http://localhost/College_Management_PHP_Bootstrap/students/classDetails.php?eid=<?php echo $_GET["eid"]; ?>" class="nav-link ">Notes</a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/College_Management_PHP_Bootstrap/students/notice.php?eid=<?php echo $_GET["eid"]; ?>" class="nav-link">Notices</a>
                </li>
								<li class="nav-item">
                  <a href="http://localhost/College_Management_PHP_Bootstrap/students/assignment.php?eid=<?php echo $_GET["eid"]; ?>" class="nav-link">Assignment</a>
                </li>
								<li class="nav-item">
                  <a href="http://localhost/College_Management_PHP_Bootstrap/students/result.php?eid=<?php echo $_GET["eid"]; ?>" class="nav-link active">Result</a>
                </li>
              </ul>
            </div>
            <div class="card-body ">
							<div class="row">
								<div class="col-md-3">
		                <table class="table">
											<thead class="text-center table-info">
												<th colspan="2">Mid Term</th>
											</thead>
											<tbody>
				                	<tr>
				                		<td>Quiz 1(20)</td>
														<td><?php echo $course["midQuiz1"]; ?></td>
				                	</tr>
													<tr>
				                		<td>Quiz 2(20)</td>
														<td><?php echo $course["midQuiz2"]; ?></td>
				                	</tr>
													<tr>
				                		<td>Performance(10)</td>
														<td><?php echo $course["midPerformance"]; ?></td>
				                	</tr>
													<tr>
				                		<td>Attendence(10)</td>
														<td><?php echo $course["midAttendence"]; ?></td>
				                	</tr>
													<tr>
				                		<td>Mid exam(40)</td>
														<td><?php echo $course["midExam"]; ?></td>
				                	</tr>
													<tr class="">
				                		<th>Mid term marks</th>
														<th><?php echo $mt = $course["midQuiz1"]+$course["midQuiz2"]+$course["midPerformance"]+ $course["midAttendence"]+$course["midExam"]; ?></th>
				                	</tr>
											</tbody>
		                </table>
									</div>
									<div class="col-md-3 mx-auto">
			                <table class="table">
												<thead class="text-center table-info">
													<th colspan="2">Final Term</th>
												</thead>
												<tbody>
													<tr>
														<td>Quiz 1(20)</td>
														<td><?php echo $course["finalQuiz1"]; ?></td>
													</tr>
													<tr>
														<td>Quiz 2(20)</td>
														<td><?php echo $course["finalQuiz2"]; ?></td>
													</tr>
													<tr>
														<td>Performance(10)</td>
														<td><?php echo $course["finalPerformance"]; ?></td>
													</tr>
													<tr>
														<td>Attendence(10)</td>
														<td><?php echo $course["finalAttendence"]; ?></td>
													</tr>
													<tr>
				                		<td>Final exam(40)</td>
														<td><?php echo $course["finalExam"]; ?></td>
				                	</tr>
													<tr class="">
				                		<th>Final term marks</th>
														<th><?php echo $ft = $course["finalQuiz1"]+$course["finalQuiz2"]+$course["finalPerformance"]+ $course["finalAttendence"]+$course["finalExam"]; ?></th>
				                	</tr>
												</tbody>
			                </table>
										</div>
										<div class="col-md-4 ml-auto">
				                <table class="table table-borderless mt-5">

													<tbody>
														<tr class="h5">
															<td>Mid term(40%)</td>
															<td><?php echo $mft = ($mt*0.4); ?></td>
														</tr>
														<tr class="h5">
															<td>Final term(60%)</td>
															<td><?php echo $ftf = ($ft*0.6); ?></td>
														</tr>
														<tr class="h4 text-success">
					                		<th>Final Grade</th>
															<th ><?php $total=$mft+$ftf; echo gradeCalculate($total)."(".($mft+$ftf).")";?></th>
					                	</tr>
													</tbody>
				                </table>
											</div>
								</div>
            </div>
          </div>
			</div>
		</div>

	   <div style="margin-top:1px;"></div>
      <script src="../js/jquery-slim.min.js"></script>
      <script src="../js/popper.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
</body>
</html>
