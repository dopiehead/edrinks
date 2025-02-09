
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6 order-lg-2">
                    <img src="assets/images/background/hero.png" alt="Collection of drinks" class="hero-image">
                </div>

                <div class="col-lg-6 order-lg-1 text-center text-lg-start">
                    <h1 class="hero-title mb-4">
                        Buy and Sell Your<br>
                        Favorite Drinks
                    </h1>
                    <p class="hero-subtitle mb-4">
                        Explore a wide variety of drinks from around the world. Join our community of drink enthusiasts.
                    </p>
                    <div class="search-container mb-4">
                        <div class="position-relative">
                             <i class="bi bi-search search-icon"></i>
                             <input type="text" name='q' class="form-control search-input " id='q' placeholder="    Search a kind of drink">
                        
                        </div>

                             <div id="results" class='bg-white w-100 d-flex justify-content-center flex-row flex-column'></div>
                    </div>
                </div>
 
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
         $("#q").on("keyup", function(e){
             e.preventDefault();      
             var x = $(this).val();
             $.ajax({
                type: "GET",
                url: "engine/search.php",
                data: {q:x},
                success: function(data){
                     $("#results").html(data);
                }

             }); 
            


         });



    </script>
</body>
</html>