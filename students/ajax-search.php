<?php
session_start();
if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
require '../model/dataaccess.php';
$search_value = $_POST["search"];
$output ="";
if($connection->connect_error){
  die("connection failed:" . $connection->connect_error);
}
else{

      $sql = "SELECT * FROM offeredcourse WHERE name LIKE '%{$search_value}%'";
      $result = $connection->query($sql);

      if($result->num_rows > 0)
      {
        $output .='<table class="table table-bordered">
          <tr>
            <th>ID</th>
            <th>Course Title</th>
            <th>Status</th>
            <th>Capacity</th>
            <th>Count</th>
            <th>Time</th>
          </tr>';
          while($row = $result->fetch_assoc())
          {
            $output .="<tr>
              <td>{$row["id"]}</td>
              <td>{$row["name"]}</td>
              <td align='center'>{$row["status"]}</td>
              <td align='center'>{$row["capacity"]}</td>
              <td align='center'>{$row["count"]}</td>
              <td align='center'>{$row["time"]}</td>
            </tr>";
          }
          $output .="</table>";
          echo $output;
      }
      else{
        echo "No course Found!!";
      }
}


 ?>
