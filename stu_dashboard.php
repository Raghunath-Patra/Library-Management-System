<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        #$connection = new mysqli(server,username,password,database);
        $domain = "@iitdh.ac.in";
        $mobile = 10000000000;
        $points = 0;
        $query_1 = "select * from users where roll = '$_SESSION[roll]'";
        $query_run = mysqli_query($connection,$query_1);
        while ($row = mysqli_fetch_assoc($query_run)){
            $mobile = $row['mobile'];
            $points = $row['points'];
        }
        $query_2 = "select COUNT(*) from issues where roll = '$_SESSION[roll]'";
        $query_run = mysqli_query($connection,$query_2);
        while ($row = mysqli_fetch_assoc($query_run)){
            $records = $row["COUNT(*)"];
        } 
        $query_3 = "select title,author,issuedate,duedate,returned from issues,books where books.id = issues.bookid AND roll ='$_SESSION[roll]' ; ";
        $result = mysqli_query($connection,$query_3);
        $html = "";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $html .= "<tr>
                            <td>" . $row["title"] . "</td>
                            <td>" . $row["author"] . "</td>
                            <td>" . $row["issuedate"] . "</td>
                            <td>" . $row["duedate"] . "</td>
                            <td>" . ($row["returned"] ? 'Yes' : 'No') . "</td>
                          </tr>";
            }
        } else {
            $html .= "<tr><td colspan='5'>No records found</td></tr>";
        }
        $connection->close();
    }
    else {
        header("Location:logout.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <section class="dash">
        <div class="options">
            <h3>OverFlow</h3>
            <div id="nav_opts">
                <div>
                    <i class="fa-solid fa-user"></i>
                    <a href="#dashboard" class="dash_link">Dashboard</a>
                </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <a href="main_page.php" class="dash_link" target="_blank">Explore</a>
                </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <a href="change_password.php"class="dash_link">Change Password</a>
                </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <a href="request_book.php"class="dash_link">Request a Book</a>
                </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <a href="logout.php"class="dash_link">Log Out</a>
                </div>
            </div>
        </div>
        <div class="data">
            <div class="user_data">
                <div id="user_details">
                    <div id="user_img">
                        <i class="fa-solid fa-user" style="font-size: 120px;"></i>
                    </div>
                    <div id="user_contact">
                        <h2><?php echo $_SESSION["name"]?></h2>
                        <p>
                            roll:<?php echo $_SESSION["roll"]; ?>
                            <br>
                            email:<?php echo $_SESSION["roll"].$domain; ?>
                            <br>
                            contact no:<?php echo $mobile?>
                    </div>
                </div>

                <div class="points">
                    <h2>Your Points</h2>
                    <div id="score">
                        <div id="coin">
                            <h3>JD</h3>
                        </div>
                    </div>
                    <h1><?php echo $points ?></h1>
                </div>

                <div id="how_to_earn_points" >
                    <h2>How to earn more?</h2>
                    <ul style="list-style-type: square;">
                        <li>first item</li>
                        <li>second item</li>
                        <li>first item</li>
                        <li>second item</li>
                    </ul>
                    <br>
                    <h2>How to earn more?</h2>
                    <ul style="list-style-type: square;">
                        <li>first item</li>
                        <li>second item</li>
                        <li>first item</li>
                        <li>second item</li>
                    </ul>
                </div>
            </div>
        
            <div class="lib_record">
                <div id="any">
                <h2>YOUR RECORDS</h2>
                <hr>

                <div id="table-container"></div> 
                    <table id="booksTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Author</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Returned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $html ?>
                        </tbody>
                    </table>
                </div>
    </section>
</body>
</html>
