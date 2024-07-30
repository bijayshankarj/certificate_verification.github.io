<?php
// require 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// ... your database connection code
require('../connection.php');

// Retrieve data from database
$sql = "SELECT * FROM certificate_tbl";
$result = $conn->query($sql);


//

$html='<table><tr><td>id</td><td>name</td><td>fatherName</td><td>address</td><td>admission_date</td><td>courseComplete</td><td>course_name</td><td>faculty_name</td><td>certificate_code</td><td>certificate_status</td><td>upload_certificate</td><td>last_updated</td></tr>';
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['fatherName'] . '</td>
                <td>' . $row['address'] . '</td>
                <td>' . $row['admission_date'] . '</td>
                <td>' . $row['courseComplete'] . '</td>
                <td>' . $row['course_name'] . '</td>
                <td>' . $row['faculty_name'] . '</td>
                <td>' . $row['certificate_code'] . '</td>
                <td>' . $row['certificate_status'] . '</td>
                <td>' . $row['upload_certificate'] . '</td>
                <td>' . $row['last_updated'] . '</td>
            </tr>';
}

$html .= '</table>';
header('Content-Type:application/xls');
header('Content-Disposition:attachment;filename=certificate_data.xls');
echo $html;
// // Create a new spreadsheet object
// $spreadsheet = new Spreadsheet();
// $sheet = $spreadsheet->getActiveSheet();

// // Set column headers
// $sheet->setCellValue('A1', 'Column1');
// $sheet->setCellValue('B1', 'Column2');
// // ... add more columns as needed

// // Populate data
// $row = 2;
// while ($row = $result->fetch_assoc()) {
//     $sheet->setCellValue('A' . $row, $row['column1']);
//     $sheet->setCellValue('B' . $row, $row['column2']);
//     // ... add more columns
//     $row++;
// }

// // Save the spreadsheet to a temporary file
// $filename = 'export.xlsx';
// $tempFilePath = 'temp/' . $filename; // Replace 'temp/' with your desired temporary directory
// $writer = new Xlsx($spreadsheet);
// $writer->save($tempFilePath);

// // Output the file for download
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment; filename="' . $filename . '"');
// header('Content-Length: ' . filesize($tempFilePath));
// readfile($tempFilePath);
// unlink($tempFilePath); // Delete the temporary file
?>