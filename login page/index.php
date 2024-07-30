<!DOCTYPE html>
<html>
<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Drop Certificate
	</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-div d-flex flex-column">
                    <h3 class="font-weight-bold">Verify Your Certificate</h3> <span class="d-block text-center px-3">Enter your certificate code to verify your details <br> visit our <a href="https://www.drop.org.in" target="_blank">website</a> to learn more about our products and services</span>
                </div>
                <div class="card-div-2">
                    <div class="px-1">
                      <form method="post" action="">
                        <div class="search"> 
                          <i class="fa fa-search"></i> 
                          <input type="text" name="search" class="form-control" placeholder="Enter your Certification code to verify"> 
                          <button type="submit" name="submit" class="btn btn-primary">Verify</button> 
                        </div>
                      </form>
                    </div>
                    <!-- div class="px-1 mb-2">
                          <div class="alert alert-success alert-dismissible fade show">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Success!</strong> This alert box could indicate a successful or positive action.
  </div>
                    </div> -->
                </div>
                <div class="mx-4">
     <table class="table table-bordered">
      <tbody>
      <?php
if (isset($_POST['submit'])) {
  $key = $_POST['search'];
  include('connection.php');
  $sql = "SELECT * FROM certificate_tbl WHERE certificate_code = '$key' LIMIT 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<tr>
              <th>Student Name</th>
              <td>{$row['name']}</td>
            </tr>
            <tr>
              <th>Father's Name</th>
              <td>{$row['fatherName']}</td>
            </tr>
            <tr>
              <th>Address</th>
              <td>{$row['address']}</td>
            </tr>
            <tr>
              <th>Addmission Date</th>
              <td>{$row['admission_date']}</td>
            </tr>
            <tr>
              <th>Course Completion Date</th>
              <td>{$row['courseComplete']}</td>
            </tr>
            <tr>
              <th>Course Name</th>
              <td>{$row['course_name']}</td>
            </tr>
            <tr>
              <th>Faculty Name</th>
              <td>{$row['faculty_name']}</td>
            </tr>
            <tr>
              <th>Certificate Code</th>
              <td>{$row['certificate_code']}</td>
            </tr>
            <tr>
              <th>Certificate Status</th>
              <td>{$row['certificate_status']}</td>
            </tr>
            <tr>
              <th>Download Certificate</th>";

      // Check for Google Drive link format
      if (strpos($row['upload_certificate'], 'https://drive.google.com/file/d/') === 0) {
        // Google Drive link - open directly in new tab
        $downloadLink = $row['upload_certificate'];
      } else {
        // Local file - use path with login/ prefix
        $downloadLink = "login/" . $row['upload_certificate'];
      }

      echo "<td>
                <a href='$downloadLink' target='_blank'>
                  <button type='button' class='btn btn-primary'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-down-circle-fill' viewBox='0 0 16 16'>
                      <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z'/>
                    </svg>
                    Download Certificate
                  </button>
                </a>
              </td>
            </tr>";
    }
  } else {
    echo "<tr rowspan='2'>
            <td>Data not found</td>
          </tr>";
  }
}
?>
  

</tbody>
  </table>
        </div>
        </div>
    </div>
            </div>
</div>
</body>
</html>