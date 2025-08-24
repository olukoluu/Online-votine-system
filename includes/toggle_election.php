<?php

include_once('connect.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_POST['id']);
$status = $_POST['status'];

$sql = "UPDATE elections SET status = $status WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../admin/elections.php");
    exit;
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
