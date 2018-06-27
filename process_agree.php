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

$room_idx = $_GET["room_value"];
$applicant_idx = $_GET["applicant_value"];
$check =$_GET["check"];

$sql = "SELECT * FROM Applicants WHERE idx = $applicant_idx";
$applicant_rows = mysql_query($sql);
$applicant = mysql_query($sql);


if ( $check =='Y' ) {
  $sql = "UPDATE Applicants SET agree='Permitted' WHERE idx ='$applicant_idx' ";
  $result = mysql_query($sql);
  
  if ($result) echo ("<script>alert(\"대여신청 승인 완료\");</script>");
  else echo ("<script>alert(\"오류 발생\");</script>");
}
else if ( $check =='N' ) {
  $sql = "UPDATE Applicants SET agree='Denied' WHERE idx ='$applicant_idx' ";
  $result = mysql_query($sql);
 
  if ($result) echo ("<script>alert(\"대여신청 거부 완료\");</script>");
  else echo ("<script>alert(\"오류 발생\");</script>");
}

echo("<script>location.replace('room_detail.php?value=$room_idx');</script>");
?>

</body>
</html>