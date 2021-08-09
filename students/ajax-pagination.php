<?php
session_start();
if(empty($_SESSION)){
	header('Location: http://localhost/College_Management_PHP_Bootstrap/login.php');
    exit();
}
require '../model/dataaccess.php';
$output="";
if($connection->connect_error){
  die("connection failed:" . $connection->connect_error);
}
else{
      $limit_per_page = 7;
      $page= "";
      if(isset($_POST["page_no"])){
        $page =$_POST["page_no"];
      }else{
        $page =1;
      }
      $offset = ($page -1)* $limit_per_page;

      $sql = "SELECT * FROM offeredcourse LIMIT {$offset}, {$limit_per_page}";
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
          $sql_total = "SELECT * FROM offeredcourse ";
          $result = $connection->query($sql_total);
          $total_record = $result->num_rows;
          $total_pages = ceil($total_record/$limit_per_page);

          $output .='<div id="pagination" class="nav justify-content-center"><ul class="pagination ">';
          for($i=1; $i<= $total_pages; $i++){
            if($i == $page){
              $class_name = "active";
            }else{
              $class_name = "";
            }
            $output .="<li class='page-item {$class_name}'><a class='page-link' id='{$i}' href=''>{$i}</a></li>";
          }
          $output .='</ul></div>';

          echo $output;
      }
      else{
        echo "No Record Found!!";
      }
}
 ?>
