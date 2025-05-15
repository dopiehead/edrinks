<?php session_start();
     if(isset($_SESSION['user_id'])){
         $userId = $_SESSION['user_id'];
         $you = $_SESSION['user_email'];
         require("../engine/config.php");
         include("contents/profile-contents.php");
         
     }

     else{
         header("Location:../../index.php");
         exit();
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesaler Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|sofia|Trirong|Poppins">
    <link rel="stylesheet" href="../assets/css/wholesaler/wholesaler-dashboard.css">
    <link rel="stylesheet" href="../assets/css/wholesaler/wholesaler-products.css">

</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-orange fw-bold" href="#">Edrinks</a>
            <div class="position-relative d-flex align-items-center">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="Search">
            </div>
            <div class="d-flex align-items-center gap-3">
            <a href='notifications.php'><i class="fas fa-bell text-secondary"></i></a>
                <img src="<?php echo"../" .htmlspecialchars($user_image); ?>" class="rounded-circle" width="32" height="32">
                <span><?php echo htmlspecialchars($user_name); ?></span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </nav>
    <!-- Navbar -->
      <?php include ("components/side-bar.php"); ?>


    <!-- Main Content -->
    <div class="main-content pt-5 my-3 px-2">

    <div id="label">
    <?php
// Make sure $conn (mysqli connection) and $you (receiver's email) are defined and sanitized

// -------------------------
// 1. Set Pagination Variables
// -------------------------
$limit = 2;  
$page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page_number < 1) {
    $page_number = 1;
}
$offset = ($page_number - 1) * $limit;

// -------------------------
// 2. Get Total Number of Unique Sender Conversations (for Pagination)
// -------------------------
$countQuery = "SELECT COUNT(*) AS total 
               FROM (
                  SELECT sender_email 
                  FROM messages 
                  WHERE receiver_email = ? 
                    AND is_receiver_deleted = 0 
                  GROUP BY sender_email
               ) AS sub";
if ($stmtCount = $conn->prepare($countQuery)) {
    $stmtCount->bind_param("s", $you);
    $stmtCount->execute();
    $resultCount = $stmtCount->get_result();
    $rowCount = $resultCount->fetch_assoc();
    $total_rows = $rowCount['total'];
    $stmtCount->close();
} else {
    die("Error preparing count statement: " . $conn->error);
}
$total_pages = ceil($total_rows / $limit);

// -------------------------
// 3. Get Unread Conversations Count (for the Inbox Header)
// -------------------------
$countUnreadQuery = "SELECT COUNT(*) AS unread_total 
                     FROM (
                        SELECT sender_email 
                        FROM messages 
                        WHERE receiver_email = ? 
                          AND is_receiver_deleted = 0 
                          AND has_read = 0 
                        GROUP BY sender_email
                     ) AS sub";
if ($stmtCountUnread = $conn->prepare($countUnreadQuery)) {
    $stmtCountUnread->bind_param("s", $you);
    $stmtCountUnread->execute();
    $resultCountUnread = $stmtCountUnread->get_result();
    $rowUnreadCount = $resultCountUnread->fetch_assoc();
    $unread_count = $rowUnreadCount['unread_total'];
    $stmtCountUnread->close();
} else {
    die("Error preparing count-unread statement: " . $conn->error);
}

// -------------------------
// 4. Fetch Paginated Messages (Grouped by Sender)
// -------------------------
// The subquery orders by has_read so that unread messages come first,
// then groups by sender_email, and finally applies LIMIT for pagination.
$messagesQuery = "SELECT * FROM (
                     SELECT * FROM messages 
                     WHERE receiver_email = ? 
                       AND is_receiver_deleted = 0 
                     ORDER BY has_read ASC 
                     LIMIT 18446744073709551615
                  ) AS sub 
                  GROUP BY sender_email 
                  LIMIT ?, ?";
if ($stmtMessages = $conn->prepare($messagesQuery)) {
    // Bind $you (string), $offset (int), and $limit (int)
    $stmtMessages->bind_param("sii", $you, $offset, $limit);
    $stmtMessages->execute();
    $resultMessages = $stmtMessages->get_result();
    $stmtMessages->close();
} else {
    die("Error preparing messages statement: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Messages</title>
    <!-- Include your CSS files or styles here -->
    <style>
        /* Basic styles for clarity */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: center; border: 1px solid #ccc; }
        .active { font-weight: bold; text-decoration: underline; }
        .numbering { color: red; }
        a { text-decoration: none; margin: 0 4px; }
    </style>
</head>
<body>

    <!-- Inbox Header -->
    <table>
        <thead>
            <tr>
                <th id="inbox">Inbox (<?php echo $unread_count; ?>)</th>
                <th><a href="messages.php" id="refresh">Refresh</a></th>
                <th><a class="mark" href="#">Mark as Read</a></th>
            </tr>
        </thead>
    </table>
    <br><br><br>

    <!-- Messages Table -->
    <table>
        <thead>
            <tr style="background-color: rgba(192,192,192,0.1);">
                <th>Action</th>
                <th>From</th>
                <th>Subject</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Loop through each conversation (grouped by sender)
        while ($row = $resultMessages->fetch_assoc()) {
            $sender_email = $row['sender_email'];

            // Query unread messages count for this sender
            $stmtUserCount = $conn->prepare("SELECT COUNT(*) AS unreadCount 
                                             FROM messages 
                                             WHERE sender_email = ? 
                                               AND receiver_email = ? 
                                               AND is_receiver_deleted = 0 
                                               AND has_read = 0");
            $stmtUserCount->bind_param("ss", $sender_email, $you);
            $stmtUserCount->execute();
            $resultUserCount = $stmtUserCount->get_result();
            $rowUserCount = $resultUserCount->fetch_assoc();
            $unreadFromUser = $rowUserCount['unreadCount'];
            $stmtUserCount->close();

            $unreadBadge = ($unreadFromUser > 0) ? "<span class='numbering'>(" . $unreadFromUser . ")</span> " : "";
            
            echo "<tr id='{$row['id']}' class='border_bottom'>";
            // Action (Delete) column (assumes you have JavaScript to handle removal)
            echo "<td id='delete'><a style='color:red;' class='remove' data-sender='" . htmlspecialchars($sender_email) . "'><i class='fa fa-trash'></i></a></td>";
            // From column – show a shortened version of sender_email
            echo "<td id='from'><a href='chat.php?user_name=" . urlencode($sender_email) . "'>" . htmlspecialchars(substr($sender_email, 0, 4)) . "</a></td>";
            
            // Subject column – style differently if unread
            if ($row['has_read'] == 0) {
                echo "<td id='message' style='font-weight:bold; font-size:14px;'>
                        <a style='font-size:13px; font-weight:bold;' href='chat.php?user_name=" . urlencode($sender_email) . "' class='reply'>" . $unreadBadge . htmlspecialchars($row['subject']) . "</a>
                      </td>";
            } else {
                echo "<td id='message' style='text-transform: capitalize; font-weight:normal;'>
                        <a style='font-size:13px;' href='chat.php?user_name=" . urlencode($sender_email) . "' class='reply'>" . $unreadBadge . htmlspecialchars($row['subject']) . "</a>
                      </td>";
            }
            // Date column
            echo "<td id='date'>" . htmlspecialchars($row['date']) . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div style="margin-top:20px;">
        <?php
        if ($page_number > 1) {
            echo '<a href="messages.php?page=' . ($page_number - 1) . '">Prev</a> ';
        }
        for ($page = 1; $page <= $total_pages; $page++) {
            if ($page == $page_number) {
                echo '<a class="active" href="messages.php?page=' . $page . '">' . $page . '</a> ';
            } else {
                echo '<a href="messages.php?page=' . $page . '">' . $page . '</a> ';
            }
        }
        if ($page_number < $total_pages) {
            echo '<a href="messages.php?page=' . ($page_number + 1) . '">Next</a>';
        }
        ?>
    </div>

</body>
</html>

  </div>



</div>
 



    </div>



    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    </body>
    </html>