<?php

  $filename  = basename($_GET["filename"]);
  $path = "../assets/notes/" . $filename;
  if(!empty($filename) && file_exists($path)){
        header("Cache-Control: public"); // needed for i.e.
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length:".filesize($path));

        readfile($path);
        exit;
      }
      else{
        echo "file download error!!";
      }
?>
