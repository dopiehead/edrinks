
    <div class="why-choose-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Content Column -->
                <div class="col-md-6">
                    <h1 class="section-title">Why Choose DrinkHub?</h1>
                    <p class="section-description">
                        Discover new drinks, share your favorites, and connect with other drink lovers.
                    </p>
                    <button id='about-button' href='about-us.php' class="learn-more-btn">Learn More</button>
                </div>
                
                <!-- Image Column -->
                <div class="col-md-6">
                    <div class="image-container">
                        <img src="assets/images/background/four-friends.png" alt="Friends enjoying drinks" class="feature-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
   <script>

        $(document).ready(function(){
            // When learn more button is clicked, open about page.
           $("#about-button").click(function(){
               var about_page = $(this).attr("href");
               window.location.href = about_page;
       

           });


        });


   </script>