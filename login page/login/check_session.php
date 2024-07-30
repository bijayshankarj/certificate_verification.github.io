<?php
session_start();

// if (isset($_SESSION["id"])) {
//   echo "active";
//   echo "<script>location.href='index.php';</script>";
// } else {
//   echo "expired";
// //   echo "<script>location.href='index.php';</script>";
// }
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > $_SESSION['inactive'])) {
    echo "expired";
    exit;
  }else if(!isset($_SESSION['start'])){
    echo "expired";
  }else{
    echo "active";
  }
?>
