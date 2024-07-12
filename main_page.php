<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        #$connection = new mysqli(server,username,password,database);
        $query_1 = "SELECT b.department,  COUNT(*) as issue_count FROM issues i JOIN books b ON i.bookid = b.id GROUP BY b.department ORDER BY issue_count DESC LIMIT 3;";
        $result_1 = mysqli_query($connection,$query_1);
        $iter = 0;
        if ($result_1->num_rows > 0) {
            $query_2 = "SELECT 
                            b.id, 
                            b.title, 
                            b.author, 
                            b.department, 
                            COALESCE(l.like_count, 0) AS like_count, 
                            COALESCE(r.review_count, 0) AS review_count
                        FROM 
                            books b
                        LEFT JOIN 
                            (SELECT bookid, COUNT(*) AS like_count FROM likes GROUP BY bookid) l 
                            ON b.id = l.bookid
                        LEFT JOIN 
                            (SELECT bookid, COUNT(*) AS review_count FROM reviews GROUP BY bookid) r 
                            ON b.id = r.bookid
                        LEFT JOIN 
                            (SELECT DISTINCT bookid FROM issues WHERE roll = 'CS23BT042') i 
                            ON b.id = i.bookid
                        WHERE 
                            i.bookid IS NULL
                        AND b.department IN ('";
            while($row = $result_1->fetch_assoc()) {
                if($iter == 0){
                    $query_2 .= $row["department"]."'";
                    $iter = 1;
                }
                else{
                    $query_2 .= ",'".$row["department"]."'";
                }
            }
            $query_2 .= ")"."ORDER BY 
                                like_count DESC 
                            LIMIT 6;";
        } else {
            $query_2 = "SELECT 
                            b.id, 
                            b.title, 
                            b.author, 
                            b.department, 
                            COALESCE(l.like_count, 0) AS like_count, 
                            COALESCE(r.review_count, 0) AS review_count
                        FROM 
                            books b
                        LEFT JOIN 
                            (SELECT bookid, COUNT(*) AS like_count FROM likes GROUP BY bookid) l 
                            ON b.id = l.bookid
                        LEFT JOIN 
                            (SELECT bookid, COUNT(*) AS review_count FROM reviews GROUP BY bookid) r 
                            ON b.id = r.bookid
                        LEFT JOIN 
                            (SELECT DISTINCT bookid FROM issues WHERE roll = 'CS23BT042') i 
                            ON b.id = i.bookid
                        WHERE 
                            i.bookid IS NULL
                        ORDER BY 
                            like_count DESC 
                        LIMIT 6
                        ";
        }
        $result_2 = mysqli_query($connection,$query_2);
        $html = [];
        while($row = $result_2->fetch_assoc())
        {
            $html[$iter] = "<div id=\"book".$iter."\" class=\"books\" onclick=\"redirectToIssue('".$row['id']."')\">
                                <img id=\"book_img\" class=\"book_img\"
                                src=\"https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png\" alt=\"Book\">
                                <div class=\"book_description\">
                                    <h2>".$row["title"]."</h2>
                                    <h3>".$row["author"]."</h3>
                                    <div class=\"like_n_review\">
                                        <div class=\"likes\">
                                            <i class=\"fa-regular fa-heart\">".$row["like_count"]."</i>
                                        </div>
                                        <h4>".$row["review_count"]." Reviews</h4>
                                    </div>
                                </div>
                            </div>";
            $iter++;
        }
        $connection->close();
    } else {
        header("Location:logout.php");
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Home</title>
    <script>
        function redirectToIssue(bookId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'set_book_session.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.href = 'issue.php';
                } else {
                    alert('Unable to set book session.');
                }
            };
            xhr.send('book_id=' + bookId);
        }
    </script>
</head>

<body>

    <header>
        <nav>
            <img src="logo.jpg">
            <ul id="menuList" class="nav_items">
                <li><a href="#institute_img">Home</a></li>
                <li><a href="#about_institute">About</a></li>
                <li><a href="#welcome">Search</a></li>
                <li><a href="#recommendation">For You</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="stu_dashboard.php">Me</a></li>
            </ul>
            <div class="hamburger" id="nav_hamburger" onclick="toggleMenu()">
                <div class="bar1" id="nav_hamburger"></div>
                <div class="bar2" id="nav_hamburger"></div>
                <div class="bar3" id="nav_hamburger"></div>
            </div>
        </nav>
    </header>
    <section class="hero_section">
        <img id="institute_img" src="hero_img.jpg" alt="institute_img">
        <div class="about_institute" id="about_institute">
            <h2>ABOUT JD UNIVERSITY</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Consectetur aliquam dolores nam nihil aperiam repudiandae tempore 
                cupiditate. Perferendis maiores iure, temporibus quasi numquam ipsa 
                sequi debitis omnis quis optio saepe.
            </p>
        </div>
    </section>
    <div class="welcome" id="welcome">
        <h2 style="padding-top: 5px;" >Welcome To JD's Library</h2>
    </div>
    <div id="search_container" style="margin-top: 10px;">
            <form class="search" id="search_form" method="GET" action="search_results.php">
                <div class="drop_box">
                    <select name="Doc Type" id="doc_type">
                        <option value="Document Type">Document Type</option>
                        <option value="Books">Books</option>
                        <option value="Audio Visual Material">Audio Visual Material</option>
                        <option value="E-Books">E-Books</option>
                        <option value="Periodical">Periodical</option>
                    </select>
                    <select name="Language" id="language">
                        <option value="Language">Language</option>
                        <option value="English">English</option>
                        <option value="Hindi">Hindi</option>
                        <option value="Kannada">Kannada</option>
                        <option value="French">French</option>
                        <option value="Russian">Russian</option>
                        <option value="Japanese">Japanese</option>
                    </select>
                    <select name="Branch" id="branch">
                        <option value="branch">Branch</option>
                        <option value="cse">CSE</option>
                        <option value="ece">ECE</option>
                        <option value="ee">EE</option>
                        <option value="mnc">MnC</option>
                        <option value="me">ME</option>
                        <option value="ch">CH</option>
                        <option value="ce">CE</option>
                        <option value="bsms">BS-MS</option>
                    </select>
                </div>
                <div id="search_bar">
                    <input type="search" name= "search_input" id= "search_input" placeholder="Search here..."/>
                    <button id="search_button" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
    </div>
    <container class="suggestion" id="recommendation">
        <h2 style="padding: 7px;">
            Suggested For You
        </h2>
        <div class="offline_books">
            <?php
                foreach($html as $book)
                {
                    echo $book;
                } 
            ?>
        </div>
    </container>
    <footer id="contact">
        <h4>Contact us</h4>
        <div id="contact_icons">
            <a href="#instagram">
                <i class="fa-brands fa-instagram" style="color:white;"></i>
            </a>
            <a href="#twitter">
                <i class="fa-brands fa-twitter" style="color:white;"></i>
            </a>
            <a href="#youtube">
                <i class="fa-brands fa-youtube" style="color:white;"></i>
            </a>
        </div>
        <h4>For More</h4>
        <h5>Reach us at bla bla bla</h5>
        <h5>Copyright &copy; All rights reserved</h5>
    </footer>
    <script>
        let menuList = document.getElementById("menuList"),
            toggle = document.getElementById("nav_hamburger");
        menuList.style.maxHeight = "0px";
        
        function toggleMenu(){
            if(menuList.style.maxHeight === "0px"){
                toggle.classList.toggle("active");
                menuList.style.maxHeight = "300px";
            }
            else{
                menuList.style.maxHeight = "0px";
                toggle.classList.toggle("active");
            }
        } 
    document.onclick = function(e){
        if(menuList.style.maxHeight !== "0px" && e.target.id !== "nav_hamburger"){
            toggle.classList.toggle("active");
            menuList.style.maxHeight = "0px";
        }
    }
    </script>
</body>
</html>
