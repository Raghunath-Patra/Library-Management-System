<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    $_SESSION['book_id'] = $_POST['book_id'];
    // Optionally, you can send a response back if needed
    echo "Session variable 'book_id' set successfully.";
} else {
    // Handle any error scenarios
    echo "Error: Unable to set session variable 'book_id'.";
}
?>
