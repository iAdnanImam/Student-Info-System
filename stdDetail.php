<?php
$roll = $_REQUEST['roll'];
$con = mysqli_connect('localhost:3306', 'root', '', 'db1');
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
if (!empty($roll)) {
    $sql = "SELECT * FROM `table1` WHERE `roll` = '$roll';";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo "<div class='table-container'>";
        echo "<h1>Details for Roll No. : $roll</h1>";
        echo "<table class='details-table'>
                <tr><th>Roll No.</th><th>Name</th><th>Age</th><th>Section</th><th>Class</th><th>CGPA</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["roll"] . 
                 "</td><td>" . $row["name"] . 
                 "</td><td>" . $row["age"] . 
                 "</td><td>" . $row["section"] . 
                 "</td><td>" . $row["class"] . 
                 "</td><td>" . $row["cgpa"] . "</td></tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<h3>No details found for the entered roll number.</h3>";
    }
} else {
    echo "<h3>Please enter a valid roll number.</h3>";
}

$con->close();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: beige;
        margin: 0;
        padding: 0;
    }

    .table-container {
        width: 80%;
        margin: 50px auto;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
    }

    table.details-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 16px;
    }

    table.details-table th, table.details-table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
    }

    table.details-table th {
        background-color: #4CAF50;
        color: white;
        text-align: center;
    }

    table.details-table td {
        text-align: center;
        color: #555;
    }

    table.details-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table.details-table tr:hover {
        background-color: #ddd;
    }

    h3 {
        text-align: center;
        color: #d9534f;
    }
</style>
