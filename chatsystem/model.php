<?php
function createDBH(){
	try{
		$user = "loc"; 
		$password = "123456"; 
		$dbname = "chatsystem";
		$host="localhost";
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
		// $hash = array(); 
		// array_push($hash, "username"=> "varchar(50)"); 
		// array_push($hash, "password"=> "varchar(50)");  
		// createTableByHash("user", $hash);
	//	echo "ket noi db thanh cong ";
	}catch(PDOException $e){
	//	echo $e->getMessage(); 
	//	echo "loi o day"; 

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
	//		echo "chua co nguoi ten la $username";
			return 1;
		}else {
	//		echo "da co nguoi ten la $username";
			return 0; 
		}
	// }catch(PDOException e){
	// 	echo "co loi trong cau lenh sql"; 
	// }
}
function insertUser($username, $password){
//	try{
	if (checkUserByUsername($username)== 0) {
		return 0;
	}
	$DBH = createDBH();	
	$sql = "insert into user(username, password) values ('$username', '$password'); "; 
	$STH = $DBH->prepare($sql); 
	$STH->execute();
//	echo $sql;
//	return 1; 
	//  }catch(PDOException $e){
	//  	echo $e->getMessage();
	// }
}

//insertUser("loc123456", "123"); 
// function createTableByHash($tablename, $hash){
// 	$sql = "create table if not exsit user(";
// 	for ($hash as $key => $value){
// 		$sql = $sql.$key." ".$value." not null" ; 
// 	}
// 	$sql = $sql.");"
// 	echo $sql; 
// }

function insertThread($ownerID){
	$DBH = createDBH();	
	$sql = "insert into thread(ownerID) values ($ownerID); "; 
	$STH = $DBH->prepare($sql); 
	$STH->execute();
//	echo $sql;
	return $DBH->lastInsertId();
}

function putMessage($message){
	
}
?>