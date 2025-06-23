<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $user = ($_SESSION['user']);

     // Database connection
     $con = mysqli_connect('localhost','root','','inventory');
     if (!$con){
         die(mysqli_error("error"+$con));
     }
     // Fetch data from health_rec table
    $query = "SELECT `Student_Number`, `Concern`, `Temperature`, `Weight`, `Prescription`, `Admission_Date` FROM `health_rec`";
    $result = mysqli_query($con, $query);
    ?>
<!DOCTYPE html>
<html>
    <head>
        <Title>View Record</Title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel = "stylesheet" type = "text/css" href ="css/dashboard.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
       />
       <style>
        .search_input {
            width: 70%;
            padding: 10px;
            margin-right: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .btn-dark {
            background-color: #7d9970;
            color: white; 
            font-size: 14px; 
            padding: 8px 16px; 
            border-radius: 4px; 
            border: none; 
            cursor: pointer; 
            transition: background-color 0.3s;
            margin-bottom: 10px;
        }
        .btn-dark:hover {
            background-color: #a2b089; 
        }
        </style>
    </head>
    <body id = "DashboardBody">
        <div class = "DashboardMainContainer">
            <div class = "dashboard_sidebar">
                <h3 class = "dashboard_logo">INFIRMARY SYSTEM</h3>
                <div class = "dashboard_sidebar_user">
                    <i class = "fa-solid fa-user-nurse" style = "color: #ffffff;"></i>
                    <span><?= $user['Last_Name']?></span>
                </div>
                <div class = "dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li class="menuActive">
                        <div class="item">
                        <a href="#" class = "sub-btn">
                            <i class="fa-solid fa-book-medical"></i>Health Records
                            <i class="fas fa-angle-right dropdown"></i>
                        </a>
                        <div class="sub-menu">
                            <a href="record-add.php" class="sub-item"><i class = "fa-solid fa-plus"></i>Add Record</a>
                            <a href="search.php" class="sub-item"><i class = "fa-solid fa-plus"></i>Update Record</a>
                            <a href="record-view.php" class="sub-item"><i class = "fa-solid fa-plus"></i>View Record</a>
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
            <div class = "dashboard_content_container ">
                <div class = "dashboard_topnav">
                    <a href = "database/logout.php" id = "LogoutBtn"><i class = "fa fa-power-off"></i>Log-out</a>
                </div>
                <div class = "dashboard_content">
                    <div class = "dashboard_content_main">
                    <div class="dashboard_content_main">
                        <!-- Search bar -->
                        <div class="input-group mb-3">
                            <input type="date" class="form-control search_input" id="admissionDate" placeholder="Search by Admission Date">
                            <div class="input-group-append">
                                <button class="btn btn-dark" type="button" id="searchButton">Search</button>
                            </div>
                        </div>

                        <!-- Table to display search results -->
                        <div class="stock-table">
                            <!-- Table content -->
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <script src ="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
$(document).ready(function () {
    // Function to handle search when the search button is clicked
    $('#searchButton').on('click', function () {
        searchByAdmissionDate();
    });

    // Function to handle search when Enter key is pressed in the search input field
    $('#admissionDate').keypress(function (e) {
        if (e.which === 13) {
            searchByAdmissionDate();
        }
    });

    // Function to perform AJAX search by Admission Date
    function searchByAdmissionDate() {
        var admissionDate = $('#admissionDate').val();

        // Check if the admissionDate is empty
        if (!admissionDate) {
            admissionDate = ''; // Set admissionDate to empty string or null
        }

        $.ajax({
            type: 'POST',
            url: 'search-rec.php', // URL to the PHP script for searching records
            data: { Admission_Date: admissionDate },
            dataType: 'html', // Expect HTML response to display in the table
            success: function (response) {
                $('.stock-table').html(response); // Update the table content with search results
            },
            error: function () {
                alert('An error occurred while searching for records.');
            }
        });
    }

    $('.sub-btn').click(function () {
        $(this).toggleClass('active'); // Toggle the active class
        $(this).next('.sub-menu').slideToggle(); // Slide toggle the sub-menu
    });
});
        </script>
    </body>
</html>