<?php

$output = "<h1 style=\"color:#8b8989;margin-left:45%; font:40px arial, sans-serif;\">Settings</h1>";

$sql = "SELECT name, email, reg_date FROM Users";
$result = mysqli_query($link, $sql);

if ($result === false) 
{
    echo mysqli_error($link);
} else {
	$num_rows = mysqli_num_rows($result);
	if ($num_rows > 0)
	{
	    	$output .= "<table border='1'>";
	    	$output .= "<thead><tr><th>Name</th><th>Email Address</th><th>Registration Date</th></tr></thead>";
	    	$output .= "<tbody>";

	    	while ($row = mysqli_fetch_assoc($result)) {
			$output .= "<tr>";
			$output .= "<td><a href=\"?page=name=".$row['name']."\">".$row['name']."</a></td>";
			$output .= "<td>".$row['email']."</td>";
			$output .= "<td>".$row['reg_date']."</td>";
			$output .= "</tr>";
		}
		$output .= "</tbody></table>";
	} else {
		$output .= "<p>No user details found.</p>";
	}

	mysqli_free_result($result);
}

echo $output;

?>