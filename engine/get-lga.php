<?php
require 'connection.php';

if (isset($_POST['location'])) {
    $location = $_POST['location'];
    $sql = "SELECT * FROM states_in_nigeria WHERE state = ?";
    
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("s", $location);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            echo "<select name='lga' id='lga' class='lga address_details'>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['lga']) . "'>" . 
                     htmlspecialchars($row['lga']) . "</option>";
            }
            echo "</select><br>";
        } else {
            echo "Error executing query";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement";
    }
}
$con->close();
?>