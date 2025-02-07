<?php
require("config.php");

if (isset($_GET['token'])) {
    $reset_token = $_GET['token'];

    // Check if the token is valid and not expired
    $stmt = $conn->prepare("SELECT id FROM user_profile WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->bind_param("s", $reset_token);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 0) {
        die("Invalid or expired token.");
    }
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
} else {
    die("No token provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Reset Your Password</h4>
                    </div>
                    <div class="card-body">
                        <form id="resetPasswordForm">
                            <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" id="new_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" id="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Reset Password</button>
                            <div id="message" class="mt-3 text-center"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
$(document).ready(function() {
    $("#resetPasswordForm").submit(function(event) {
        event.preventDefault();

        var user_id = $("#user_id").val();
        var new_password = $("#new_password").val();
        var confirm_password = $("#confirm_password").val();

        if (new_password !== confirm_password) {
            $("#message").html('<div class="alert alert-danger">Passwords do not match.</div>');
            return;
        }

        $.ajax({
            type: "POST",
            url: "process-reset-password.php",
            data: { user_id: user_id, new_password: new_password },
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    $("#message").html('<div class="alert alert-success">' + response.message + '</div>');
                    setTimeout(() => { window.location.href = "sign-in.php"; }, 3000);
                } else {
                    $("#message").html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $("#message").html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
            }
        });
    });
});
</script>

</body>
</html>
