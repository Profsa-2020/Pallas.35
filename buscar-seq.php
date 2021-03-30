<?php
     $seq = 1;
     session_start();
     if (isset($_SESSION['wrkiteped']['seq']) == true) {
          $nro = count($_SESSION['wrkiteped']['seq']);
          for ($ind = 0; $ind < $nro; $ind++) {
               $seq = $seq + 1;
          }
     }
     echo $seq;     
?>