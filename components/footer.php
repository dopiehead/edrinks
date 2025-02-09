


    <footer class="footer text-white">
        <div class="container">
            <div class="row">
                <!-- Logo and Social Links -->
                <div class="col-md-3 footer-column">
                    <a href="#" class="footer-logo mb-3 d-inline-block">e-Drink</a>
                    <ul class="social-links mt-3">
                        <li><a class='text-white' href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a class='text-white' href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a class='text-white' href="#"><i class="fab fa-x-twitter"></i></a></li>
                    </ul>
                </div>

                <!-- Company Links -->
                <div class="col-md-2 footer-column">
                    <h3 class="footer-heading">Company</h3>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div class="col-md-2 footer-column">
                    <h3 class="footer-heading">Support</h3>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-md-5 footer-column">
                    <h3 class="footer-heading">Subscribe to our newsletter</h3>
                    <p class="text-light">Stay updated with the latest drink trends and offers</p>
                    <div class="input-group mb-3">
                                                
                         <input type="email" id="newsletter-email" class="form-control newsletter-input" placeholder="Email address">
                         <button class="newsletter-button" class="newsletter-button" type="button"><span class='spinner-border text-warning'></span> <span class='subscribe-note'>Subscribe</span></button>
                       
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script>
        $(document).ready(function(){
         $(".spinner-border").hide();
         $(document).on("click", ".newsletter-button ",function(event){
            $(".spinner-border").show();
            $(".subscribe-note").hide();
             event.preventDefault();
             var email = $("#newsletter-email").val();   
             if(email === ""){
                 swal({
                         title:"Notice",
                         icon:"warning",
                         text:"Please enter an email address",

                 });
                 return;
             }      
             $.ajax({
                 url: "engine/subscribe.php",
                 method: "POST",
                 data: {email: email},
                 success: function(response){
                     $(".spinner-border").hide();
                     $(".subscribe-note").show();
                     if(response === "1"){
                         swal({
                             title:"Success",
                             icon:"success",
                             text:"You have successfully subscribed to our newsletter"
                         });
                     
                     }
                     
                     else{
                          swal({
                              title:"Notice",
                              icon:"warning",
                              text:response
                         });

                         
                     }
                 }

                 error: function(jqXHR, textStatus, errorThrown){
                     $(".spinner-border").hide();
                     $(".subscribe-note").show();
                     console.log(errorThrown);
                 }
             });
         });

        });

    </script>
