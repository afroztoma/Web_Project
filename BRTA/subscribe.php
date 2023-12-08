<?php
include_once "connection.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$email = $_POST['email'];

$sql = "INSERT INTO subscribers (email) VALUES ('$email')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php?success_msg=Thank You for Subscribe");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
