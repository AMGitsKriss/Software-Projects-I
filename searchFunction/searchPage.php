<?php
//Tested using my own DB. 
//Works but issues to iron out, like the way results are displayed, db and search criteria to change.
include_once('../db_connect.php');

//Using GET method from form search.php
//%(percentage wildcard)
if(isset($_GET['title'])){
    $title = "%".$_GET['title']."%";
}else{
    $title = "none";
}
//Used my own db to test
$sql= "SELECT * FROM entries WHERE title LIKE :title";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->execute();
$total = $stmt->rowCount();

//fetches objects and echos. Echos out as row
while ($row = $stmt->fetchObject()) {
   echo $row->title;
}
?>
