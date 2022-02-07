const card = document.getElementById("book-category");




for (let i = 0; i<1;i++){
    // card_text += card_text;
}
window.onload = function() {
    const myElement = document.getElementById("book-category");
    
    for (let i = 0; i<1;i++){
        const card_text = `<!-- a single card -->
        <div class="row" id="book-card">
            <div class="col-lg-4">
                <div class="card">
                    <!-- <div class="card-header">header</div> -->
                    <div class="card-body py-4">
                        <h4 class="card-title text-center">Category ${i}</h4>
                    </div>
                    <div class="card-footer">
                        <div class ="container-fluid">
                            <div class ="row">
                                <div class ="col-md-6 col-sm-6">
                                    <h5 class="">50/30</h5>
                                </div>
                                <div class ="col-md-6 col-sm-6 text-center ps-5">                                               
                                    <i class="fas fa-2x fa-plus-circle "></i>                                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- a single card -->
        `
        //myElement.innerHTML += card_text; 
    }
}

