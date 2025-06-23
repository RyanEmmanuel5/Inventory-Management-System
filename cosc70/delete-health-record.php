<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

include 'database/search-con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM health_rec WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($con)]);
    }
    exit();
}
?>
