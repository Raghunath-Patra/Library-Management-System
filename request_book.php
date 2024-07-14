<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    } else {
        header("Location:logout.php");
    }
    if(isset($_POST['request_book'])) {
        $book_title = $_POST['book_title'];
        $book_author = $_POST['book_author'];
        $book_edition = $_POST['book_edition'];
        $publication_year = $_POST['publication_year'];
        $isbn = $_POST['isbn'];
        $lang = $_POST['language'];
        $publisher = $_POST['publisher'];
        $catagory = $_POST['subject'];
        $reason = $_POST['reason'];
        $notes = $_POST['notes'];

        $connection = new mysqli(server,username,password,database);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $query = "INSERT INTO RequestedBooks (roll,book_title,book_author,book_edition,publication_year,isbn,language,publisher,catagory,reason,note)
        VALUES ('$_SESSION[roll]','$book_title','$book_author','$book_edition','$publication_year','$isbn','$lang','$publisher','$catagory','$reason','$notes')";
        if ($connection->query($query) === TRUE) {
            echo '<script> window.alert("Form Submitted Successfully!");</script>';
            header("Location:stu_dashboard.php");
        }
        else{
            echo "failed";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Request Book</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="request_page">
        <div class="request-container">
            <h1>Request a book</h1>
            <form action="" method="POST">
                <div>
                <input type="text" id="book_title" name="book_title" placeholder="Book Title:" required>
                </div>
                
                <div>
                <input type="text" id="book_author" name="book_author"placeholder="Book Author:" required>
                </div>
                
                <div>
                <input type="text" id="book_edition"placeholder="Edition/Volume:" name="book_edition">
                
                <input type="text" id="publication_year" name="publication_year" placeholder="Publication Year:">
                </div>
                
                <div>
                <input type="text" id="isbn" name="isbn" placeholder="ISBN:">
                
                <input type="text" id="language" name="language"placeholder="Preferred Language:">
                </div>
                
                <div>
                <input type="text" id="publisher" name="publisher" placeholder="Publisher:">
                </div>
                
                <div>
                <input type="text" id="subject" name="subject" placeholder="Subject/Category:">
                </div>
                
                <div>
                <textarea id="reason" name="reason"placeholder="Reason for Request:"></textarea>
                </div>
                
                <div>
                <textarea id="notes" name="notes" placeholder="Additional Notes:"></textarea>
                </div>
                <div>
                <button type="submit" name="request_book">Submit Request</button>
                </div>
            </form>
            <script>
                function getBookinfo(){
                    <?php 
                    $connection = new mysqli("localhost","root","","SOI");

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
        </div>
    </section>
</body>

</html>
