<?php 
$details = isset($_GET['details']) && !empty($_GET['details']) ? filter_var($_GET['details'],FILTER_SANITIZE_URL): null;
?>
<input type="hidden" name='url' id='url' value = "<?= htmlspecialchars($details) ?>">

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("components/links.php"); ?>
    <title>Sign In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/sign-in.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-light">

     <div class="card">
             
        <h2>Sign In</h2>
        <form id="signinForm" style='font-family:poppins;'>

            <div class="mb-3">
                 <label class="form-label text-secondary">Email</label>
                 <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                 <label class="form-label text-secondary">Password</label>
                 <input type="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <div class='d-flex justify-content-between'>
                 <a href="sign-up.php" class='text-sm text-decoration-none mt-2'>Create Account</a>
                 <a href="forgot-password.php" class="forgot-password hover:text-decoration-none">Forgot password?</a>
            </div>

            <button type="submit" class="btn  btn-custom w-100 mt-3"> <span class='spinner-border text-warning'></span> <span class='signin-note'>Sign In</span> </button>

            <div class="container d-flex justify-content-between mt-5">
                 <a href="index.php" class="btn btn-outline-secondary me-2">Back to Home</a>
                 <a href="#" onclick="window.history.back();" class="btn btn-outline-primary">Go Back</a>
            </div>
            
            <div id="error-message" class="error-message"></div>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        $(".spinner-border").hide();
        
        $("#signinForm").submit(function(event) {
            event.preventDefault();
            $(".spinner-border").show();
            $(".signin-note").hide();
            $('.btn-custom').prop('disabled', true);
            
            let email = $("#email").val();
            let password = $("#password").val();
            let url = $("#url").val().trim(); // Trim URL to ensure it's not empty
            
            $.ajax({
                type: "POST",
                url: "engine/signin-process.php",
                data: { email: email, password: password },
                dataType: "json",
                success: function(response) {
                    $(".spinner-border").hide();
                    $(".signin-note").show();
                    $('.btn-custom').prop('disabled', false);
                    
                    if (response.status === "success") {
                        if (url && url !== "") {
                            window.location.href = url;
                        } else {
                            switch (response.user_role) {
                                case "Customer":
                                    window.location.href = "dashboard/customer-dashboard.php";
                                    break;
                                case "Importer":
                                    window.location.href = "dashboard/importer-dashboard.php";
                                    break;
                                case "Wholesaler":
                                    window.location.href = "dashboard/wholesaler-dashboard.php";
                                    break;
                                case "Manufacturer":
                                    window.location.href = "dashboard/manufacturer-dashboard.php";
                                    break;
                                case "Admin":
                                    window.location.href = "dashboard/admin/admin-dashboard.php";
                                    break;
                                case "Distributor":
                                    window.location.href = "dashboard/distributor-dashboard.php";
                                    break;
                                default:
                                    window.location.href = "dashboard/general/general-dashboard.php";
                                    break;
                            }
                        }
                    } else {
                        $("#error-message").text(response.message);
                    }
                },
                error: function() {
                    $(".spinner-border").hide();
                    $(".signin-note").show();
                    $('.btn-custom').prop('disabled', false);
                    $("#error-message").text("Something went wrong. Please try again.");
                }
            });
        });
    });
</script>


</body>
</html>
