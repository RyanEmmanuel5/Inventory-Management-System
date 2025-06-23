<?php
session_start();
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <link rel = "stylesheet" type = "text/css" href ="css/register.css">
</head>
<body class = "Regbody">
<form action="database/process.php" method="POST" id="register_form">
    <h1>Register</h1>
    <div class="name_error">
        <label for="First_Name">FIRST NAME</label>
        <input type="text" name="First_Name" placeholder="Please input your First Name" value="">
    </div>
    <div>
        <label for="Middle_Initial">MIDDLE INITIAL</label>
        <input type="text" name="Middle_Initial" placeholder="Please input your Middle Initial" value="">
    </div>
    <div>
        <label for="Last_Name">LAST NAME</label>
        <input type="text" name="Last_Name" placeholder="Please input your Last Name" value="">
    </div>
    <div>
        <label for="Email">EMAIL</label>
        <input type="email" name="Email" placeholder="Please input your Email" value="">
        <?php if ($error_message): ?>
            <span style="color: red;"><?php echo $error_message ?></span>
        <?php endif ?>
    </div>
    <div>
        <label for="Password">PASSWORD</label>  
        <input type="password" name="Password" placeholder="Please input your desired Password" value="">
    </div>
    <div>
        <label for="Date_Created">DATE CREATED</label>
        <input type="date" name="Date_Created" placeholder="Date Created" value="">
    </div>
    <div>
        <button type="submit" name="Register" id="Reg_Btn">Register</button>
    </div>
</form>
</body>
</html>