<?php
function createDBH(){
	try{
		$user = "loc"; 
		$password = "123456"; 
		$dbname = "chatsystem";
		$host="localhost";
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
	}catch(PDOException $e){
	
	}
	return $DBH; 
}
function checkUserByUsername($username){
	//try{
		$sql = "select * from user where username = '$username' ";
		$DBH = createDBH();
		$STH = $DBH->query($sql);
		$STH->setFetchMode(PDO::FETCH_ASSOC); 
		$flag = 0; 
		while($row = $STH->fetch()){
			$flag = 1; 
			break;
		}
		if ($flag == 0){
			return "chuaco";
		}else {
	//		echo "da co nguoi ten la $username";
			return "daco"; 
		}
}
function insertUser($username, $password){
	if (checkUserByUsername($username)== 0) {
		return 0;
	}
	$DBH = createDBH();	
	$sql = "insert into user(username, password) values ('$username', '$password'); "; 
	$STH = $DBH->prepare($sql); 
	$STH->execute();
}

function insertThread($ownerID){
	$DBH = createDBH();	
	$sql = "insert into thread(ownerID) values('$ownerID'); "; 
	$STH = $DBH->prepare($sql); 
	$STH->execute();
	return $DBH->lastInsertId();
}


function checkUserLogin($username, $password){
	$sql = "select * from user where username = '$username' and password = '$password' ";
	$DBH = createDBH();
	$STH = $DBH->query($sql);
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	$flag = 0; 
	while($row = $STH->fetch()){
		$flag = 1; 
		break;
	}
	if ($flag == 0){
//		echo "chua co nguoi ten la $username";
		return "chuaco";
	}else {
//		echo "da co nguoi ten la $username";
		return "daco"; 
	}
}

function getUserId($username){
	$sql = "select * from user where username = '$username'";
	//echo $sql ; 
	$DBH = createDBH();
	$STH = $DBH->query($sql);
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	while($row = $STH->fetch()){
		$id = $row["ID"]; 
		return $id; 
	}
	return -1; 
}

function insertMessage($userID, $threadID, $content){
	$DBH = createDBH();	
	echo "cai gia tri thread ID o may chu ".$threadID; 
	$sql = "insert into message(content, ownerID, threadID) values ('$content', '$userID', '$threadID'); "; 
	$STH = $DBH->prepare($sql); 
	$STH->execute();
}

function getAllMessageToString(){
	$DBH = createDBH();	
	$sql = "select * from message"; 
	$STH = $DBH->query($sql);
	$STH->setFetchMode(PDO::FETCH_ASSOC);  
	$str = ""; 
	while($row = $STH->fetch()){
		$str = $str.$row["content"]."<br>"; 
	}
	return $str; 
}
?>