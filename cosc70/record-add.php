<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $user = ($_SESSION['user']);
?>


<!DOCTYPE html>
<html>
    <head>
        <Title>Add Record</Title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/dashboard.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
            }
            .container h1 {
                text-align: center;
                margin-bottom: 20px;
            }
            .form-row {
                display: flex;
                flex-wrap: wrap;
                margin-bottom: -15px;
            }
            .form-group {
                flex: 1;
                min-width: 200px;
                padding: 5px;
            }
            .form-group.label-middle {
                flex: 0.5;
                min-width: 100px;
            }
            .form-group input[type="text"], .form-group select {
                width: 100%;
                padding: 8px;
                margin-top: 5px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            .appBtn {
                display: block;
                width: 110px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }
            .appBtn i {
                margin-right: 5px;
            }
            .success-message {
                background-color: #d4edda;
                color: #155724;
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #c3e6cb;
                border-radius: 4px;
            } 
            .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            }
        </style>
    </head>
    <body id="DashboardBody">
        <div class="DashboardMainContainer">
            <div class="dashboard_sidebar">
                <h3 class="dashboard_logo">INFIRMARY SYSTEM</h3>
                <div class="dashboard_sidebar_user">
                    <i class="fa-solid fa-user-nurse" style="color: #ffffff;"></i>
                    <span><?= $user['Last_Name']?></span>
                </div>
                <div class="dashboard_sidebar_menus">
                    <ul class="dashboard_menu_lists">
                        <li class="menuActive">
                            <div class="item">
                                <a href="#" class="sub-btn">
                                    <i class="fa-solid fa-book-medical"></i>Health Records
                                    <i class="fas fa-angle-right dropdown"></i>
                                </a>
                                <div class="sub-menu">
                                    <a href="record-add.php" class="sub-item"><i class="fa-solid fa-plus"></i>Add Record</a>
                                    <a href="search.php" class="sub-item"><i class="fa-solid fa-plus"></i>Update Record</a>
                                    <a href="record-view.php" class="sub-item"><i class="fa-solid fa-plus"></i>View Record</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <a href="manage-stocks.php" class="sub-btn">
                                    <i class="fa-solid fa-chart-simple"></i>Stocks 
                                    
                                </a>
                                
                            </div>
                        </li>
                        <li>
                            <div class="item"><a href="dashboard.php"><i class="fa-solid fa-gauge"></i>Dashboard</a></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="dashboard_content_container">
                <div class="dashboard_topnav">
                    <a href="database/logout.php" id="LogoutBtn"><i class="fa fa-power-off"></i>Log-out</a>
                </div>
                <div class="dashboard_content">
                    <div class="dashboard_content_main">
                        <div id="userAddFormContainer">
                            <form action="database/rec-add.php" method="POST" class="appForm">
                            <h2 style="text-align: center; font-family: Calibri, sans-serif; font-weight: bold;">FILL UP FORM</h2>
                                <?php
                                if(isset($_SESSION['success_message'])) {
                                    echo '<div class="success-message">'.$_SESSION['success_message'].'</div>';
                                    unset($_SESSION['success_message']);
                                }
                                ?>
                                <?php
                                // Check if there's an error message
                                if(isset($_SESSION['error_message'])) {
                                    echo '<div class="error-message">'.$_SESSION['error_message'].'</div>';
                                    unset($_SESSION['error_message']); // Unset the error message to prevent it from showing again on page reload
                                }
                                ?>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Student_No">STUDENT NUMBER:</label>
                                        <input type="text" id="Student_No" name="Student_No" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Course_Section">COURSE AND SECTION:</label>
                                        <input type="text" id="Course_Section" name="Course_Section" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Last_Name">LAST NAME:</label>
                                        <input type="text" id="Last_Name" name="Last_Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="First_Name">FIRST NAME:</label>
                                        <input type="text" id="First_Name" name="First_Name" required>
                                    </div>
                                    <div class="form-group label-middle">
                                        <label for="Middle_Initial">MIDDLE INITIAL:</label>
                                        <input type="text" id="Middle_Initial" name="Middle_Initial">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Contact_No">CONTACT NUMBER:</label>
                                        <input type="text" id="Contact_No" name="Contact_No" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Age">AGE:</label>
                                        <input type="text" id="Age" name="Age" required>
                                    </div>
                                    <div class="form-group label-middle">
                                        <label for="Gender">SEX BY BIRTH:</label>
                                        <input type="text" id="Gender" name="Gender" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Guardian">NAME OF GUARDIAN:</label>
                                        <input type="text" id="Guardian" name="Guardian" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Guardian_No">GUARDIAN'S CONTACT NUMBER:</label>
                                        <input type="text" id="Guardian_No" name="Guardian_No" required>
                                    </div>
                                </div>
                                <input type="hidden" name="table" value="students_rec">
                                <button type="submit" class="appBtn"></i> ADD RECORD</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.sub-btn').click(function(){
                    $(this).toggleClass('active'); // Toggle the active class
                    $(this).next('.sub-menu').slideToggle(); // Slide toggle the sub-menu
                });
            });
        </script>
    </body>
</html>
