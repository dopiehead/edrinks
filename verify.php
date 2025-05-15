<?php
require("config.php");

if (isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];

    // Check if vkey exists
    $stmt = $conn->prepare("SELECT id, verified FROM user_profile WHERE vkey = ? AND verified = 0");
    $stmt->bind_param("s", $vkey);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update user as verified
        $stmt->bind_result($user_id, $verified);
        $stmt->fetch();

        $update_stmt = $conn->prepare("UPDATE user_profile SET verified = 1 WHERE id = ?");
        $update_stmt->bind_param("i", $user_id);

        if ($update_stmt->execute()) {
            $message = "Your account has been successfully verified! You can now <a href='login.php'>log in</a>.";
        } else {
            $message = "Something went wrong. Please try again.";
        }
    } else {
        $message = "This account is already verified or the verification key is invalid.";
    }
} else {
    $message = "Invalid request.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 100px; }
        .card { border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>

<div class="container">
    <div class="card text-center p-4">
        <h2>Email Verification</h2>
        <p><?php echo $message; ?></p>
        <a href="login.php" class="btn btn-primary">Go to Login</a>
    </div>
</div>

</body>
</html>
