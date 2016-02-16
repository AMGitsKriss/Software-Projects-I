<?php

$output .= "<h1 style=\"color:#8b8989;margin-left:45%; font:40px arial, sans-serif;\">Home</h1>";

$sql = "SELECT name, postid FROM Posts
	ORDER BY postid";
$result = mysqli_query($link, $sql);

if ($result === false) 
{
    echo mysqli_error($link);
} else {
	$num_rows = mysqli_num_rows($result);
	if ($num_rows > 0)
	{
	    	$output .= "<table border='1'>";
	    	$output .= "<thead><tr><th>User Name</th><th>Post</th></tr></thead>";
	    	$output .= "<tbody>";

	    	while ($row = mysqli_fetch_assoc($result)) {
			$output .= "<tr>";
			$output .= "<td><a href=\"?page=name=".$row['name']."\">".$row['name']."</a></td>";
			$output .= "<td>".$row['postid']."</td>";
			$output .= "</tr>";
		}
		$output .= "</tbody></table>";
	} else {
		$output .= "<p>There are no posts to display.</p>";
	}

	mysqli_free_result($result);
}

echo $output;

?>