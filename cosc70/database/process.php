<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Register'])) {
    // Database connection
    $db = new mysqli('localhost', 'root', '', 'inventory');

    // Check connection
    if ($db->connect_error) {
        die('Connection failed: ' . $db->connect_error);
    }

    $First_Name = mysqli_real_escape_string($db, $_POST['First_Name']);
    $Middle_Initial = mysqli_real_escape_string($db, $_POST['Middle_Initial']);
    $Last_Name = mysqli_real_escape_string($db, $_POST['Last_Name']);
    $Password = mysqli_real_escape_string($db, $_POST['Password']); // Store plain text password
    $Email = mysqli_real_escape_string($db, $_POST['Email']);
    $Date_Created = mysqli_real_escape_string($db, $_POST['Date_Created']);

    // Check if email is already registered
    $sql_u = "SELECT * FROM users WHERE Email = ?";
    $stmt_u = $db->prepare($sql_u);
    $stmt_u->bind_param("s", $Email);
    $stmt_u->execute();
    $res_u = $stmt_u->get_result();

    if ($res_u->num_rows > 0) {
        // Email is already taken
        $_SESSION['error_message'] = "Email is already registered. Please use a different email.";
        header('Location: ../register.php');
        exit();
    } else {
        // Proceed to insert data
        $query = "INSERT INTO users (First_Name, Middle_Initial, Last_Name, Password, Email, Date_Created)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ssssss", $First_Name, $Middle_Initial, $Last_Name, $Password, $Email, $Date_Created);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Registration success message
            $_SESSION['success_message'] = "Registration successful. Please log in.";

            // Redirect to login page
            header('Location: ../login.php');
            exit();
        } else {
            $_SESSION['error_message'] = "Error: " . $stmt->error;
            header('Location: ../register.php');
            exit();
        }

        $stmt->close();
    }

    $stmt_u->close();
    $db->close();
}
?>