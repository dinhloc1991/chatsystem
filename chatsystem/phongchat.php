<html>
<style>
#error{
	color: red;
}

#memberList{
	color: green;
}

#dvThread{
	width: 700px;
	height: 100px;
	border-style: solid;
	border-width: 1px;
	border-color: red; 
	overflow: scroll;

}
#dvInput{

}

</style>
<head>
	<script src="jquery-2.0.3.js" > </script>
	<script>
		$(document).ready(function(){
			console.log("abcd"); 
			var members = Array(); 
			threadID = -1; 
			$("#ipUser").on("keypress", function(e){
				if (e.which  == 13){
					console.log("nut enter duoc bam");
					addedUserName = $("#ipUser").val(); 
						$.ajax({
							type: "POST",
							data: { "addmember":"true", "username":　addedUserName},
							url: "handle.php"
						}).done(function (msg){
							console.log("gia tri message tra ve "+msg);  
							if (msg=="ok"){
								console.log("da co nguoi ten la "+addedUserName);
								if (members.indexOf(addedUserName)==-1){
									members.push(addedUserName);
									$("#memberList").append(addedUserName+ ", ");
								}
								$("#error").html();
							}else {
								console.log("chua co nguoi ten la "+ addedUserName);
								$("#error").html("error : chua co user ten la "+addedUserName);
							}
						});   
				}
			}); 


			$("#btnSend").click(function() {
				console.log("nut send duoc bam");
				uploadMessage();
			});

			$("#tfinput").on("keypress", function(e){
			//	console.log("da co phim bam");
				if (e.which == 13){
					console.log("nut enter bam");
					uploadMessage();
				}
			}); 

			$("#btnLogout").click(function(){
				console.log("nut logout duoc bam "); 
				$.ajax({
					type: "POST", 
					url: "handle.php",
					data: {"logout":"true"} 
				}).done(function(msg){
					if (msg=="ok"){
						window.location.href="index.php";
					}
				}); 
			}); 
			function uploadMessage(){
				console.log("gia tri la "+$("#memberList").text()); 
				if ($("#memberList").text()=="") {
					alert("input username please");
					return; 
				}

				var message = $("#tfinput").val();
				console.log("noi dung message "+message);

				if ($("#dvThread").text()=="") {
					initThread();
					getMessage(); 
					console.log("abcdde"); 
				}else{
					console.log("thread da duoc khoi tao roi　 "); 
				}
				$("#dvThread").append(message+"<br>");
				console.log("gia tri thread ID flag 2 "+threadID); 
				putMessageToServer(message, threadID, userID);  //DaNG LAM TOI DAY 
				// $.ajax({
				// 	type: "POST",
				// 	data: { "message":　message},
				// 	url: "handle.php"
				// }).done(function (msg){
				// 	//console.log(msg);
				// 	console.log("gia tri message tra ve "+msg);  
				// });   
			} 
			
			function setThreadID(threadid){
				threadID = threadid; 
				console.log("gia tri o ham set nay  "+threadID); 
			}
			function initThread(){ 
				$.ajax({
					type:"POST", 
					data: {"initThread":"true", "userID":userID}, 
					url:"handle.php", 
					success: function(msg){
						//if (msg=="ok") console.log("init thread ok"); 
						threadID = msg; 
						console.log("gia tri thread id tra ve "+threadID); 
						setThreadID(threadID); 
					}, 
					error: function(){
						console.log("bi loi o threadid"); 
					}
				});
		//		console.log("gia tri threadid o cho ajax nay "+threadID); 
			}
			function putMessageToServer(message, threadID, userID){
				console.log("gia tri thread id o day "+ threadID); 
				$.ajax({
					type: "POST",
					data: { "message":"true", "content":message, "threadID":threadID, "userID":userID},
					url: "handle.php"
				}).done(function (msg){
					console.log(msg); 
				});  
			}
			function getMessage(){
				var t = setInterval(function(){
					$.ajax({
						type:"POST", 
						url: "handle.php", 
						data:{"getMessage":"true"},
					}).done(function (msg){
						//console.log(msg);
						console.log("gia tri message tra ve "+msg);  
						$("#dvThread").html(msg); 
					}); 
				},1000);
			}
			// function poll(){
		 //    	$.ajax({ 
		 //    		url: "handle.php", 
		 //    		data:{"getMessage":"true"},
		 //    		complete: poll, 
		 //    		timeout: 1000, //so 1000 co nghia la no cho trong 1000 s ma cai ham goi ajax chua thanh cong thi no se tiep tuc goi lai poll 
		 //    		success: function(msg){
		 //       			 //Update your dashboard gauge
		 //       		// salesGauge.setValue(data.value);
		 //       			$("#dvThread").html(msg); 
		 //       			console.log("thanh cong");
		 //    		}, 
		 //    		error: function(){
		 //    			console.log("loi"); 
		 //    		}
		 //    	});
			// };
		}); 	
	</script>
</head>
<body>
	<?php
		session_start();
		if (isset($_SESSION["username"])){
			$username = $_SESSION["username"];
			$password = $_SESSION["password"];
			$userID = $_SESSION["userid"]; 
			echo "chao $username";
			echo "<script> var userID　= $userID; </script> "; 
			?>
			<button id = "btnLogout"> Logout </button> <?php   
		}else {
			echo "chua login";
			header("Location: index.php"); 
		}
	?>
	<div id = "chatroom">
		<div id = "createMembers"> 
			Nhap vao username cua nguoi muon gui: 
			<input id = "ipUser" type = "text" size = 20 />
			<div id = "memberList" ></div>
			<div id = "error"> 
			</div>
		</div>	

		<div id = "dvThread"></div>
		<div id = "dvInput"> 
			Input <input id="tfinput" type="text" size = 30 /> 
			<button id ="btnSend" > Send </button> 

		</div>
	</div>


</body>

</html>