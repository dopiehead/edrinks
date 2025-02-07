
    <div class="featured-section">
        <div class="container">
            <!-- Hero Image -->
            <div class="row">
                <div class="col-md-4">
                    <img src="assets/images/cropped/dark-spirit.jpg" alt="Dark Spirit" class="hero-image">
                </div>
                
                <!-- Top Brands -->
                <div class="col-md-8">
                    <h2 class="section-title">Top brands in e-drink</h2>
                    <div class="brand-grid">
                        <div class="brand-item">
                            <img src="assets/images/cropped/hennessy.png" alt="Hennessey">
                            <div class="brand-name"><a class='text-white  text-decoration-none' href='products.php?product_name=hennessy&&category=alcoholic'>Hennessey</a></div>
                        </div>
                        <div class="brand-item">
                            <img src="assets/images/cropped/pepsi.jpg" alt="Pepsi">
                            <div class="brand-name"><a class='text-white  text-decoration-none' href='products.php?product_name=pepsi&&category=non-alcoholic'>Pepsi</a></div>
                        </div>
                        <div class="brand-item">
                            <img src="assets/images/cropped/trophy.jpg" alt="Trophy">
                            <div class="brand-name"><a class='text-white  text-decoration-none' href='products.php?product_name=trophy&&category=alcoholic'>Trophy</a></div>
                        </div>
                        <div class="brand-item">
                            <img src="assets/images/cropped/cocktail.png" alt="Slurt">
                            <div class="brand-name"><a class='text-white  text-decoration-none' href='products.php?product_name=slurt&&category=non-alcoholic'>Slurt</a></div>
                        </div>
                        <div class="brand-item">
                            <img src="assets/images/cropped/coca-cola.jpg" alt="Coca-Cola">
                            <div class="brand-name"><a class='text-white text-decoration-none' href='products.php?product_name=trophy&&category=non-alcoholic'>Coca-cola</a></div>
                        </div>
                        <div class="brand-item">
                            <img src="assets/images/cropped/guiness.png" alt="Guinness">
                            <div class="brand-name"><a class='text-white  text-decoration-none' href='products.php?product_name=guiness&&categorye=alcoholic'>Guiness</a></div>
                        </div>
                        <div class="brand-item">
                            <img src="assets/images/cropped/johnnie-walker.png" alt="Johnny walker">
                            <div class="brand-name"><a class='text-white text-decoration-none' href='products.php?product_name=johnny walker&&category=alcoholic'>Johnny Walker</a></div>
                        </div>
                        <div class="brand-item">
                            <img src="assets/images/cropped/monster-energy.png" alt="Monster">
                            <div class="brand-name"><a class='text-white text-decoration-none' href='products.php?product_name=monster&&category=alcoholic'>Monster</a></div>
                        </div>
                    </div>
                    <div class="see-more">see more</div>
                </div>
            </div>

            <!-- Today's Deals -->
            <div class="deals-container">
                <h2 class="section-title">Today's deals</h2>
                <p class="mb-4">Best price and deals you will ever see today</p>
                
                <div class="row">
                    <?php 
                    require("config.php");
                    $getdeals = $conn->prepare("SELECT * FROM products WHERE product_discount > 0"); 
                    $getdeals->execute();
                    $dealer = $getdeals->get_result();
                    while($deals = $dealer->fetch_assoc()){
                        $discount = (($deals['product_discount'])/100 * ($deals['product_price']));
                        $product_discount =  ($deals['product_price'] - $discount);
                        $product_quantity = $deals['product_quantity'];
                    ?>
                    <div class="col-md-3">
                        <div class="deal-card">
                            <div class="badge bg-primary position-absolute"><i class='fas fa-naira-sign'></i> <?php echo htmlspecialchars(($product_discount*$product_quantity)); ?></div>
                            <img src="<?php echo htmlspecialchars($deals['product_image']); ?>" alt="Burger Deal" class="deal-image">
                            <h5 class='text-capitalize'><?php echo htmlspecialchars($deals['product_name']); ?></h5>
                            <ul class="list-unstyled">
                                <li>• <?php echo htmlspecialchars($deals['product_quantity']); ?></li>
                            </ul>
                            <div class="deal-price"><?php echo htmlspecialchars(($deals['product_price'])* ($product_quantity)); ?></div>
                        </div>
                    </div>
                  <?php  }  ?>

    <!-- Repeat for other deals -->
                </div>
            </div>

            <!-- Location Section -->
            <div class="location-section">
                <h4>Do you want to get a single drink? Enter your address to know what's near you</h4>
                <div class="location-input mt-4">
                    <div class="input-group">
                        <input type="text" name='location' id='location' class="form-control" placeholder="What's your address?">
                        <button name='btn-location' id='btn-location' class="btn btn-primary"><span class='spinner-border text-warning'></span><span class='location_note'>Use current location</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
  $(document).ready(function() {  
      $(".spinner-border").hide();          
      $(document).on("click", "#btn-location", function(e) {
          e.preventDefault();
          $(".spinner-border").show();
          $(".location_note").hide();
          $("#btn-location").prop("disabled", true);

          var location = $("#location").val().trim();

          if (location !== "") {  
              $.ajax({
                  url: "engine/get_location.php",
                  type: "POST",
                  data: { location: location }, // Corrected data format
                  success: function(response) {  
                      $(".spinner-border").hide(); 
                      $(".location_note").show();
                      $("#btn-location").prop("disabled", false);

                      if (response == "1") {
                          window.location.href = 'products.php?product_location=' + encodeURIComponent(location);
                      } else {
                          swal({
                              title: "Notice",
                              text: "Unable to find location",
                              icon: "warning",
                              button: "Try again"
                          });
                      }
                  },
                  error: function() {
                      $(".spinner-border").hide(); 
                      $("#btn-location").prop("disabled", false);
                      swal({
                          title: "Error",
                          text: "Something went wrong. Please try again.",
                          icon: "error",
                          button: "OK"
                      });
                      $(".location_note").show();
                  }
              });
          } else {
              swal({
                  title: "Input Required",
                  text: "Please enter a location before proceeding.",
                  icon: "info",
                  button: "OK"
              });
              $("#btn-location").prop("disabled", false);
              $(".spinner-border").hide();
              $(".location_note").show();
          }
      });
  });
</script>

