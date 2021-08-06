<?php
session_start();

if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
require '../model/dataaccess.php';
$user = array();
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
			}

			$cpassErr = $emailErr = $passwordErr = $addressErr = "";

			$email = $cpass = $password = $address = "";

			if ($_SERVER["REQUEST_METHOD"] == "POST") {

			 			$postUser =array();

			 			$id = $_POST["id"];
			 			$sql = "SELECT * FROM users WHERE id = '$id'";
						$result = $connection->query($sql);

						if($result->num_rows > 0)
						{
								while($row = $result->fetch_assoc())
								{
										$postUser = $row;
								}
						}

					  if (empty($_POST["email"])) {
					    $emailErr = "*Email is required";
					  } else {
					    $email = test_input($_POST["email"]);
					  }

					  if (empty($_POST["password"])) {
					    $passwordErr = "*Password is required";
					  } else {
					    $password = test_input($_POST["password"]);
					  }

					  if (empty($_POST["cpass"])) {
					    $cpassErr = "*Confirm Password is required";
					  } else {
					    $cpass = test_input($_POST["cpass"]);
					  }

					  if (empty($_POST["address"])) {
					    $addressErr = "*Address is required";
					  } else {
					    $address = test_input($_POST["address"]);
					  }

					  if (empty($_FILES["file_field"])) {

					  		echo $_POST["file_field"];
							$target_file = $postUser["image"] ;

					  } else {

						    $file_field = $_FILES["file_field"];
						    $target_dir = "../assets/images/";
							$target_file = $target_dir . basename($_FILES["file_field"]["name"]);

					  }

					  if($email != "" && $password != "" && $cpass != "" && $address != "" && $target_file != "")
					   {
					   		if (move_uploaded_file($_FILES["file_field"]["tmp_name"], $target_file)){
			                    if ($connection->connect_error) {
			                        die("Connection failed: " . $connection->connect_error);
			                    }
			                    else{
			                        echo "Connection successful";
			                        $sql = "UPDATE users SET email='$email', image= '$target_file',
			                                password='$password', address='$address' WHERE id='$id' ";
			                          if ($connection->query($sql) === TRUE) {
			                            echo "Updated successfully";

			                            header('Location:http://localhost/College_Management_PHP_Bootstrap/logout.php');
			                            exit();
			                          }
			                    }
						  }
						  else{ echo "file upload error!!!";}
					}
				}
				function test_input($data) {
				  $data = trim($data);
				  $data = stripslashes($data);
				  $data = htmlspecialchars($data);
				  return $data;
				}
?>
    <title>Edit Profile</title>
</head>
<body>
		<div class="container">

			<ul class="nav nav-pills justify-content-center mt-5  ">
				<li class="nav-items">
					<a class="nav-link active " href="http://localhost/College_Management_PHP_Bootstrap/students/home.php">Home</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active" href="http://localhost/College_Management_PHP_Bootstrap/students/viewProfile.php">View Profile</a>
				</li>
				<li class="nav-items">
					<a class="nav-link active" href="http://localhost/College_Management_PHP_Bootstrap/students/editProfile.php">Edit Profile</a>
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

			<div class="container">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
					<div class="row mt-5">
						<div class="col-md-4 text-center mt-3" >
							<img class="rounded-circle" atl="" src="<?=@$user["image"] ?>" height="200" width="200"><br><br>
							<button type="button" class="btn btn-outline-success btn-sm"><label for="file_field">Change image</label></button>
							<input type="file" id="file_field"  name="file_field" hidden />

						</div>
						<div class="col-md-8  personal-info">
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">ID </label>
				                    <div class="col-md-9">
				                        <input class="form-control" value="<?php echo $user["id"]; ?>" disabled />
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Name</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="text" value="<?php echo $user["firstName"]. " ".$user["lastName"]; ?>" disabled />
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Gender</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="text" value="<?php echo $user["gender"]; ?>" disabled />
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Date of Birth</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="text" value="<?php echo $user["dob"]; ?>" disabled />
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Email</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="email" name="email" value="<?php echo $user["email"]; ?>"/>
				                        <span style="color:red;"> <?php echo $emailErr;?></span>
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Password</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="password" name="password" value="<?php echo $user["password"]; ?>" />
				                        <span style="color:red;"> <?php echo $passwordErr;?></span>
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Confirm password</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="password" name="cpass" value="<?php echo $user["password"]; ?>" />
				                        <span style="color:red;"> <?php echo $cpassErr;?></span>
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Address</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="text" name="address" value="<?php echo $user["address"]; ?>"/>
				                        <span style="color:red;"> <?php echo $addressErr;?></span>
				                    </div>
				                </div>
				                <div class="form-group row ">
				                    <label class="col-md-3 col-form-label form-control-label"></label>
				                    <div class="col-md-9 mt-2">
				                        <input type="reset" class="btn btn-secondary" value="Cancel" />
				                        <button type="submit" class="btn btn-primary">Save Changes</button>
				                        <input class="form-control" type="number" name="id" value="<?php echo $user["id"]; ?>" hidden />
				                    </div>
				                </div>
				        </div>
					</div>
				</form>
			</div>


		</div>

	   <div style="margin-top:1px;"></div>
      <script src="../js/jquery-slim.min.js"></script>
      <script src="../js/popper.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
</body>
</html>
