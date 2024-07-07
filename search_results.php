<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    #$connection = new mysqli(server,username,password,database);
    $doc_type = isset($_GET['doc_type']) ? $_GET['doc_type'] : '';
    $language = isset($_GET['language']) ? $_GET['language'] : '';
    $branch = isset($_GET['Branch']) ? $_GET['Branch'] : '';
    $search_input = isset($_GET['search_input']) ? $_GET['search_input'] : '';
    $dept = array("cse"=>"Computer Science","me"=>"Mechanical Engineering","ee"=>"Electrical Engineering","ce"=>"Civil Engineering","ch"=>"Chemical Engineering","ep"=>"Engineering Physics","mnc"=>"Maths and Computing","bsms"=>"Interdisciplinary Sciences");

    $query = "SELECT b.id, b.title, b.author, b.department, COUNT(l.bookid) AS like_count, COUNT(r.bookid) AS review_count
              FROM books b 
              LEFT JOIN likes l ON b.id = l.bookid 
              LEFT JOIN reviews r ON b.id = r.bookid 
              WHERE 1=1";

    #if ($doc_type) {
        #$query .= " AND b.document_type = '$doc_type'";
    #}
    #if ($language) {
    #    $query .= " AND b.language = '$language'";
    #}
    if (!empty($branch) && $branch !== 'branch') {
        $query .= " AND b.department = '$dept[$branch]'";
    }
    if (!empty($search_input)) {
        $query .= " AND (b.title LIKE '%$search_input%' OR b.author LIKE '%$search_input%')";
    }

    $query .= " GROUP BY b.id, b.title, b.author, b.department ORDER BY like_count DESC";

    $result = mysqli_query($connection, $query);
    $count = $result->num_rows;
    $html = [];
    $iter = 0;

    while ($row = $result->fetch_assoc()) {
        $html[$iter] = "<div id=\"book" . $iter . "\" class=\"books\" onclick=\"redirectToIssue('" . $row['id'] . "')\">
                            <img id=\"book_img_1\" class=\"book_img\"
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
        $iter++;
    }
    $htmlContent = implode("", $html);
    $_SESSION["search"] = $htmlContent;
    $_SESSION["count"] = $count;
    $connection->close();
    Header("Location:search.php");
} else {
    header("Location: logout.php");
}
?>