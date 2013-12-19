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
	height: 300px;
	border-style: solid;
	border-width: 1px;
	border-color: red; 
}
#dvInput{

}

</style>
<head>
	<script src="jquery-2.0.3.js" > </script>
	<script>
		$(document).ready(function(){
			console.log("abcd"); 
			$("#ipUser").on("keypress", function(e){
				if (e.which  == 13){
					console.log("nut enter duoc bam");
					userName = $("#ipUser").val(); 
						$.ajax({
							type: "POST",
							data: { "username":　userName},
							url: "handle.php"
						}).done(function (msg){
							console.log("gia tri message tra ve "+msg);  
							if (msg=="ok"){
								console.log("da co nguoi ten la "+userName);
								$("#memberList").html(userName + ", ");
								$("error").html();
							}else {
								console.log("chua co nguoi ten la "+ userName);
								$("#error").html("error : chua co user ten la "+userName);
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

			function uploadMessage(){
				var message = $("#tfinput").val()+"<br>";
				console.log("noi dung message "+message);
				// thread = $("#dvThread").text(); 
				// console.log("gia tri co san trong thread : "+ thread); 
				// thread = thread + message; 
				$("#dvThread").append(message);

				// $.ajax({
				// 	type: "POST",
				// 	data: { "message":　message},
				// 	url: "handle.php"
				// }).done(function (msg){
				// 	//console.log(msg);
				// 	console.log("gia tri message tra ve "+msg);  
				// });   
			}

			function putMessageToServer(message){
				$.ajax({
					type: "POST",
					data: { "message":　message},
					url: "handle.php"
				}).done(function (msg){
					console.log("gia tri message tra ve "+msg);  
					if (msg=="ok"){
						console.log("da co nguoi ten la "+userName);
						$("#memberList").html(userName + ", ");
						$("error").html();
					}else {
						console.log("chua co nguoi ten la "+ userName);
						$("#error").html("error : chua co user ten la "+userName);
					}
				});  
			}
	// var t = setInterval(function(){
	// 	$.ajax({
	// 		url: "handle.php"
	// 	}).done(function (msg){
	// 		//console.log(msg);
	// 		console.log("gia tri message tra ve "+msg);  
	// 		$("#dvThread").html(msg); 
	// 	}); 
	// },10);

			function poll(){
		    	$.ajax({ 
		    		url: "handle.php", 
		    		complete: poll, 
		    		timeout: 1000, //so 1000 co nghia la no cho trong 1000 s ma cai ham goi ajax chua thanh cong thi no se tiep tuc goi lai poll 
		    		success: function(msg){
		       			 //Update your dashboard gauge
		       		// salesGauge.setValue(data.value);
		       			$("#dvThread").html(msg); 
		       			console.log("thanh cong");
		    		}, 
		    		error: function(){
		    			console.log("loi"); 
		    		}
		    	});
			};
		}); 	
	</script>
</head>
<body>
	<div id = "chatroom">
		<div id = "createMembers"> 
			Nhap vao username cua nguoi muon gui: 
			<input id = "ipUser" type = "text" size = 20 />
			<div id = "memberList" > 
			</div>
			<div id = "error"> 
			</div>
		</div>	

		<div id = "dvThread"> 
		</div>
		<div id = "dvInput"> 
			Input <input id="tfinput" type="text" size = 30 /> 
			<button id ="btnSend" > Send </button> 

		</div>
	</div>


</body>

</html>