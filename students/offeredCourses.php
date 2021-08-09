<?php
session_start();
if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
require '../model/dataaccess.php';

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

    <title>All courses page</title>
</head>
<body>
		<div class="container">
			<?php require 'nav.php'; ?>
      <div class="container my-5">
        <div class="card">
            <div class="card-header bg-info text-light">
                <h5>Ofered Courses</h5>
            </div>
        <div class="card-body" id="table-data">



          </div>
			</div>
		</div>
  </div>
	   <div style="margin-top:1px;"></div>
      <script src="../js/jquery-slim.min.js"></script>
      <script src="../js/popper.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script type="text/javascript">
          $(document).ready(function() {
              loadTable();
              function loadTable(page){
                $.ajax({
                  url: "http://localhost/College_Management_PHP_Bootstrap/students/ajax-pagination.php",
                  type: "POST",
                  data: {page_no :page},
                  success: function(data) {
                      $("#table-data").html(data);
                  }
                });
              }

              //pagination code
              $(document).on("click","#pagination a",function(e){
                  e.preventDefault();
                  var page_id = $(this).attr("id");

                  loadTable(page_id);
              })
          })
      </script>
</body>
</html>
