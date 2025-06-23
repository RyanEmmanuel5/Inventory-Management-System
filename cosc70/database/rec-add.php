<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Student_No = $_POST['Student_No'];
    $Last_Name = $_POST['Last_Name'];
    $First_Name = $_POST['First_Name'];
    $Middle_Initial = $_POST['Middle_Initial'];
    $Contact_No= $_POST['Contact_No'];
    $Course_Section = $_POST['Course_Section'];
    $Age = $_POST['Age'];
    $Gender = $_POST['Gender'];
    $Guardian = $_POST['Guardian'];
    $Guardian_No = $_POST['Guardian_No'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'inventory');
    if ($conn->connect_error) {
        die('Connection Failed: '.$conn->connect_error);
    } else {
        // Check if the student number already exists
        $check_query = "SELECT * FROM students_rec WHERE Student_Number = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $Student_No);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error_message'] = "Student number already registered. Please use a different one.";
            header('location: ../record-add.php'); // Redirect back to the form page
            exit();
        } else {
            // Insert new record if student number doesn't exist
            $stmt = $conn->prepare("INSERT INTO students_rec (Student_Number, Last_Name, First_Name, Middle_Initial, Contact_No, Course_Section, Age, Gender, Guardian, Guardian_No)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssisss", $Student_No, $Last_Name, $First_Name, $Middle_Initial, $Contact_No, $Course_Section, $Age, $Gender, $Guardian, $Guardian_No);
            $stmt->execute();
            $_SESSION['success_message'] = "Record added successfully.";
            header('location: redirect.php'); // Redirect to the success page
            exit();
        }

        $check_stmt->close();
        $stmt->close();
        $conn->close();
    }
}
?>
