<?php
session_start();

if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
require '../model/dataaccess.php';
$user = array();
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$email = test_input($_POST["email"]);
		$pass = test_input($_POST["pass"]);
		$address = test_input($_POST["address"]);
		$id = $_POST["id"];
		echo basename($_FILES["file_field"]["name"]);
		$postUser =array();

		$sql = "SELECT * FROM users WHERE id = '$id'";
		$result = $connection->query($sql);
		if($result->num_rows > 0)
		{
				while($row = $result->fetch_assoc())
				{
						$postUser = $row;
				}
		}
	  if (empty($_POST["file_field"])) {
				$target_file = $postUser["image"] ;
				echo $postUser["image"];
				if ($connection->connect_error) {
						die("Connection failed: " . $connection->connect_error);
				}
				else{
						echo "Connection successful";
						$sql = "UPDATE users SET email='$email', image= '$target_file',
										password='$pass', address='$address' WHERE id='$id' ";
							if ($connection->query($sql) === TRUE) {
								echo "Updated successfully";
								header('Location:http://localhost/College_Management_PHP_Bootstrap/logout.php');
								exit();
							}
				}

	  } else {
		    $file_field = $_FILES["file_field"];
		    $target_dir = "../assets/images/";
				$target_file = $target_dir . basename($_FILES["file_field"]["name"]);
				if (move_uploaded_file($_FILES["file_field"]["tmp_name"], $target_file)){
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            else{
                echo "Connection successful";
                $sql = "UPDATE users SET email='$email', image= '$target_file',
                        password='$pass', address='$address' WHERE id='$id' ";
                  if ($connection->query($sql) === TRUE) {
                    echo "Updated successfully";
                    header('Location:http://localhost/College_Management_PHP_Bootstrap/logout.php');
                    exit();
                  }
            }
					}
					else{ echo "file upload error!!!";
			  	}
		  }

}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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
		<script>
			function validation(){
				var email = document.editProfile.email;
				var pass = document.editProfile.pass;
				var cpass = document.editProfile.cpass;
				var address = document.editProfile.address;
				var image = document.editProfile.file_field;

				if(email.value=="" ||  pass.value=="" ||  cpass.value=="" || address.value==""){

					if(email.value==""){
						email.style.borderColor="red";
						document.getElementById("emailErr").innerHTML="Please, fillup Email!";
					}
					if(pass.value==""){
						pass.style.borderColor="red";
						document.getElementById("passErr").innerHTML="Please, fillup Password!";
					}
					if(cpass.value==""){
						cpass.style.borderColor="red";
						document.getElementById("cpassErr").innerHTML="Please, fillup Confirm Password!";
					}

					if(address.value==""){
						address.style.borderColor="red";
						document.getElementById("addressErr").innerHTML="Please, fillup address!";
					}
					return false;
				}
				else if(pass.value != cpass.value){
					pass.style.borderColor ="red";
					cpass.style.borderColor ="red";
					document.getElementById("cpassErr").innerHTML="Password not matched!!"
					return false;
				}
				else{
					return true;
				}
			}
		</script>

    <title>Edit Profile</title>
</head>
<body>
		<div class="container">

			<?php require 'nav.php'; ?>

			<div class="container">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="editProfile" onsubmit="return validation()" enctype="multipart/form-data">
					<div class="row mt-5">
						<div class="col-md-4 text-center mt-3" >
							<img class="rounded-circle" atl="" src="<?=@$user["image"] ?>" height="200" width="200"><br><br>
							<button type="button" class="btn btn-outline-success btn-sm"><label for="file_field">Choose image</label></button>
							<input type="file" id="file_field"  name="file_field" value="<?php echo $user["image"] ?>" hidden />

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
				                        <span id="emailErr"></span>
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Password</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="password" name="pass" value="<?php echo $user["password"]; ?>" />
				                        <span id="passErr"></span>
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Confirm password</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="password" name="cpass" value="<?php echo $user["password"]; ?>" />
				                        <span id="cpassErr"></span>
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-3 col-form-label form-control-label">Address</label>
				                    <div class="col-md-9">
				                        <input class="form-control" type="text" name="address" value="<?php echo $user["address"]; ?>"/>
				                        <span id="addressErr"></span>
				                    </div>
				                </div>
				                <div class="form-group row ">
				                    <label class="col-md-3 col-form-label form-control-label"></label>
				                    <div class="col-md-9 mt-2">
				                        <input type="reset" class="btn btn-secondary" value="Cancel" />
				                        <input type="submit" name="submit" id="submit" value="Save changes" class="btn btn-primary">
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
