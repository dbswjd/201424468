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

$sql = "DELETE FROM Applicants WHERE room_idx=$room_idx";
mysql_query($sql);

$sql = "DELETE FROM Room WHERE idx = $room_idx ";
mysql_query($sql);

echo("<script>alert(\"강의실 정보를 삭제하였습니다\");</script>");
echo("<script>location.replace('manager.php');</script>");
?>

</body>
</html>