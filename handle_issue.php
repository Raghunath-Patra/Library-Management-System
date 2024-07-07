<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #$connection = new mysqli(server,username,password,database);

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['book_id']) && isset($_SESSION['roll'])) {
        $book_id = $_SESSION['book_id'];
        $roll = $_SESSION['roll'];
        $issue_date = $_SESSION['date'];
        $due_date = $_SESSION['due'];
        $returned = 0;

        $query = "INSERT INTO issues (bookid, roll, issuedate, duedate, returned) VALUES ('$book_id', '$roll', '$issue_date', '$due_date', '$returned')";

        if ($connection->query($query) === TRUE) {
            echo "Book issued successfully";
        } else {
            echo "Error: " . $query . "<br>" . $connection->error;
        }
    } else {
        echo "Session variables not set";
    }

    $connection->close();
    exit;
}
?>