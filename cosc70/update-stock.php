<?php
include 'database/stock-con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ID = $_POST['ID'];
    $Quantity = $_POST['Quantity'];
    $Generic_Name = $_POST['Generic_Name'];
    $Brand_Name = $_POST['Brand_Name'];
    $Mg = $_POST['Mg'];
    $Expiration_Date = $_POST['Expiration_Date'];
    $Date_Added = $_POST['Date_Added'];

    $sql = "UPDATE stocks SET Quantity='$Quantity', Generic_Name='$Generic_Name', Brand_Name='$Brand_Name', Mg='$Mg', Expiration_Date='$Expiration_Date', Date_Added='$Date_Added' WHERE ID='$ID'";
    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Record updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($con)]);
    }
    exit();
}
?>
