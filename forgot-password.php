<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Forgot Password</title>
    <link rel="stylesheet" href="assets/css/forgot-password.css">

    <?php include ("components/links.php"); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>

    <div class="card">
   
        <a class='position-absolute top-0 left-0 mt-2 text-warning' onclick='history.go(-1)'><i class='fa fa-arrow-left fa-1x'></i></a>
  
        <h2 class='fw-bold mt-2 mb-4'>Forgot Password</h2>
        <form id="forgotPasswordForm">
             <div class='mb-3'>
                 <select name='user_type' id="user_type" class="form-control"  required>
                     <option value="">Select your role</option>
                     <option value="Customer">Customer</option>
                     <option value="Importer">Importer</option>
                     <option value="Retailer">Retailer</option>
                     <option value="Distributor">Distributor</option>
                     <option value="Wholesaler">Wholesaler</option>
                     <option value="Admin">Admin</option>
                  </select>
             </div>

            <div class="mb-3">               
                 <input name='email' type="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn btn-custom btn-primary text-white w-100"><span class='spinner-border text-warning'></span><span class='reset-note'>Reset Password</span></button>
            <div id="message" class="message"></div>
        </form>
    </div>
    <script>
    $(document).ready(function () {
    $(".spinner-border").hide(); // Hide spinner initially

    $("#forgotPasswordForm").submit(function (event) {
        event.preventDefault();
        $(".spinner-border").show(); // Show spinner on submit
        $(".reset-note").hide();
        $('.btn-custom').prop('disabled', true); // Disable button to prevent spam
      
        var formData = $(this).serialize(); // Serialize form inputs

        $.ajax({
            type: "POST",
            url: "engine/forgot-password-process.php",
            data: formData,
            dataType: "json",
            success: function (response) {
              
                $(".spinner-border").hide();
                $(".reset-note").show();
                $('.btn-custom').prop('disabled', false);

                if (response.status === "success") {
                    $("#message").html('<span class="text-success">' + response.message + '</span>').fadeIn();
                } else {
                    $("#message").html('<span class="text-danger">' + (response.message || "An unexpected error occurred.") + '</span>').fadeIn();
                }
            },
            error: function (xhr, status, error) {
                $("#message").html('<span class="text-danger">Something went wrong. Please try again.</span>').fadeIn();
                $(".spinner-border").hide();
                $(".reset-note").show();
                $('.btn-custom').prop('disabled', false);
                console.error("AJAX Error: ", status, error);
            }
        });
    });
});
</script>
</body>
</html>
