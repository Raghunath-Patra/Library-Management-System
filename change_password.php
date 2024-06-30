<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    } else {
        header("Location:logout.php");
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
            <h1>Change Password</h1>
            <form action="" method="POST">
                <div class="user_password">
                    <input type="password" id="oldpasswd" name="oldpasswd" required>
                    <label for="username">Old Password</label>
                </div>
                <div class="user_password">
                    <input type="password" id="passwd" name="passwd" required>
                    <label for="password">New Password</label>
                </div>
                <div class="user_password">
                    <input type="password" id="confpasswd" name="confpasswd" required>
                    <label for="password">Verify Password</label>
                </div>
                <button type="submit" name="submit" onclick="changepass()">submit</button>
            </form>
            <script>
                function changepass(){
                    <?php 
                    #$connection = new mysqli(server,username,password,database);
                    if ($_POST['oldpasswd'] == $_SESSION['password'] && $_POST['passwd'] == $_POST['confpasswd'])
                    {
                        $query = "UPDATE users SET password='$_POST[passwd]' WHERE roll = '$_SESSION[roll]'";
                        if ($connection->query($query) === TRUE) {
                            $_SESSION['password'] = $_POST['passwd'];
                            echo 'password updated';
                            header("Location:stu_dashboard.php");
                          }
                          else{
                            echo "failed";
                          }
                    }
                    $connection->close();
                                ?>
            }
            </script>
            <div class="forgot_pass">
                <a href="#">forgot password?</a>
            </div>
        </div>
    </section>
</body>

</html>