<?php 
       require("config.php");
      if(isset($_GET['search']) && !empty($_GET['search'])){
          
             $search =  base64_decode($conn->real_escape_string($_GET['search']));
     } else {

         $search = ''; // Default search query if no search parameter is provided
     } ?>

<!DOCTYPE html>
<html>
<head>
    <?php include("components/links.php"); ?>
    <link rel="stylesheet" href="assets/css/products.css">
    <title>Product Display</title>
</head>
<body>
    <?php include("components/navbar.php"); ?>

    <div class="location-indicator text-center mt-3 mb-2">
        <i class="fas fa-map-marker-alt"></i>
        <span>Your current location</span>
    </div>

    <div class="container">
        <!-- Filters Section -->
        <div class="filters-section">
            <div class="d-flex flex-wrap align-items-center">
                <select name="categories" id="categories" class="filter-button">
                    <option  value="">All Categories</option>
                    <option <?php if($search=='wholesaler' && !empty($search)){echo "selected";} ?> value="wholesaler">Wholesaler</option>
                    <option <?php if($search=='importer' && !empty($search)){echo "selected";} ?> value="importer">Importer</option>
                    <option <?php if($search=='manufacturer' && !empty($search)){echo "selected";} ?> value="manufacturer">Manufacturer</option>
                    <option <?php if($search=='distributor' && !empty($search)){echo "selected";} ?> value="distributor">Distributor</option>
                </select>

                <select name="price_range" id="price_range" class="filter-button">
                <option value=""><i class="fa fa-naira-sign"></i>Any amount</option>
                    <option value="10000-50000">Less than <i class="fa fa-naira-sign"></i>50000</option>
                    <option value="50000-100000">Less than <i class="fa fa-naira-sign"></i>100000</option>
                    <option value="100000-500000">Less than <i class="fa fa-naira-sign"></i>500000</option>
                    <option value="500000-1000000">Less than <i class="fa fa-naira-sign"></i>1000000</option>
                </select>

                <?php  
                  
                    $get_drink = $conn->prepare("SELECT COUNT(*) AS count, product_name FROM products GROUP BY product_name");
                    $get_drink->execute();
                    $result = $get_drink->get_result();

                ?>

                <select name="brands" id="brands" class="filter-button text-capitalize">
                    <option value="">All Brand</option>
                    <?php while ($brand = $result->fetch_assoc()) { ?>
                        <option value="<?php echo htmlspecialchars($brand['product_name']); ?>">
                            <?php echo htmlspecialchars($brand['product_name']) . " <span class='text-secondary text-sm'>(" . htmlspecialchars($brand['count']) . ")</span>"; ?>
                        </option>
                    <?php } ?>
                </select>

                <select name="drink_type" id="drink_type" class="filter-button">
                   
                     <option value="">All Drinks</option>
                     <option value="alcoholic">Alcoholic</option>
                     <option value="non-alcoholic">Non-alcoholic</option>  

                </select>


                <select name="sort" id="sort" class="filter-button">
                     <option value="">All prices</option>
                     <option value="highest">Highest price - Lowest price</option>
                     <option value="lowest">Lowest price - Highest price</option>
                     <option value="recent">Recently added</option>  
                     <option value="views">Most viewed</option>
                     <option value="ratings">Highest rating</option>

               </select>

                <span class="ms-auto items-count"></span>
            </div>
        </div>

        <!-- Product Container -->
        <div class="product-container">
            
            <!-- Products will be dynamically loaded here -->
             <div class="loading-spinner text-center mt-5 d-flex flex-row flex-column gap-1">
              
                     <span class="spinner-border text-warning" role="status"></span>
                     <span class="sr-only">Loading...</span>
              
             </div>
        
        </div>
    </div>

    <?php include 'components/footer.php'; ?>



    <?php 
         if ($search!='') { ?>
             <script>
                 $(document).ready(function(){
                     $('#categories').children('option').each(function(){
                          if($(this).is(':selected')){
                              $(this).trigger('change');   
                          }
                     });
                 });
             </script>
     <?php } ?>

     <script>

  $(document).ready(function () {
      $('.numbering').load('engine/item-numbering.php');
      $(".product-container").load('fetch-products.php?page=1'); // Load products dynamically

      $("#categories").on("change", function (event) {
          event.preventDefault();
          let categories = $("#categories").val();
          getData(categories);
      });

      $("#brands").on("change", function (event) {
          event.preventDefault();
          let brands = $("#brands").val();
          let categories = $("#categories").val();
          getData(categories, brands);
      });

      $("#drink_type").on("change", function (event) {
          event.preventDefault();
         let brands = $("#brands").val();
         let categories = $("#categories").val();
         let drink_type = $("#drink_type").val();
          getData(categories, brands, drink_type);
      });

      $("#price_range").on("change", function (event) {
          event.preventDefault();
         let  brands = $("#brands").val();
         let categories = $("#categories").val();
         let drink_type = $("#drink_type").val();
         let price_range = $("#price_range").val();
          getData( categories, brands, drink_type, price_range);
      });

      $("#sort").on("change", function (event) {
          event.preventDefault();
         let brands = $("#brands").val();
         let categories = $("#categories").val();
         let drink_type = $("#drink_type").val();
         let price_range = $("#price_range").val();
         let sort = $("#sort").val();
          getData(categories, brands, drink_type, price_range, sort);
      });

     $(document).on("click",".btn-success", function (event) {
          event.preventDefault();
         let brands = $("#brands").val();
         let categories = $("#categories").val();
         let drink_type = $("#drink_type").val();
         let price_range = $("#price_range").val();
         let sort = $("#sort").val();
         let page = $(this).attr("id");
         getData(categories, brands, drink_type, price_range, sort ,page);

     });

      function getData(categories, brands, drink_type, price_range, sort ,page) {   
          
           $(".spinner-border").show();
        
          $.ajax({
              url: "fetch-products.php",
              method: "POST",
              data: {
                  categories: categories,
                  brands: brands,
                  drink_type: drink_type,
                  price_range: price_range,
                  sort: sort,
                  page:page
              },
              success: function (data) {

                $(".spinner-border").hide();

             if(data){

                  $(".product-container").html(data);
                 

             }

              else{
                  $(".product-container").html("<p>No products found.</p>");
                 
                  $(".items-count").text("0 items");
              }

            }
          });
      }
  });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> 

    
</body>
</html>
