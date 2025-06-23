<?php

    //start the session
    session_start();

    $success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
    unset($_SESSION['success_message']);

    $error_message = '';

    if($_POST){
        include('database/connection.php');

        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = 'SELECT * FROM users WHERE users.email = "'. $email .'" AND 
        users.password = "'. $password .'"';
        $stmt = $conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetchAll()[0];
            $_SESSION['user'] = $user;

            header('location: dashboard.php');
        } else $error_message = 'Please ensure that email and password are correct';

    }
?>

<html>
    <link rel = "stylesheet" type = "text/css" href ="css/login.css">
    <head>
        <title>Login</title>
    </head>
    <body id = "LoginBody1">
        <div>
        <?php if ($success_message): ?>
            <div id="successMessage" style="background: ivory; text-align: center; color: green; font-size: 20px; padding: 10px; font-weight: bold; font-family: Calibri; margin: -8px;">
            <?php echo $success_message ?>
            </div>
        <?php endif ?>
        <!-- your login form -->
        </div>
        <?php if(!empty($error_message)) { ?>
            <div id="errorMessage">
                <p><?= $error_message ?> </p>
            </div>
        <?php } ?>
        <div class = "container">
            <div class = "LoginHeader">
            </div>
            <div class = "LoginBody">
                <form action = "login.php" method = "POST">
                    <img src = "images1/logo.png"  class = "logoCont"                    
                    />

                    <div class = "Lheader">
                        <h1>CAVITE STATE UNIVERSITY</h1>
                        <h2>NAIC CAMPUS</h2>
                    </div>
                    <div class = "Lheader2">
                        <h3>INFIRMARY SYSTEM</h3> 
                    </div>
                    <div class = "LoginInputsContainer">
                        <label for = " ">Email</label>
                        <input placeholder = "Please input email" name = "email" type ="text" />
                    </div>
                    <div class = "LoginInputsContainer">
                        <label for =" ">Password</label>
                        <input placeholder = "Please input password" name = "password" type = "password" />
                    </div>
                    <div>
                        <div class = "LoginButtonContainer">
                        <button>LOGIN</button>
                    </div>
                    <div>
                        <div class = "RegButtonContainer">
                        <button type="button" onclick="redirectToRegister()">REGISTER</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
        function redirectToRegister() {
            window.location.href = "register.php";
        }
    </script>
    </body>
</html>