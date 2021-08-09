<?php
session_start();
if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
require '../model/dataaccess.php';
$rows = [];
$user = array();
$courseErr = "";
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
						$sql = "SELECT * FROM enrolledcourse WHERE sId = (SELECT id FROM users WHERE email = '$email')";
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
</head>
<body>
		<div class="container">

			<ul class="nav nav-pills justify-content-center mt-5  ">
				<li class="nav-items">
					<a class="nav-link active " href="http://localhost/College_Management_PHP_Bootstrap/students/home.php">Home</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active " href="http://localhost/College_Management_PHP_Bootstrap/students/viewProfile.php">View Profile</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active" href="http://localhost/College_Management_PHP_Bootstrap/students/editProfile.php">Edit Profile</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active" href="http://localhost/College_Management_PHP_Bootstrap/students/gradeReport.php">Grade Report</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active" href="http://localhost/College_Management_PHP_Bootstrap/students/offeredCourses.php">Offered Courses</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active" href="http://localhost/College_Management_PHP_Bootstrap/students/offeredCourses.php">Registration</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active" href="http://localhost/College_Management_PHP_Bootstrap/logout.php">Logout</a>
				</li>
			</ul>

			<div class="row justify-content-center  mt-5">
				<div class="col-md-10">
					<table class="table">
						<thead>
							<tr class="bg-info">
								<th colspan="4" class="display-8 text-light">Class Schedule</th>
							</tr>
						</thead>
						<tbody>


							<?php if(!empty($rows)){ ?>
								<tr>
									<td>Sunday</td>
									<?php foreach($rows as $course){
										if($course["day"] == "sunday"){ ?>
											<td> <a href="http://localhost/College_Management_PHP_Bootstrap/students/classDetails.php?eid=<?php echo $course["id"]; ?>"><div class="d-inline-block">
													<p class="display-6 h6 font-weight-bold"><?php echo $course["cName"]; ?> </p>
													<small><?php echo $course["time"]." "; ?><span class="badge badge-success">Valid</span></small>
												  </div></a>
											</td>
										<?php }
									} ?>
								</tr>
								<tr>
									<td>Monday</td>
									<?php foreach($rows as $course){
										if($course["day"] == "monday"){ ?>
											<td> <a href="http://localhost/College_Management_PHP_Bootstrap/students/classDetails.php?eid=<?php echo $course["id"]; ?>"><div class="d-inline-block">
													<p class="display-6 h6 font-weight-bold"><?php echo $course["cName"]; ?> </p>
													<small><?php echo $course["time"]." "; ?><span class="badge badge-success">Valid</span></small>
												  </div></a>
											</td>
										<?php }
									} ?>
								</tr>
								<tr>
									<td>Tuesday</td>
									<?php foreach($rows as $course){
										if($course["day"] == "tuesday"){ ?>
											<td> <a href="http://localhost/College_Management_PHP_Bootstrap/students/classDetails.php?eid=<?php echo $course["id"]; ?>"><div class="d-inline-block">
													<p class="display-6 h6 font-weight-bold"><?php echo $course["cName"]; ?> </p>
													<small><?php echo $course["time"]." "; ?><span class="badge badge-success">Valid</span></small>
												  </div></a>
											</td>
										<?php }
									} ?>
								</tr>
								<tr>
									<td>Wednesday</td>
									<?php foreach($rows as $course){
										if($course["day"] == "wednesday"){ ?>
											<td> <a href="http://localhost/College_Management_PHP_Bootstrap/students/classDetails.php?eid=<?php echo $course["id"]; ?>"><div class="d-inline-block">
													<p class="display-6 h6 font-weight-bold"><?php echo $course["cName"]; ?> </p>
													<small><?php echo $course["time"]." "; ?><span class="badge badge-success">Valid</span></small>
												  </div></a>
											</td>
										<?php }
									} ?>
								</tr>
								<tr>
									<td>Thursday</td>
									<?php foreach($rows as $course){
										if($course["day"] == "thursday"){ ?>
											<td> <a href="http://localhost/College_Management_PHP_Bootstrap/students/classDetails.php?eid=<?php echo $course["id"]; ?>"><div class="d-inline-block">
													<p class="display-6 h6 font-weight-bold"><?php echo $course["cName"]; ?> </p>
													<small><?php echo $course["time"]." "; ?><span class="badge badge-success">Valid</span></small>
												  </div></a>
											</td>
										<?php }
									} ?>
								</tr>

							<?php }
							else{ echo $courseErr; } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	   <div style="margin-top:1px;"></div>
      <script src="../js/jquery-slim.min.js"></script>
      <script src="../js/popper.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
</body>
</html>
