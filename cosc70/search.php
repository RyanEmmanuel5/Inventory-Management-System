<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $user = ($_SESSION['user']);

    include 'database/search-con.php'

?>
<!DOCTYPE html>
<html>
    <head>
        <Title>Search</Title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel = "stylesheet" type = "text/css" href ="css/dashboard.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
       <style>
        /* Your custom CSS */
        div.dashboard_content {
            padding: 10px;
            background: #f4f4f9;
            border-radius: 8px;
            margin-top: 33px;
            margin-left: 25px;
        }

        div.dashboard_content_main {
            margin-top: 20px;
        }

        div.search_container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .search_input {
            width: 70%;
            padding: 10px;
            margin-top: 10px;
            margin-right: 10px;
            margin-left: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        div.table_container {
            overflow-x: auto;
        }

        .table.custom_table {
            font-family: Calibri, sans-serif;
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .table.custom_table th, .table.custom_table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table.custom_table th {
            background: #7d9970;
            color: #f9f9f7;
            font-weight: bold;
        }

        .table.custom_table tbody tr:hover {
            background: #f1f1f1;
        }

        .table.custom_table tbody tr a {
            text-decoration: none;
            color: #496d4c;
            font-weight: bold;
        }

        .table.custom_table tbody tr a:hover {
            color: #2e4d3a;
        }

        h2.text-danger {
            color: #ff6b6b;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
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
            margin-top: 10px;
            margin-bottom: 10px;
            margin-right: 10px;
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
                         
                    <form method="POST">
    <div class="input-group mb-3">
        <input type="text" class="form-control search_input" placeholder="Search Student Data" name="search">
        <div class="input-group-append">
            <button class="btn btn-dark" type="submit" name="submit">Search</button>
        </div>
    </div>
</form>
                            <div class = "table_container">
                                <table class = "table table-bordered">
                                    <?php
                                        if (isset($_POST['submit'])){
                                            $search =$_POST['search'];

                                            $sql = "Select * from students_rec where Student_Number like '%$search%'
                                            or First_Name like '%$search%' or Last_Name like '%$search%'";
                                            $result = mysqli_query($con, $sql);
                                            if($result){
                                               if(mysqli_num_rows($result) > 0){
                                                    echo '<thead>
                                                    <tr>
                                                    <th>Student Number </th>
                                                    <th>COURSE & SECTION</th>
                                                    <th>LAST NAME</th>
                                                    <th>FIRST NAME</th>
                                                    <th>MIDDLE INITIAL</th>
                                                    <th>CONTACT NO.</th>
                                                    <th>AGE</th>
                                                    <th>GENDER</th>
                                                    <th>GUARDIAN</th>
                                                    <th>GUARDIAN CONTACT</th>
                                                    </tr>
                                                    </thead>
                                                    ';
                                                    while ($row = mysqli_fetch_assoc($result)){
                                                    echo '<tbody>
                                                    <tr>
                                                    <td><a href = "search-dashboard.php?data='.$row['Student_Number'].'">'.$row['Student_Number'].'</a></td>
                                                    <td>'.$row['Course_Section'].'</td>
                                                    <td>'.$row['Last_Name'].'</td>
                                                    <td>'.$row['First_Name'].'</td>
                                                    <td>'.$row['Middle_Initial'].'</td>
                                                    <td>'.$row['Contact_No'].'</td>
                                                    <td>'.$row['Age'].'</td>
                                                    <td>'.$row['Gender'].'</td>
                                                    <td>'.$row['Guardian'].'</td>
                                                    <td>'.$row['Guardian_No'].'</td>
                                                    </tr>
                                                    </tbody>
                                                    ';
                                                    }
                                               }else{
                                                echo '<h2 class = text-danger>Data Not Found</h2>';
                                               }
                                            }
                                        }
                                    ?>
                                </table>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <script src ="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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