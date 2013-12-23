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

function getUsernameById($id){
	$sql = "select * from user where ID = $id ";
	//echo $sql ; 
	$DBH = createDBH();
	$STH = $DBH->query($sql);
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	while($row = $STH->fetch()){
		$username = $row["username"]; 
		return $username ; 
	}
	return ""; 
}

function insertMessage($userID, $threadID, $content){
	$DBH = createDBH();	
	echo "cai gia tri thread ID o may chu ".$threadID; 
	$sql = "insert into message(content, ownerID, threadID) values ('$content', '$userID', '$threadID'); "; 
	$STH = $DBH->prepare($sql); 
	$STH->execute();
}

function getAllMessageToString($threadID){
	$DBH = createDBH();	
	$sql = "select * from message where threadID = $threadID"; 
	$STH = $DBH->query($sql);
	$STH->setFetchMode(PDO::FETCH_ASSOC);  
	$str = ""; 
	while($row = $STH->fetch()){
		$id = $row["ID"]; 
		$ownerID = $row["ownerID"]; 
		$username = getUsernameById($ownerID); 
		$str = $str."<div id = 'ms$id'> $username : ".$row["content"]."</div> <button id='rm$id' onclick='removeMessage($id)'>Remove</button><button id='ed$id' onclick='editMessage($id)'>Edit</button> "; 
	//	$str = $str.$row["content"]."<br>"; 
	}
	return $str; 
}

function removeMessage($idMs){
	$DBH = createDBH();	
	$sql = "delete from message where ID = $idMs"; 
	$STH = $DBH->prepare($sql); 
	$STH->execute();
}

function editMessage($idMs, $content){
	$DBH = createDBH();	
	$sql = "update message set content = '$content' where ID = $idMs"; 
	$STH = $DBH->prepare($sql); 
	$STH->execute();
}


function getAllThreadsOfUser($userID){
	$DBH = createDBH();	
	$firstSql = "select threadID from member where userID = $userID"; 
	//echo $firstSql; 

	$STH = $DBH->query($firstSql);
	$STH->setFetchMode(PDO::FETCH_ASSOC); 
	while($row = $STH->fetch()){
		$threadID = $row["threadID"];
		$secondSql = "select u.username from user as u, member as m where m.threadID = $threadID and m.userID = u.ID "; 
		//echo $secondSql; 
		$STH2 = $DBH->query($secondSql);
		$STH2->setFetchMode(PDO::FETCH_ASSOC);
		$threadInfo = "<div id = 'thread$threadID' onclick='continueThread($threadID)'> "; 
		while($row2 = $STH2->fetch()){ 
			$threadInfo.=$row2["username"].", "; 
		} 
		$threadInfo.="</div>";
		echo $threadInfo;  
	}
}

function insertMember($threadID, $memberList, $userID){
	$DBH = createDBH();	
	$sql = "insert into member(threadID, userID) values ($threadID, $userID)"; 
	$STH = $DBH->prepare($sql); 
	$STH->execute();
	foreach ($memberList as $name) {
		$id = getUserId($name);
		$sql = "insert into member(threadID, userID) values ($threadID, $id)"; 
		$STH = $DBH->prepare($sql); 
		$STH->execute();
	}
}
?>