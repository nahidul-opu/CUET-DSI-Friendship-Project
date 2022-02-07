$(document).ready(function () {
  // $("#main-body").html("../test.html");

  $("#more").click(function () {
    $("#sidebar").toggle();
  });

  $("#inventory").click(function () {
    $("#inventory").css("background-color", "#2f0410");
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
                                    <button type="button" class="btn btn-primary badge-pill" style="width: 80px;">Update</button>
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

var total_cards = 3;

card_title = ["Fiction", "Sci-fi", "Engineering"];

console.log(total_cards);

for (var i = 0; i < total_cards; i++) {
  /*html = '<div class="card" style="width: 18rem;"><div class="card-body"><h5 class="card-title">'+ card_title[i]+ '</h5><p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p><a href="#" class="btn btn-primary">Go somewhere</a></div></div>';
    
    
     $("#grid").append(html);*/
  /*    $("#grid").append('<div class="card" style="width: 18rem;"><div class="card-body"><h5 class="card-title">Card title</h5><p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p><a href="#" class="btn btn-primary">Go somewhere</a></div></div>');*/
}
/*

$("#add-card").click(function(){
    $("#grid").append('<div class="card" style="width: 18rem;"><div class="card-body"><h5 class="card-title">New Card</h5><p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p><a href="#" class="btn btn-primary">Go somewhere</a></div></div>');
    
})


$("#edit-card").click(function(){
    
})
*/
