<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $roll = trim($_POST["roll"]);
    $name = trim($_POST["name"]);
    $age = trim($_POST["age"]);
    $section = trim($_POST["section"]);
    $class = trim($_POST["class"]);
    $cgpa = trim($_POST["cgpa"]);
    $updates = [];
    if (!empty($name)) $updates[] = "name = '$name'";
    if (!empty($age)) $updates[] = "age = '$age'";
    if (!empty($section)) $updates[] = "section = '$section'";
    if (!empty($class)) $updates[] = "class = '$class'";
    if (!empty($cgpa)) $updates[] = "cgpa = '$cgpa'";
    if (count($updates) == 0) {
        echo "<h3>No fields updated</h3>";
    } else {
        $sql = "UPDATE table1 SET " . implode(", ", $updates) . " WHERE roll = '$roll'";
        if ($conn->query($sql) === TRUE) {
            echo "<h3>Record Updated Successfully</h3>";
        } else {
            echo "<h3>Error: " . $conn->error . "</h3>";
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["check"])) {
    $roll_number = trim($_POST["roll"]);
    $stmt = $conn->prepare("SELECT * FROM table1 WHERE roll = ?");
    $stmt->bind_param("s", $roll_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<h3>Invalid Roll Number</h3>";
    } else {
        $row = $result->fetch_assoc();
        ?>
        <html>
        <head>
            <style>
                body {
                    text-align: center;
                    font-family: Arial, sans-serif;
                    background-color: beige;
                }
                .container {
                    margin-top: 50px;
                    background: white;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
                    width: 50%;
                    margin: auto;
                    text-align: left;
                }
                h1 {
                    color: #007BFF;
                }
                input[type='text'] {
                    width: 80%;
                    padding: 10px;
                    margin: 8px 0;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                }
                button {
                    background-color: #28a745;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    cursor: pointer;
                    border-radius: 5px;
                    font-size: 16px;
                    transition: 0.3s;
                }
                button:hover {
                    background-color: #218838;
                    transform: scale(1.2);
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Update Student Data</h1>
                <form method='post'>
                    <input type='hidden' name='roll' value='<?php echo $roll_number; ?>'>
                    <label>Name:</label><br>
                    <input type='text' name='name' placeholder='Current: <?php echo $row['name']; ?>'><br>
                    <label>Age:</label><br>
                    <input type='text' name='age' placeholder='Current: <?php echo $row['age']; ?>'><br>
                    <label>Section:</label><br>
                    <input type='text' name='section' placeholder='Current: <?php echo $row['section']; ?>'><br>
                    <label>Class:</label><br>
                    <input type='text' name='class' placeholder='Current: <?php echo $row['class']; ?>'><br>
                    <label>CGPA:</label><br>
                    <input type='text' name='cgpa' placeholder='Current: <?php echo $row['cgpa']; ?>'><br>
                    <button type='submit' name='update'>Update</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    }
    $stmt->close();
} else { ?>
    <html>
    <head>
        <style>
            body {
                text-align: center;
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
            }
            .container {
                margin-top: 50px;
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
                width: 40%;
                margin: auto;
            }
            h1 {
                color: #007BFF;
            }
            input {
                width: 80%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
                text-align: left;
            }
            button {
                background-color: #007BFF;
                color: white;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                text-align: left;
                border-radius: 5px;
                font-size: 16px;
                transition: 0.3s;
            }
            button:hover {
                background-color: #0056b3;
                transform: scale(1.2);
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Enter Roll Number</h1>
            <form method='post'>
                <input type='text' name='roll' placeholder='Enter Roll Number' required><br>
                <button type='submit' name='check'>Fetch Record</button>
            </form>
        </div>
    </body>
    </html>
<?php }
$conn->close();
?>
