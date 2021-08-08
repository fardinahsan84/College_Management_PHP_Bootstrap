<?php
session_start();
if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
require '../model/dataaccess.php';
require 'gradeCalculate.php';

$rows = [];
$user = array();
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
            $email = $_SESSION["email"];
            $sql = "SELECT * FROM users WHERE email = '$email'";
						$result = $connection->query($sql);

						if($result->num_rows > 0)
						{
								while($row = $result->fetch_assoc())
								{
										$user = $row;
								}
						}

						$sId = $user["id"] ;
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
			}
		?>
    <title>Home page</title>
    <style media="screen">
      td {
        text-align: center;
      }
    </style>
</head>
<body>
		<div class="container">
			<?php require 'nav.php'; ?>

			<div class="container my-5">
        <div class="card">
            <div class="card-header bg-info text-white align-items-end">
              <div class="row justify-content-between">
                    <div class="d-inline-block ml-2">
                      <h4>Grade report</h4>
                    </div>
                    <div class="d-inline-block mr-2">
                      <a class=" text-white" style="text-decoration:none;" href="http://localhost/College_Management_PHP_Bootstrap/pdf.php?sId=<?php echo $sId; ?>">
												<p class="h5">Print-<i class="fa fa-print" aria-hidden="true"></i></p> </a>
                    </div>
                </div>
            </div>
            <div class="card-body ">
							<div class="row justify-content-center">
								<div class="col-md-10">
                  <?php if(!empty($rows)){ ?>
		                <table class="table">
											<thead class="text-center table-info">
												<th >Course Name</th>
                        <th >Midterm grade</th>
                        <th>Final term grade</th>
                        <th>Final Grade</th>
											</thead>
											<tbody>
                        <?php foreach($rows as $course){

                            $midTotal = $course["midQuiz1"]+$course["midQuiz2"]+$course["midPerformance"]+ $course["midAttendence"]+$course["midExam"];
                            $finalTotal = $course["finalQuiz1"]+$course["finalQuiz2"]+$course["finalPerformance"]+ $course["finalAttendence"]+$course["finalExam"];
                            $total = ($midTotal*0.4)+($finalTotal*0.6);
                           ?>
													<tr class="">
				                		<td class="text-left"><?php echo $course["cName"]; ?></td>
														<td><?php echo gradeCalculate($midTotal); ?></td>
                            <td><?php echo gradeCalculate($finalTotal);  ?></td>
                            <td><?php echo gradeCalculate($total); ?></td>
				                	</tr>
                        <?php } ?>
											</tbody>
		                </table>
                  <?php }
                  else{
                    echo "No result published yet!!";
                  } ?>

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
