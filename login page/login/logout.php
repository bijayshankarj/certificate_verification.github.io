<?php
session_start();
$_SESSION["id"] = 0;
session_destroy();
echo "<script>location.href='index.php';</script>";
?>



