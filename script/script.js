$(document).ready(function () {
  //global variable for data cache
  var output;
  var target_category_id;

  //inventory tab default color
  $("#inventory").css("background-color", "#2f0410");

  // bishal starting card append
  var location = window.location.href;
  var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
  //console.log(directoryPath);
  function loadCategoryCard() {
    $.ajax({
      type: "GET",
      url: directoryPath + "api/category/",
      dataType: "json",
      async: true,
      success: function (data, status) {
        // //console.log(data.keys());

        var category = data["message"];
        $("#book-card").empty();
        for (let i = 0; i < category.length; i++) {
          var card =
            `<button class="category-card-click m-3" id="` +
            category[i].category_id +
            `"><div class="col-lg-4 ">
                <div class="card h-90 category-card-tarnsparent" style="width:280px;height:220px;margin:0;padding:0;">
                  <div class="card-body py-5" id="card-body">
                    <h4 class="card-title text-center">` +
            category[i].category_name +
            `</h4>
                  </div>
                <div class="card-footer">
                <div class ="container-fluid">
                  <div class ="row">
                      <div class ="col-md-6 col-sm-6">
                          <h5 class="">` +
            category[i].category_count +
            `</h5>
                        </div>
                        <div class ="col-md-6 col-sm-6 text-center ps-5">                                               
                          <i class="fas fa-2x fa-plus-circle "></i>                                                
                        </div>
                  </div>
              </div>
            </div>
          </div>
      </div></button>`;

          $("#book-card").append(card);
        }
      },
    });
  }

  loadCategoryCard();

  //ending append

  function showBookDetails(data, category_id) {
    console.log("show book details function called");
    $("#book-details-table").empty();
    var table_header = `<thead id="table-head">
                              <tr>
                                  <th class="float-center">SL No.</th>
                                  <th class="float-center">Book Name</th>
                                  <th class="float-center">Writer Name</th>
                                  <th class="float-center">Actions</th>
                              </tr>
                            </thead>`;

    $("#book-details-table").append(table_header);
    for (let i = 0; i < data.length; i++) {
      // if (data[i].category_id !== category_id) {
      //   continue;
      // }
      var content =
        `<tbody>
                        <tr>
                            <th scope="row">` +
        (i + 1) +
        `</th>
                            <td>` +
        data[i].title +
        `</td>
                            <td>` +
        data[i].author_name +
        `</td>
                            <td>
                                <div class="float-center">
                                    <button type="button" class="btn btn-primary badge-pill update-button" style="width: 80px;"id="` +
        i +
        `">Update</button>
                                    <button type="button" class="btn btn-danger badge-pill delete-book-button" style="width: 80px;" id="` +
        data[i].book_id +
        `">Delete</button>
                                </div>
                            </td>
                        </tr>
                      </tbody>`;

      $("#book-details-table").append(content);
    }
    console.log("function end here");
  }

  //update button handle
  $("#book-details-table").on("click", ".update-button", function (e) {
    alert($(this).text());
    var btn_id = $(this).attr("id");
    //console.log($(this).attr("id"));
    //console.log(output[btn_id].title);
    //console.log("****************************************");
  });

  //book delete button
  $("#book-details-table").on("click", ".delete-book-button", function (e) {
    // alert($(this).text());
    var btn_id = $(this).attr("id");
    console.log($(this).attr("id"));
    //console.log($(this).attr("id"));
    //console.log(output[btn_id].title);
    //console.log("****************************************");
    var location = window.location.href;
    var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
    //console.log(directoryPath);
    //receive book data with ajax get request

    var createDeleteUrl = directoryPath + "api/books/" + btn_id;
    console.log(createDeleteUrl);
    $.ajax({
      type: "DELETE",
      url: createDeleteUrl,
      dataType: "json",
      async: true,
      success: function (data, status) {
        // //console.log(data.keys());
        // alert(data["message"]);
        // console.log(data["message"]);
        alert("Delete Successful");

        var dataFetch =
          directoryPath +
          `api/books/?column=category_id&value=` +
          target_category_id;
        $.ajax({
          type: "GET",
          url: dataFetch,
          dataType: "json",
          async: true,
          success: function (data, status) {
            // //console.log(data.keys());

            output = data["message"];
            showBookDetails(output, target_category_id);
          },
          error: function (data) {
            //alert("fail");
          },
        });
      },
      error: function (data) {
        alert("failed");
        //alert("fail");
      },
    });
  });

  //category card click button
  $("#book-card").on("click", ".category-card-click", function (e) {
    // alert($(this).attr("id"));
    // //console.log($(this));
    target_category_id = $(this).attr("id");

    $("#main-body").hide();
    var location = window.location.href;
    var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
    //console.log(directoryPath);
    //receive book data with ajax get request

    // category book api: /api/books/?column=column_name&value=keyword
    var crateUrl =
      directoryPath +
      `api/books/?column=category_id&value=` +
      target_category_id;
    //   directoryPath +
    //   `api/books/?category_id=` +
    //   target_category_id +
    //   `&column=` +
    //   searchBy +
    //   `&value=` +
    //   bookname;

    $.ajax({
      type: "GET",
      url: crateUrl,
      dataType: "json",
      async: true,
      success: function (data, status) {
        // //console.log(data.keys());

        output = data["message"];
        showBookDetails(output, target_category_id);
      },
      error: function (data) {
        //alert("fail");
      },
    });

    $("#book-details").show();
  });

  //toggle button for side bar
  $("#more").click(function () {
    $("#sidebar").toggle();
  });

  //inventory tab click function
  $("#inventory").click(function () {
    $("#inventory").css("background-color", "#2f0410");
    $("#bookissue").css("background-color", "");
    $("#book-details").hide();
    $("#issue-book").hide();
    $("#main-body").show();
    
    loadCategoryCard();
  });


   //issuebook tab click function
   $("#bookissue").click(function () {
    $("#bookissue").css("background-color", "#2f0410");
    $("#inventory").css("background-color", "");
    $("#book-details").hide();
    $("#main-body").hide();
    $("#issue-book").show();

     loadCategoryCard();
  });

  //book search option, search by author and book title
  $("#book-search-input").change(function () {
    var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
    var bookname = $(this).val();
    var searchBy = $("#book-search-dropdown option:selected").val();
    $(this).val("");
    //apt: /api/books/?column=column_name&value=keyword
    //category wise book search api: /api/books/?category_id=?&column=?&value=?
    var crateUrl =
      directoryPath +
      `api/books/?category_id=` +
      target_category_id +
      `&column=` +
      searchBy +
      `&value=` +
      bookname;
    // var crateUrl =
    //   directoryPath +
    //   `api/books/?column=` +
    //   searchBy +
    //   `&value=` +
    //   bookname +
    //   `&like=true`;
    // console.log(crateUrl);

    $.ajax({
      type: "GET",
      url: crateUrl,
      dataType: "json",
      async: true,
      success: function (data, status) {
        output = data["message"];
        showBookDetails(output, target_category_id);
      },
      error: function (data, status) {
        alert("Data not found");
      },
    });

    $("#book-details").show();
  });

  //book dropdown change the placeholder of the input field
  $("#book-search-dropdown").change(function () {
    if ($("#book-search-dropdown option:selected").val() === "title") {
      $("#book-search-input").attr("placeholder", "Enter book title");
    } else {
      $("#book-search-input").attr("placeholder", "Enter author name");
    }
  });
});
