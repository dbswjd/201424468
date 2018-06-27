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

<script type="text/javascript">
function confirmation() {
  var answer = confirm("강의실을 정말로 삭제하시겠습니까?")
  if (answer) window.location = "delete_room.php?room_idx=<?=$room_idx?>";
  else {}
}
</script>
<style>
#maximum_capability { width:75px;}
</style>
</head>

<body>
<div data-role="page" id="room_update" >
  <div data-role="header" data-position="fixed">
    <a href="#" data-icon="back" data-rel="back" data-direction="reverse">뒤로가기</a>
    <h1> <?=$room_building ." - ".$room_name?> </h1>
    <a href="#" onclick="confirmation();">삭제하기</a>
  </div>
  <div data-role="content">
    <form method="post" action="process_room_update.php?value=<?=$room_idx?>">
    <ul>
      <li><p><label for="maximum_capability">최대수용인원 :</label>
      <input type="range" name="maximum_capability" id="maximum_capability" value ="<?=$room_capability?>" min ="0" max = "1000"/></p></li>

      <li><p><label for="table_chair">테이블 및 의자 수 :</label>
      <input type="text" name="table_chair" id="table_chair" data-mini="true" value ="<?=$room_table_chair?>"/></p></li>

      <li><p><label for="time_start">대여가능 시작 시간 : </label>
      <input type="time" name="time_start" id="time_start" data-mini="true" value="<?=$room_start?>"/></p></li>

      <li><p><label for="time_end">대여가능 마감 시간 : </label>
      <input type="time" name="time_end" id="time_end" data-mini="true" value="<?=$room_end?>"/></p></li>
      
      <li><p><label for="ps">기타 특이사항 및 주의사항 : </label>
      <textarea cols="25" rows="5" name="ps" id="ps" data-mini="true"><?=$room_ps?></textarea></p></li>
    </ul>
    <div class="ui-grid-a">
      <div class="ui-block-a"><a href="#" data-role="button" data-rel="back" data-direction="reverse">취소</a></div>
      <div class="ui-block-b"><input type="button" value="수정"onclick='submit();'/></div>
    </div>
  </div>
  </form>
</div>
</body>
</html>