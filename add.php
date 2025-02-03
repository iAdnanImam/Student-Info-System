<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "<div class='form-container'>";
    echo "<h2 class='form-title'>Add New Entry</h2>";
    echo "<form method='post' action=''>
            <label for='roll'>Roll No. :</label>
            <input type='text' id='roll' name='roll' required><br><br>
            <label for='name'>Name:</label>
            <input type='text' id='name' name='name' required><br><br>
            <label for='age'>Age:</label>
            <input type='text' id='age' name='age' required><br><br>
            <label for='section'>Section:</label>
            <input type='text' id='section' name='section' required><br><br>
            <label for='class'>Class:</label>
            <input type='text' id='class' name='class' required><br><br>
            <label for='cgpa'>CGPA:</label>
            <input type='text' id='cgpa' name='cgpa' required><br><br>
            <button type='submit' class='submit-button'>Submit</button>
          </form>";
    echo "</div>";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $con = mysqli_connect('localhost', 'root', '', 'db1');
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $roll = $_POST['roll'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $section = $_POST['section'];
    $class = $_POST['class'];
    $cgpa = $_POST['cgpa'];
    $sql = "INSERT INTO table1 (roll, name, age, section, class, cgpa) 
            VALUES ('$roll', '$name', '$age', '$section', '$class', '$cgpa')";
    if (mysqli_query($con, $sql)) {
        echo "<div class='form-container'>";
        echo "<h3>Record Inserted Successfully</h3>";
        echo "<form method='get'>
                <button formaction='add.php' class='action-button'>ADD MORE</button>
                <button formaction='admin.html' class='action-button'>MENU</button>
              </form>";
        echo "</div>";
    } else {
        echo "<h3>Error: " . $sql . "<br>" . mysqli_error($con) . "</h3>";
    }
    mysqli_close($con);
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: beige;
    }

    .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        width: 320px;
        text-align: center;
        border: 2px solid black;
        transform: scale(0.8);
    }

    .form-title {
        font-size: 24px;
        font-weight: bold;
        color: black;
        margin-bottom: 20px;
    }

    label {
        font-size: 14px;
        font-weight: bold;
        color: #555;
        display: block;
        margin-bottom: 5px;
        text-align: left;
    }

    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin: 6px 0 15px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button.submit-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 15px;
    }

    button.submit-button:hover {
        background-color: #45a049;
        transition: ease 0.5s;
        transform: scale(1.2);
    }

    button.action-button {
        background-color:#0056b3;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        margin-top: 10px;
    }

    button.action-button:hover {
        background-color: #0056b3;
    }

    h3 {
        color: #333;
        text-align: center;
    }
</style>
