<?php
    // Database connection
    $con = mysqli_connect('localhost', 'root', '', 'inventory');
    if (!$con){
        die(mysqli_error($con));
    }
    
    // Check if Admission_Date parameter is set in the POST request
    if(isset($_POST['Admission_Date']) && !empty($_POST['Admission_Date'])) {
        // Admission date is provided, perform search based on the provided date
        $admissionDate = $_POST['Admission_Date'];
        
        // Fetch data based on the provided admission date
        $query = "SELECT `Student_Number`, `Concern`, `Temperature`, `Weight`, `Prescription`, `Admission_Date` FROM `health_rec` WHERE `Admission_Date` = '$admissionDate'";
    } else {
        // No admission date provided, fetch all records from the table
        $query = "SELECT `Student_Number`, `Concern`, `Temperature`, `Weight`, `Prescription`, `Admission_Date` FROM `health_rec`";
    }

    $result = mysqli_query($con, $query);

    // Check if there are any records returned
    if(mysqli_num_rows($result) > 0) {
        // Display the records in HTML table format
        echo "<table class='table table-bordered'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Student Number</th>";
        echo "<th>Concern</th>";
        echo "<th>Temperature</th>";
        echo "<th>Weight</th>";
        echo "<th>Prescription</th>";
        echo "<th>Admission Date</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while($row = mysqli_fetch_assoc($result)) {
            // Output the data in table rows
            echo "<tr>";
            echo "<td>".$row['Student_Number']."</td>";
            echo "<td>".$row['Concern']."</td>";
            echo "<td>".$row['Temperature']."</td>";
            echo "<td>".$row['Weight']."</td>";
            echo "<td>".$row['Prescription']."</td>";
            echo "<td>".$row['Admission_Date']."</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        // No records found
        echo "<p>No data found for the selected Admission Date.</p>";
    }

    // Close the database connection
    mysqli_close($con);
?>
