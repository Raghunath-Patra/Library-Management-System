<?php
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    #$connection = new mysqli(server,username,password,database);

    // Check if session variables are set
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['book_id']) && isset($_SESSION['roll'])) {
        $book_id = $_SESSION['book_id'];
        $roll = $_SESSION['roll'];
        $issue_date = $_SESSION['date'];
        $due_date = $_SESSION['due'];
        $returned = 0;

        // Prepare SQL query
        $query = "INSERT INTO issues (bookid, roll, issuedate, duedate, returned) VALUES ('$book_id', '$roll', '$issue_date', '$due_date', '$returned')";

        // Execute query
        if ($connection->query($query) === TRUE) {
            echo "Book issued successfully";
        } else {
            echo "Error: " . $query . "<br>" . $connection->error;
        }
    } else {
        echo "Session variables not set";
    }

    // Close database connection
    $connection->close();
    exit; // Exit to prevent further HTML rendering
}
?>