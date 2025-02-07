<?php 
     $conn = mysqli_connect("localhost","root","","e_drinks");
     if(!$conn){
         die("Connection failed: ". mysqli_connect_error());
     }
  ?>