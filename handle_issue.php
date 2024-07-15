<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #$connection = new mysqli(server,username,password,database);

    if ($connection->connect_error) {
        echo json_encode(array("status" => "error", "message" => "Connection failed: " . $connection->connect_error));
        exit;
    }

    try {
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['book_id']) && isset($_SESSION['roll'])) {
            $book_id = $_SESSION['book_id'];
            $roll = $_SESSION['roll'];
            $issue_date = $_SESSION['date'];
            $due_date = $_SESSION['due'];
            $returned = 0;

            // Check if the entry already exists
            $check_query = "SELECT * FROM issues WHERE bookid = '$book_id' AND roll = '$roll'";
            $check_result = $connection->query($check_query);

            if ($check_result->num_rows > 0) {
                throw new Exception("Book already issued to this user.");
            }

            //Updating points
            $insert_query = "INSERT INTO issues (bookid, roll, issuedate, duedate, returned) VALUES ('$book_id', '$roll', '$issue_date', '$due_date', '$returned')";
            if ($connection->query($insert_query) === TRUE) {        
                if(isset($_SESSION["increment"]))
                {
                    $new_points = $_SESSION["points"] - intval($_SESSION["increment"]);
                    $update_points_query = "UPDATE users SET points = $new_points WHERE roll = '$_SESSION[roll]'";
                    if ($connection->query($update_points_query) === TRUE) {
                        echo json_encode(array("status" => "success"));
                    } else {
                        throw new Exception("Failed to deduct points.");
                    }
                }
                else{
                    echo json_encode(array("status" => "success"));
                }
            } else {
                throw new Exception("Failed to issue book.");
            }
        } else {
            throw new Exception("Session variables not set.");
        }
    } catch (Exception $e) {
        echo json_encode(array("status" => "error", "message" => $e->getMessage()));
    }

    $connection->close();
    exit;
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
    exit;
}
?>
