<?php

$conn = mysqli_connect(
    "localhost",
    "bankuser",
    "bank123",
    "bankdb"
);

if(!$conn){
    die("Database Connection Failed");
}

?>
