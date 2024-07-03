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
    <title>Dash Board</title>
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
                    <a href="#reviews" class="dash_link">Reviews</a>
                </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <a href="request.html" class="dash_link">Request a book</a>
                </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <a href="logout.php" class="dash_link">Log out</a>
                </div>
            </div>
        </div>

        <div id="user_details" class="user_details">
            <div id="user_img">
                <i class="fa-solid fa-user" style="font-size: 120px;"></i>
            </div>
            <div id="user_contact">
                <h2>
                    <?php echo $_SESSION["name"]?>
                </h2>
                <p>
                    roll:
                    <?php echo $_SESSION["roll"]; ?><br>
                    email:
                    <?php echo $_SESSION["roll"].$domain; ?><br>
                    contact no:
                    <?php echo $mobile?>
                </p>
            </div>
        </div>

        <div class="points">
            <h2>Your Points</h2>
            <div id="score">
                <div id="coin">
                    <h3>JD</h3>
                </div>
            </div>
            <!-- <h1><?php echo $points ?></h1> -->
        </div>

        <div id="how_to_earn_points" class="issue_bar">
            <h1>Notifications</h1>
            <h2>Yeha pe notifications hogne</h2>
        </div>

        <div class="activity">
                <div class="graphic">
              
                  <div class="row">
                    <div class="chart">
                      <span class="block" title="On time">
                         <span class="value">57%</span>
                      </span>
                      <span class="block" title="Delayed">
                         <span class="value">43%</span>
                      </span>
                    </div>
                  </div>
              
                </div>
              
                  <ul class="legend">
                    <li>On time</li>
                    <li>Delayed</li>
                  </ul>
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
                        <tr>
                            <th>Introduction to Algorithm</th>
                            <th>Thomas H. Comen, Chaleres E. Leiserson, Ronald L Rivest, Cliifford Stein</th>
                            <th>2024-06-30</th>
                            <th>2024-07-05</th>
                            <th>No</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <?php echo $html ?> -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>

</html>
