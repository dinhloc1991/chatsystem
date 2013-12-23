<html>
<style>
#errorInform{
	color: red;
}
</style>
<head>
	<script src="jquery-2.0.3.js" ></script> 
	<script> 
		$(document).ready(function(){
			console.log("abc");
			$("#btnLogin").click(function(){
				console.log("abc");
				username = $("#username").val();
				password = $("#password").val();
				$.ajax({
					type:"POST", 
					data: {"login":"true", "username":username, "password":password}, 
					url: "handle.php"
				}).done(function(msg){
					console.log(msg);
					if(msg=="ok"){
						console.log("login thanh cong");
						window.location.href="phongchat.php";
					}else {
						console.log("ko duoc");
						$("#errorInform").html("ko login duoc");
					}
				}).error(function(){
					console.log("co loi xay ra");
				}); 
			});
		});		 
	</script>
</head>
<body>
	username <input type="text" size "30" id = "username">
	password <input type="password" size = 30 id = "password" > 
	<button id = "btnLogin">login </button> 
	<div id="errorInform"> </div>

</body>
</html>
