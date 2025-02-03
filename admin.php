<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "db1");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = trim($_REQUEST['username']);
    $pass = trim($_REQUEST['password']);
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();
        if (password_verify($pass, $stored_password) || $pass === $stored_password) {
            $_SESSION['admin'] = $name;
            echo "<html>
                    <head>
                        <style>
                            body {
                                text-align: center;
                                font-family: Arial, sans-serif;
                                background-color: #f5f5f5;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                margin-top: 50px;
                                background: white;
                                padding: 30px;
                                border-radius: 10px;
                                box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
                                display: inline-block;
                                width: 50%;
                            }
                            h1 {
                                color: green;
                                font-size: 28px;
                            }
                            h3 {
                                color: #333;
                            }
                            .btn-container {
                                margin-top: 20px;
                                display: flex;
                                justify-content: center;
                                gap: 15px;
                            }
                            button {
                                background-color: #007BFF;
                                color: white;
                                border: none;
                                padding: 12px 25px;
                                cursor: pointer;
                                border-radius: 8px;
                                font-size: 18px;
                                transition: all 0.3s ease;
                                box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2);
                            }
                            button:hover {
                                background-color: #0056b3;
                                transform: scale(1.1);
                            }
                            table {
                                margin: 20px auto;
                                border-collapse: collapse;
                                width: 80%;
                                background: white;
                                border-radius: 8px;
                                overflow: hidden;
                                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                            }
                            th, td {
                                padding: 12px;
                                border: 1px solid #ddd;
                                text-align: center;
                            }
                            th {
                                background-color: #007BFF;
                                color: white;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <h1>Login Successful</h1>
                            <h3>Welcome to the Admin Page</h3>
                            <table>
                                <tr>
                                    <th>Feature</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td>Add New Student Details</td>
                                    <td><form method='get'><button formaction='add.php'>ADD</button></form></td>
                                </tr>
                                <tr>
                                    <td>Delete from Records</td>
                                    <td><form method='get'><button formaction='delete.php'>DELETE</button></form></td>
                                </tr>
                                <tr>
                                    <td>Update Details for a Student</td>
                                    <td><form method='get'><button formaction='update.php'>UPDATE</button></form></td>
                                </tr>
                            </table>
                        </div>
                    </body>
                  </html>";
        } else {
            echo "<h3>Invalid Password</h3>";
        }
    } else {
        echo "<h3>Not an Admin</h3>";
    }
    $stmt->close();
    $conn->close();
?>
