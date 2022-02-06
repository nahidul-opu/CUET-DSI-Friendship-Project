$(document).ready(function () {
  // $("#main-body").html("../test.html");
  $("#main-body").append("../test.html");

  $("#more").click(function () {
    $("#sidebar").toggle();
  });

  $("#inventory").click(function () {
    $("#inventory").css("background-color", "#2f0410");
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
