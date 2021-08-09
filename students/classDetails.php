<?php
session_start();
if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
require '../model/dataaccess.php';
$rows = [];
$name ="";
$noteErr = "";
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
						$sql = "SELECT *
										FROM notes
										WHERE eId ='$eId' ";
						$course_sql= "SELECT cName FROM enrolledcourse WHERE id = '$eId' ";
						$result = $connection->query($sql);
						$result2 = $connection->query($course_sql);
						if($result2->num_rows > 0){
								$name = $result2->fetch_assoc();
								if($result->num_rows > 0)
								{
										while($row = $result->fetch_assoc())
										{
												$rows[] = $row;
										}
								}
								else{
									$noteErr = "No notes Available!!";
								}
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
					<div class="card-header bg-primary text-light" >
								<h4><?php echo $name["cName"]; ?></h4>
						</div>
						<div class="card-body">
		        <div class="card">
		            <div class="card-header">
		              <ul class="nav nav-tabs card-header-tabs">
		                <li class="nav-item">
		                  <a href="http://localhost/College_Management_PHP_Bootstrap/students/classDetails.php?eid=<?php echo $_GET["eid"]; ?>" class="nav-link active">Notes</a>
		                </li>
		                <li class="nav-item">
		                  <a href="http://localhost/College_Management_PHP_Bootstrap/students/notice.php?eid=<?php echo $_GET["eid"]; ?>" class="nav-link">Notices</a>
		                </li>
										<li class="nav-item">
		                  <a href="http://localhost/College_Management_PHP_Bootstrap/students/assignment.php?eid=<?php echo $_GET["eid"]; ?>" class="nav-link">Assignment</a>
		                </li>
										<li class="nav-item">
		                  <a href="http://localhost/College_Management_PHP_Bootstrap/students/result.php?eid=<?php echo $_GET["eid"]; ?>" class="nav-link">Result</a>
		                </li>
		              </ul>
		            </div>
		            <div class="card-body">
		                <table class="table">
											<tbody>
												<?php if(!empty($rows)){
																foreach($rows as $note){ ?>
								                	<tr>
								                		<td><a href="download.php?filename=<?php echo $note["name"]; ?>" style="text-decoration:none;"><?php
																											echo $note["name"]; ?></a></td>
																		<td><?php echo $note["uploadDate"]; ?></td>
								                	</tr>
															<?php }
											 			}
												 else{ ?>
		 											<span> <?php echo $noteErr; ?></span>
		 										<?php } ?>
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
