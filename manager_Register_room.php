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

  session_start();
  $manager_ID =  $_SESSION['managerid'];
  
  $sql = "SELECT * FROM Managers WHERE ID = '$manager_ID'";
  $manager_result = mysql_query($sql);
  $manager = mysql_fetch_array($manager_result);
  $name = $manager['name'];
?>



<!DOCTYPE HTML>
<html>
<head>

<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>Manager_Register_room</title>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>

<style>
#second { position:absolute; margin-top:20px; width:100%; text-align: center;}
label {margin-down:20px;}
</style>

<script>
</script>

</head>
<body>

<div data-role="page" id="Enrol_room">
        <div data-role="header" data-position="fixed">
            <a href="#" data-icon="back" data-rel="back" data-direction="reverse">Back</a>
            <h1>대여할 강의실 등록하기</h1>
            <a href="manager.php" data-icon="home" data-iconpos="notext">Home</a>
        </div>
        <div data-role="content">
            <form name="room" method="post" action="room.php">
                <div class="ui-body ui-body-b gap">
	        
                    <p><h3>담당 건물 : <label for="room_buliding"><?=$manager['building']?></h3></p></label>

                    <label for="room_name">강의실 이름(번호)  : </label>
                    <input type="text" placeholder="ex)6515, 창의마루" name="room_name" id="room_name" data-mini="true" />

                    <label for="time_start">대여가능 시작 시간 : </label>
                    <input type="time" name="time_start" id="time_start" data-mini="true" />

                    <label for="time_end">대여가능 마감 시간 : </label>
                    <input type="time" name="time_end" id="time_end" data-mini="true" />

                    <label for="maximum_capability">최대수용인원 :</label>
                    <input type="text" placeholder="숫자만 입력해주세요" name="maximum_capability" id="maximum_capability" data-mini="true" />

                    <label for="table_chair">테이블 및 의자 수 :</label>
                    <input type="text" placeholder="ex)책상 50개, 의자 100개"name="table_chair" id="table_chair" data-mini="true" />

                    <label for="ps">기타 특이사항 및 주의사항 :</label>
                    <textarea cols="25" rows="5" name="ps" id="ps" data-mini="true"></textarea>
                   
                </div>
                <div class="ui-body">
                    <input type="button" class="ui-btn ui-shadow ui-corner-all ui-icon-arrow-r ui-btn-icon-right" id="btnEnrol" onclick="submit();" value="등록하기"/>
                </div>
            </form>
        </div>
</div>
</body>
</html>