<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}
$user = $_SESSION['user'];

include 'database/search-con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentNumber = $_POST['studentNumber'];
    $concern = $_POST['concern'];
    $temperature = $_POST['temperature'];
    $weight = $_POST['weight'];
    $prescription = $_POST['prescription'];
    $admissionDate = $_POST['admissionDate'];

    $sql = "INSERT INTO health_rec (Student_Number, Concern, temperature, weight, prescription, Admission_Date) VALUES ('$studentNumber', '$concern', '$temperature', '$weight', '$prescription', '$admissionDate')";
    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Record added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($con)]);
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .form-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 3px solid #ffd770;
            z-index: 9;
            background-color: #f9f9f7;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
            font-weight: bold;
            font-family: Calibri;
            font-size: 14px;
        }
        .form-container {
            max-width: 300px;
            padding: 10px;
            background-color: #f9f9f7;
            border-radius: 10px;
        }
        .form-container input[type=text], .form-container input[type=date] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px 0;
            background: #f1f1f1;
            border-radius: 10px;
            border: 2px solid #ffd770;
            text-align: center;
            font-weight: bold;
            font-family: Calibri;
            font-size: 14px;
        }
        .form-container .btn {
            background-color: #7d9970;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
            opacity: 0.8;
            font-weight: bold;
            font-family: Calibri;
            font-size: 14px;
        }
        .form-container .cancel {
            background-color: #7d9970;
        }
        .form-container .btn:hover, .open-button:hover {
            background-color: #a2b089;
        }
        .btn-delete {
        background-color: #7d9970;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;

    }

    .btn-delete:hover {
        background-color: #a2b089;
    }
    </style>
</head>
<body id="DashboardBody">
    <div class="DashboardMainContainer">
        <div class="dashboard_sidebar">
            <h3 class="dashboard_logo">INFIRMARY SYSTEM</h3>
            <div class="dashboard_sidebar_user">
                <i class="fa-solid fa-user-nurse" style="color: #ffffff;"></i>
                <span><?= htmlspecialchars($user['Last_Name']) ?></span>
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
                    <?php
                    $data = $_GET['data'];
                    $sql = "SELECT * FROM students_rec WHERE Student_Number = $data";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        echo '<div class="searchresultcontainer">
                            <div class="jumbotron" style="font-family: Calibri, sans-serif; padding: 20px;">
                                <h2 style="font-weight: bold; margin-bottom: 10px;">' . htmlspecialchars($row['Last_Name']) . '</h2>
                                <hr style="margin: 10px 0;">
                                <p style="font-weight: bold; margin-bottom: 10px;">Student Number: ' . htmlspecialchars($row['Student_Number']) . '</p>
                                <div class="lead text-right" style="margin-bottom: 10px;">
                                    <a class="btn btn-primary btn-sm custom-button" href="#" role="button" onclick="openForm()">Add New Data</a>
                                    <a class="btn btn-primary btn-sm custom-button" href="search.php" role="button">Go Back</a>
                                </div>
                            </div>
                        </div>';

                        // Fetch and display health records for the student
                        $healthSql = "SELECT * FROM health_rec WHERE Student_Number = $data";
                        $healthResult = mysqli_query($con, $healthSql);
                        if (mysqli_num_rows($healthResult) > 0) {
                            echo '<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Concern</th>
                                        <th>Temperature</th>
                                        <th>Weight</th>
                                        <th>Prescription</th>
                                        <th>Date of Admission</th>
                                    </tr>
                                </thead>
                                <tbody>';
                            while ($healthRow = mysqli_fetch_assoc($healthResult)) {
                                echo '<tr>
                                    <td>' . htmlspecialchars($healthRow['Concern']) . '</td>
                                    <td>' . htmlspecialchars($healthRow['temperature']) . '</td>
                                    <td>' . htmlspecialchars($healthRow['weight']) . '</td>
                                    <td>' . htmlspecialchars($healthRow['prescription']) . '</td>
                                    <td>' . htmlspecialchars($healthRow['Admission_Date']) . '</td>
                                    <td><button class="btn-delete" data-id="' . htmlspecialchars($healthRow['ID']) . '">Delete</button></td>

                                </tr>';
                            }
                            echo '</tbody></table>';
                        } else {
                            echo '<p>No health records found for this student.</p>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div id="formPopup" class="form-popup">
        <form id="healthRecordForm" class="form-container">
            <h2>Add New Data</h2>
            <input type="hidden" name="studentNumber" value="<?= htmlspecialchars($data) ?>">

            <label for="concern"><b>Concern</b></label>
            <input type="text" placeholder="Enter Concern" name="concern" required>

            <label for="temperature"><b>Temperature</b></label>
            <input type="text" placeholder="Enter Temperature" name="temperature" required>

            <label for="weight"><b>Weight</b></label>
            <input type="text" placeholder="Enter Weight" name="weight" required>

            <label for="prescription"><b>Prescription</b></label>
            <input type="text" placeholder="Enter Prescription" name="prescription" required>

            <label for="admissionDate"><b>Date of Admission</b></label>
            <input type="date" name="admissionDate" required>

            <button type="submit" class="btn">Submit</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('.sub-btn').click(function(){
            $(this).toggleClass('active');
            $(this).next('.sub-menu').slideToggle();
        });

        $('#healthRecordForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        location.reload(); // Reload the page to fetch and display the new record
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while submitting the form.');
                }
            });
        });

        $('.btn-delete').click(function() {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this record?")) {
            $.ajax({
                type: 'POST',
                url: 'delete-health-record.php',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        location.reload(); // Reload the page to update the table
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting the record.');
                }
            });
        }
    });
});


    function openForm() {
        document.getElementById("formPopup").style.display = "block";
    }

    function closeForm() {
        document.getElementById("formPopup").style.display = "none";
    }
    </script>
</body>
</html>
