<?php
session_start();

if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
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
					<a class="nav-link active" href="#">Edit Profile</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active" href="#">Results</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active" href="#">Notice</a>
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
								<th colspan="2" class="display-8 text-light">Class Schedule</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Saturday</td>
								<td><a href="#"><div class="d-inline-block">
										    <p class="display-6">Object Oriented Programming-2 </p>
										    Time: 12:30 PM- 02:00 PM
									  </div></a>
									  <a href="#"><div class="d-inline-block ml-5">
										    <p class="display-6">Engineering Ethics</p>
										    Time: 02:00 PM- 05:00 PM
									  </div></a>
								</td>
							</tr>
							<tr>
								<td>Sunday</td>
								<td>Computed Aided and Design</td>
							</tr>
							<tr>
								<td>Monday</td>
								<td><span>Engineering Ethics</span><br><span>Web technologies</span></td>
							</tr>
							<tr>
								<td>Tuesday</td>
								<td><span>Object Oriented programming-2</span><br><span>Research Methodology</span></td>
							</tr>
							<tr>
								<td>Tuesday</td>
								<td><span>Object Oriented programming-2</span><br><span>Research Methodology</span></td>
							</tr>
							<tr>
								<td>Wednesday</td>
								<td><span>Database management System</span><br><span>Web technologies</span></td>
							</tr>

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
