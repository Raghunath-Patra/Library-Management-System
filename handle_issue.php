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
        $query_2 = "SELECT points from users";
        $result_2 = mysqli_query($connection,$query_2);
        if ($connection->query($query) === TRUE) {
            echo "Book issued successfully";
            $result_2 = mysqli_query($connection,$query_2);
            while($row = $result_2->fetch_assoc()) {
                $new = $_SESSION["points"] - intval($_SESSION["increment"]);
                $query_3 = "UPDATE users SET points = $new WHERE roll = '$_SESSION[roll]'";
                if($connection->query($query_3) === TRUE) {
                    echo "points deducted succesfully";
                }
            }
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
