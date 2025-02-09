
function add(button) {
  const input = button.parentElement.querySelector('.quantity-input');
  const subtractBtn = button.parentElement.querySelector('#subtractBtn');
  let value = parseInt(input.value);
  value++;
  input.value = value;
  
  // Enable subtract button if value > 1
  if (value > 1) {
      subtractBtn.disabled = false;
  }
}

function subtract(button) {
  const input = button.parentElement.querySelector('.quantity-input');
  let value = parseInt(input.value);
  if (value > 1) {
      value--;
      input.value = value;
      
      // Disable subtract button if value is 1
      if (value === 1) {
          button.disabled = true;
      }
  }
}

function checkValue(input) {
  const subtractBtn = input.parentElement.querySelector('#subtractBtn');
  let value = parseInt(input.value);
  
  // Ensure value is not less than 1
  if (value < 1 || isNaN(value)) {
      input.value = 1;
      value = 1;
  }
  
  // Update subtract button state
  subtractBtn.disabled = value === 1;

}
      
$('.numbering').load('engine/item-numbering.php');


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




