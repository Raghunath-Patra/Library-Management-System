<?php
    session_start();
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

</head>

<body>
    <header>
        <nav>
            <img src="logo.jpg">
            <ul>
                <li><a href="#institute_img">Home</a></li>
                <li><a href="#search_container">Search</a></li>
                <li><a href="#recommendation">For You</a></li>
                <li><a href="#e_books">E-Books</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="stu_dashboard.html">Me</a></li>
            </ul>
        </nav>
    </header>
    <section class="hero_section">
        <img id="institute_img" src="hero_img.jpg" alt="institute_img">
        <pre>
            <?php echo $_SESSION['name'] ?>
            kjgd jcgaicja lclaucg
            jjjdwijqk wudkikawdk 
            udwygd uydkia
            jbcj lknck lsjaud 
            ihciug uaehfuyagduh
            jbxytsfx uusgs
        </pre>

    </section>
    <div id="search_container">
        <div class="search">
            <div class="drop_box">
                <select>
                    <option value="normal book">All</option>
                    <option value="offline_books">Offline Only</option>
                    <option value="e-book">e-book</option>
                </select>
                <select>
                    <option value="opt1">option 1</option>
                    <option value="opt2">option 2</option>
                    <option value="opt3">option 3</option>
                    <option value="opt4">option 4</option>
                </select>
            </div>
            <div id="search_bar">
                <input type="search" id="search_input" placeholder="Search here..." />
                <a href="search.html"><i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>
    </div>
    <container class="suggestion" id="recommendation">
        <h2 style="padding: 7px;">
            Suggested For You
        </h2>
        <div class="offline_books">
            <div id="book1" class="books">
                <a href="issue.html">
                    <img id="book_img_1" class="book_img"
                    src="https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png" alt="Book">
                </a>
                <div class="book_description">
                    <h2>Name Of The Book</h2>
                    <h3>Author of The Book</h3>
                    <div class="like_n_review">
                        <div class="likes">
                            <i class="fa-regular fa-heart">23</i>
                        </div>
                        <h4>2 Reviews</h4>
                    </div>
                </div>
            </div>
            <div id="book2" class="books">
                <img id="book_img_1" class="book_img"
                    src="https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png" alt="Book">
                <div class="book_description">
                    <h2>Name Of The Book</h2>
                    <h3>Author of The Book</h3>
                    <div class="like_n_review">
                        <div class="likes">
                            <i class="fa-regular fa-heart">23</i>
                        </div>
                        <h4>2 Reviews</h4>
                    </div>
                </div>
            </div>
            <div id="book3" class="books">
                <img id="book_img_1" class="book_img"
                    src="https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png" alt="Book">
                <div class="book_description">
                    <h2>Name Of The Book</h2>
                    <h3>Author of The Book</h3>
                    <div class="like_n_review">
                        <div class="likes">
                            <i class="fa-regular fa-heart">23</i>
                        </div>
                        <h4>2 Reviews</h4>
                    </div>
                </div>
            </div>
            <div id="book4" class="books">
                <img id="book_img_1" class="book_img"
                    src="https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png" alt="Book">
                <div class="book_description">
                    <h2>Name Of The Book</h2>
                    <h3>Author of The Book</h3>
                    <div class="like_n_review">
                        <div class="likes">
                            <i class="fa-regular fa-heart">23</i>
                        </div>
                        <h4>2 Reviews</h4>
                    </div>
                </div>
            </div>
            <div id="book5" class="books">
                <img id="book_img_1" class="book_img"
                    src="https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png" alt="Book">
                <div class="book_description">
                    <h2>Name Of The Book</h2>
                    <h3>Author of The Book</h3>
                    <div class="like_n_review">
                        <div class="likes">
                            <i class="fa-regular fa-heart">23</i>
                        </div>
                        <h4>2 Reviews</h4>
                    </div>
                </div>
            </div>
            <div id="book6" class="books">
                <img id="book_img_1" class="book_img"
                    src="https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png" alt="Book">
                <div class="book_description">
                    <h2>Name Of The Book</h2>
                    <h3>Author of The Book</h3>
                    <div class="like_n_review">
                        <div class="likes">
                            <i class="fa-regular fa-heart">23</i>
                        </div>
                        <h4>2 Reviews</h4>
                    </div>
                </div>
            </div>
        </div>
        <h2 style="padding: 5px;">
            Some E-Books
        </h2>
        <div class="e-books" id="e_books">
            <div id="ebook1" class="books">
                <div id="book_img_1" class="book_img"></div>
                <div class="book_description">
                    <h2>Name Of The Book</h2>
                    <h3>Author of The Book</h3>
                    <div class="like_n_review">
                        <div class="likes">
                            <i class="fa-regular fa-heart">23</i>
                        </div>
                        <h4>2 Reviews</h4>
                    </div>
                </div>
            </div>
            <div id="ebook2" class="books">
                <div id="book_img_1" class="book_img"></div>
                <div class="book_description">
                    <h2>Name Of The Book</h2>
                    <h3>Author of The Book</h3>
                    <div class="like_n_review">
                        <div class="likes">
                            <i class="fa-regular fa-heart">23</i>
                        </div>
                        <h4>2 Reviews</h4>
                    </div>
                </div>
            </div>
            <div id="ebook3" class="books">
                <div id="book_img_1" class="book_img"></div>
                <div class="book_description">
                    <h2>Name Of The Book</h2>
                    <h3>Author of The Book</h3>
                    <div class="like_n_review">
                        <div class="likes">
                            <i class="fa-regular fa-heart">23</i>
                        </div>
                        <h4>2 Reviews</h4>
                    </div>
                </div>
            </div>
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
</body>

</html>