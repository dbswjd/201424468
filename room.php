<?php
header('content-type: text/html; charset=utf-8');
  
$dbConn = mysql_connect('localhost', 'root','1whsql');
  
if ($dbConn) echo "db와 연결에 성공하였습니다<br/>";
else echo "db와 연결에 실패하였습니다<br/>";


mysql_select_db("Rental_Place_Service", $dbConn);
mysqli_query($dbConn, "set session character_set_connection=utf8;");
mysqli_query($dbConn, "set session character_set_results=utf8;");
mysqli_query($dbConn, "set session character_set_client=utf8;");
mysql_query("set names utf8");

session_start();
$room_manager_id = $_SESSION['managerid'];

$sql = "SELECT * FROM Managers WHERE ID = '$room_manager_id'";
$manager_result = mysql_query($sql);
$manager = mysql_fetch_array($manager_result);


$room_buliding =$manager['building'];
$manager_idx_for_room =$manager['idx'];

$room_name = $_POST["room_name"];
$time_start = $_POST["time_start"];
$time_end = $_POST["time_end"];
$maximum_capability = $_POST["maximum_capability"];
$table_chair= $_POST["table_chair"];
$ps = $_POST["ps"];

if ( ! $maximum_capability ) $maximum_capability = 0;

echo "room_manager_id is $room_manager_id <br/>manager_idx_for_room is $manager_idx_for_room <br/> room_building is $room_buliding <br/> room_name is $room_name <br/> capa is $maximum_capability <br/> table and chair is $table_chair<br/> ps is $ps<br/>";
echo "time_start is $time_start <br/> time_end is $time_end<br/>";

$sql = "INSERT INTO Room (manager_idx ,building, room_name, maximum_capability, table_chair, ps, rental_hour_start, rental_hour_end, new_request ) VALUES ('$manager_idx_for_room','$room_buliding','$room_name',$maximum_capability,'$table_chair','$ps', '$time_start', '$time_end',0)";
$result = mysql_query($sql);

if( $result ) {
echo ("<script>alert(\"강의실 등록에 성공하였습니다!\");</script>");
}
else echo "<script>alert(\"강의실 등록에 실패하였습니다!\");</script>";

echo("<script>location.replace('manager.php');</script>");
?>


