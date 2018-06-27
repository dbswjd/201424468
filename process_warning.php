<html>
<body>

<?php

header('content-type: text/html; charset=utf-8');
$dbConn = mysql_connect('localhost', 'root','1whsql');

mysql_select_db('Rental_Place_Service',$dbConn);
mysqli_query($dbConn, "set session character_set_connection=utf8;");
mysqli_query($dbConn, "set session character_set_results=utf8;");
mysqli_query($dbConn, "set session character_set_client=utf8;");
mysql_query("set names utf8");

$room_idx = $_GET["room_idx"];
$applicant_idx = $_GET["applicant_idx"];
$check =$_GET["check"];


$sql = "SELECT * FROM Applicants WHERE idx = $applicant_idx";
$applicant_rows = mysql_query($sql);
$applicant = mysql_fetch_array($applicant_rows);

$student_idx = $applicant['student_idx'];

$sql = "SELECT * FROM Students WHERE idx = $student_idx ";
$student_rows= mysql_query($sql);
$student = mysql_fetch_array($student_rows);

$student_idx = $student['idx'];
$student_name = $student['name'];
$student_warning = $student['warning'];

if ( $check == "good" ) {
  $sql = "UPDATE Applicants SET warning='NoWarning' WHERE idx ='$applicant_idx' ";
  mysql_query($sql);
  echo ("<script>alert(\"확인하였습니다\");</script>");
}

else if ( $check =="bad" ) {
  $sql = "UPDATE Applicants SET warning='Warning' WHERE idx ='$applicant_idx' ";
  mysql_query($sql);

  $new_student_warning = $student_warning + 1;
  $sql = "UPDATE Students SET warning = $new_student_warning WHERE idx = $student_idx ";
  mysql_query($sql);

  echo ("<script>alert(\"".$student_name."님에게 경고를 주었습니다.\");</script>");
}
echo ("<script>location.replace('room_detail.php?value=$room_idx&check=Y&name=$student_name');</script>");

?>

</body>
</html>