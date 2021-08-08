<?php
require 'dataaccess.php';
class User {

    private $connection;
    public function __construct(mysqli $connection) {
        $this->connection = $connection;
    }

    public function getAllUsers() {

        $sql = 'SELECT * FROM users';
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();
        // Fetch the data into a stdClass[] array.
        $rows = [];
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }
        return $rows;
    }

    //get user by email
    public function getUserByEmail($userEmail) {

      $user = array();
      $sql = "SELECT * FROM users WHERE email = '$userEmail'";
      $result = $connection->query($sql);

      if($result->num_rows > 0)
      {
          while($row = $result->fetch_assoc())
          {
              $user = $row;
          }

          return $user;
      }
    }
  }
