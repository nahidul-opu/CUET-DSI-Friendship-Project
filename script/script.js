$(document).ready(function () {
  var output;
  var target_category_id;

  //inventory tab default color
  $("#inventory").css("background-color", "#2f0410");

  // bishal starting card append
  var location = window.location.href;
  var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
  //console.log(directoryPath);
  $.ajax({
    type: "GET",
    url: directoryPath + "api/category/",
    dataType: "json",
    async: true,
    success: function (data, status) {
      // //console.log(data.keys());

      var category = data["message"];
      for (let i = 0; i < category.length; i++) {
        var card =
          `<button class="category-card-click m-3" id="` +
          category[i].category_id +
          `"><div class="col-lg-4">
              <div class="card h-90" style="width:280px;height:220px;margin:0;padding:0;">
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
  //ending append

  //update button handle successfully
  $("#book-details-table").on("click", ".update-button", function (e) {
    alert($(this));
    var btn_id = $(this).attr("id");
    //console.log($(this).attr("id"));
    //console.log(output[btn_id].title);
    //console.log("****************************************");
  });

  $("#book-card").on("click", ".category-card-click", function (e) {
    // alert($(this).attr("id"));
    // //console.log($(this));
    target_category_id = $(this).attr("id");

    $("#main-body").hide();
    var location = window.location.href;
    var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
    //console.log(directoryPath);
    //receive book data with ajax get request
    $.ajax({
      type: "GET",
      url: directoryPath + "api/books/",
      dataType: "json",
      async: true,
      success: function (data, status) {
        // //console.log(data.keys());

        output = data["message"];
        //alert(output);
        //console.log(typeof output);
        //console.log(output);
        // var content = None;
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
        for (let i = 0; i < output.length; i++) {
          //console.log("###########################");
          //console.log(output[i].category_id);
          //console.log(target_category_id);
          if (output[i].category_id !== target_category_id) {
            continue;
          }
          //console.log(output[i].author_name);
          var content =
            `<tbody>
                        <tr>
                            <th scope="row">` +
            i +
            `</th>
                            <td>` +
            output[i].title +
            `</td>
                            <td>` +
            output[i].author_name +
            `</td>
                            <td>
                                <div class="float-center">
                                    <button type="button" class="btn btn-primary badge-pill update-button" style="width: 80px;"id="` +
            i +
            `">Update</button>
                                    <button type="button" class="btn btn-danger badge-pill" style="width: 80px;">Delete</button>
                                </div>
                            </td>
                        </tr>
                      </tbody>`;

          $("#book-details-table").append(content);
        }
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
  });

  $("#book-search-input").change(function () {
    // alert("The text has been changed.");
    // alert($(this).val());
    // alert($("#book-search-dropdown option:selected").val());
    // alert($("#book-search-dropdown").text());
    //console.log($(this).val());
    var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
    var bookname = $(this).val();
    var searchBy = $("#book-search-dropdown option:selected").val();
    $(this).val("");
    //apt: /api/books/?column=column_name&value=keyword
    var crateUrl =
      directoryPath +
      `api/books/?column=` +
      searchBy +
      `&value='` +
      bookname +
      `'`;
    //console.log(crateUrl);

    $.ajax({
      type: "GET",
      url: crateUrl,
      dataType: "json",
      async: true,
      success: function (data, status) {
        // //console.log(data.keys());
        // alert(status);
        //console.log("----------------------------------------------------");
        //console.log(data);
        output = data["message"];
        //alert(output);
        //console.log(typeof output);
        //console.log(output);
        // var content = None;
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
        for (let i = 0; i < output.length; i++) {
          //console.log()
          if (output[i].category_id !== target_category_id) {
            continue;
          }
          ////console.log(output[i].author_name);
          var content =
            `<tbody>
                        <tr>
                            <th scope="row">` +
            i +
            `</th>
                            <td>` +
            output[i].title +
            `</td>
                            <td>` +
            output[i].author_name +
            `</td>
                            <td>
                                <div class="float-center">
                                    <button type="button" class="btn btn-primary badge-pill update-button" style="width: 80px;"id="` +
            i +
            `">Update</button>
                                    <button type="button" class="btn btn-danger badge-pill" style="width: 80px;">Delete</button>
                                </div>
                            </td>
                        </tr>
                      </tbody>`;

          $("#book-details-table").append(content);
        }
      },
      error: function (data, status) {
        alert("Data not found");
      },
    });

    $("#book-details").show();
  });

  $("#book-search-dropdown").change(function () {
    if ($("#book-search-dropdown option:selected").val() === "title") {
      $("#book-search-input").attr("placeholder", "Enter book title");
    } else {
      $("#book-search-input").attr("placeholder", "Enter author name");
    }
  });

  // $("#book-search-btn").click(function () {
  //   alert($("#book-search-input").val());
  // });
});
