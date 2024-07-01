    <?php
    session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $_SESSION['book_id'] = 50;
        $connection = new mysqli("localhost","root","Ranethegr8#123","SOI");
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
            <b id="issue_date">Issue: 12/12/2012</b>
            <b id="due_date">Due: 12/01/2013</b>
            <br>
            <b>Extend Due Date by
                <div>
                    <div class="wrapper">
                        <span class="minus">-</span>
                        <span class="num">00</span>
                        <span class="plus">+</span>

                    </div>
                    <button id="extend_date_by">Go</button>
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
        let plus = document.querySelector(".plus"),
        minus = document.querySelector(".minus"),
        num = document.querySelector(".num");
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

        let book_issue = document.querySelector("#issue_book");
        book_issue.addEventListener("click",()=>{
            let date_issue = document.querySelector("#issue_date"),
                date_due = document.querySelector("#due_date");
            let date1 = date_issue.innerText,
                date2 = date_due.innerText;
            let msg = date1 + "\n" + date2 +"\nAre you Sure ?";
            confirm(msg);
        });
    </script>
</body>
</html>