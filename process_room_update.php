<?php

header('content-type: text/html; charset=utf-8');
$dbConn = mysql_connect('localhost', 'root','1whsql');
 
if ($dbConn) echo "db와 연결에 성공하였습니다<br/>";
else echo "db와 연결에 실패하였습니다<br/>";

mysql_select_db('Rental_Place_Service',$dbConn);
mysqli_query($dbConn, "set session character_set_connection=utf8;");
mysqli_query($dbConn, "set session character_set_results=utf8;");
mysqli_query($dbConn, "set session character_set_client=utf8;");
mysql_query("set names utf8");

$room_idx = $_GET["value"];

$new_room_capability = $_POST['maximum_capability'];
$new_room_table_chair = $_POST['table_chair'];
$new_room_start = $_POST['time_start'];
$new_room_end = $_POST['time_end'];
$new_room_ps = $_POST['ps'];

$sql = "UPDATE Room 
SET maximum_capability='$new_room_capability',
  table_chair='$new_room_table_chair', 
  rental_hour_start = '$new_room_start', 
  rental_hour_end='$new_room_end', 
  ps ='$new_room_ps' 
  WHERE idx='$room_idx' ";

$result = mysql_query($sql);

if ($result) echo ("<script>alert(\"강의실 정보를 수정하였습니다!\");</script>");
else echo ("<script>alert(\"강의실 정보를 수정하지 못했습니다!\");</script>");

echo("<script>location.replace('room_detail.php?value=$room_idx');</script>");
?>

