<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            #$connection = new mysqli(server,username,password,database);
            if ($connection->connect_error) {
                echo json_encode(array("status" => "error", "message" => "Connection failed: " . $connection->connect_error));
                exit;
            }
            $selectedGenres = json_decode($_POST['genres']);
            $selectedPublishers = json_decode($_POST['publishers']);
            $query = "SELECT * from ($_SESSION[query]) AS original WHERE 1=1 ";     
            if(!empty($selectedGenres)){
                $iter = 0;
                $query .= "AND original.genre IN (";
                foreach($selectedGenres as $genre){
                    if($iter == 0)
                    {
                        $query .= "'$genre'";
                        $iter = 1;
                    }
                    else{
                        $query .= ",'$genre'";
                    }
                }
                $query .= ") ";
            }
            if(!empty($selectedPublishers)){
                $flag= 0;
                $query .= "AND original.publisher IN (";
                foreach($selectedPublishers as $publisher){
                    if($flag == 0)
                    {
                        $query .= "'$publisher'";
                        $fla = 1;
                    }
                    else{
                        $query .= ",'publisher'";
                    }
                }
                $query .= ") ";
            }
            $result = mysqli_query($connection,$query);
            $count = $result->num_rows;
            $html = [];
            $genres = [];
            $authors = [];
            $publishers = [];
            $iter = 0;
            while ($row = $result->fetch_assoc()) {
                $html[$iter] = "<div id=\"book" . $iter . "\" class=\"books\" onclick=\"redirectToIssue('" . $row['id'] . "')\">
                                    <img id=\"book_img\" class=\"book_img\"
                                    src=\"https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png\" alt=\"Book\">
                                    <div class=\"book_description\">
                                        <h2>" . $row["title"] . "</h2>
                                        <h3>" . $row["author"] . "</h3>
                                        <div class=\"like_n_review\">
                                            <div class=\"likes\">
                                                <i class=\"fa-regular fa-heart\">" . $row["like_count"] . "</i>
                                            </div>
                                            <h4>" . $row["review_count"] . " Reviews</h4>
                                        </div>
                                    </div>
                                </div>";
                if (!in_array($row['genre'], $genres)) {
                    $genres[] = $row['genre'];
                }
                if (!in_array($row['author'], $authors)) {
                    $authors[] = $row['author'];
                }
                if (!in_array($row['publisher'], $publishers)) {
                    $publishers[] = $row['publisher'];
                }
                $iter++;
            }
            $htmlContent = implode("", $html);
            echo json_encode(array("status" => "success", "message" => $htmlContent));
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid request method."));
            exit;
        }
    } else {
        header("Location:logout.php");
    }
?>