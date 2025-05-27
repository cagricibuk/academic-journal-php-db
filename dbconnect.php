<?php

$dbname = "project";
$host = "localhost";
$user = "root";
$pwd = "";

$conn = mysqli_connect($host, $user, $pwd, $dbname);
// Check connection
if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}
else{
    echo "connected";
}
// tamamdır zaten collabrate çaışıyoruz 
?>