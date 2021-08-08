<?php
require 'model/dataaccess.php';

$sameEmailErr=" ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    else{
				$email = test_input($_POST["email"]);
				$emailSql = "SELECT * FROM users WHERE email = '$email'";
				$result = $connection->query($emailSql);
				if($result->num_rows < 1)
				{
						$fname = test_input($_POST["fname"]);
						$lname = test_input($_POST["lname"]);
						$pass = test_input($_POST["pass"]);
						$phone = test_input($_POST["phone"]);
						$gender = test_input($_POST["gender"]);
						$address = test_input($_POST["address"]);
						$dob = test_input($_POST["dob"]);

		  			$sql = "INSERT INTO users (firstName, lastName, email,  password, phone, gender, address, dob)
		  					VALUES ('$fname', '$lname', '$email' ,'$pass', '$phone','$gender', '$address', '$dob')";

				  			if ($connection->query($sql) === TRUE) {
				    				echo "New record created successfully";
				    				header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
				    				exit();
				  			}
								$connection->close();
				}else{
					$connection->close();
					$sameEmailErr = "*This email already exist...";
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
<html>
<head>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/entryForm.css">
	<script>
		function validation(){
			var fname = document.register.fname;
			var lname = document.register.lname;
			var email = document.register.email;
			var pass = document.register.pass;
			var cpass = document.register.cpass;
			var phone = document.register.phone;
			var dob = document.register.dob;
			var address = document.register.address;
			var gender = document.register.gender;

			if( fname.value==""  || lname.value=="" || email.value=="" ||  pass.value=="" ||  cpass.value=="" ||  phone.value=="" ||  dob.value=="" ||  address.value=="" ||  gender.value=="" ){

				if(fname.value==""){
					fname.style.borderColor="red";
					document.getElementById("fnameErr").innerHTML="Please, fillup first name!";
				}
				if(lname.value==""){
					lname.style.borderColor="red";
					document.getElementById("lnameErr").innerHTML="Please, fillup last name!";
				}
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
				if(phone.value==""){
					phone.style.borderColor="red";
					document.getElementById("phoneErr").innerHTML="Please, fillup Phone no!";
				}
				if(dob.value==""){
					dob.style.borderColor="red";
					document.getElementById("dobErr").innerHTML="Please, select Birth Date!";
				}
				if(address.value==""){
					address.style.borderColor="red";
					document.getElementById("addressErr").innerHTML="Please, fillup address!";
				}
				if(gender.value==""){
					//gender.style.borderColor="red";
					document.getElementById("genderErr").innerHTML="Please, select gender!";
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
	<title>Registration form</title>
</head>
<body>

	<div class="testbox">
	  <h1>Registration</h1>

	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"  name="register" onsubmit="return validation()">
	    <?php //$admin=$users->getUserByEmailPass($_SESSION["email"],$_SESSION["password"]); ?>
	<hr>

	  <label id="txt" for="fname">First Name</label>
	  <input type="text" name="fname" id="fname" />
		<span id="fnameErr"></span>

	  <label id="txt" for="lname">Last Name</label>
	  <input type="text" name="lname" id="lname" />
		<span id="lnameErr"></span>

	  <label id="txt" for="email">Email</label>
	  <input type="text" name="email" id="email" />
		<span id="emailErr"><?php echo $sameEmailErr;?></span>

	  <label id="txt" for="pass">password</label>
	  <input type="password" name="pass" id="pass" />
		<span id="passErr"> </span>

	  <label id="txt" for="cpass">Confirm password</label>
	  <input type="password" name="cpass" id="cpass" />
		<span id="cpassErr"></span>


	  <label id="txt" for="phone">Mobile no</label>
	  <input type="number" name="phone" id="phone" />
		<span id="phoneErr"></span>

	  <label id="txt" for="dob">Date Of Birth</label>
	  <input type="date" name="dob" id="dob" />
		<span id="dobErr"></span>

	  <label id="txt" for="address">Address</label>
	  <input type="text" style="height:90px;" name="address" id="address" /><br>
		<span id="addressErr"></span><br><br>

	  <label id="txt" for="gender">Gender</label>
	    <input type="radio" value="male" id="male" name="gender"/>
	    <label for="male" class="radio" >Male</label>
	    <input type="radio" value="female" id="female" name="gender" />
	    <label for="female" class="radio">Female</label>
			<span id="genderErr"></span><br><br>


	   <p>By clicking Update your data will register, if you wish to reset<a href="http://localhost/College_Management_PHP_Bootstrap/register.php">click here!</a></p>

	   <input class="button" type="submit" value="Register" name="submit" id="submit" />
	  </form>

	</div>
</body>
</html>
