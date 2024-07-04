<?php
    session_start();
        // Function to update due date in session
        function updateDueDate($increment) {
            if (isset($_SESSION['due']) && strtotime($_SESSION['due'])) {
                $due_timestamp = strtotime($_SESSION['due']);
                $new_due_timestamp = strtotime("+$increment days", $due_timestamp);
                $_SESSION['due'] = date("Y-m-d", $new_due_timestamp);
                return true;
            }
            return false;
        }
    
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['increment'])) {
            $increment = intval($_POST['increment']);
            if (updateDueDate($increment)) {
                echo $_SESSION['due'];
            } else {
                echo "Error: Unable to update due date.";
            }
            exit; // Exit to prevent further HTML rendering
        }
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['book_id'])) {
        $_SESSION['date'] = date("Y-m-d");
        $_SESSION['due'] = date("Y-m-d");
        #$connection = new mysqli(server,username,password,database);
        $query_1 = "select * from books where id = '$_SESSION[book_id]'";
        $query_run = mysqli_query($connection,$query_1);
        while ($row = mysqli_fetch_assoc($query_run)){
            $title = $row['title'];
            $author = $row['author'];
            $description = $row['description'];
            $genre = $row['genre'];
            $department = $row['department'];
            $vendor = $row['vendor'];
            $publisher = $row['publisher'];
        }
        $query_2 = "select COUNT(*) from reviews WHERE bookid = '$_SESSION[book_id]'";
        $query_run = mysqli_query($connection,$query_2);
        while($row = mysqli_fetch_assoc($query_run)){
            $reviews = $row["COUNT(*)"];
        }
        $query_3 = "select COUNT(*) from likes WHERE bookid = '$_SESSION[book_id]'";
        $query_run = mysqli_query($connection,$query_2);
        while($row = mysqli_fetch_assoc($query_run)){
            $likes = $row["COUNT(*)"];
        }
    }
    else{
        header("Location:logout.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <a href="javascript:history.back()" style="text-decoration: none; color:black; margin: 10px;">Go Back</a>
    <div id="book_container">
            <div class="likes">
                <i class="fa-regular fa-heart"><?php echo $likes ?></i>
            </div>
            <img id="book_img_1" class="img_n_likes" src="https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png" alt="Book">
    </div>
    <section class="book_details">
        <div class="description_of_book">
                <h1 id="title"><?php echo $title ?></h1>
                <br>
                <h3 id="author">by: <?php echo $author ?>, <?php echo $description ?></h3>
                <br>
                <h4 id="department"><?php echo $department ?></h4>
                <br>
                <h4 id="description"><?php echo $description ?></h4>
                <br>
                <p id="publisher">Published by: <?php echo $publisher ?></p>
                <p id="vendor">Vendor: <?php echo $vendor ?></p>
        </div>
        <hr>
        <div class="dates">
            <b id="issue_date">Issue: <?php echo $_SESSION['date'] ?></b>
            <b id="due_date">Due: <?php echo $_SESSION['due'] ?></b>
            <br>
            <b>Extend Due Date by
                <div>
                    <div class="wrapper">
                        <span class="minus">-</span>
                        <span class="num">00</span>
                        <span class="plus">+</span>
                    </div>
                    <button id="extend_date_by" onclick="changeDue()">Go</button>
                </div>
            </b>
        </div>
        <div class="order">
            <div id="issue_book">
                <h3>Issue Book</h3>
            </div>
            <div id="add_to_cart">
                <i class="fa-regular fa-heart"></i>
                <h3>Add to Cart</h3>
            </div>
        </div>
        <?php 
            
            if ( ! empty($_POST['comment'])){
                $comment = $_POST['comment'];
                $t = time();
                $t1 = date("Y-m-d",$t);
                $query5 = "insert into reviews values('$_SESSION[book_id]','$_SESSION[roll]','$comment','$t1')";
                mysqli_query($connection,$query5);
            }
            
        ?>
        <div class="review_section">
            <h1><?php echo $reviews ?> Total Reviews</h1>
            <div class="review_box">
                <div id="review">
                    <b id="reviewer">
                    <?php
                        $query = "select * from reviews";
                        $query_run = mysqli_query($connection,$query);
                        while ($row = mysqli_fetch_assoc($query_run))
                        {
                            if ($row["bookid"] == $_SESSION["book_id"])
                            {
                                echo $row["roll"];
                                echo "<br>";
                            } 
                        }
                    ?>    
                    </b>
                    <p id="review_comment">
                    <?php
                        $query = "select * from reviews";
                        $query_run = mysqli_query($connection,$query);
                        while ($row = mysqli_fetch_assoc($query_run))
                        {
                            if ($row["bookid"] == $_SESSION["book_id"])
                            {
                                echo $row["review"];
                                echo "<br>";
                            } 
                        }
                    ?>
                    </p>
                </div>

            </div>
            <div class="add_review">
                <!-- <textarea name="comment" id="user_review" placeholder="Enter your input here..."></textarea>
                <button type="submit">
                    post >
                </button> -->
                <form name='form' method='post' action="issue.php">

                Comment: <input type="text" name="comment" id="comment" placeholder="Enter your input here ..." ><br/>

                <input type="submit" name="submit" value="Submit">  
                
                </form>
            </div>
        </div>
    </section>
    <script>
        const d = new Date();
        let plus = document.querySelector(".plus"),
        minus = document.querySelector(".minus"),
        num = document.querySelector(".num");
        let due = document.getElementById("due_date");
        let a = 0;
        plus.addEventListener("click",()=>{
            a++;
            a = (a<10) ? "0"+a : a;
            num.innerText = a;
        });
        minus.addEventListener("click",()=>{
            if(a>0){
                a--;
                a = (a<10 && a>=0) ? "0"+a : a;
                num.innerText = a;
            }
        });
        function changeDue() {
            console.log("clicked");
        }
        function changeDue() {
            const increment = parseInt(num.innerText);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "issue.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Update due date in the UI only after successful response
                        due.innerText = "Due: " + xhr.responseText;
                        console.log("Due date updated successfully");
                    } else {
                        console.error("Error: Unable to update due date");
                    }
                }
            };
            xhr.send("increment=" + increment);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const issueBookDiv = document.getElementById("issue_book");

            issueBookDiv.addEventListener("click", function() {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "handle_issue.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            console.log("Book issued successfully");
                            window.location.href = "stu_dashboard.php";
                            // Optionally, update UI or show a success message
                        } else {
                            console.error("Error issuing book");
                        }
                    }
                };
                xhr.send(); // Send the AJAX request
            });
        });
    </script>

</body>
</html>
