<?
// function getContent(){
// 	$content = file_get_contents("log.txt"); 
// 	echo $content; 
// }
include "model.php";

if(isset($_POST["addmember"])){
	$userName = $_POST["username"]; 
	$flag = checkUserByUsername($userName);
	if 	($flag == "daco"){
		echo "ok";
	}else echo "not";

}

if (isset($_POST["message¥"])){
	insertMessage(message);
}

if (isset($_POST["login"])){
	$username = $_POST["username"];
	$password = $_POST["password"];
	//echo $username;
	//echo $password; 
	$flag = checkUserLogin($username, $password);
	if 	($flag == "daco"){
		echo "ok";
		session_start();
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
		$_SESSION["userid"] = getUserId($username);
	}else echo "not";
}

if (isset($_POST["logout"])){
	session_start(); 
	unset($_SESSION["username"]); 
	unset($_SESSION["password"]);
	echo "ok";
}

if (isset($_POST["initThread"])){
	$userID = $_POST["userID"];
	$threadID = insertThread($userID); 
	echo "$threadID";  
}

if (isset($_POST["message"])){
	$userID = $_POST["userID"];
	$threadID = $_POST["threadID"];
	$content = $_POST["content"];
	insertMessage($userID, $threadID, $content); 
}

if (isset($_POST["getMessage"])){
	$s = getAllMessageToString(); 
	echo $s; 
}
?>