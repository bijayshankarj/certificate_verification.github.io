<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION["id"]) || $_SESSION["id"] != 1) {
  header("Location: http://localhost/login%20page/login/index.php");
  exit;
}

// Check session expiration
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > $_SESSION['inactive'])) {
  session_destroy();
  header("Location: http://localhost/login%20page/login");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Search Database</title>
  <style>
    body {
      background: url('images/rm222-mind-16.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Arial', sans-serif;
      color: #000000;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      /* height: 100vh; */
      margin: 0;
      padding-top: 50px;
    }

    h1 {
      margin-bottom: 20px;
      font-size: 2.5em;
      color: #000000;
    }

    form {
      margin-bottom: 20px;
    }

    label {
      font-size: 1.2em;
      margin-right: 10px;
    }

    input[type="text"] {
      padding: 10px;
      width: 300px;
      border: 1px solid #ddd;
      border-radius: 4px;
      outline: none;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    input[type="text"]:focus {
      border-color: #007BFF;
    }

    #results {
      /* width: 80%; */
      /* max-width: 1000px; */
      background: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }

    /* tr:nth-child(even) {
      background-color: #f2f2f2;
    } */

    .edit-button,
    .delete-button {
      padding: 8px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
      margin-right: 5px;
      transition: background-color 0.3s;
    }

    .edit-button {
      background-color: #28a745;
      color: #0759f2;
    }

    .edit-button:hover {
      background-color: #0440b0;
    }

    .delete-button {
      background-color: #dc3545;
      color: #fff;
    }

    .delete-button:hover {
      background-color: #a01d2a;
    }

    .login100-form-btn {
      margin-right: 5px;
      font-size: 16px;
      color: white;
      line-height: 1.2;
      text-transform: uppercase;
      background: #4095e4;
      border: none;
      border-radius: 5px;
      padding: 10px 25px;
      cursor: pointer;
      /* transition: background 0.3s; */

    }

    .login100-form-btn:hover {
      background: #2575fc;
    }

    .login100-form-btn a {
      color: #FFF;
      text-decoration: none;
      /* margin-top: 20px; */
      display: block;
      text-align: left;
      width: max-content;
    }

    .container-login100-form-btn {
      margin-left: 70%;
      display: flex;
      justify-content: center;
    }
  </style>
</head>

<body>
  <!-- <span><a href='add-certificate.php'>Add New Certificate</a></span> -->
  <div class="container-login100-form-btn p-t-25">
    <button class="login100-form-btn"><a href='add-certificate.php'>Add New Certificate</a></button>
    <button type="submit" name="submit" class="login100-form-btn"><a href='logout.php'>Logout</a></button>
    <button type="submit" name="submit" class="login100-form-btn"><a href='export.php'>Export Data</a></button>
  </div>
  <h1>Search Database</h1>
  <form action="" method="get">
    <label for="search">Search:</label>
    <input type="text" name="search" id="search" onkeyup="searchData()">
  </form>
  <div id="results"></div>

  <script>
    function deleteCertificate(certificateId) {
      if (confirm("Are you sure you want to delete this certificate?")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "success") {
              alert("Certificate deleted successfully!");
              window.location.href = "find.php";
            } else {
              alert("Error deleting certificate: " + this.responseText);
            }
          }
        };
        xhttp.open("POST", "delete_certificate.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("certificateId=" + certificateId);
      }
    }

    function searchData() {
      var searchTerm = document.getElementById("search").value;
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("results").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "search.php?search=" + searchTerm, true);
      xhttp.send();
    }
    window.onload = searchData;
  </script>
</body>

</html>

