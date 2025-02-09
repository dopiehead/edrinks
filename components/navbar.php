
  <nav class="navbar navbar-expand-lg navbar-light bg-light ">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand" href="index.php">e-Drink</a>

      <!-- Toggle button for mobile view -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Links -->
      <div class="collapse navbar-collapse gap-5" id="navbarNav">
        <ul class="navbar-nav ms-auto gap-2 ">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Buy Drinks
            </a>
            <ul class="dropdown-menu">
              
               <li><a class="dropdown-item" href="products.php?categories=wholesaler">Wholesaler</a></li>
               <li><a class="dropdown-item" href="products.php?categories=importer">Importer</a></li>
               <li><a class="dropdown-item" href="products.php?categories=manufacturer">Manufacturer</a></li>
               <li><a class="dropdown-item" href="products.php?categories=distributor">Distributor</a></li>

            </ul>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Sell Drinks
            </a>
            <ul class="dropdown-menu">
            <li>
    <a class="dropdown-item" href="<?php echo isset($_SESSION['user_id']) ? 'dashboard/posts.php' : 'sign-in.php?details=' . urlencode('dashboard/wholesaler/wholesaler-post.php'); ?>">
        Wholesaler
    </a>
</li>
<li>
    <a class="dropdown-item" href="<?php echo isset($_SESSION['user_id']) ? 'dashboard/posts.php' : 'sign-in.php?details=' . urlencode('dashboard/importer/importer-post.php'); ?>">
        Importer
    </a>
</li>
<li>
    <a class="dropdown-item" href="<?php echo isset($_SESSION['user_id']) ? 'dashboard/posts.php' : 'sign-in.php?details=' . urlencode('dashboard/manufacturer/manufacturer-post.php'); ?>">
        Manufacturer
    </a>
</li>

            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
        </ul>
        <!-- Icons -->
        <div class="d-flex align-items-center ms-lg-3 position-relative">
          <a href="#" class="icons me-3"><i class="bi bi-search"></i></a>
          <?php if(!isset($_SESSION['user_id'])) { ?> 
          <a href="sign-in.php" class="icons me-3"><i class="bi bi-person"></i></a>
          <?php } else {
           if(!empty($_SESSION['user_role'])){
            $user_role = $_SESSION['user_role'];
            if($user_role=='Customer'){?>
               <a href="dashboard/customer-dashboard.php" class="icons me-3"><i class="bi bi-person"></i></a>  
           <?php } elseif($user_role=='Importer') { ?>   
               <a href="dashboard/importer-dashboard.php" class="icons me-3"><i class="bi bi-person"></i></a>  
           <?php } elseif($user_role == 'Wholesaler') {?> 
            <a href="dashboard/wholesaler-dashboard.php" class="icons me-3"><i class="bi bi-person"></i></a>  
           <?php } elseif($user_role=='Distributor'){?> 
            <a href="dashboard/distributor-dashboard.php" class="icons me-3"><i class="bi bi-person"></i></a>  
            <?php } ?>       
            <?php }  }?>
          <a href="cart.php" class="icons"><i class="bi bi-bag"></i><span style='font-size:12px; margin-top:-3px' class='numbering rounded rounded-circle bg-danger text-white px-2 position-absolute'></span></a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"  rel="stylesheet"/>

