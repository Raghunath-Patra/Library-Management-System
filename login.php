<?php
    session_start();

    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $connection = new mysqli("localhost", "root", "", "SOI");

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        $query = "SELECT * FROM users WHERE roll = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {
            echo '<script type="text/javascript">
                    document.addEventListener("DOMContentLoaded", function() {
                        let wrong_msg = document.getElementById("wrong_entry");
                        wrong_msg.innerHTML = "user not available";
                        wrong_msg.style.padding = "5px";
                    });
                  </script>';
        } else {
            $row = $result->fetch_assoc();
            if ($row['password'] == $password) {
                $_SESSION['name'] = $row['name'];
                $_SESSION['roll'] = $row['roll'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['loggedin'] = true;
                header("Location: stu_dashboard.php");
                exit;
            } else {
                echo '<script type="text/javascript">
                    document.addEventListener("DOMContentLoaded", function() {
                        let wrong_msg = document.getElementById("wrong_entry");
                        wrong_msg.innerHTML = "wrong password";
                        wrong_msg.style.padding = "5px";
                    });
                      </script>';
            }
        }

        $stmt->close();
        $connection->close();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="login_page">
        <div class="logo">
            <img src="https://www.bing.com/images/blob?bcid=RD..1RMpsCoHK-aIhSrEz4JCSVqs.....2A" alt="none">
        </div>
        <div class="login-container">
            <h1>Login</h1>
            <div class="wrong_entry" id="wrong_entry">
                
            </div>
            <form action="" method="POST">
                <div class="user_name">
                    <input type="text" id="username" name="username" required>
                    <label for="username">Enter your roll no</label>
                </div>
                <div class="user_password">
                    <input type="text" id="password" name="password" required>
                    <label for="password">Password</label>
                </div>
                <button type="submit" name= "login" onclick="getinfo()">Login</button>
            </form>
        </div>
    </section>

</body>
</html>
