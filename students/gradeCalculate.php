<?php

  function gradeCalculate($total)
  {
    $grade = "";
    if($total >= 0 && $total < 50){
      $grade = "F";
    }
    else if($total >= 50 && $total < 55){
      $grade = "D";
    }
    else if($total >= 55 && $total < 60){
      $grade = "D+";
    }
    else if($total >= 60 && $total < 65){
      $grade = "C";
    }
    else if($total >= 65 && $total < 70){
      $grade = "C+";
    }
    else if($total >= 70 && $total < 80){
      $grade = "B";
    }
    else if($total >= 80 && $total < 85){
      $grade = "B+";
    }
    else if($total >= 85 && $total < 90){
      $grade = "A";
    }
    else{
      $grade = "A+";
    }

    return $grade;
  }

?>
