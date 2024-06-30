<?php
    session_start();
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
            <h1>Admin</h1>
            <form action="" method="POST">
                <div class="user_name">
                    <input type="text" id="username" name="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="user_password">
                    <input type="text" id="password" name="password" required>
                    <label for="password">Password</label>
                </div>
                <button type="submit" name= "login" onclick="getinfo()">Login</button>
            </form>
            <div id="error"></div>
            <script>
                function getinfo(){
                    <?php 
                    #$connection = new mysqli(server,username,password,database);
                    $query = "select * from users where roll = '$_POST[username]'";
                    $query_run = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        if($row['roll'] == $_POST['username']){
                            if($row['password'] == $_POST['password']){
                                $_SESSION['name'] =  $row['name'];
                                $_SESSION['roll'] =  $row['roll'];
                                $_SESSION['password'] =  $row['password'];
                                $_SESSION['loggedin'] = true;
                                $connection->close();
                                header("Location: stu_dashboard.php");
                            }
                        }
                    }
                                ?>
            }
            </script>
        </div>
    </section>
</body>

</html>