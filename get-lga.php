<?php

require 'connection.php';

$condition = "SELECT * from states_in_nigeria";

if (isset($_POST['location'])) {

$location = mysqli_escape_string($con,$_POST['location']);

$condition .= " where state = '".htmlspecialchars($location)."'";
}
$getStates = mysqli_query($con,$condition);

echo "<select name='lga' id='lga' class=' lga address_details'>";

while ($states = mysqli_fetch_array($getStates)) {

echo"<option value='".htmlspecialchars($states['lga'])."'>".htmlspecialchars($states['lga'])."</option>";
}


echo"</select><br>";



?>

