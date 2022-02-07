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
    // alert("clicked");
    // $("#main-body").hide();
    $("#main-body").hide();

    $.ajax({
      type: "GET",
      url: "/CUET-DSI-Friendship-Project/api/books",
      dataType: "text",
      async: true,
      success: function (data, status) {
        var output = data;
        alert(output);
        console.log(typeof data);
        console.log(data);
        for (let i = 0; i < data.length; i++) {
          console.log(data[i]);
        }
        var content = `<tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>The Poet</td>
                            <td>Michael Cornelly</td>
                            <td>
                                <div class="float-center">
                                    <button type="button" class="btn btn-primary badge-pill" style="width: 80px;">Update</button>
                                    <button type="button" class="btn btn-danger badge-pill" style="width: 80px;">Delete</button>
                                </div>
                            </td>
                        </tr>
                      </tbody>`;

        // $("#table-head").append();
      },
      error: function (data) {
        alert("fail");
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
