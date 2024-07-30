<?php
// $servername = "103.152.79.223";
// $username = "droporg1_admin";
// $password = "t3?l*46wEHRj";
// $dbname = "droporg1_certificate_verification";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>