<?php
$hash = isset($_GET['hash']) ? (int) $_GET['hash'] : 0;

if(!isset($hash) || $hash!='wannahash'){
  header("Location: http://localhost/login%20page/login/index.php");
  exit;
}
require('../connection.php'); // Replace with your connection path

$sql = "SELECT email, password FROM admin"; // Modify table and column names if needed
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $user_id = $row['email'];
    $old_password = $row['password'];

    // Hash the password using password_hash()
    $hashed_password = password_hash($old_password, PASSWORD_DEFAULT);

    // Update the database with the hashed password
    $update_sql = "UPDATE admin SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $hashed_password, $user_id);
    $stmt->execute();
    $stmt->close();
  }
  echo "Passwords hashed successfully!";
} else {
  echo "No users found in the database.";
}

$conn->close();
?>
