$(document).ready(function () {
  var output;
  //inventory tab default color
  $("#inventory").css("background-color", "#2f0410");
  $("#more").click(function () {
    $("#sidebar").toggle();
  });
  //inventory tab click function
  $("#inventory").click(function () {
    $("#inventory").css("background-color", "#2f0410");
    $("#book-details").hide();
    $("#main-body").show();
  });

  //update-button function
  function x() {
    // $(this).prop("disabled",true);
    console.log(this);
  }

  //card click function
  $("#card-click").click(function (e) {
    e.preventDefault();
    // //alert("clicked");
    // $("#main-body").hide();
    $("#main-body").hide();
    var location = window.location.href;
    var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
    console.log(directoryPath);
    //receive book data with ajax get request
    $.ajax({
      type: "GET",
      url: directoryPath + "api/books/",
      dataType: "json",
      async: true,
      success: function (data, status) {
        // console.log(data.keys());

        output = data["message"];
        //alert(output);
        console.log(typeof output);
        console.log(output);
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
          console.log(output[i].author_name);
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

  //update button handle successfully
  $("#book-details-table").on("click", ".update-button", function (e) {
    alert($(this));
    var btn_id = $(this).attr("id");
    console.log($(this).attr("id"));
    console.log(output[btn_id].title);
    console.log("****************************************");
  });
});
