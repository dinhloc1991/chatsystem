<?
// function getContent(){
// 	$content = file_get_contents("log.txt"); 
// 	echo $content; 
// }
include "model.php";

if(isset($_POST["username"])){
	$userName = $_POST["message"]; 
	$flag = checkUserByUsername($userName);
	if 	($flag == 0){
		echo "ok";
	}else echo "not";

}

if (isset($_POST["message"]){
	insertMessage(message);
}


?>