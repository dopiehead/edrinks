
<?php session_start();
     if(isset($_SESSION['user_id'])){
         $userId = $_SESSION['user_id'];
         require("../engine/config.php");
         include("contents/profile-contents.php");
         
     }

     else{
        header("Location:../index.php");
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|sofia|Trirong|Poppins">
    <link rel="stylesheet" href="../../assets/css/wholesaler/wholesaler-dashboard.css">

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
                <img src="<?php echo"../../" .htmlspecialchars($user_image); ?>" class="rounded-circle" width="32" height="32">
                <span><?php echo htmlspecialchars($user_name); ?></span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </nav>
    <br><br><br>
<?php include ("../components/side-bar.php"); ?>

    <!-- Main Content -->
    <div class="main-content pt-5">
        <div class="container-fluid pt-4">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">

                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">No. of Products</p>
                                <h3 class="mb-2">0</h3>
                                <small class="text-danger">-3.22 Form last month</small>
                            </div>
                            <i class="fas fa-building fs-4 text-secondary"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">Customers</p>
                                <h3 class="mb-2">0</h3>
                                <small class="text-danger">-2.33% Form last month</small>
                            </div>
                            <i class="fas fa-user-friends fs-4 text-secondary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">Revenue</p>
                                <h3 class="mb-2">0</h3>
                                <small class="text-success">+4.25% Form last month</small>
                            </div>
                            <i class="fas fa-dollar-sign fs-4 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>

  
  

            <!-- Charts Section -->
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="chart-container">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Income Analytics</h5>
                                <i class="fas fa-info-circle ms-2 text-secondary"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button">
                                    This Year
                                </button>
                            </div>
                        </div>
                        <canvas id="incomeChart" height="300"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Overview</h5>
                            <i class="fas fa-ellipsis-v text-secondary"></i>
                        </div>
                        <h2 class="mb-4"></h2>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Views</span>
                                <span>0</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Comments</span>
                                <span>0</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 60%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Rating</span>
                                <span>0</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: 45%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-4">
        <div class="transaction-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0">Recent Transaction History</h5>
                    <i class="fas fa-info-circle text-muted"></i>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button">
                        This Month
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="table-header">
                            <th>Orders <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Date <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Items category <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Item Name <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Status <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Price <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="" class="avatar" alt="David Nurmi">
                                    <div>
                                        <div>David Nurmi</div>
                                        <div class="order-id">#ID144542</div>
                                    </div>
                                </div>
                            </td>
                            <td>15 Dec 2024</td>
                            <td>Alcoholic</td>
                            <td>Coke</td>
                            <td><span class="status-paid">Paid</span></td>
                            <td>$6,437</td>
                            <td><i class="fas fa-ellipsis-vertical text-muted"></i></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>

</body>
</html>