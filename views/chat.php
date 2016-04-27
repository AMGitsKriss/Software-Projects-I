<?php 
include_once('../config/db_connect.php');

function formatDate($date){
	return date('g:i a', strtotime($date));
}

		
	$query = "SELECT * FROM chat ORDER BY id DESC";
	$run = $conn->query($query);
	while($row = $run->fetch_array()) :
		?>
			<div id="chat_data">
				<span style="color:green;"><?php echo $row['name']; ?></span> :
				<span style="color:brown;"><?php echo $row['msg']; ?></span>
				<span style="float:right;"><?php echo formatDate($row['date']); ?></span>
			</div>
			<?php endwhile;?>