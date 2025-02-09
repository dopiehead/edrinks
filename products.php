<?php 
require("config.php");

$categories = isset($_GET['categories']) && !empty($_GET['categories']) 
    ? $conn->real_escape_string($_GET['categories']) 
    : '';

    $search = isset($_GET['search']) && !empty($_GET['search']) 
    ? $conn->real_escape_string($_GET['search'])
    : '';



$product_name = isset($_GET['product_name']) && !empty($_GET['product_name']) 
    ? $conn->real_escape_string($_GET['product_name']) 
    : '';
?>

<input type="hidden" id='mylongitude'>
<input type="hidden" id='mylatitude'>

<?php
session_start(); // Start the session to access session variables
function getAddressFromCoordinates($latitude, $longitude) {
    // Replace YOUR_OPENCAGE_API_KEY with your OpenCage API key
     $apiKey = 'a066b39ac06a4ef98fbfe9368f1f8182'; // Replace with your OpenCage API key
     $url = "https://api.opencagedata.com/geocode/v1/json?q=$latitude+$longitude&key=$apiKey&language=en";
    // Suppress errors for file_get_contents and handle them manually
     $response = @file_get_contents($url);
    // Check if the request was successful
     if ($response === FALSE) {
        // return "Error: Unable to retrieve location data.";
    }
    // Decode the JSON response
     $responseData = json_decode($response);
    // Check if the response is valid
    if ($responseData && $responseData->status->code == 200 && isset($responseData->results[0])) {
         // Get the formatted address from the response
         $address = $responseData->results[0]->formatted;
         return $address;
    } else {
         return "Address not found!";
    }
}

// Check if latitude and longitude are set in session
if (isset($_SESSION['latitude']) && isset($_SESSION['longitude'])) {
     $latitude = $_SESSION['latitude'];
     $longitude = $_SESSION['longitude'];
    // Get the address from coordinates
     $address = getAddressFromCoordinates($latitude, $longitude);
     $myaddress =  $address;
     $_SESSION['address'] = $myaddress;

}

?>

<!DOCTYPE html>
<html>
<head>
    <?php include("components/links.php"); ?>
    <link rel="stylesheet" href="assets/css/products.css">
    <link rel="stylesheet" href="assets/css/share-pop.css">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
    <title>Product Display</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: poppins !important;
        }
    </style>
</head>
<body>
    <?php include("components/navbar.php"); ?>

    <div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="input-group">
                <input name='search' id='search' type="text" class="form-control" placeholder="Search drinks..." aria-label="Search" value='<?php if(!empty($search)) :echo($search); endif;?>'>
                <button class="btn btn-outline-primary" id='btn-search' type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>

    <div class="location-indicator text-center mt-3 mb-2">
        <i class="fas fa-map-marker-alt"></i>
        <span><button name='product_location' id='<?php if(isset($myaddress)):echo $myaddress;endif; ?>' type='hidden' class='product_location border-0 bg-white'><?php if(isset($myaddress)): echo $myaddress; endif; ?></button>
    </div>

    <div class="container">
        <!-- Filters Section -->
        <div class="filters-section">
            <div class="d-flex flex-wrap align-items-center">
                <select name="categories" id="categories" class="filter-button">
                    <option  value="">All Categories</option>
                    <option <?php if($categories=='wholesaler' && !empty($categories)){echo "selected";} ?> value="wholesaler">Wholesaler</option>
                    <option <?php if($categories=='importer' && !empty($categories)){echo "selected";} ?> value="importer">Importer</option>
                    <option <?php if($categories=='manufacturer' && !empty($categories)){echo "selected";} ?> value="manufacturer">Manufacturer</option>
                    <option <?php if($categories=='distributor' && !empty($categories)){echo "selected";} ?> value="distributor">Distributor</option>
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

                <select name="brands" id="brands" class="filter-button text-capitalize text-dark">
                    <option value="">All Brand</option>
                    <?php while ($brand = $result->fetch_assoc()) { ?>

                        <option <?php if ($brand['product_name'] === $product_name) echo "selected"; ?> value="<?php echo htmlspecialchars($brand['product_name']); ?>"><?php echo htmlspecialchars($brand['product_name']); ?></option>

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

    <script>
    $(document).ready(function () {
        <?php 
        $categories = isset($categories) ? $categories : '';  
        $search = isset($search) ? $search : '';  
        $product_name = isset($product_name) ? $product_name : '';  
        $myaddress = isset($myaddress) ? $myaddress : '';  
        ?>

        <?php if (!empty($categories) || !empty($search) || !empty($product_name) || !empty($myaddress)) { ?>
 
        if ('<?= htmlspecialchars($categories, ENT_QUOTES, 'UTF-8') ?>' !== '') {
            $('#categories').trigger('change');
        }
        if ('<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>' !== '') {
            $('#btn-search').trigger('click');
        }
        if ('<?= htmlspecialchars($myaddress, ENT_QUOTES, 'UTF-8') ?>' !== '') {
            $('.product_location').trigger('click');
        }
        if ('<?= htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8') ?>' !== '') {
            $('#brands').trigger('change');
        }

        <?php } ?>
    });
</script>

      </script>

 

     <script>

  $(document).ready(function () {
      $('.numbering').load('engine/item-numbering.php');
      $(".product-container").load('fetch-products.php?page=1'); // Load products dynamically

      $("#btn-search").on("click", function (event) {
          event.preventDefault();
          let search = $("#search").val();
          getData(search);
      });

      $("#categories").on("change", function (event) {
          event.preventDefault();
          let search = $("#search").val();
          let categories = $("#categories").val();
          getData(search, categories);
      });

      $("#brands").on("change", function (event) {
          event.preventDefault();
          let search = $("#search").val();
          let brands = $("#brands").val();
          let categories = $("#categories").val();
          getData(search, categories, brands);
      });

      $("#drink_type").on("change", function (event) {
          event.preventDefault();
         let search = $("#search").val();
         let brands = $("#brands").val();
         let categories = $("#categories").val();
         let drink_type = $("#drink_type").val();
          getData(search, categories, brands, drink_type);
      });
     

      $(".product_location").on("click", function (event) {
          event.preventDefault();
         let search = $("#search").val();
         let myaddress = $(".product_location").attr("id");
         let brands = $("#brands").val();
         let categories = $("#categories").val();
         let drink_type = $("#drink_type").val();
          getData(search, categories, brands, drink_type, myaddress);
      });     
      

      $("#price_range").on("change", function (event) {
          event.preventDefault();
         let search = $("#search").val();
         let myaddress = $("#product_location").val();
         let  brands = $("#brands").val();
         let categories = $("#categories").val();
         let drink_type = $("#drink_type").val();
         let price_range = $("#price_range").val();
          getData(search, categories, brands, drink_type, myaddress, price_range);
      });

      $("#sort").on("change", function (event) {
          event.preventDefault();
         let search = $("#search").val();
         let myaddress = $("#product_location").val();
         let brands = $("#brands").val();
         let categories = $("#categories").val();
         let drink_type = $("#drink_type").val();
         let price_range = $("#price_range").val();
         let sort = $("#sort").val();
          getData(search, categories, brands, drink_type, myaddress, price_range, sort);
      });

     $(document).on("click",".btn-success", function (event) {
          event.preventDefault();
         let search = $("#search").val();
         let myaddress = $("#product_location").val();
         let brands = $("#brands").val();
         let categories = $("#categories").val();
         let drink_type = $("#drink_type").val();
         let price_range = $("#price_range").val();
         let sort = $("#sort").val();
         let page = $(this).attr("id");
         getData(search, categories, brands, drink_type, myaddress, price_range, sort ,page);

     });

      function getData(search, categories, brands, drink_type, myaddress, price_range, sort ,page) {   
          
           $(".spinner-border").show();
        
          $.ajax({
              url: "fetch-products.php",
              method: "POST",
              data: {
                  search: search,
                  categories: categories,
                  brands: brands,
                  drink_type: drink_type,
                  product_location:myaddress,
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

<script>
$(document).ready(function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                console.log("Latitude: " + latitude, "Longitude: " + longitude); // Debugging

                // Set the latitude and longitude values to the input fields
                $("#mylatitude").val(latitude);
                $("#mylongitude").val(longitude);

                // Make the AJAX request to send data to the server
                $.ajax({
                    url: "engine/getLocation.php",
                    type: "POST",
                    data: { latitude: latitude, longitude: longitude },
                    success: function (response) {
                        console.log("Server Response:", response); // Debugging

                        if (response == 1) {
                            console.log("Location received successfully.");
                           
                        } else {
                           console.log("Server Response:", response); // Debugging
                        }
                    },
                    error: function (err) {
                        console.error("AJAX Error:", err);
                        swal({
                            title: "Error",
                            icon: "error",
                            text: "An error occurred while sending location data.",
                        });
                    },
                });
            },
            function (error) {
                // Error handling for location failure
                let errorMsg = "";
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        errorMsg = "You denied the request for Geolocation.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMsg = "Location information is unavailable.";
                        break;
                    case error.TIMEOUT:
                        errorMsg = "The request to get user location timed out.";
                        break;
                    case error.UNKNOWN_ERROR:
                        errorMsg = "An unknown error occurred.";
                        break;
                }
                console.warn("Geolocation Error: " + errorMsg);
                swal({
                    title: "Location Error",
                    icon: "warning",
                    text: errorMsg,
                });
            }
        );
    } else {
        console.warn("Geolocation is not supported by this browser.");
        swal({
            title: "Not Supported",
            icon: "info",
            text: "Geolocation is not supported by this browser.",
        });
    }
});
</script>

<script>
         var myaddress = "<?= htmlspecialchars($myaddress); ?>";

</script>
    
</body>
</html>
