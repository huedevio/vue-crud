<?php 

$conn = new mysqli("localhost", "root","", "crudvue");

if($conn->connect_error)
{
    die ("Connetion Failed!".$conn->connect_error);
}

?>