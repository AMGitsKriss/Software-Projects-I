<?php

$content = "<h1 style=\"color:#8b8989;margin-left:45%; font:40px arial, sans-serif;\">Settings</h1>";

$sql = "SELECT name, email, reg_date FROM Users";
$result = mysqli_query($link, $sql);

if ($result === false) 
{
    echo mysqli_error($link);
} else {
	$num_rows = mysqli_num_rows($result);
	if ($num_rows > 0)
	{
	    	$content .= "<table border='1'>";
	    	$content .= "<thead><tr><th>Name</th><th>Email Address</th><th>Registration Date</th></tr></thead>";
	    	$content .= "<tbody>";

	    	while ($row = mysqli_fetch_assoc($result)) {
			$content .= "<tr>";
			$content .= "<td><a href=\"?page=name=".$row['name']."\">".$row['name']."</a></td>";
			$content .= "<td>".$row['email']."</td>";
			$content .= "<td>".$row['reg_date']."</td>";
			$content .= "</tr>";
		}
		$content .= "</tbody></table>";
	} else {
		$content .= "<p>No user details found.</p>";
	}

	mysqli_free_result($result);
}

echo $content;

?>