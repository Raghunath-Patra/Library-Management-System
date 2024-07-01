<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Search</title>
</head>
<body>
    <a href="javascript:history.back()" style="text-decoration: none; color:black; margin: 10px;">Go Back</a>
    <div id="search_container" style="margin-top: 10px;">
        <div class="search">
            <div class="drop_box">
                <select name="Doc Type" id="doc_type">
                    <option value="Document Type">Document Type</option>
                    <option value="Books">Books</option>
                    <option value="Audio Visual Material">Audio Visual Material</option>
                    <option value="E-Books">E-Books</option>
                    <option value="Periodical">Periodical</option>
                </select>
                <select name="Language" id="language">
                    <option value="Language">Language</option>
                    <option value="English">English</option>
                    <option value="Hindi">Hindi</option>
                    <option value="Kannada">Kannada</option>
                    <option value="French">French</option>
                    <option value="Russian">Russian</option>
                    <option value="Japanese">Japanese</option>
                </select>
                <select name="Branch" id="branch">
                    <option value="branch">Branch</option>
                    <option value="cse">CSE</option>
                    <option value="ece">ECE</option>
                    <option value="ee">EE</option>
                    <option value="mnc">MnC</option>
                    <option value="me">ME</option>
                    <option value="ch">CH</option>
                    <option value="ce">CE</option>
                    <option value="bsms">BS-MS</option>
                </select>
            </div>
            <div id="search_bar">
                <input type="search" id="search_input" placeholder="Search here..."/>
                <a href="search.html" ><i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>
    </div>
    <div style="display: flex; margin: 2vw;">
        <div class="filter_container" id="filter_container">
            <h3>Refine Your Search</h3>
            <optgroup label="Availability">
                <option value="available">
                    Currently available items only
                </option>
            </optgroup>
            <optgroup label="Authors">
                <option value="author">
                    hfsytdsu kusagyfa usy
                </option>
                <option value="author">
                    usy jhJCAJCVAHC bc
                </option>
                <option value="author">
                    jsbxjashxvss jhcvac
                </option>
            </optgroup>
            <optgroup label="Genre">
                <option value="genre">
                    Algorithms
                </option>
                <option value="genre">
                    jbjsygs
                </option>
                <option value="genre">
                    hfsytdsu kusag
                </option>
            </optgroup>
            <optgroup label="Publisher">
                <option value="publisher">
                    Lipringer Nature
                </option>
                <option value="publisher">
                    ajgfs kajhkgss
                </option>
                <option value="publisher">
                    jbjsygs
                </option>
            </optgroup>
        </div>
    
    <div class="search_result_container">
        <div style="display: flex;justify-content: space-between;">
                <h2 id="no_of_results">Your search Returned 34 Results</h2>
                <div class="hamburger" id="hamburger">
                    <div class="bar" id="bar1"></div>
                    <div class="bar" id="bar2"></div>
                    <div class="bar" id="bar3"></div>
                </div> 
        </div>
        <div class="resultant_books">
            <div class="book_description">
                <h2 id="title">Name of the Book</h2>
                <h3 id="author">by: Book Author's Name, hjv hytdrhf gu, fytrdtrs gtt, gftrdtrd hvgt. uytfytf jhbtf  
                    Book Author's Name, hjv hytdrhf gu, fytrdtrs gtt, gftrdtrd hvgt. uytfytf jhbtf </h3>
                <br>
                <h4 id="department">Department: Computer Science</h4>
                <div class="like_n_review">
                    <div class="likes">
                        <i class="fa-regular fa-heart">23</i>
                    </div>
                    <div>
                        <h4 id="no_of_reviews">2 Reviews</h4>
                    </div>
                </div>
            </div>
            <a href="issue_book.html">
                <img id="book_img_1" class="book_img" src="https://openclipart.org/image/2400px/svg_to_png/204361/1415799000.png" alt="Book">
            </a>
        </div>
    </div>
</div>
<script>
    let toggle = document.getElementById("hamburger"),
        filter_container = document.getElementById("filter_container");
    
    document.onclick = function(e){
        if(e.target.id === "hamburger" || e.target.id === "bar1" || e.target.id === "bar2" || e.target.id === "bar3"){
            toggle.classList.toggle("active");
            if(filter_container.className === "filter_container"){
                filter_container.className += "_responsive";
            }
            else{
                filter_container.className = "filter_container";
            }
        }
        else if(filter_container.className === "filter_container_responsive"){
            toggle.classList.toggle("active");
            filter_container.className = "filter_container";
        }
    }
    
</script>
</body>
</html>
