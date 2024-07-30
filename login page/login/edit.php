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

include ('../connection.php');


$certificateId = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Get certificate ID from URL parameter

// Check if a valid ID is provided
if (!$certificateId) {
    echo "Invalid certificate ID.";
    exit;
}

$sql = "SELECT * FROM certificate_tbl WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $certificateId);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    // Prepare form with existing data
    $name = $row['name'];
    $fatherName = $row['fatherName'];
    $address = $row['address'];
    $admission_date = $row['admission_date'];
    $courseComplate = $row['courseComplete'];
    $course_name = $row['course_name'];
    $faculty_name = $row['faculty_name'];
    $certificate_code = $row['certificate_code'];
    $certificate_status = $row['certificate_status'];


    // Handle form submission (if submitted)
    if (isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $fatherName = trim($_POST['fatherName']);


        $address = trim($_POST['address']);
        $admission_date = trim($_POST['admission_date']);
        $courseComplete = trim($_POST['courseComplete']);
        $course_name = trim($_POST['course_name']);
        $faculty_name = trim($_POST['faculty_name']);
        $certificate_code = trim($_POST['certificate_code']);
        $certificate_status = trim($_POST['certificate_status']);


        //prepared statement sql 
        $stmt = $conn->prepare("UPDATE certificate_tbl SET name = ?, fatherName = ?, address = ?, admission_date = ?, courseComplete = ?, course_name = ?, faculty_name = ?, certificate_code = ?, certificate_status = ? WHERE id = ?");

        // Bind parameters
        $stmt->bind_param("sssssssssi", $name, $fatherName, $address, $admission_date, $courseComplete, $course_name, $faculty_name, $certificate_code, $certificate_status, $certificateId);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Optionally, redirect back to search page
            //   header("Location: search.html");
            $message = '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> Data updated successfully.
                    </div>';
        } else {
            echo "Error updating certificate: " . $conn->error;
            $message = '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> Failed to add data.
                    </div>';
        }
    }

    $conn->close();
    ?>
    <!-- ....................................................Display Content......................................................-->
    <!DOCTYPE html>
    <html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

    <head>
        <title>Admin | Edit Certificate</title>
        <script>
            // Function to check session status
            function checkSession() {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "check_session.php", true);
                xhr.onload = function () {
                    if (xhr.responseText === "expired") {
                        window.location.href = "http://localhost/login%20page/login/logout.php";
                    }
                };
                xhr.send();
            }

            // Check session every 30 seconds
            setInterval(checkSession, 30000);
        </script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, follow">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

        <style>
            body {
                /* background: linear-gradient(to right, #4095e4, #2575fc); */
                background: url(images/rm222-mind-16.jpg);
                background-size: 100%;
                font-family: 'Arial', sans-serif;
            }

            @media only screen and (max-width: 768px) {
                body {
                    /* z-index: -1; */
                    /* position: absolute; */
                    background: url(images/rm222-mind-16.jpg);
                    background-size: 350%;
                    /* transform: rotate(90deg); */
                }
            }

            .container-login100 {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: 15px;
            }

            .wrap-login100 {
                width: 100%;
                max-width: 800px;
                background: white;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                padding: 30px;
            }

            .login100-form-title {
                font-size: 30px;
                color: #333;
                font-weight: 700;
                text-align: center;
                margin-bottom: 30px;
                position: relative;
            }

            .login100-form-title::after {
                content: '';
                width: 0px;
                height: 3px;
                background: #4095e4;
                display: block;
                margin: 0 auto;
                margin-top: 10px;
            }

            .wrap-input100 {
                position: relative;
                border-bottom: 2px solid #d9d9d9;
                margin-bottom: 30px;
            }

            .input100 {
                font-size: 16px;
                color: #555;
                line-height: 1.2;
                display: block;
                width: 100%;
                background: transparent;
                padding: 10px 0;
                border: none;
                border-radius: 0;
                border-bottom: 2px solid transparent;
                transition: border-color 0.3s;
            }

            .input100:focus {
                outline: none;
                border-bottom-color: #4095e4;
            }

            .symbol-input100 {
                font-size: 18px;
                color: #999;
                position: absolute;
                bottom: 10px;
                right: 0;
            }

            .custom-file-label::after {
                content: "Browse";
                background: #4095e4;
                color: white;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
            }

            .login100-form-btn {
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

            a {
                color: #4095e4;
                text-decoration: none;
                margin-top: 20px;
                display: block;
                text-align: left;
                width: max-content;
            }

            .container-login100-form-btn {
                display: flex;
                justify-content: center;
            }
        </style>

    </head>

    <body>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-l-20 p-r-20 p-t-20 p-b-30" style="width:800px;">
                    <form class="login100-form validate-form" method="POST" action="" enctype="multipart/form-data">
                        <span class="login100-form-title p-b-55">
                            Edit Certificate
                        </span>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if (isset($message)) {
                                    echo $message;
                                }
                                //   echo "<label for='name'>Name:</label>";
                                //   echo "<input type='text' name='name' id='name' value='$name' required>";
                                //   echo "<br>";
                                ?>
                            </div>
                            <div class="col-md-6">
                                <div class="wrap-input100 validate-input m-b-16" data-validate="Student name is required">
                                    <input class="input100" type='text' name='name' id='name' value="<?php echo $name; ?>"
                                        required>
                                    <!-- <input class="input100" type="text" name="name" placeholder="student name"> -->
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <span class="lnr lnr-envelope"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wrap-input100 validate-input m-b-16" data-validate="father's name is required">
                                    <input class="input100" type='text' name='fatherName' id='fatherName'
                                        value="<?php echo $fatherName; ?>" required>
                                    <!-- <input class="input100" type="text" name="fatherName" placeholder="father's name"> -->
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <span class="lnr lnr-lock"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wrap-input100 validate-input m-b-16" data-validate="Address is required">
                                    <input class="input100" type='text' name='address' id='address'
                                        value="<?php echo $address; ?>" required>
                                    <!-- <input class="input100" type="text" name="address" placeholder="address"> -->
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <span class="lnr lnr-envelope"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wrap-input100 validate-input m-b-16" data-validate="Admission_date is required">
                                    <input class="input100" type='text' name='admission_date' id='admission_date'
                                        value="<?php echo $admission_date; ?>" required>
                                    <!-- <input class="input100" type="text" name="admission_date" placeholder="Admission Date (dd/mm/yyyy)"> -->
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <span class="lnr lnr-envelope"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wrap-input100 validate-input m-b-16"
                                    data-validate=" Course Completion Date is required">
                                    <input class="input100" type='text' name='courseComplete' id='courseComplete'
                                        value="<?php echo $courseComplate; ?>" required>
                                    <!-- <input class="input100" type="text" name="courseComplate" placeholder="Course Completion Date (dd/mm/yyyy)"> -->
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <span class="lnr lnr-envelope"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wrap-input100 validate-input m-b-16" data-validate="course name  is required">
                                    <input class="input100" type='text' name='course_name' id='course_name'
                                        value="<?php echo $course_name; ?>" required>
                                    <!-- <input class="input100" type="text" name="course_name" placeholder="Course Name"> -->
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <span class="lnr lnr-lock"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wrap-input100 validate-input m-b-16"
                                    data-validate=" Certificate_code is required">
                                    <input class="input100" type='text' name='certificate_code' id='certificate_code'
                                        value="<?php echo $certificate_code; ?>" required>
                                    <!-- <input class="input100" type="text" name="certificate_code" placeholder="Certificate Code"> -->
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <span class="lnr lnr-envelope"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wrap-input100 validate-input m-b-16"
                                    data-validate=" Certificate Status is required">
                                    <input class="input100" type='text' name='certificate_status' id='certificate_status'
                                        value="<?php echo $certificate_status; ?>" required>
                                    <!-- <input class="input100" type="text" name="certificate_status" placeholder="Certificate Status"> -->
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <span class="lnr lnr-envelope"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wrap-input100 validate-input m-b-16"
                                    data-validate="Valid Faculty Name is required">
                                    <input class="input100" type='text' name='faculty_name' id='faculty_name'
                                        value="<?php echo $faculty_name; ?>" required>
                                    <!-- <input class="input100" type="text" name="faculty_name" placeholder="Faculty Name"> -->
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <span class="lnr lnr-envelope"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="wrap-input100 validate-input m-b-16" data-validate="Valid email is required">
                                    <div class="custom-file mb-3">
                                        <!-- <input type="file" class="custom-file-input" id="customFile"
                                            name="upload_certificate">
                                        <label class="custom-file-label" for="customFile">Upload Certificate(Pdf
                                            only)</label> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-login100-form-btn p-t-25">
                            <button type="submit" name="submit" class="login100-form-btn">
                                Update
                            </button>


                        </div>
                        <div>
                            <span><a href="logout.php">Log out</a></span>
                            <span><a href='find.php'>Back to Search</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
        <script src="vendor/bootstrap/js/popper.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
    </body>

    </html>






    <!-- .....................................................................................................................-->
    <?php
} else {
    echo "Certificate not found.";
    $conn->close();
}


?>

<script>
    // Function to handle delete confirmation and send AJAX request (optional)
    function deleteCertificate(certificateId) {
        if (confirm("Are you sure you want to delete this certificate?")) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == "success") {
                        alert("Certificate deleted successfully!");
                        // Optionally, redirect back to search page after successful deletion
                        window.location.href = "search.php";
                    } else {
                        alert("Error deleting certificate: " + this.responseText);
                    }
                }
            };
            xhttp.open("POST", "delete_certificate.php", true); // Change URL to your delete script
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("certificateId=" + certificateId);
        }
    }
</script>