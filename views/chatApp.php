<?php 
//include_once("includes/db.php");
$action = htmlspecialchars($_SERVER["PHP_SELF"]."?page=chatApp");




$sql = "SELECT groupid FROM GroupMembers WHERE userid = '$_SESSION[username]'";

$result = mysqli_query($conn, $sql);




// check query returned a result
if ($result === false) {
    echo mysqli_error($conn);
} else {
    $options = "";
    // create an option for each artist
	$count=0;
    while ($row = mysqli_fetch_assoc($result)) {
		$count++;
		if($count==1)
		{
			$tempgroup =  $row['groupid'];
			
		}
        $options .= "<option value='".$row['groupid']."'>";
        $options .= $row['groupid'];
        $options .= "</option>";
    }
}






$output .= "<script>function ajax(){var req = new XMLHttpRequest();
		req.onreadystatechange = function(){
		if(req.readyState == 4 && req.status == 200){
		document.getElementById('chat').innerHTML = req.responseText;
		} 
		}
		req.open('GET','views/chat.php',true); 
		req.send();
		}
		window.setInterval('ajax()', 1000);</script>
	
<body onload='ajax();'>

<div id='container'>
<form method=\"post\" action=\"\">    
                <fieldset>
                    <label for='group' class='label label-danger'> Group:</label>
                    <select class=\"form-control\" name='group'>

                        \".$options.\"
                        <option value=''>nothing</option>
                    </select>
                
                <input class='btn btn-danger' type=\"submit\"  name=\"groupsubmit\" value=\"change group\"/>
                </fieldset>
              </form>
		<div id='chat_box' style='overflow:scroll; width:max-width;height:400px;'>
		<div id=\"chat\"></div>
		</div>
		
		
		<br>
		<br>
		<br>
		<form method=\"post\" action=\"\">
		<textarea class='form-control' name='msg'></textarea>
		<input type='submit' class='btn btn-primary' name='submit' value='Send it'/>
		
		</form>
		
		
		";

		if(isset($_POST['groupsubmit'])){
			
			if(isset($_SESSION['group'])){
				$_SESSION["group"]= $_POST['group'];
			}else{
				$_SESSION["group"]= $tempgroup;
			}
			
			
			
		}
		
		if(isset($_POST['submit'])){ 
		
		$name = $_SESSION["username"];
		$msg = $_POST['msg'];

		
		//sanitising the input
		$msg = trim($msg);
		$msg = stripslashes($msg);
		$msg = htmlspecialchars($msg);
		$msg = mysqli_real_escape_string($conn,$msg);
		
		$query = "INSERT INTO chat (name,msg, togroup) values ('$name','$msg', '$_SESSION[group]')";
		
		$run = $conn->query($query);
		
		}
		?>