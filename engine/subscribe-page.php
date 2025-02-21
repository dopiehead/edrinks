<?php
 $newsletter_email = $_POST['newsletter_email'];
 $date_added = date("Y-m-d H:i:s");
 $stmt = $conn->prepare("INSERT INTO newsletter (newsletter_email,date_added) VALUES (?,?)");
 $stmt->bind_param("ss", $newsletter_email, $date_added);

if( $stmt->execute()):
       echo"1";
else:
    // If something goes wrong, display an error message
    echo"Error: ". $stmt->error;
endif;



?>