<?php
session_start();
$max_attempts = 5;

// Define session key for storing login attempts
$login_attempts_key = 'login_attempts';


if (isset($_POST['submit'])) {
  $message = '';
  include('../connection.php');

  // **Input Validation**
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $password = trim($_POST['password']);  // Sanitize password (optional)

  if (empty($email) || empty($password)) {
    $message = "Email and password are required.";
  } else {
    // **Check for existing login attempts in session**
    if (isset($_SESSION[$login_attempts_key]) && $_SESSION[$login_attempts_key] >= $max_attempts) {
      $message = "Too many failed login attempts. Please try again later.";
      // exit($message);  // Exit script after exceeding attempts
      session_destroy();
    }

    // **Prepared Statement and Password Hashing**
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);  // Bind email parameter

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      // **Verify password with secure hashing**
      if (password_verify($password, $row['password'])) {
        $_SESSION["id"] = 1;
        $_SESSION['inactive'] = 5999;
        $_SESSION['start'] = time();  // Update session start time
        $message = "Login Successfully";
        echo "<script>location.href='find.php';</script>";

        // Reset login attempts on successful login
        unset($_SESSION[$login_attempts_key]);

      } else {
        // Increment login attempts on failed password
        if (!isset($_SESSION[$login_attempts_key])) {
          $_SESSION[$login_attempts_key] = 0;
        }
        $_SESSION[$login_attempts_key]++;

        $message = "Wrong Password\n";
        $remaining_attempts = $max_attempts - $_SESSION[$login_attempts_key];
        $message .= " You have " . $remaining_attempts . " attempts remaining.";
      }
    } else {
      // Increment login attempts for invalid email
      if (!isset($_SESSION[$login_attempts_key])) {
        $_SESSION[$login_attempts_key] = 0;
      }
      $_SESSION[$login_attempts_key]++;

      $message = "Invalid email or password.\n";
      $remaining_attempts = $max_attempts - $_SESSION[$login_attempts_key];
      $message2 =" You have " . $remaining_attempts . " attempts remaining.";
      echo '<script>showLoginMessage("' . $message2 . '");</script>';
    }

    $stmt->close();  // Close the prepared statement
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title>Administrator | Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style1.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="robots" content="noindex, follow">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="login_styles.css">
</head>

<body>
 
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image imagee">
                    <!------------- Image ------------->
                    <!-- <img src="1.jpg" alt="drop"> -->
                    <div class="text">
                        <p>D R O P</p>
                    </div>
                </div>
                <div class="col-md-6 right">
                    <div class="input-box">
                        <header>Hello, Welcome back</header>
                        <?php
                        if (isset($message)){
                           echo $message;
                        }
                     ?>
                        <form method="POST" action="">
                            <div class="input-field">
                                <input type="text" class="input" id="email" name="email" required="" autocomplete="off" >
                                <label for="email">Email</label> 
                            </div>
                            <div class="input-field">
                                <input type="password" class="input" id="pass" name="password" required="" >
                                <label for="pass">Password</label> 
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit" name="submit" value="Login">
                            </div>
                            <div class="signin">
                                <!-- <span>Already have an account? <a href="#">Log in here</a></span> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="login_script.js"></script>
</body>

</html>