<?php
include("dbconn.php");
// 建立資料庫連線，並將連線存在$conn
$conn = mysqli_connect($servername, $username, $password);
// 選取資料庫
mysqli_select_db($conn, $dbname);
// 透過mysqli_query執行資料庫指令，設定連線編碼
mysqli_query($conn, "SET NAMES 'utf8'");

// 資料庫指令先存放在$sql
$sql = "SELECT * FROM `characters` ORDER BY `characters`.`id` DESC";
// 透過mysqli_query執行資料庫指令, 並將結果存放在$ret


$ret = mysqli_query($conn, $sql);
// 透過while迴圈，每次從$ret抓一筆記錄，存放於$row
while ($row = mysqli_fetch_assoc($ret)) {	

	$TableData[] = array
	            (
	                "id" => $row['id'],
	                "number" => $row['number'],
	                "type" => $row['type'],
	                "class" => $row['class'],
	                "captain" => $row['captain'],
	                "skill" => $row['skill'],
	                "sailor" => $row['sailor'],
	            );   
	}
	echo json_encode($TableData);
	mysqli_close($conn);
?>
