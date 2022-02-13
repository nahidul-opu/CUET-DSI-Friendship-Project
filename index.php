<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-------------------------page loading animation div-------------------------------->
    <div id="loading-animation"></div>

    <!------------------------------parent div of all the content--------------------------------->
    <div class="d-flex flex-row bg-image" style="min-height: 100vh;" id="parent-div">
        <!--------------Navbar design--------->
        <div class="flex-column sticky-top" style="background-color: rgba(181, 184, 189,0.2);width: 300px;max-height: 100vh;" id="sidebar">
            <!---------navbar card--------------->
            <div class="card" style="background-color: rgba(255,255,255,0.2);">
                <img src="./src/library.jpg" class="card-img-top" alt="cuet central library">
                <div class="card-body">
                    <h5 class="card-title text-white">CUET-DSI Central Library</h5>

                </div>
            </div>



            <!-------------navbar options--------------->
            <div class="d-flex flex-column align-items-center mt-3">

                <button class="btn btn-secondary m-1 text-start" style="width: 85%;" id="inventory">
                    <span class="h5">
                        <i class="bi bi-box-seam"></i>
                        Inventory
                    </span>
                </button>
                <button class="btn btn-secondary m-1 text-start" style="width: 85%;text-align: left;" id="users">
                    <span class="h5">
                        <i class="bi bi-people"></i>
                        Users
                    </span>
                </button>
                <button class="btn btn-secondary m-1 text-start" style="width: 85%;text-align: left;" id="history">
                    <span class="h5">
                        <i class="bi bi-clock-history"></i>
                        History
                    </span>
                </button>

                <button class="btn btn-secondary m-1 text-start" style="width: 85%;text-align: left;" id="dashboard">
                    <span class="h5">
                        <i class="bi bi-bar-chart"></i>
                        Dashboard
                    </span>
                </button>


            </div>


        </div>
        <!-----------------------body design----------------------->
        <div class="container-fluid p-0" id="body-div">
            <!-------------header design----------->
            <div class="d-flex flex-row sticky-top p-3 header-design text-white">
                <div class="container" style="width: fit-content;">
                    <button type="button" class="btn btn-outline-light" aria-label="Left Align" id="more">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor" class="bi bi-list" viewBox="4 4 10 10">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </button>
                </div>
                <div class="container" style="width: fit-content;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                        <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                    </svg>
                </div>
                <div class="container">
                    <h3>Library Management</h3>
                </div>


            </div>

            <!----------------------body after header--------------->
            <div class="container-fluid row b-1 justify-content-center" id="main-body">
                <!---------------------global search design for inventory tab------------------->
                <div class="flex-row" id="global-search-div">
                    <i class="bi bi-search" id="global-search-icon"></i>
                    <input type="text" class="" placeholder="Search by user,book,id" id="global-search-input">
                </div>
                <!------------------------------ bishal category card design begin ---------------------->
                <div class="book-category " id="book-category-div">
                    <div class="title text-center md-3">
                        <h2 class="font-wight-bolder text-light text-center">Books Category</h2>
                    </div>
                    <div class="row justify-content-center" id="book-card">
                    </div>
                </div>
                <!---------------------------Global search result table design----------------------------->
                <table class="table table-hover table-dark" id="global-search-result-table" style="display:none;">
                    <thead id="table-head">
                        <tr>
                            <th class="float-center">SL No.</th>
                            <th class="float-center">Book Name</th>
                            <th class="float-center">Writer Name</th>
                            <th class="float-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="global-result-tbody">


                    </tbody>
                    <!-------data will be added in script.js------>
                </table>


                <!---------------------------------- The Modal ------------------------------------------>
                <!----------------------------------edit category popup---------------------------------->
                <div class="modal" id="edit-category" style="top:25%">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="margin:auto">
                                <form method="post" action="#">
                                    <input id="edit-category-name" type="text" placeholder="New category name">
                                    <input id="edit-category-submit" type="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!------------------------------------ add category popup--------------------------------->
                <div class="modal" id="add-category" style="top:25%">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="margin:auto">
                                <form action="#action" method="post">
                                    <input id="edit-category-name" type="text" placeholder="Category Name">
                                    <input id="edit-category-submit" type="submit" value="Add Category">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!------------------------------update book----------------->
            <!------------------------------------------pop up form---------------------->
            <div class="modal" id="edit-book-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Book Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>

                            <script>
                                $(".btn-close").click(function() {
                                    $("#edit-book-modal").hide();
                                })
                            </script>

                        </div>
                        <div class="modal-body">
                            <form action="#" method="post" id="edit-book-form">
                                <div class="mb-3">
                                    <label class="form-label">Book Name</label>
                                    <input id="book-name" type="text" class="form-control" name="title" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Book Author</label>
                                    <input type="text" id="auth-name" class="form-control" name="author_name" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Publisher</label>
                                    <input type="text" id="pub" class="form-control" name="publisher" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Publish Year</label>
                                    <input type="text" id="pub-year" class="form-control" name="pub_year" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ISBN</label>
                                    <input type="text" id="isbn" class="form-control" name="isbn" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Count</label>
                                    <input type="text" id="total" class="form-control" name="total" placeholder="">
                                </div>
                                <button type="submit" class="btn btn-primary" id="book-edit-form-submit">Submit</button>
                            </form>
                        </div>


                    </div>
                </div>
            </div>

            <!--------------------------delete book confirmation modal---------->
            <div class="modal" id="delete-confirm">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h2>Are you sure you want to delete?</h2>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary m-2" id="cancel">Cancel</button>
                                <button class="btn btn-danger m-2" id="confirm">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--------------------------------book details page------------------------------>
            <!------------------------------ book details main container ------------------->
            <div class="container jumbotrom card text-center" id="book-details" style="background-color: rgba(181, 184, 189,0.4);min-height:100vh">
                <!---------------------------floating add book button-------------------------->
                <a href="" id="float-button">
                    <h1 class="display-4 floating-add-button">
                        <i class="bi bi-journal-plus"></i>
                    </h1>
                </a>



                <!---------------------------- pop up form ---------------------->
                <div class="modal" id="add-book-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Book</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                <script>
                                    $(".btn-close").click(function() {
                                        $("#add-book-modal").hide();
                                    })
                                </script>

                            </div>
                            <div class="modal-body">
                                <form action="#" method="post" id="add-book-form">
                                    <div class="mb-3">
                                        <label class="form-label">Book Name</label>
                                        <input id="mAB-book-name" type="text" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Book Author</label>
                                        <input type="text" id="mAB-author-name" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Book Category</label>
                                        <input type="text" id="mAB-category-id" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Publisher</label>
                                        <input type="text" id="mAB-publisher" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Publish Year</label>
                                        <input type="text" id="mAB-pub-year" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">ISBN</label>
                                        <input type="text" id="mAB-isbn" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Total Count</label>
                                        <input type="text" id="mAB-total-count" class="form-control" placeholder="">
                                    </div>
                                    <!-- <div class="mb-3">
                                            <label class="form-label">Current Count</label>
                                            <input type="text" id="mAB-current-count" class="form-control"  placeholder="">
                                        </div>-->
                                    <button type="submit" class="btn btn-primary" id="book-add-form-submit">Submit</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <nav class="navbar navbar-light nav justify-content-center">
                    <form class="d-flex flex-row" id="book-search-form">
                        <input class="form-control mr-sm-2" type="search" id="book-search-input" placeholder="Enter book title" aria-label="Search">
                        <!-- <button class="btn btn-info" type="submit" id="book-search-btn">Search</button> -->
                        <div id="drop-down-search-container" class="row">
                            <select name="book-search-dropdown" id="book-search-dropdown">
                                <option value="title">by book title</option>
                                <option value="author_name">by author name</option>
                            </select>
                        </div>
                    </form>
                </nav>

                <div class="card-body" id="card-details">
                    <table class="table table-hover table-dark" id="book-details-table">
                        <thead id="table-head">
                            <tr>
                                <th class="float-center">SL No.</th>
                                <th class="float-center">Book Name</th>
                                <th class="float-center">Writer Name</th>
                                <th class="float-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="category-book-result">

                        </tbody>
                        <!-------data will be added in script.js------>
                    </table>

                    <!----------------- pagination ------------------->
                    <nav aria-label="Page navigation example" id="pagination-div" style="display:none">
                        <ul class="pagination justify-content-center" id="pagination">
                            <!--<li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>--->
                            <li class="page-item"><a class="page-link" id="1">1</a></li>
                            <li class="page-item"><a class="page-link" id="2" href="">2</a></li>
                            <li class="page-item"><a class="page-link" id="3" href="">3</a></li>
                            <li class="page-item"><a class="page-link" id="4" href="">4</a></li>
                            <li class="page-item"><a class="page-link" id="5" href="">5</a></li>
                            <!--<li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>

                                </a>
                            </li>-->
                        </ul>

                    </nav>
                </div>
            </div>




            <!------------------- book issue modal start ----------------->
            <div class="modal" id="issue-book-modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Issue Book Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>

                            <script>
                                $(".btn-close").click(function() {
                                    $("#issue-book-modal").hide();
                                });
                            </script>

                        </div>

                        <div class="modal-body ui-front">
                            <!-- ------------- -->


                            <div class="p-3 rounded" style="background-color: rgba(215, 215, 215, 0.8);">
                                <div class="row ">
                                    <div class="col-md-8 text-black ">
                                        <!-- 1 -->
                                        <div class="row  p-1 rounded-top m-1">
                                            <!-- 1.1 -->
                                            <div class="col-md-6">
                                                <img class="img-fluid" src="https://api.lorem.space/image/book?w=200&h=250" alt="c">
                                            </div>
                                            <!-- 1.2 -->
                                            <div class="col-md-6 text-black" id="book-issue-book-info">
                                                <!-- jquery will append code here  -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 2 -->
                                    <div class="col-md-4 text-black p-3 rounded my-1">

                                        <div class="form-group">
                                            <style>
                                                /* inside css file not working so.. -_- */
                                                .ui-autocomplete {
                                                    position: absolute;
                                                    top: 100%;
                                                    left: 0;
                                                    z-index: 1000;
                                                    display: none;
                                                    float: left;
                                                    min-width: 160px;
                                                    padding: 5px 0;
                                                    margin: 2px 0 0;
                                                    list-style: none;
                                                    font-size: 14px;
                                                    text-align: left;
                                                    background-color: #ffffff;
                                                    border: 1px solid #cccccc;
                                                    border: 1px solid rgba(0, 0, 0, 0.15);
                                                    border-radius: 4px;
                                                    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
                                                    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
                                                    background-clip: padding-box;
                                                }

                                                .ui-autocomplete>li>div {
                                                    display: block;
                                                    padding: 3px 20px;
                                                    clear: both;
                                                    font-weight: normal;
                                                    line-height: 1.42857143;
                                                    color: #333333;
                                                    white-space: nowrap;
                                                }

                                                .ui-state-hover,
                                                .ui-state-active,
                                                .ui-state-focus {
                                                    text-decoration: none;
                                                    color: #262626;
                                                    background-color: #f5f5f5;
                                                    cursor: pointer;
                                                }
                                            </style>
                                            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                            <label for="Student">
                                                <h5>Search User</h5>
                                            </label>
                                            <input class="rounded-2 form-control " type="text" id="issue-user-search" placeholder="User Name" />
                                            <div id="book-issue-user-info" class="py-3">
                                                <!-- jquery will append user info here dynamically  -->

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <!-- 3 -->
                                    <div class="col-md-8  text-white text-center p-3 rounded" id="book-avalability">

                                    </div>
                                    <!-- 4 -->
                                    <div class="col-md-4 text-center p-3 rounded" id="issue-return-book">
                                        <button type="button" class="btn btn-success btn-block" id="book-issue-btn">Issue Book</button>

                                    </div>
                                </div>

                            </div>
                            <!-- ------------- -->

                        </div>
                    </div>
                </div>
            </div>


            <!---------------------history tab design--------------->
            <div class="container" id="history-tab-body" style="display:none;">
                <h2 class="p-2 mt-3 mb-3" id="history-header">History</h2>
                <!----------------history tab search option design--------------->
                <div class="navbar navbar-light nav justify-content-center" id="history-search-container">
                    <form class="d-flex flex-row align-middle" id="history-tab-search">
                        <input class="form-control m-0" type="search" id="history-search-input" placeholder="Enter book title" aria-label="Search">
                        <div id="drop-down-search-container" class="row">
                            <select name="book-search-dropdown" id="history-search-dropdown">
                                <option value="title">by book title</option>
                                <option value="author_name">by user name</option>
                            </select>
                        </div>
                    </form>
                </div>

                <table class="table table-dark table-striped" id="history-details-table">
                    <thead>
                        <tr>
                            <th scope="col">Sl. no</th>
                            <th scope="col" onclick="tableHeader('user_id')">
                                <div>
                                    <i class="bi bi-caret-up no-display" id="user_id0"></i>
                                    <i class="bi bi-caret-down no-display" id="user_id1"></i>
                                    <br>
                                    User id
                                </div>

                            </th>
                            <th scope="col" onclick="tableHeader('name')">
                                <div>
                                    <i class="bi bi-caret-up no-display" id="name0"></i>
                                    <i class="bi bi-caret-down no-display" id="name1"></i>
                                    <br>
                                    User Name
                                </div>
                            </th>
                            <th scope="col" onclick="tableHeader('title')">
                                <div>
                                    <i class="bi bi-caret-up no-display" id="title0"></i>
                                    <i class="bi bi-caret-down no-display" id="title1"></i>
                                    <br>
                                    Book name
                                </div>

                            </th>
                            <th scope="col" onclick="tableHeader('status')">
                                <div>
                                    <i class="bi bi-caret-up no-display" id="status0"></i>
                                    <i class="bi bi-caret-down no-display" id="status1"></i>
                                    <br>
                                    Status
                                </div>

                            </th>
                            <th scope="col" onclick="tableHeader('issue_date')">
                                <div>
                                    <i class="bi bi-caret-up no-display" id="issue_date0"></i>
                                    <i class="bi bi-caret-down no-display" id="issue_date1"></i>
                                    <br>
                                    Issue date
                                </div>
                            </th>
                            <th scope="col" onclick="tableHeader('due_date')">
                                <div>
                                    <i class="bi bi-caret-up no-display" id="due_date0"></i>
                                    <i class="bi bi-caret-down no-display" id="due_date1"></i>
                                    <br>
                                    Due date
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody id="history-tab-table-body">

                    </tbody>
                </table>
            </div>



            <!------------------bishal User list TAB start here ----------------------->
            <div class="p-4" id="user-list-div" style="display:none">
                <h3 class="text-center text-white bg-dark rounded p-2">User List</h3>

                <table class="table table-hover table-dark" id="user-list-table">
                    <thead id="table-head">
                        <tr>
                            <th class="float-center">SL No.</th>
                            <th class="float-center">ID</th>
                            <th class="float-center">User Name</th>
                            <th class="float-center">email</th>
                            <th class="float-center">Phone</th>
                            <th class="float-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="user-list-table-body">
                    </tbody>
                    <!-- jquery will append user table here -->
                </table>

            </div>

            <!------------------bishal User list end here ----------------------->


            <!----------------- bishal user update modal start ------------------------->
            <div class="modal" id="edit-user-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>

                            <script>
                                $(".btn-close").click(function() {
                                    $("#edit-user-modal").hide();
                                })
                            </script>

                        </div>
                        <div class="modal-body">
                            <form action="#" method="post" id="edit-user-form">
                                <div class="mb-3">
                                    <label class="form-label">User Name</label>
                                    <input id="user-name" type="text" class="form-control" name="title" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">phone no.</label>
                                    <input id="phone-no" type="text" class="form-control" name="title" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" id="email-id" class="form-control" name="author_name" placeholder="">
                                </div>
                                <button type="submit" class="btn btn-primary" id="user-edit-form-submit">Update info</button>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
            <!----------------- bishal user update modal start ------------------------->



            <!----------------- Dashboard page ------------------->

            <div class="mx-5 p-5" id="dashboard-body" style="display:none">

                <div class="title text-center md-3">
                    <h2 class="font-wight-bolder text-light">Dash Board</h2>
                    <h4 class="font-wight-bolder text-light" id="today"></h4>
                </div>



                <div class="container-fluid mt-5" style="display:grid">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card category-card-tarnsparent pt-3" id="card1">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-right">
                                                <h3 id="num-1">300</h3>
                                                <span id="label-1">Total Books</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card category-card-tarnsparent pt-3">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">

                                            <div class="media-body text-right">
                                                <h3 id="num-2">5</h3>
                                                <span id="label-2">Categories</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card category-card-tarnsparent pt-3">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">

                                            <div class="media-body text-right">
                                                <h3 id="num-3">112</h3>
                                                <span id="label-3">Books Issued</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card category-card-tarnsparent pt-3">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">

                                            <div class="media-body text-right">
                                                <h3 id="num-4">90</h3>
                                                <span id="label-4">Books Recieved</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-xl-5">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card category-card-tarnsparent pt-3">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 id="num-5">10</h3>
                                                <span id="label-5">Over Due Books</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card category-card-tarnsparent pt-3">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 id="num-6">6</h3>
                                                <span id="label-6">New Books</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card category-card-tarnsparent pt-3">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 id="num-7">101</h3>
                                                <span id="label-7">Users Added</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card category-card-tarnsparent pt-3">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-center">
                                                <form id="date-filter">

                                                    <input id="from" type="text" placeholder="From" style=" width:83px" onfocus="(this.type='date')" onblur="(this.type='text')">

                                                    <input id="to" type="text" placeholder="To" style=" width:83px" onfocus="(this.type='date')" onblur="(this.type='text')">

                                                    <div class="text-center">
                                                        <input id="date-submit" value="filter" type="submit" class="btn btn-secondary p-0" style="margin-top:10px">
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>





        </div>

    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>

</body>

</html>
