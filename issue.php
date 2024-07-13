<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['book_id'])) {
        $_SESSION['date'] = date("Y-m-d");
        $_SESSION['due'] = date("Y-m-d");
        $due_timestamp = strtotime($_SESSION['due']);
        $new_due_timestamp = strtotime("+30 days", $due_timestamp);
        $_SESSION['due'] = date("Y-m-d", $new_due_timestamp);
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
        $query_run = mysqli_query($connection,$query_3);
        while($row = mysqli_fetch_assoc($query_run)){
            $likes = $row["COUNT(*)"];
        }
        $query_4 = "select * from users WHERE roll = '$_SESSION[roll]'";
        $query_run = mysqli_query($connection,$query_4);
        while ($row = mysqli_fetch_assoc($query_run)){
            $_SESSION["points"] = $row['points'];
        }
        
    }
    else{
        header("Location:logout.php");
    }   
        function userLiked(){
            $query_6 = "select * from likes WHERE bookid = '$_SESSION[book_id]' AND roll = '$_SESSION[roll]'";
            global $connection;
            $query_run = mysqli_query($connection,$query_6);
            if(mysqli_num_rows($query_run) > 0){
                    return true;
            }
            else{
                return false;
            }
        }
    if(isset($_POST['action'])){
        header('Content-Type: application/json');
        $bookid = $_POST['book_id'];
        $action = $_POST['action'];
        $t = time();
        $t1 = date("Y-m-d",$t);
        if($action == "like"){
            $query_9 = "INSERT INTO likes (bookid, roll, timestamp) VALUES ('$_SESSION[book_id]', '$_SESSION[roll]', '$t1')";
            echo "like";
        }
        else if($action == "unlike"){
            echo "unlike";
            $query_9 = "DELETE FROM likes WHERE bookid = '$bookid' AND roll = '$_SESSION[roll]'";
        }
        global $connection;
        mysqli_query($connection,$query_9);
        echo getRating($bookid);
        echo json_encode(getRating($bookid));
        exit(0);
    }
        function getRating($id){
            global $connection;
            $rating = array();
            $likes_q = "select COUNT(*) from likes WHERE bookid = '$_SESSION[book_id]'";
            $likes_res = mysqli_query($connection,$likes_q);
            $likes = mysqli_fetch_array($likes_res);
            $rating = ['likes' => $likes[0]];
            return json_encode($rating);
        }
        function updateDueDate($increment) {
            if (isset($_SESSION['due']) && strtotime($_SESSION['due'])) {
                $due_timestamp = strtotime($_SESSION['due']);
                $new_due_timestamp = strtotime("+$increment days", $due_timestamp);
                $_SESSION['due'] = date("Y-m-d", $new_due_timestamp);
                return true;
            }
            return false;
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['increment'])) {
            $increment = intval($_POST['increment']);
            $_SESSION['increment'] = $increment;
            if($_SESSION["points"] < $increment){
                echo $_SESSION['due'];
                $extend_msg = "\nInsufficient points!";
                echo $extend_msg;
            }
            else if (updateDueDate($increment)) {
                echo $_SESSION['due'];
                $extend_msg = "\nExtended by $increment days";
                echo $extend_msg;
            } else {
                $extend_msg = "Error: Unable to update due date.";
                echo $extend_msg;
            }
            exit;
        }
        if (!empty($_POST['comment'])) {
            #$connection = new mysqli(server,username,password,database);
            $comment = $_POST['comment'];
            $t = time();
            $t1 = date("Y-m-d", $t);
            $query5 = "insert into reviews values('$_SESSION[book_id]','$_SESSION[roll]','$comment','$t1')";
            mysqli_query($connection, $query5);
            header("Location: issue.php");
            exit;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <a href="javascript:history.back()" style="text-decoration: none; color:black; margin: 10px;">Go Back</a>
    <div id="book_container">
            <div class="likes">
                <i <?php if(userLiked()) : ?>
                        class="fa-regular fa-heart like_icon"
                    <?php else: ?>
                        class="fa-solid fa-lock like_icon"
                    <?php endif ?>
                        data-id="<?php echo $_SESSION['book_id']?>"></i>
                <h3 id = "like_count"><?php echo $likes ?></h3>
            </div>
            <img id="book_img" class="img_n_likes" src="https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png" alt="Book">
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
            <b>
                You have <?php echo $_SESSION["points"] ?> points
                <div>Extend Due date by:</div>
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
        <div class="review_section">
            <h1><?php echo $reviews ?> Total Reviews</h1>
            <div class="review_box">
                    <?php
                        $query = "select * from reviews ORDER BY timestamp DESC";
                        $query_run = mysqli_query($connection,$query);
                        while ($row = mysqli_fetch_assoc($query_run))
                        {
                            if ($row["bookid"] == $_SESSION["book_id"])
                            {
                                echo "<div id=\"review\">
                                    <b id=\"reviewer\">
                                        $row[roll]
                                    </b>
                                    <div id=\"review_comment\">
                                        $row[review]
                                    </div>
                                </div>";
                            } 
                        }
                    ?>    
            </div>
            <div class="add_review">
                <form name='form' method='post' action="issue.php">
                <textarea name="comment" id="comment" placeholder="Enter your input here..."></textarea>
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
        let likes = document.getElementById("like_count").innerHTML;
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
            const increment = parseInt(num.innerText);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "issue.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
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
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.status === "success") {
                                    alert("Book issued successfully!");
                                    window.location.href = "stu_dashboard.php";
                                } else {
                                    alert("Error: " + response.message);
                                }
                            } catch (e) {
                                console.error("Error parsing JSON response: ", e);
                                alert("Unexpected error occurred.");
                            }
                        } else {
                            console.error("XHR request failed with status: ", xhr.status);
                            alert("Error issuing book.");
                        }
                    }
                };
                xhr.send();
            });
        });


        $(document).ready (function(){
            $('.like_icon').on('click',function(){
                var book_id = $(this).data('id');
                $clicked_btn = $(this);
                if($clicked_btn.hasClass('fa-solid fa-lock')){
                    action = 'like';
                    $clicked_btn.removeClass('fa-solid fa-lock');
                    $clicked_btn.addClass('fa-regular fa-heart');
                    likes = (parseInt(likes)+1).toString();
                    document.getElementById("like_count").innerHTML = likes;
                }
                else if($clicked_btn.hasClass('fa-regular fa-heart')){
                    action = 'unlike';
                    $clicked_btn.removeClass('fa-regular fa-heart');
                    $clicked_btn.addClass('fa-solid fa-lock');
                    likes = (parseInt(likes)-1).toString();
                    document.getElementById("like_count").innerHTML = likes;
                }
                $.ajax({
                    url: 'issue.php',
                    type: 'post',
                    data: {
                        'action': action,
                        'book_id': book_id
                    },
                    success: function(data){
                        res = JSON.parse(data);
                        if(action == "like"){
                            $clicked_btn.removeClass('fa-solid fa-lock');
                            $clicked_btn.addClass('fa-regular fa-heart');
                        }
                        else if(action == "unlike"){
                            $clicked_btn.removeClass('fa-regular fa-heart');
                            $clicked_btn.addClass('fa-solid fa-lock');
                        }
                    }
                });
            });
        });
    </script>

</body>
</html>
