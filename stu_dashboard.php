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
    <div class="nav_logo">
        <div class="hamburger" id="stu_hamburger" onclick="toggleMenu()">
            <div class="bar1" id="stu_hamburger"></div>
            <div class="bar2" id="stu_hamburger"></div>
            <div class="bar3" id="stu_hamburger"></div>
        </div>
        <img src="logo.jpg" alt="Logo">
    </div>
    <div class="dash">
        <div class="options" id="toggle_option">
            <div class="toggle_option">
                <h2>OverFlow</h2>
                <div id="dash_opts">
                    <div>
                        <i class="fa-solid fa-house"></i>
                        <a href="main_page.php" class="dash_link">Explore</a>
                    </div>
                    <div>
                        <i class="fa-solid fa-clipboard"></i>
                        <a href="#your_record" class="dash_link">Your Record</a>
                    </div>
                    <div>
                        <i class="fa-solid fa-lock"></i>
                        <a href="change_password.php" class="dash_link">Change Password</a>
                    </div>
                    <div>
                        <i class="fa-solid fa-book"></i>
                        <a href="request.html" class="dash_link">Request a book</a>
                    </div>
                    <div>
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <a href="logout.php" class="dash_link">Log out</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="user_data">
            <div id="user_details">
                <div id="user_img">
                    <i class="fa-solid fa-user" id="user_img_icon"></i>
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
                <h1><?php echo $points ?></h1>
            </div>

            <div id="notice">
                <h2>Notifications</h2>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                    Dolorum sed quasi eaque, harum esse reprehenderit
                     voluptatibus, sunt animi nisi, omnis pos
                </p>
            </div>
        </div>
    </div>
    <div class="your_record" id="your_record">
        <h2>YOUR RECORDS</h2>
        <hr>
    </div>
    <div class="lib_record">
        <div class="records">
            <div id="table-container">
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
        </div>
    </div>
    <script>
        let toggle_option = document.getElementById("toggle_option"),
        toggle = document.getElementById("stu_hamburger");
        toggle_option.style.maxWidth = "0px";
    function toggleMenu(){
        toggle.classList.toggle("active");
        if(toggle_option.style.maxWidth === "0px"){
            toggle_option.style.maxWidth = "300px";
        }
        else{
            toggle_option.style.maxWidth = "0px";
        }
    } 
    document.onclick = function(e){
        let width = window.innerWidth;
        if(width < 600 && toggle_option.style.maxWidth !== "0px" && e.target.id !== "stu_hamburger"){
            toggle.classList.toggle("active");
            toggle_option.style.maxWidth = "0px";
        }
    }
    function handleResize(){
        let windowWidth = window.innerWidth;
        if(windowWidth > 600 && toggle_option.style.maxWidth === "0px"){
            toggle.classList.toggle("active");
            toggle_option.style.maxWidth = "300px"
        }
    }
    handleResize();
    window.addEventListener("resize",handleResize);
    
    </script>
</body>
</html>
