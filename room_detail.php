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

$sql = "SELECT * FROM Room WHERE idx = $room_idx ";
$room_result = mysql_query($sql);

$room = mysql_fetch_array($room_result);

$room_idx = $room['idx'];
$room_building = $room['building'];
$room_name = $room['room_name'];
$room_capability = $room['maximum_capability'];
$room_table_chair = $room['table_chair'];
$room_ps = $room['ps'];
$room_start = $room['rental_hour_start'];
$room_end = $room['rental_hour_end'];


$sql ="UPDATE Applicants SET agree='Denied' WHERE agree= 'waiting'  AND date< NOW(); ";
$result = mysql_query($sql);



?>

<!DOCTYPE HTML>
<html>
<head>

<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>Room_detail</title>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>

<style>
#second { position:absolute;margin-top:25px;width:100%;text-align: center;}
</style>
</head>
<body>
<div data-role="page" id="room_detail" >
  <div data-role="header" data-position="fixed">
    <a href="manager.php" data-icon="back" data-direction="reverse">뒤로가기</a>
    <h1> <?=$room_building."<br>". $room_name?> </h1>
    <a href="room_update.php?value= <?=$room_idx?> ">수정하기</a>
  </div>
  <div data-role="content">

    <ul>
      <li><p><b>최대수용인원 : </b><?=$room_capability?></p></li>
      <li><p><b>테이블 및 의자 수 : </b><?=$room_table_chair?></p></li>
      <li><p><b>대여가능시간 : </b><?=$room_start?> ~ <?=$room_end?></p></li>
      <li><p><b>기타 특이사항 : </b><br> <?=$room_ps?></p></li>
    </ul>

    <ul data-role="listview" id="second">
      <li data-role="list-divider"> 허가를 기다리는 대여신청</p></li>

<?php
$sql= "SELECT * FROM Applicants WHERE room_idx=$room_idx AND agree='waiting' ORDER BY date ";
$applicant_rows = mysql_query($sql);

if ($applicant_rows) {
  while($applicant = mysql_fetch_array($applicant_rows) ) {
    $idx = $applicant['idx'];
    $agree = $applicant['agree'];

    echo "<li><a href=\"agree_to_student.php?value=$idx\" data_rel=\"dialog\">";
    echo "희망 대여 날짜 : ".date( "Y년 m월 d일",strtotime($applicant['date']) )."<br>";
    echo "희망 대여 시간 : ".date("H : i",strtotime($applicant['start']) )." ~ ".date("H : i",strtotime($applicant['end']) )."<br>";
    echo "대여 목적 : ".$applicant['purpose']."</a></li>";
  }
}
?>

    <li data-role="list-divider"> 승인한 대여신청</li>

<?php
$sql = "SELECT * FROM Applicants WHERE room_idx =$room_idx AND agree='Permitted'  AND date >= NOW() ORDER BY date";
$applicant_rows = mysql_query($sql);

if ($applicant_rows) {
  while($applicant = mysql_fetch_array($applicant_rows) ) {
    $idx = $applicant['idx'];
    $agree = $applicant['agree'];

    echo "<li><a href=\"check_applicant.php?value=$idx\" data_rel=\"dialog\">";
    echo "희망 대여 날짜 : ".date( "Y년 m월 d일",strtotime($applicant['date']) )."<br>";
    echo "희망 대여 시간 : ".date("H : i",strtotime($applicant['start']) )." ~ ".date("H : i",strtotime($applicant['end']) )."<br>";
    echo "대여 목적 : ".$applicant['purpose']."</a></li>";
  }
}
?>


    <li data-role="list-divider"> 대여완료된 신청 (경고주기)</li>

<?php
$sql = "SELECT * FROM Applicants WHERE warning = 'Normal' AND room_idx=$room_idx AND agree='Permitted' AND date < NOW() ORDER BY date";
$applicant_rows = mysql_query($sql);

if ($applicant_rows) {
  while($applicant = mysql_fetch_array($applicant_rows) ) {
    $idx = $applicant['idx'];
    $agree = $applicant['agree'];

    echo "<li><a href=\"warning_applicant.php?value=$idx\" data_rel=\"dialog\">";
    echo "희망 대여 날짜 : ".date( "Y년 m월 d일",strtotime($applicant['date']) )."<br>";
    echo "희망 대여 시간 : ".date("H : i",strtotime($applicant['start']) )." ~ ".date("H : i",strtotime($applicant['end']) )."<br>";
    echo "대여 목적 : ".$applicant['purpose']."</a></li>";
  }
}
?>


    </ul>
  </div>
</div>
</body>
</html>