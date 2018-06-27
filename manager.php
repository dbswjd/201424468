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

  if ( !$manager_ID) {
    echo ("<script>alert(\"시간 초과로 세션이 만료되었습니다\");</script>");
    echo("<script>location.replace('login.html');</script>");
  }
 
  $_SESSION['managerid'] = $manager_ID;

  $sql = "SELECT * FROM Managers WHERE ID = '$manager_ID'";
  $manager_result = mysql_query($sql);
  $manager = mysql_fetch_array($manager_result);
  
  $name = $manager['name'];
  $manager_idx = $manager['idx'];
  $manager_building = $manager['building'];
  
  $sql = "SELECT * FROM Room WHERE manager_idx = $manager_idx";
  $room_result = mysql_result($sql);
  $room = mysql_fetch_array($room_result);

  $room_idx = $room['idx'];
  $sql = "SELECT * FROM Applicants WHERE room_idx = $room_idx AND agree='waiting' ";
  $applicant_result = mysql_query($sql);
  
  $sql ="UPDATE Applicants SET agree='Denied' WHERE agree= 'waiting'  AND date< NOW(); ";
  mysql_query($sql);

?>

<!DOCTYPE HTML>
<html>
<head>

<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>Manager</title>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>

<style>

#content_div {top:0px; margin-top:0px; padding-top:0px; padding-left:0px; padding-right:0px;}
#second { width:100%; margin:auto; padding:auto;}
.ui-grid-a { top:0px; width:100%; margin = 0px; font-size:large; font-weight:bolder;}
.ui-block-a {text-align: center; padding-top:10px;}
.ui-block-b {text-align: right; padding-right = 10px;}
#register_button { border-right : 0px; padding-right:0px;border-style : solid; }
</style>

</head>

<body>
<div data-role="page" id="Manager_home" >
		<div data-role="header" id="header" >
		  <a href="login.html" class="ui-btn-right">Log out</a>
		  <h1>반갑습니다 <?=$name?> 님</h1>
		</div>
		<div data-role="content" id="content_div">
		  <div class="ui-grid-a" id ="grid">
		    <div class="ui-block-a"><p>담당 건물 <br/> <?=$manager_building?></p></div>
		    <div class="ui-block-b"><p><a href="manager_Register_room.php" id="register_button"data-inline ="true" data-role="button">강의실 등록하기</a></p></div>
                          </div>
		  <ol data-role="listview" id="second">
                            <li data-role="list-divider">등록한 강의실 <p class="ui-li-aside">허가를 기다리는 신청 수</p></li>
<?php

$sql= "SELECT * FROM Room WHERE manager_idx = '$manager_idx'";
$room_result = mysql_query($sql);

if ($room_result) {
  while($room = mysql_fetch_array($room_result) ){
    $room_idx = $room['idx'];

    $sql = "SELECT * FROM Applicants WHERE room_idx = $room_idx AND agree='waiting' ";
    $applicant_result = mysql_query($sql);
    
    $new_room_request = mysql_num_rows($applicant_result);

    $sql = "UPDATE Room SET request = $new_room_request WHERE idx = $room_idx";
    mysql_query($sql);

    $room_building = $room['building'];
    $room_name = $room['room_name'];

    $room_request = $room['new_request'];
    echo ("<li><a href =\"room_detail.php?value=$room_idx\">".$room_building." - ".$room_name."<span class=\"ui-li-count\">".$new_room_request."</span></a></li>");
  }
}
else echo ("<p>등록된 강의실이 존재하지 않습니다</p>");
?>
		    </ol>
		  </form>
		</div>
</div>
</body>
</html>





