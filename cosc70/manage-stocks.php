
<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $user = ($_SESSION['user']);

$user = $_SESSION['user'];

include 'database/stock-con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Quantity = $_POST['Quantity'];
    $Generic_Name = $_POST['Generic_Name'];
    $Brand_Name = $_POST['Brand_Name'];
    $Mg = $_POST['Mg'];
    $Expiration_Date = $_POST['Expiration_Date'];
    $Date_Added = $_POST['Date_Added'];

    $sql = "INSERT INTO stocks (Quantity, Generic_Name, Brand_Name, Mg, Expiration_Date, Date_Added) VALUES ('$Quantity', '$Generic_Name', '$Brand_Name', '$Mg', '$Expiration_Date', '$Date_Added')";
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
        <Title>Stocks</Title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel = "stylesheet" type = "text/css" href ="css/dashboard.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
       />
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
            margin-left: 120px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
            font-weight: bold;
            font-family: Calibri;
            font-size: 14px;
            margin-top: 20px;
        }
        .form-container {
            max-width: 500px;
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
        .row {
    display: flex;
    margin-bottom: 10px;
}

.col {
    flex: 1;
    margin-right: 10px;
}

.col:last-child {
    margin-right: 0;
}

/* Adjust as needed */
.form-container input[type=text],
.form-container input[type=date] {
    width: calc(100% - 10px); /* Subtract padding from width */
}
    .update-btn, .delete-btn {
        background-color: #7d9970 !important;
        color: white;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        border-radius: 5px;
        margin-top: -20px;
    }
    .update-btn:hover, .delete-btn:hover {
        background-color: #a2b089 !important;
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
                    <a class="btn btn-primary btn-sm custom-button mb-3" href="#" role="button" onclick="openForm()">Add New Data</a>
                    <div class="stock-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Quantity</th>
                            <th>Generic Name</th>
                            <th>Brand Name</th>
                            <th>Mg</th>
                            <th>Expiration Date</th>
                            <th>Date Added</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Include database connection
                        include 'database/stock-con.php';

                        // Fetch data from the stocks table
                        $sql = "SELECT * FROM stocks";
                        $result = mysqli_query($con, $sql);

                        // Check if there are any rows returned
                        if(mysqli_num_rows($result) > 0) {
                            // Loop through each row and display data
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['Quantity'] . "</td>";
                                echo "<td>" . $row['Generic_Name'] . "</td>";
                                echo "<td>" . $row['Brand_Name'] . "</td>";
                                echo "<td>" . $row['Mg'] . "</td>";
                                echo "<td>" . $row['Expiration_Date'] . "</td>";
                                echo "<td>" . $row['Date_Added'] . "</td>";
                                echo '<td><button class="update-btn" onclick="openUpdateForm(' . $row['ID'] . ', \'' . $row['Quantity'] . '\', \'' . $row['Generic_Name'] . '\', \'' . $row['Brand_Name'] . '\', \'' . $row['Mg'] . '\', \'' . $row['Expiration_Date'] . '\', \'' . $row['Date_Added'] . '\')">Update</button></td>';
                                echo '<td><button class="delete-btn" onclick="deleteRow(' . $row['ID'] . ')">Delete</button></td>';
                                echo "</tr>";
                            }
                        } else {
                            // No data found in stocks table
                            echo "<tr><td colspan='7'>No data available</td></tr>";
                        }

                        // Close database connection
                        mysqli_close($con);
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="formPopup" class="form-popup">
    <form id="healthRecordForm" class="form-container">
        <h2>Add New Stock</h2>
        <div id="successMessage" style="display:none; color: green;"></div>
        <div id="errorMessage" style="display:none; color: red;"></div>

        <div class="row">
            <div class="col">
                <label for="Quantity"><b>Quantity</b></label>
                <input type="text" name="Quantity" required>
            </div>
            <div class="col">
                <label for="Mg"><b>Mg</b></label>
                <input type="text" name="Mg" required>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="Generic_Name"><b>Generic Name</b></label>
                <input type="text"  name="Generic_Name" required>
            </div>
            <div class="col">
                <label for="Brand_Name"><b>Brand Name</b></label>
                <input type="text"  name="Brand_Name" required>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="Expiration_Date"><b>Expiration Date</b></label>
                <input type="date" name="Expiration_Date" required>
            </div>
            <div class="col">
                <label for="Date_Added"><b>Date Added</b></label>
                <input type="date" name="Date_Added" required>
            </div>
        </div>

        <button type="submit" class="btn">Submit</button>
        <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
    </form>
</div>

<div id="updateFormPopup" class="form-popup">
        <form id="updateForm" class="form-container">
            <h2>Update Stock</h2>
            <input type="hidden" name="ID" id="updateID">
            <div class="row">
                <div class="col">
                    <label for="updateQuantity"><b>Quantity</b></label>
                    <input type="text" name="Quantity" id="updateQuantity" required>
                </div>
                <div class="col">
                    <label for="updateMg"><b>Mg</b></label>
                    <input type="text" name="Mg" id="updateMg" required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="updateGeneric_Name"><b>Generic Name</b></label>
                    <input type="text" name="Generic_Name" id="updateGeneric_Name" required>
                </div>
                <div class="col">
                    <label for="updateBrand_Name"><b>Brand Name</b></label>
                    <input type="text" name="Brand_Name" id="updateBrand_Name" required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="updateExpiration_Date"><b>Expiration Date</b></label>
                    <input type="date" name="Expiration_Date" id="updateExpiration_Date" required>
                </div>
                <div class="col">
                    <label for="updateDate_Added"><b>Date Added</b></label>
                    <input type="date" name="Date_Added" id="updateDate_Added" required>
                </div>
            </div>

            <button type="submit" class="btn">Submit</button>
            <button type="button" class="btn cancel" onclick="closeUpdateForm()">Close</button>
        </form>
    </div>

        <script src ="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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

            $('#updateForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'update-stock.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            location.reload(); // Reload the page to fetch and display the updated record
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while submitting the form.');
                    }
                });
            });
        });
        
    function openForm() {
        document.getElementById("formPopup").style.display = "block";
    }

    function closeForm() {
        document.getElementById("formPopup").style.display = "none";
    }
    function openUpdateForm(id, quantity, genericName, brandName, mg, expirationDate, dateAdded) {
            document.getElementById("updateID").value = id;
            document.getElementById("updateQuantity").value = quantity;
            document.getElementById("updateGeneric_Name").value = genericName;
            document.getElementById("updateBrand_Name").value = brandName;
            document.getElementById("updateMg").value = mg;
            document.getElementById("updateExpiration_Date").value = expirationDate;
            document.getElementById("updateDate_Added").value = dateAdded;
            document.getElementById("updateFormPopup").style.display = "block";
        }

        function closeUpdateForm() {
            document.getElementById("updateFormPopup").style.display = "none";
        }

        function deleteRow(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                $.ajax({
                    type: 'POST',
                    url: 'delete-stock.php',
                    data: { ID: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            location.reload(); // Reload the page to remove the deleted record from the table
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while trying to delete the record.');
                    }
                });
            }
        }

    </script>
    </body>
</html>