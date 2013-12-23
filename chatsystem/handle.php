<?

include "model.php";

if(isset($_POST["addmember"])){
	$userName = $_POST["username"]; 
	$flag = checkUserByUsername($userName);
	if 	($flag == "daco"){
		echo "ok";
	}else echo "not";

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
	$memberList = json_decode($_POST["memberList"]);
	$threadID = insertThread($userID);
	insertMember($threadID, $memberList, $userID);  
	//print_r($memberList); 
	echo "$threadID";  
}

if (isset($_POST["message"])){
	$userID = $_POST["userID"];
	$threadID = $_POST["threadID"];
	$content = $_POST["content"];
	insertMessage($userID, $threadID, $content); 
}

if (isset($_POST["getMessage"])){
	$s = getAllMessageToString($_POST["threadID"]); 
	echo $s; 
}

if (isset($_POST["removeMessage"])) {
	$idMs = $_POST["idMs"];
	removeMessage($idMs); 
	echo "ok"; 
}

if (isset($_POST["editMessage"])) {
	$idMs = $_POST["idMs"];
	$content = $_POST["content"];
	editMessage($idMs, $content); 
	echo "ok"; 
}

?>