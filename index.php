<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="d-flex flex-row bg-image" style="min-height: 100vh;">
        <!--------------Navbar design--------->
        <div class="flex-column sticky-top"
            style="background-color: rgba(181, 184, 189,0.2);width: 300px;max-height: 100vh;" id="sidebar">
            <!---------navbar card--------------->
            <div class="card" style="background-color: rgba(255,255,255,0.2);">
                <img src="./src/library.jpg" class="card-img-top" alt="cuet central library">
                <div class="card-body">
                    <h5 class="card-title text-white">CUET-DSI Central Library</h5>

                </div>
            </div>



            <!-------------navbar options--------------->
            <div class="d-flex flex-column align-items-center mt-3">

                <button class="btn btn-secondary m-1 text-start" style="width: 85%;">
                    <span class="h5">
                        <i class="bi bi-box-seam"></i>
                        Inventory
                    </span>
                </button>
                <button class="btn btn-secondary m-1 text-start" style="width: 85%;text-align: left;">
                    <span class="h5">
                        <i class="bi bi-people"></i>
                        Users
                    </span>
                </button>
                <button class="btn btn-secondary m-1 text-start" style="width: 85%;text-align: left;">
                    <span class="h5">
                        <i class="bi bi-journal-plus"></i>
                        Issue Book
                    </span>
                </button>
                <button class="btn btn-secondary m-1 text-start" style="width: 85%;text-align: left;">
                    <span class="h5">
                        <i class="bi bi-clock-history"></i>
                        History
                    </span>
                </button>
                <button class="btn btn-secondary m-1 text-start" style="width: 85%;text-align: left;">
                    <span class="h5">
                        <i class="bi bi-bar-chart"></i>
                        Dashboard
                    </span>
                </button>


            </div>


        </div>
        <!-------------body design----------->
        <div class="container-fluid p-0">
            <!-------------header design----------->
            <div class="d-flex flex-row sticky-top p-3 header-design text-white">
                <div class="container" style="width: fit-content;">
                    <button type="button" class="btn btn-outline-light" aria-label="Left Align" id="more">
                        <!-- <i class="bi bi-list" ></i> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor"
                            class="bi bi-list" viewBox="4 4 10 10">
                            <path fill-rule="evenodd"
                                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </button>
                </div>
                <div class="container" style="width: fit-content;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                        class="bi bi-journal-text" viewBox="0 0 16 16">
                        <path
                            d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                        <path
                            d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                        <path
                            d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                    </svg>
                </div>
                <div class="container">
                    <h3>Library Management</h3>
                </div>


            </div>
            <!-------------body after header----------->
            <div class="container-fluid row b-1" id="grid">
                <!--------------------------------xxxx---------------------------------------->
                <!--------------------------------card---------------------------------------->


                <div class="category-card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="text-align:Center">Title</h5>
                        <p class="card-text" style="float:left; margin-top:30px;">40/50</p>
                        <!--
                        <button id="edit-card" style=""> ? </button>-->
                        <!--   edit category--------------->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-category" style="float:right; margin-top:25px; background-color:grey">edit</button>
                    </div>
                </div>

                <!--add category ---------------------------------------------------------------------------->
                <div class="category-card" style="width: 18rem;">
                    <div class="card-body">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category" style="float:right; margin-top:25px; background-color:white; color:black; width:100%; border:0;">+</button>
                    </div>
                </div>


                <!--<a href="#" class="btn btn-primary">40/50</a>-->


                <!-- The Modal -->
                <!--
--------------------------------edit category popup
-->
                <div class="modal" id="edit-category" style="top:25%">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal body -->
                            <div class="modal-body" style="margin:auto">
                                <form method="post" action="#">
                                    <input id="edit-category-name" type="text" placeholder="New category name">
                                    <input id="edit-category-submit" type="submit">
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <!--     <div class="modal-footer" style="margin:auto">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>-->


                        </div>
                    </div>
                </div>
                <!--
 ---------------------------------- add category popup
-->
                <div class="modal" id="add-category" style="top:25%">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal body -->
                            <div class="modal-body" style="margin:auto">
                                <form action="#action" method="post">
                                    <input id="edit-category-name" type="text" placeholder="Add Category">
                                    <input id="edit-category-submit" type="submit" value="Add Category">
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <!--     <div class="modal-footer" style="margin:auto">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>-->


                        </div>
                    </div>
                </div>





                <!-- <script>
                    var total_cards = 5;
                    console.log(total_cards);

                    for (var i = 0; i < total_cards; i++) {
                        /*$(".container-fluid row b-1").append('<div class="card" style="width: 18rem;"><div class="card-body"><h5 class="card-title">Card title</h5><p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p><a href="#" class="btn btn-primary">Go somewhere</a></div></div>');*/
                        
                        document.write('<div class="card" style="width: 18rem;"><div class="card-body"><h5 class="card-title">Card title</h5><p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p><a href="#" class="btn btn-primary">Go somewhere</a></div></div>');

                    }
                </script>-->










            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
