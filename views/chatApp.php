<?php 
//include_once("includes/db.php");
$action = htmlspecialchars($_SERVER["PHP_SELF"]."?page=chatApp");

$output .= "<script>function ajax(){var req = new XMLHttpRequest();
		req.onreadystatechange = function(){
		if(req.readyState == 4 && req.status == 200){
		document.getElementById('chat').innerHTML = req.responseText;
		} 
		}
		req.open('GET','views/chat.php',true); 
		req.send();
		}
		window.setInterval('ajax()', 100);</script>
	
<body onload='ajax();'>

<div id='container'>
		<div id='chat_box' style='overflow:scroll; width:465px;height:400px;'>
		<div id=\"chat\"></div>
		</div>
		<form method=\"post\" action=\"\">
		<textarea name=\"msg\"></textarea>
		<input type=\"submit\" name=\"submit\" value=\"Send it\"/>
		
		</form>";

		if(isset($_POST['submit'])){ 
		
		$name = $_SESSION["username"];
		$msg = $_POST['msg'];

		
		//sanitising the input
		$msg = trim($msg);
		$msg = stripslashes($msg);
		$msg = htmlspecialchars($msg);
		$msg = mysqli_real_escape_string($conn,$msg);
		
		$query = "INSERT INTO chat (name,msg) values ('$name','$msg')";
		
		$run = $conn->query($query);
		
		}
		?>