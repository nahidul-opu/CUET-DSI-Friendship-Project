$(document).ready(function () {
  //global variable for data cache
  var output;
  var target_category_id;
  var directoryPath;

  var location = window.location.href;
  directoryPath = location.substring(0, location.lastIndexOf("/") + 1);

  //inventory tab default color
  $("#inventory").css("background-color", "#2f0410");

  // bishal starting card append

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
                            <button type="button" class="btn btn-success badge-pill issue-book-button" style="width: 80px;" id="` +
        data[i].book_id +
        `">Issue</button>
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

  //issue book button click
  //global variable
  var users_list = [];
  var book;
  $("#book-details-table").on("click", ".issue-book-button", function (e) {
    var btn_id = $(this).attr("id");

    $.ajax({
      type: "GET",
      url: directoryPath + `api/books/` + btn_id,
      dataType: "json",
      async: true,
      success: function (data, status) {
        // //console.log(data.keys());

        book = data["message"][0];
        var book_info =
          `<b>Title:</b> ` +
          book.title +
          `<br><br>
        <b>Author:</b> ` +
          book.author_name +
          `<br><br>
        <b>Publisher:</b> ` +
          book.publisher +
          `<br><br>        
        <b>Published:</b>` +
          book.pub_year +
          `<br><br>
        <b>Available copy:</b> ` +
          book.current_count +
          `<br><br>
        <b>ISBN:</b> ` +
          book.isbn +
          `
        `;
        $("#issue-user-search").val("");
        $("#book-issue-user-info").empty();

        $("#book-issue-book-info").empty();
        $("#book-issue-book-info").append(book_info);
        if (book.current_count > 0) {
          $("#book-avalability").empty();
          $("#book-avalability").append(
            `<h5 class="bg-success mx-5 p-2 rounded">Available</h5>`
          );
        } else {
          $("#book-avalability").empty();
          $("#book-avalability").append(
            `<h5 class="bg-danger mx-5 p-2 rounded">Not available</h5>`
          );
        }

        $("#issue-book-modal").show();
      },
    });

    //retrive userlist to use auto complete issue-user search
    $.ajax({
      type: "GET",
      url: directoryPath + `api/users/`,
      dataType: "json",
      async: true,
      success: function (data, status) {
        var users = data["message"];
        if (users_list.length == 0) {
          for (let i = 0; i < users.length; i++)
            users_list.push(users[i].user_id + ". " + users[i].name);
        }
      },
    });
  });

  //issue book button action
  $("#book-issue-btn").on("click", function () {
    user_id = $("#issue-user-search").val().split(".");
    let data = {
      book_id: "",
      user_id: "",
    };
    var url = directoryPath + "api/borrow";
    data.book_id = book.book_id;
    data.user_id = user_id[0];
    if (data.book_id != "" && data.user_id != "") {
      if (confirm("Confirm book issue?")) {
        $.post(url, JSON.stringify(data), function (msg) {
          $("#result").html(msg);
        });
        $("#issue-book-modal").hide();
      }
    } else {
      alert("please select a user to issue book.");
    }
  });

  //issue book button action
  $("#book-issue-btn").on("click", function () {
    user_id = $("#issue-user-search").val().split(".");
    console.log("-------------print");
    let data = {
      book_id: "",
      user_id: "",
    };
    var url = directoryPath + "api/borrow";
    data.book_id = book.book_id;
    data.user_id = user_id[0];
    if (data.book_id != "" && data.user_id != "") {
      if (confirm("Confirm book issue?")) {
        $.post(url, JSON.stringify(data), function (msg) {
          $("#result").html(msg);
        });
        $("#issue-book-modal").hide();
      }
    } else {
      alert("please select a user to issue book.");
    }
  });

  //update button handle successfully
  $("#book-details-table").on("click", ".update-button", function (e) {
    var btn_id = $(this).attr("id");
    // console.log($(this).attr("id"));
    // console.log(output[btn_id].title);
    // console.log("****************************************");

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
  /*---------------------------book delete button----------------------------------*/
  $("#book-details-table").on("click", ".delete-book-button", function (e) {
    // alert($(this).text());
    var btn_id = $(this).attr("id");
    // console.log($(this).attr("id"));

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
            // console.log("clicked gggg");

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
  /*-------------------------category card click button----------------------------*/
  $("#book-card").on("click", ".category-card-click", function (e) {
    // alert($(this).attr("id"));
    // //console.log($(this));
    target_category_id = $(this).attr("id");

    $("#main-body").hide();
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
  /*-------------------------toggle button for side bar----------------------------*/
  $("#more").click(function () {
    $("#sidebar").toggle();
  });

  /*-----------------------inventory tab click function----------------------------*/
  $("#inventory").click(function () {
    $("#inventory").css("background-color", "#2f0410");
    $("#users").css("background-color", "");
    $("#bookissue").css("background-color", ""); //#2f0410
    $("#history").css("background-color", "");
    $("#dashboard").css("background-color", "");

    $("#book-details").hide();
    $("#history-tab-body").hide();
    $("#issue-book").hide();
    $("#main-body").show();
    loadCategoryCard();
  });

  //issuebook tab click function
  // $("#bookissue").click(function () {
  //   $("#bookissue").css("background-color", "#2f0410");
  //   $("#inventory").css("background-color", "");
  //   $("#book-details").hide();
  //   $("#main-body").hide();
  //   $("#issue-book").show();

  //   loadCategoryCard();
  // });
  //book search option, search by author and book title
  $("#book-search-input").on("keyup", function () {
    console.log($(this).val());
    var bookname = $(this).val();
    var searchBy = $("#book-search-dropdown option:selected").val();
    // $(this).val("");
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
        showBookDetails({}, target_category_id);
      },
    });
  });
  //   loadCategoryCard();
  // });

  //issue user auto complete
  $(document).ready(function () {
    var availableTags = users_list;
    $("#issue-user-search").autocomplete({
      source: availableTags,
    });
  });

  $("#issue-user-search").keypress(function (e) {
    var key = e.which;
    if (key == 13) {
      var s_user = $("#issue-user-search").val();
      console.log(s_user);
      result = s_user.split(".");
      var user_info =
        `
      <b>Name: </b>` +
        result[1] +
        `<br>
      <b>User Id : </b>` +
        result[0] +
        `<br>
      `;
      $("#book-issue-user-info").empty();
      $("#book-issue-user-info").append(user_info);
    }
  });

  $("#issue-user-search").keypress(function (e) {
    var location = window.location.href;
    var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);

    var key = e.which;
    if (key == 13) {
      var s_user = $("#issue-user-search").val();
      console.log(s_user);
      result = s_user.split(".");
      var user_info =
        `
    <b>Name: </b>` +
        result[1] +
        `<br>
    <b>User Id : </b>` +
        result[0] +
        `<br>
    `;
      $("#book-issue-user-info").empty();
      $("#book-issue-user-info").append(user_info);
    }
  });

  ////////////////////

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
      /*alert("submit attempted");*/
      e.preventDefault();
      let data = {
        title: "",
        author_name: "",
        pub_year: "",
        isbn: "",
        total_count: "",
        current_count: "",
        category_id: "",
        publisher: "",
      };

      var url = directoryPath + "api/books";

      console.log(data);

      data.title = $("#mAB-book-name").val();
      data.author_name = $("#mAB-author-name").val();
      data.pub_year = $("#mAB-pub-year").val();
      data.publisher = $("#mAB-publisher").val();
      data.isbn = $("#mAB-isbn").val();
      data.total_count = $("#mAB-total-count").val();
      data.current_count = $("#mAB-total-count").val();
      data.category_id = $("#mAB-category-id").val();

      console.log(JSON.stringify(data));

      $.post(url, JSON.stringify(data), function (msg) {
        // Display the returned data in browser
        $("#result").html(msg);
      });

      $("#add-book-modal").hide();
    });
  });

  /*---------------------------------history tab design-----------------------*/
  function historyTableLoad(data) {
    $("#history-tab-table-body").empty();

    var tableRow;
    for (let i = 0; i < data.length; i++) {
      tableRow =
        `<tr>
                    <td>` +
        (i + 1) +
        `</td>
                    <td>` +
        data[i].user_id +
        `</td>
                    <td>` +
        data[i].name +
        `</td>
                    <td>` +
        data[i].title +
        `</td>
                    <td>` +
        data[i].status +
        `</td>
                    <td>` +
        data[i].issue_date +
        `</td>
                    <td>` +
        data[i].due_date +
        `</td>
                  </tr>`;
      $("#history-tab-table-body").append(tableRow);
    }
  }

  $("#history").on("click", function () {
    $("#inventory").css("background-color", "");
    $("#users").css("background-color", "");
    $("#bookissue").css("background-color", ""); //#2f0410
    $("#history").css("background-color", "#2f0410");
    $("#dashboard").css("background-color", "");

    $("#book-details").hide();
    $("#main-body").hide();
    $("#issue-book").hide();
    $("#history-tab-body").show();

    //history fetch api:
    var fetchHistoryUrl = directoryPath + "api/borrow";
    console.log(fetchHistoryUrl);
    $.ajax({
      type: "GET",
      url: fetchHistoryUrl,
      dataType: "json",
      async: true,
      success: function (data, status) {
        console.log(data);
        console.log(data[0].book_id);
        historyTableLoad(data);
      },
      error: function (data) {
        //alert("fail");
      },
    });
  });

  $("#history-search-dropdown").change(function () {
    if ($("#history-search-dropdown option:selected").val() === "title") {
      $("#history-search-input").attr("placeholder", "Enter book title");
    } else {
      $("#history-search-input").attr("placeholder", "Enter user name");
    }
  });

  $("#history-search-input").on("keyup", function () {
    console.log($(this).val());
    var searchValue = $(this).val();

    var dataFetchUrl = "";
    directoryPath +
      $.ajax({
        type: "GET",
        url: dataFetchUrl,
        dataType: "json",
        async: true,
        success: function (data, status) {
          output = data["message"];
          showBookDetails(output, target_category_id);
        },
        error: function (data, status) {
          console.log(data);
        },
      });
  });
});
