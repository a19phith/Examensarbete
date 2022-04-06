<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "pilotstudie";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $sql = "DELETE FROM elpriser";
    
    if ($conn->query($sql) === TRUE) {
        echo "good";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
$conn->close();
?>