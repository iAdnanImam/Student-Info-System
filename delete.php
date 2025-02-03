<?php
$conn = new mysqli('localhost', 'root', '', 'db1');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_number = $_POST['roll_number'];
    $check_sql = "SELECT * FROM table1 WHERE roll = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $roll_number);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $delete_sql = "DELETE FROM table1 WHERE roll = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $roll_number);
        if ($stmt->execute()) {
            $message = "<p class='success'>Roll number $roll_number deleted successfully.</p>";
        } else {
            $message = "<p class='error'>Error deleting record: " . $conn->error . "</p>";
        }
    } else {
        $message = "<p class='error'>Invalid roll number.</p>";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Roll Number</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: beige;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        label {
            font-size: 18px;
        }
        input {
            padding: 8px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
            transform: scale(1.5);
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .message {
            margin-top: 15px;
        }
    </style>
    <script>
        function clearInput() {
            document.getElementsByName("roll_number")[0].value = "";
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Delete Roll Number</h1>
        <form method="POST" action="">
            <label for="roll">Enter Roll Number to Delete:</label>
            <input type="number" name="roll_number" required>
            <br>
            <button type="submit">Delete</button>
        </form>
    </div>
    <div class="message">
        <?php echo $message; ?>
    </div>
</body>
</html>
