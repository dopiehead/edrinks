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

        <!-- <div class="mb-3">
                <label class="form-label text-secondary">Role</label>
                <select id="user_role" class="form-control"  required>
                     <option value="">Select your role</option>
                     <option value="Customer">Customer</option>
                     <option value="Importer">Importer</option>
                     <option value="Retailer">Retailer</option>
                     <option value="Distributor">Distributor</option>
                     <option value="Wholesaler">Wholesaler</option>
                     <option value="Admin">Admin</option>
                </select>
            </div> -->


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
                            // Redirect based on role
                            switch (response.user_role) {
                                case "Customer":
                                    window.location.href = "dashboard/customer/customer-dashboard.php";
                                    break;
                                case "Importer":
                                    window.location.href = "dashboard/importer/importer-dashboard.php";
                                    break;
                                case "Wholesaler":
                                    window.location.href = "dashboard/wholesaler/wholesaler-dashboard.php";
                                    break;
                                case "Admin":
                                    window.location.href = "dashboard/admin/admin-dashboard.php";
                                    break;
                                case "Retailer":
                                    window.location.href = "dashboard/retailer/retailer-dashboard.php";
                                    break;
                                default:
                                    window.location.href = "dashboard/general/general-dashboard.php";
                                    break;
                            }
                        } else {
                            $("#error-message").text(response.message);
                        }
                    },
                    error: function() {
                        $("#error-message").text("Something went wrong. Please try again.");
                    }
                });
            });
        });
    </script>

</body>
</html>
