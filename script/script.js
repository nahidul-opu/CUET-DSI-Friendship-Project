$(document).ready(function () {
  $("#inventory").css("background-color", "#2f0410");
  $("#more").click(function () {
    $("#sidebar").toggle();
  });

  $("#inventory").click(function () {
    $("#inventory").css("background-color", "#2f0410");
    $("#book-details").hide();
    $("#main-body").show();
  });

  $("#card-click").click(function (e) {
    e.preventDefault();
    // //alert("clicked");
    // $("#main-body").hide();
    $("#main-body").hide();
    var location = window.location.href;
    var directoryPath = location.substring(0, location.lastIndexOf("/") + 1);
    console.log(directoryPath);
    $.ajax({
      type: "GET",
      url: directoryPath + "api/books/",
      dataType: "json",
      async: true,
      success: function (data, status) {
        // console.log(data.keys());

        var output = data["message"];
        //alert(output);
        console.log(typeof output);
        console.log(output);
        // var content = None;
        $("#book-details-table").empty();
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
                                    <button type="button" id="` +
            i +
            `"class="btn btn-primary badge-pill" style="width: 80px;">Update</button>
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
});
