<?php
include 'database/stock-con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['ID'];

    $sql = "DELETE FROM stocks WHERE ID = '$id'";
    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($con)]);
    }
    exit();
}
?>
