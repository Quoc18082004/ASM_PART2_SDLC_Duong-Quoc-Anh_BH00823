<?php
$servername = "localhost"; // ID server
$username = "root";        // username
$password = "";            // pass
$dbname = "quoc_anhbh00823-1"; //name Database


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
?>