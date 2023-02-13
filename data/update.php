<?php
include("dbconn.php");
// 建立資料庫連線，並將連線存在$conn
$conn = mysqli_connect($servername, $username, $password);
// 選取資料庫
mysqli_select_db($conn, $dbname);
// 透過mysqli_query執行資料庫指令，設定連線編碼
mysqli_query($conn, "SET NAMES 'utf8'");

$data = $_POST['data']; 
$type = $_POST['type']; 
$class = $_POST['class'];
$skill = $_POST['skill']; 
// print_r($data); 
// print_r("<br>");
// print_r($type . "<br>");
// print_r($class . "<br>");
// print_r($skill . "<br>");

// "SELECT * FROM (SELECT * FROM `characters` WHERE `type` LIKE '%技%' OR `type` LIKE '%知%') as result WHERE `class` LIKE '%強韌%' OR `class` LIKE '%格鬥%' ORDER By `number`"
//--------------------first------------------------------
$sql_child_first = "SELECT * FROM `characters` WHERE ";
if($class>0){
	for($i=0;$i<(int)$class;$i++){
		if($i == (int)$class-1){
			$sql_child_first .= "`class` LIKE ";
			$sql_child_first .= " '%";
			$sql_child_first .= $data[$i+(int)$type];
			$sql_child_first .= "%'";
		}else{
			$sql_child_first .= "`class` LIKE ";
			$sql_child_first .= " '%";
			$sql_child_first .= $data[$i+(int)$type];
			$sql_child_first .= "%'";
			$sql_child_first .= " OR";
		}
	}
}else{
	$sql_child_first .= "`class` LIKE ' '  ";
}

//--------------------first------------------------------
//-------------------second------------------------------
$sql_child_second = "SELECT * FROM " . "(" . $sql_child_first . ")" . "as first ";

if($type > 0){
	$sql_child_second .= " where ";
	for($i=0;$i<(int)$type;$i++){
		if($i == (int)$type-1){
			$sql_child_second .= "`type` LIKE ";
			$sql_child_second .= " '%";
			$sql_child_second .= $data[$i];
			$sql_child_second .= "%'";
		}else{
			$sql_child_second .= "`type` LIKE ";
			$sql_child_second .= " '%";
			$sql_child_second .= $data[$i];
			$sql_child_second .= "%'";
			$sql_child_second .= " OR";
		}
	}
}
//-------------------second------------------------------
//-------------------parents------------------------------

$sql_parents = "SELECT * FROM " . "(" . $sql_child_second . ")" . "as second ";

if($skill > 0){
	$sql_parents .= " where ";
	for($i=0;$i<(int)$skill;$i++){
		if($i == (int)$skill-1){
			$sql_parents .= "`skill` LIKE ";
			$sql_parents .= " '%";
			$sql_parents .= $data[$i+(int)$type+(int)$class];
			$sql_parents .= "%'";
		}else{
			$sql_parents .= "`skill` LIKE ";
			$sql_parents .= " '%";
			$sql_parents .= $data[$i+(int)$type+(int)$class];
			$sql_parents .= "%'";
			$sql_parents .= " OR ";
		}
	}
	$sql_parents .= "ORDER BY `id` DESC";
}else{
	$sql_parents .= "ORDER BY `id` DESC";
}
//-------------------parents------------------------------


// print_r($sql_parents);


// 1:力 2:技 3:速 4:心 5:知 6:格鬥 7:斬擊 8:打擊 9:射擊 10:自由 11:強韌 12:野心 13:博學 14:拳頭 15:技能格影響力 16:屬性增傷 17:連擊係數

// // 透過mysqli_query執行資料庫指令, 並將結果存放在$ret

// echo "<br>" . $sql_parents . "<br>" ; //這邊輸出我的SQL字串

// 透過mysqli_query執行資料庫指令, 並將結果存放在$ret


$ret = mysqli_query($conn, $sql_parents); 
// die();
// if (!$ret) {

//     printf("Error: %s\n", mysqli_error($conn));
//     exit();
// }
// 透過while迴圈，每次從$ret抓一筆記錄，存放於$row
$result = mysqli_num_rows($ret);
// echo "<br>" . $result;
if($result > 0){
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
}else{
		echo json_encode("null");	
}
mysqli_close($conn);
		

	


?>