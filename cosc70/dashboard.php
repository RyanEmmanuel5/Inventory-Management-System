<?php
 session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $user = ($_SESSION['user']);

    

    // Establish database connection
    $db_host = 'localhost'; // Database host
    $db_name = 'your_database'; // Database name

    // Establish database connection
    $connection = mysqli_connect('localhost', 'root', '', 'inventory');

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //for line chart

    // Query to fetch data from health_rec table for the latest 5 dates
    $query = "SELECT DATE(Admission_Date) AS date, COUNT(*) AS record_count 
              FROM health_rec 
              GROUP BY DATE(Admission_Date)
              ORDER BY Admission_Date DESC
              LIMIT 5";

    // Execute query
    $result = mysqli_query($connection, $query);

    // Check if query execution was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    // Fetch data from the result
    $labels = [];
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['date'];
        $data[] = $row['record_count'];
    }

    // Reverse the order of labels and data arrays
    $labels = array_reverse($labels);
    $data = array_reverse($data);

    // Free result set if it exists and if it hasn't been freed already
    if ($result) {
        mysqli_free_result($result);
    }

    //until here

    //for pie chart

    // Query to fetch data from stocks table
    $query_stocks = "SELECT Brand_Name, Quantity FROM stocks";

    // Execute query
    $result_stocks = mysqli_query($connection, $query_stocks);

    // Check if query execution was successful
    if (!$result_stocks) {
    die("Query failed: " . mysqli_error($connection));
    }

    // Fetch data from the result
    $Brand_Name = [];
    $Quantity = [];
    while ($row = mysqli_fetch_assoc($result_stocks)) {
    $Brand_Name[] = $row['Brand_Name'];
    $Quantity[] = $row['Quantity'];
    }

    // Free result set if it exists and if it hasn't been freed already
    if ($result_stocks) {
    mysqli_free_result($result_stocks);
    }

    //until here

    //for total health rec

    // Query to fetch total number of health records
    $query_total_records = "SELECT COUNT(*) AS ID FROM health_rec";

    // Execute query
    $result_total_records = mysqli_query($connection, $query_total_records);

    // Check if query execution was successful
    if (!$result_total_records) {
    die("Query failed: " . mysqli_error($connection));
    }

    // Fetch total number of records from the result
    $total_records = mysqli_fetch_assoc($result_total_records)['ID'];

    // Free result set if it exists and if it hasn't been freed already
    if ($result_total_records) {
    mysqli_free_result($result_total_records);
    }

    //for total student rec

    // Query to fetch total number of student records
    $query_total_student_records = "SELECT COUNT(*) AS ID FROM students_rec";

    // Execute query
    $result_total_student_records = mysqli_query($connection, $query_total_student_records);

    // Check if query execution was successful
    if (!$result_total_student_records) {
    die("Query failed: " . mysqli_error($connection));
    }

    // Fetch total number of student records from the result
    $total_student_records = mysqli_fetch_assoc($result_total_student_records)['ID'];

    // Free result set if it exists and if it hasn't been freed already
    if ($result_total_student_records) {
    mysqli_free_result($result_total_student_records);
    }

    // Close connection
    mysqli_close($connection);

?>
<!DOCTYPE html>
<html>
    <head>
        <Title>Dashboard</Title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel = "stylesheet" type = "text/css" href ="css/dashboard.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
       />
       <style>

        /* CSS for the chart container */
        .chart-container {
            width: 500px; /* Adjust the width as needed */
            height: 300px; /* Adjust the height as needed */
            margin-left: 30px; /* Center the container horizontally with some top margin */
            border: 3px solid #a2b089; /* Optional: Add a border for visualization */
            margin-top: -13px;
            padding: 20px;
            border-radius: 10px;
        }
        .chart-container1{
            width: 500px; /* Adjust the width as needed */
            height: 300px; /* Adjust the height as needed */
            margin-left: 600px; /* Center the container horizontally with some top margin */
            border: 3px solid #a2b089; /* Optional: Add a border for visualization */
            margin-top: -300px;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }
        .chart-container2{
            border: 3px solid #a2b089;
            border-radius: 10px;
            width: 200px;
            height: 200px;
        }
        /* CSS for the canvas */
        canvas#stockPieChart {
            width: 100% !important;
            height: 100% !important;
            max-width: 300px; /* Set maximum width */
            max-height: 300px; /* Set maximum height */
            align: center;
        }
        .square1{
            border: 3px solid #a2b089;
            border-radius: 10px;
            padding: 20px;
            width: 225px;
            height: 225px;
            margin-top: 40px;
            margin-left: 30px;
        }
        .square1 h6{
            text-align: center;
        }
        .square2{
            border: 3px solid #a2b089;
            border-radius: 10px;
            padding: 20px;
            width: 225px;
            height: 225px;
            margin-top: -225px;
            margin-left: 305px;
        }
        .square2 h6{
            text-align: center;
        }
        .square3{
            border: 3px solid #a2b089;
            border-radius: 10px;
            padding: 20px;
            width: 500px;
            height: 225px;
            margin-top: -225px;
            margin-left:600px;
        }
        .square3 h6{
            text-align: center;
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
                        <div class = "chart-container-1">
                            <div class="chart-container">
                                <canvas id="recordChart"></canvas>
                            </div>
                            <div class = "chart-container1">
                                <canvas id="stockPieChart"></canvas>
                            </div>
                            <div class="square1">
                                <div style="display: flex; justify-content: center;">
                                    <i class="fa-solid fa-notes-medical" style="color: #a2b089; font-size: 45px; margin-top: 5px; "></i>
                                </div>
                                <h6 style = "font-size: 23px; font-family: calibri; font-weight: bold; margin-top: 15px;">TOTAL HEALTH RECORDS</h6>
                                <div style="display: flex; justify-content: center;">
                                    <p style="font-size: 50px; color: #333; font-weight: bold; margin-top: -10px;"><?php echo $total_records; ?></p>
                                </div>
                            </div>
                            <div class="square2">
                                <div style="display: flex; justify-content: center;">
                                    <i class="fa-solid fa-user-graduate" style="color: #a2b089; font-size: 45px; margin-top: 5px;"></i>
                                </div>
                                <h6 style="font-size: 23px; font-family: calibri; font-weight: bold; margin-top: 15px;">TOTAL STUDENT RECORDS</h6>
                                <div style="display: flex; justify-content: center;">
                                    <p style="font-size: 50px; color: #333; font-weight: bold; margin-top: -10px;"><?php echo $total_student_records; ?></p>
                                </div>
                            </div>
                            <div class = "square3">
                                <div style="display: flex; justify-content: center;">
                                    <i class="fa-solid fa-hospital" style="color: #a2b089; font-size: 35px; margin-top: 5px; margin-bottom: -10px;"></i>
                                </div>
                                <h6 style="font-size: 23px; font-family: calibri; font-weight: bold; margin-top: 15px; border-bottom: 1px solid; border-color: #a2b089;">NEARBY HOSPITALS AND CLINICS HOTLINES</h6>
                                <div style="display: flex; flex-direction: column;">
                                <ul style="list-style-type: disc; margin-right: 10px;">
                                    <li style="font-size: 13px; color: #333; font-weight: bold; margin-top: 5px; margin-left: -17px;">First Filipino Saint Hospital - San Lorenzo Ruiz ------ (046)-412-1411</li>
                                </ul>
                                <ul style="list-style-type: disc; margin-right: 10px;">
                                    <li style="font-size: 13px; color: #333; font-weight: bold; margin-top: -10px; margin-left: -17px;">Naic Doctors Hospital ---------------------------------- (046)-412-1443</li>
                                </ul>
                                <ul style="list-style-type: disc; margin-right: 10px;">
                                    <li style="font-size: 13px; color: #333; font-weight: bold; margin-top: -10px; margin-left: -17px;">Naic Rural Health Unit - Main ------------------------- (046)-412-0296</li>
                                </ul>
                                <ul style="list-style-type: disc; margin-right: 10px;">
                                    <li style="font-size: 13px; color: #333; font-weight: bold; margin-top: -10px; margin-left: -17px;">Naic Medicare Hospital -------------------------------- (046)-412-0312</li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src ="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>


    <script>

         // JavaScript code for rendering the pie chart
         $(document).ready(function () {
        var canvas = document.getElementById('stockPieChart');
        canvas.width = 400; // Set the width
        canvas.height = 300; // Set the height

        var ctx = canvas.getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($Brand_Name); ?>,
                datasets: [{
                    label: 'Medicine Quantity',
                    data: <?= json_encode($Quantity); ?>,
                    backgroundColor: [
                        'rgba(51, 61, 41, 1)',
                        'rgba(101, 109, 74, 1)',
                        'rgba(164, 172, 134, 1)',
                        'rgba(194, 197, 170, 1)',
                        'rgba(47, 62, 70, 1)',
                        'rgba(53, 79, 82, 1)',
                        'rgba(166, 138, 100, 1)',
                        'rgba(147, 102, 57, 1)',
                        'rgba(127, 79, 36, 1)',
                        'rgba(88, 47, 14, 1)',
                    ],
                    borderColor: [
                        'rgba(51, 61, 41, 1)',
                        'rgba(101, 109, 74, 1)',
                        'rgba(164, 172, 134, 1)',
                        'rgba(194, 197, 170, 1)',
                        'rgba(47, 62, 70, 1)',
                        'rgba(53, 79, 82, 1)',
                        'rgba(166, 138, 100, 1)',
                        'rgba(147, 102, 57, 1)',
                        'rgba(127, 79, 36, 1)',
                        'rgba(88, 47, 14, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Medicine Quantity Distribution',
                        font: {
                            size: 16,
                            family: 'Calibri',
                            weight: 'bold'
                        }
                    }
                }
            }
        });
    });
        

        // JavaScript code for rendering the chart
        $(document).ready(function(){
            var ctx = document.getElementById('recordChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($labels); ?>,
                    datasets: [{
                        label: 'Newly Added Health Records',
                        data: <?= json_encode($data); ?>,
                        borderColor: '#7d9970',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            // Display only whole numbers on the y-axis
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Newly Added Health Records',
                            font: {
                                size: 16, // Increase the font size as needed
                                family: 'Calibri', // Set the font family
                                weight: 'bold' // Set the font weight to bold
                            }
                        }
                    }
                }
            });
        });
    </script>

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