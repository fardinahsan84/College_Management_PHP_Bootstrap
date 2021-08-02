<?php
require 'model/dataaccess.php';
?>
<!DOCTYPE html>
<html>
<head>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/entryForm.css">
	<title>Registration form</title>

<?php
$fnameErr = $lnameErr = $emailErr = $genderErr = $passErr = $cpassErr = $addErr = $dobErr = $phoneErr =  "";

$fname = $lname= $email = $gender = $pass = $cpass = $address = $dob = $phone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["fname"])) {
    $fnameErr = "*First name is required";
  } else {
	$fname = test_input($_POST["fname"]);
  }

  if (empty($_POST["lname"])) {
    $lnameErr = "*Last name is required";
  } else {
	$lname = test_input($_POST["lname"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "*Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }

  if (empty($_POST["email"])) {
    $emailErr = "*Email is required";
  } else {
    $email = test_input($_POST["email"]);
  }

  if (empty($_POST["pass"])) {
    $passErr = "*Password is required";
  } else {
    $pass = test_input($_POST["pass"]);
  }

  if (empty($_POST["cpass"])) {
    $cpassErr = "Confirm password is required";
  } else {
    $cpass = test_input($_POST["cpass"]);
  }

  if (empty($_POST["phone"])) {
    $phoneErr = "*Mobile no is required";
  } else {
    $phone = test_input($_POST["phone"]);
  }

  if (empty($_POST["dob"])) {
    $dobErr = "*Date of Birth is required";
  } else {
    $dob = test_input($_POST["dob"]);
  }

   if (empty($_POST["address"])) {
    $addErr = "*Address is required";
  } else {
    $address = test_input($_POST["address"]);
  }

  if($fname != "" && $lname != "" && $email != "" && $gender !="" && $pass != "" 
  		&& $cpass != "" && $phone != "" && $dob != "" && $address != "") 
   {
   		if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        else{
  			echo "Connection successful";
  			
  			$sql = "INSERT INTO users (firstName, lastName, email,  password, phone, gender, address, dob)
  					VALUES ('$fname', '$lname', '$email' ,'$pass', '$phone','$gender', '$address', '$dob')"; 

  			if ($connection->query($sql) === TRUE) {
    				echo "New record created successfully";
    				header('Location: http://localhost/My Project/Project/login.php');
    				exit();
  			}

  			$conn->close();
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
</head>
<body>
	<div class="testbox">
	  <h1>Registration</h1>

	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	    <?php //$admin=$users->getUserByEmailPass($_SESSION["email"],$_SESSION["password"]); ?>
	<hr>
	  <span class="error"> <?php echo $fnameErr;?></span>
	  <label id="txt" for="fname">First Name</label>
	  <input type="text" name="fname" id="fname" />

	  <span class="error"> <?php echo $lnameErr;?></span>
	  <label id="txt" for="lname">Last Name</label>
	  <input type="text" name="lname" id="lname" />

	  <span class="error"> <?php echo $emailErr;?></span>
	  <label id="txt" for="email">Email</label>
	  <input type="email" name="email" id="email" />

	  <span class="error"> <?php echo $passErr;?></span>
	  <label id="txt" for="pass">password</label>
	  <input type="password" name="pass" id="pass" />

	  <span class="error"> <?php echo $cpassErr;?></span>
	  <label id="txt" for="cpass">Confirm password</label>
	  <input type="password" name="cpass" id="cpass" />

	  <span class="error"> <?php echo $phoneErr;?></span>
	  <label id="txt" for="phone">Mobile no</label>
	  <input type="number" name="phone" id="phone" />

	  <span class="error"> <?php echo $dobErr;?></span>
	  <label id="txt" for="dob">Date Of Birth</label>
	  <input type="date" name="dob" id="dob" />

	  <span class="error"> <?php echo $addErr;?></span>
	  <label id="txt" for="address">Address</label>
	  <input type="text" style="height:90px;" name="address" id="address" /><br>

	  <span class="error"> <?php echo $genderErr;?></span><br>
	  <label id="txt" for="gender">Gender</label>
	    <input type="radio" value="male" id="male" name="gender"/>
	    <label for="male" class="radio" >Male</label>
	    <input type="radio" value="female" id="female" name="gender" />
	    <label for="female" class="radio">Female</label>


	   <p>By clicking Update your data will update, if you wish to <a href="/BDBooks/admin/home.php">cancel</a>click here!</p>

	   <input class="button" type="submit" value="Register" />
	  </form>
	</div>
</body>
</html>