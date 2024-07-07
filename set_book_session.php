<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    $_SESSION['book_id'] = $_POST['book_id'];
    echo "Session variable 'book_id' set successfully.";
} else {
    echo "Error: Unable to set session variable 'book_id'.";
}
?>
