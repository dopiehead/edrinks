<?php 

if(isset($_POST['id'])){
     $id = $_POST['id'];
     $delete = $conn->prepare("DELETE FROM user_notifications WHERE id = ?");
     if($delete->bind_param('i',$id)){
         $delete->execute();
         echo "1";
     }
}

?>