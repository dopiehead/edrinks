<!DOCTYPE html>
<html lang="en">
<head>

    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/css/sign-up.css">
     <?php include ("components/links.php"); ?>

</head>
<body>
<div class="container text-center mt-4">
        <h1 class="fw-bold text-dark">Sign up</h1>
    </div>
    <div class="signup-container">
        <h4 class="mb-3">Create an Account</h4>
        <form id="signupForm">
            <div class="mb-3">
                <input name='user_name' type="text" class="form-control" placeholder="Your name">
            </div>
            <div class="mb-3">
                <input name='user_email' type="email" class="form-control" placeholder="yourname@domain.com">
            </div>
            <div class="mb-3">
                <input name='user_password' type="password" class="form-control" placeholder="Password">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Re-type password">
            </div>
            <div class="mb-3">
                <label class="form-label">Are you joining as:</label>
                <div class="d-flex flex-wrap justify-content-center g-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id='Customer'>Customer</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id='Imposter'>Importer</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id='Wholesaler'>Wholesaler</button>           
                    <button type="button" class="btn btn-outline-secondary btn-sm" id='Distributor'>Distributor</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id='Manufacturer'>Manufacturer</button>

                    <input type="hidden" id="user_type" name="user_type">
                </div>
            </div>
            <div class="terms mb-3"> 
                <p>By clicking Sign up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
                <p>Already have an account? <a href="sign-in.php">Log in</a></p>
            </div>
            <button type="submit" class="btn btn-custom w-100 py-2 "><span class='spinner-border text-warning'></span> <span class='signup-note'>Sign up</span></button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    
    <script>
    $(document).ready(function() {
        $(".spinner-border").hide();  // Initially hide the spinner

        // User Type Selection
        $(".btn-outline-secondary").click(function(e) {
            e.preventDefault(); // Prevent default button click
            var userType = $(this).attr("id"); // Get the id of the clicked button
            $("#user_type").val(userType); // Set the value of hidden input
            $(this).addClass("btn-secondary text-white"); // Highlight selected button
            $(this).siblings().removeClass("btn-secondary text-white"); // Remove from others
        });

        // Form Submission
        $("#signupForm").submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            $(".spinner-border").show(); // Show spinner
            $(".signup-note").hide(); // Hide any previous signup notes
            $('.btn-custom').prop('disabled', true); // Disable the submit button

            var formData = $("#signupForm").serialize(); // Get form data

            $.ajax({
                 type: "POST",
                 url: "engine/signup-process.php", // Adjust URL as needed
                 data: formData,
                 dataType: "json",
                 success: function(response) {
                     $(".spinner-border").hide(); // Hide spinner
                     $(".signup-note").show(); // Show signup note

                     console.log(response);  // Log the entire response for debugging

                    if (response.status === "success") {
                        swal({
                            icon: "success",
                            title: "Registration Successful",
                            text: response.message
                        });

                        $("#signupForm")[0].reset(); // Reset the form
                        $('.btn-custom').prop('disabled', false); // Re-enable the submit button

                    } else {
                        swal({
                            icon: "warning",
                            title: "Registration Failed",
                            text: response.message
                        });

                        $('.btn-custom').prop('disabled', false); // Re-enable the submit button
                    }
                },
                error: function(err) {
                    $(".spinner-border").hide(); // Hide spinner if error occurs
                    console.error(err);  // Log the error for debugging
                    swal({
                        icon: "error",
                        title: "Registration Failed",
                        text: err.responseText || "Something went wrong"
                    });

                    $('.btn-custom').prop('disabled', false); // Re-enable the submit button
                    $(".signup-note").show();
                }
            });
        });
    });
</script>

</body>
</html>
