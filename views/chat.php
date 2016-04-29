<?php 
include_once('../config/db_connect.php');

session_start();

function formatDate($date){
	return date('g:i a', strtotime($date));
}

		if(isset(($_SESSION['group']))&&($_SESSION['group']!=="")){
	$query = "SELECT * FROM chat WHERE togroup = '$_SESSION[group]' ORDER BY id DESC";

	$run = $conn->query($query);
	while($row = $run->fetch_array()) :
		?>
			<div id="chat_data" style='background:grey'>
				<span style="color:brown;"><?php echo $row['name']; ?></span> :
				<span style="color:black;"><?php echo $row['msg']; ?></span>
				<span style="color:blue; float:right;"><?php echo formatDate($row['date']); ?></span>
			</div>
		<?php endwhile;}?>