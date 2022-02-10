$(document).ready(function () {
  //global variable for data cache
  var output;
  var target_category_id;
  var directoryPath;

  //inventory tab default color
  $("#inventory").css("background-color", "#2f0410");

  // bishal starting card append
  var location = window.location.href;
  directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
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
    // console.log("show book details function called");
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
    // console.log("function end here");
  }
  // console.log("function end here");



  function show_user(data, category_id) {

    $("#user-details").empty();
    var table_header = `<thead id="table-head">
                              <tr>
                                  <th class="float-center">User ID</th>
                                  <th class="float-center">Email</th>
                                  <th class="float-center">Name</th>
                                  <th class="float-center">Borrowed Books</th>
                                  <th class="float-center">Contact No</th>
                                  <th class="float-center">Image Path</th>
                                  <th class="float-center">Fine</th>
                                  <th class="float-center">Created At</th>
                                  <th class="float-center">Updated At</th>
                                  <th class="float-center">Actions</th>
                              </tr>
                            </thead>`;

    $("#user-details").append(table_header);
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
        data[i].user_id +
        `</td>
                            <td>` +
        data[i].email +
        `</td>
                            <td>` +
        data[i].name +
        `</td>
                            <td>` +
        data[i].borrow_count +
        `</td>
                            <td>` +
        data[i].contact_no +
        `</td>
                            <td>` +
        data[i].fine +
        `</td>
                            <td>` +
        data[i].created_at +
        `</td>
                           <td>` +
        data[i].updated_at +
        `</td>
                            <td>
                                <div class="float-center">
                                    <button type="button" class="btn btn-primary badge-pill update-button" style="width: 80px;"id="` +
        i +
        `">Update</button>
                                    <button type="button" class="btn btn-danger badge-pill delete-book-button" style="width: 80px;" id="` +
        data[i].user_id +
        `">Delete</button>
                                </div>
                            </td>
                        </tr>
                      </tbody>`;

      $("#user-details").append(content);
    }
    // console.log("function end here");
  }

  //update button handle successfully
  $("#book-details-table").on("click", ".update-button", function (e) {
    /*alert($(this));*/
    var btn_id = $(this).attr("id");
    console.log($(this).attr("id"));
    console.log(output[btn_id].title);
    console.log("****************************************");

    $("#edit-book-modal").show();

    $("#book-name").attr("value", output[btn_id].title);
    $("#auth-name").attr("value", output[btn_id].author_name);
    $("#pub-year").attr("value", output[btn_id].pub_year);
    $("#pub").attr("value", output[btn_id].publisher);
    $("#isbn").attr("value", output[btn_id].isbn);
    $("#total").attr("value", output[btn_id].total_count);

    $("#edit-book-form").submit(function (e) {
      //          alert("form submitted");
      /*alert($("#book-name").val());*/
      output[btn_id].title = $("#book-name").val();
      output[btn_id].author_name = $("#auth-name").val();
      output[btn_id].pub_year = $("#pub-year").val();
      output[btn_id].publisher = $("#pub-year").val();
      output[btn_id].isbn = $("#isbn").val();
      output[btn_id].total_count = $("#total").val();

      var url = "api/books/" + output[btn_id]["book_id"];
      console.log(url);
      e.preventDefault();

      console.log(output[btn_id]);

      $.ajax({
        url: url,
        type: "PUT",
        dataType: "json",
        data: JSON.stringify(output[btn_id]),
        success: function (data, textStatus, xhr) {
          showBookDetails(output);
          console.log(data);
        },
        error: function (xhr, textStatus, errorThrown) {
          console.log("Error in Operation");
        },
      });

      $("#edit-book-modal").hide();
    });
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

    var createDeleteUrl = directoryPath + "api/books/" + btn_id;

    $("#delete-confirm").show();

    $("#delete-confirm").on("click", "button", function () {
      var deleteStatus = $(this).attr("id");
      // console.log($(this).attr("id"));
      if (deleteStatus === "cancel") {
        $("#delete-confirm").hide();
      }

      if (deleteStatus === "confirm") {
        $("#delete-confirm").hide();

        var dataFetch =
          directoryPath +
          `api/books/?column=category_id&value=` +
          target_category_id;
        $.ajax({
          type: "DELETE",
          url: createDeleteUrl,
          dataType: "json",
          async: true,
          success: function (data, status) {
            console.log("clicked gggg");

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
      }
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
    $("#book-details").hide();
    $("#main-body").show();
    loadCategoryCard();
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

//user tab click function
$("#users").click(function () {
  $("#users").css("background-color", "#2f0410");
  $("#inventory").css("background-color", "");
  $("#user-details").hide();
  $("#main-body").hide();
  $("#users").show();

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

  //book dropdown change the placeholder of the input field
  $("#book-search-dropdown").change(function () {
    if ($("#book-search-dropdown option:selected").val() === "title") {
      $("#book-search-input").attr("placeholder", "Enter book title");
    } else {
      $("#book-search-input").attr("placeholder", "Enter author name");
    }
  });

  /* -------------------------------happy wednesday---------------------------*/
  /* -------------------------------happy wednesday---------------------------*/

  $("#book-details").on("click", "#float-button", function (ev) {
    /* alert("float button clicked");*/
    $("#add-book-modal").show();
    ev.preventDefault();

    $("#add-book-form").submit(function (e) {
      alert("submit attempted");
      e.preventDefault();
      let data = {
        title: "",
        author_name: "",
        pub_year: "",
        isbn: "",
        total_count: "",
        current_count: "",
        category: "",
        publisher: "",
      };

      var url = directoryPath + "api/books";

      data.title = $("#book-name").val();
      data.author_name = $("#auth-name").val();
      data.pub_year = $("#pub-year").val();
      data.publisher = $("#pub").val();
      data.isbn = $("#isbn").val();
      data.total_count = $("#total").val();
      data.current_count = $("#cur_count").val();
      data.category = $("#category").val();
      console.log(data);
      console.log(JSON.stringify(data));

      $.post(url, JSON.stringify(data), function (msg) {
        // Display the returned data in browser
        $("#result").html(msg);
      });
    });
  });
});
