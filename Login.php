<?php
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <title>Login Form</title>
    <?php
    $passwordErr = $emailErr = $U_P_Err = "";

    $email = $password =  "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
      if($email != "" && $password!= ""){

          $host = "localhost";
          $user = "root";
          $pass = "";
          $db   = "college_management";

          $conn = new mysqli($host, $user, $pass, $db);

          if($conn->connect_error){
            die("connection failed:" . $conn->connect_error);
          }
          else{

                $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
                $result = $conn->query($sql);

                if($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc())
                    {
                        $_SESSION["email"] = $row["email"];
                        $_SESSION["password"] = $row["password"];

                        header('Location: http://localhost/College_Management_PHP_Bootstrap/students/home.php');
                        exit();
                    }
                }
                else{
                  $U_P_Err = "Invalid Email/Password!";
                }
          }
      }
      elseif($email == "" && $password == ""){

          $emailErr = "";
          $passwordErr = "";
          $U_P_Err = "*Email/Password required!";
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

  <nav class="navbar navbar-light bg-info navbar-dark navbar-expand-md">
      <div class="container">
        <a class="navbar-brand" href="http://localhost/College_Management_PHP_Bootstrap/login.php">FAI College Dhaka</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto" >
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active"
                    data-toggle="dropdown" href="#">Services</a>
                    <div class="dropdown-menu bg-info ">
                      <a href="#" class="dropdown-item">Servise 1</a>
                      <a href="#" class="dropdown-item">Servise 2</a>
                      <a href="#" class="dropdown-item">Servise 3</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Contact</a>
                </li>
            </ul>

          </div>
        </div>
    </nav>

      <div class="container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="px-5 py-5  mt-5">
              <div class="row justify-content-center">
                  <div class="col-md-4">
                    <div class="card bg-light" style="width: 23rem; height: 20rem;">
                      <div class="card-body">
                        <h4 class="display-8 text-center mb-3">LOGIN</h4>
                        <div class="input-group mt-4">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="material-icons">person</i></span>
                                </div>
                                <input class="form-control form-control-sm" type="email" placeholder="email" id="email" name="email" >
                            </div>

                          <div class="input-group mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key " style="font-size:24px;"></i></span>
                              </div>
                              <input class="form-control form-control-sm" type="password" placeholder="password" id="password" name="password" >
                              <div class="input-group-append">
                                <span class="input-group-text" onclick="myPass();" >
                                  <i class="fas fa-eye" id="show_eye"></i>
                                  <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                </span>
                              </div>
                          </div>

                          <button type="submit" id="submit" class="btn btn-primary btn-md btn-block mt-3">Sign in</button>
                          <div class="display-10 text-center mt-2">
                            <span style="color:red;"> <?php echo $U_P_Err.$emailErr.$passwordErr;?></span><br>
                            <span ><a href="#">Forget Password?</a><br>
                                <a href="http://localhost/College_Management_PHP_Bootstrap/register.php">Register now!!</a></span>
                              </div>
                      </div>
                  </div>
                </div>
            </div>
          </form>
          </div>
          <script  type="text/javascript">
              function myPass(){
                var x = document.getElementById("password");
                var show_eye = document.getElementById("show_eye");
                var hide_eye = document.getElementById("hide_eye");
                hide_eye.classList.remove("d-none");
                if (x.type === "password") {
                  x.type = "text";
                  show_eye.style.display = "none";
                  hide_eye.style.display = "block";
                } else {
                  x.type = "password";
                  show_eye.style.display = "block";
                  hide_eye.style.display = "none";
                }
            }
          </script>

      <div style="margin-top:1px;"></div>
      <script src="js/jquery-slim.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
  </body>
  </html>
