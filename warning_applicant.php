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

$applicant_idx = $_GET["value"];

$sql = "SELECT * FROM Applicants WHERE idx = $applicant_idx";
$applicant_rows = mysql_query($sql);
$applicant = mysql_fetch_array($applicant_rows);

$applicant_room_idx= $applicant['room_idx'];
$applicant_student_idx = $applicant['student_idx'];
$applicant_date = $applicant['date'];
$applicant_start = $applicant['start'];
$applicant_end = $applicant['end'];
$applicant_purpose = $applicant['purpose'];
$applicant_capability = $applicant['capability'];
$applicant_purpose = $applicant['purpose'];
$applicant_agree = $applicant['agree'];

$sql = "SELECT * FROM Students WHERE idx = $applicant_student_idx";
$student_rows = mysql_query($sql);
$student = mysql_fetch_array($student_rows);

$student_name = $student['name'];
$student_department = $student['department'];
$student_phoneNumber = $student['phoneNumber'];
$student_warning = $student['warning'];


$sql = "SELECT * FROM Room WHERE idx = $applicant_room_idx";
$room_rows = mysql_query($sql);
$room = mysql_fetch_array($room_rows);

$room_idx = $room['idx'];
$room_building = $room['building'];
$room_name = $room['room_name'];
$room_capability = $room['maximum_capability'];
$room_table_chair = $room['table_chair'];
$room_ps = $room['ps'];
$room_start = $room['rental_hour_start'];
$room_end = $room['rental_hour_end'];


$date = $applicant['date'];

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>warning_applicant</title>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
</head>

<body>
<div data-role="page" id="room_update" data-theme="b" >
  <div data-role="header" data-position="fixed" data-theme="b" >
    <a href="room_detail.php?value=<?=$room_idx?>" data-icon="back" data-direction="reverse">뒤로가기</a>
    <h1> <?=$room_building."<br>". $room_name?> </h1>
  </div>
  <div data-role="content">
    <ul>
      <p id="divider"><h2>신청인 정보</h2></p>
      <li><p><b> 이름 : </b><?=$student_name?> <p></li>
      <li><p><b> 학과 : </b><?=$student_department?> <p></li>
      <li><p><b> 연락처 : </b><?=$student_phoneNumber?> <p></li>
      <li><p><b> 경고횟수 : </b><?=$student_warning?> <p></li>

      <p id="divider"><h2> 대여 신청 정보</h2> </p>
      <li><p><b> 희망 대여 날짜 : </b><?= date( "Y년 m월 d일",strtotime($date) )?></p></li>
      <li><p><b> 희망 대여 시간 : </b><?= date("H : i",strtotime($applicant['start']) )." ~ ".date("H : i",strtotime($applicant['end']) ) ?></p></li>
      <li><p><b> 총 대여 인원 : </b><?=$applicant_capability?> 명</p></li>
      <li><p><b> 대여 목적 : </b><br><?=$applicant_purpose?></p></li>
    </ul>
    <div class="ui-grid-a">
      <div class="ui-block-a"><a href="process_warning.php?applicant_idx=<?=$applicant_idx?> &room_idx=<?=$room_idx?> &check=good" data-role="button">확인</a></div>
      <div class="ui-block-b"><a href="process_warning.php?applicant_idx=<?=$applicant_idx?> &room_idx=<?=$room_idx?> &check=bad" data-role="button">경고주기</a></div>
    </div>
  </div> 
</div>
</body>
</html>