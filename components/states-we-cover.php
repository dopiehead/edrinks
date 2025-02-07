
    <div class="container my-5">
        <section class="states-section">
            <img src="assets/images/background/female-chapman.jpg" alt="Person enjoying drink" class="featured-image">
            
            <h2 class="section-title">State we cover</h2>
            
            <div class="states-container">
                  <?php require ("engine/connection.php");
                  
                  $query = "SELECT state, COUNT(*) AS state_count 
                  FROM states_in_nigeria 
                  GROUP BY state 
                  ORDER BY state_count DESC 
                  LIMIT 20";
        
                  $result = $con->prepare($query);  
                  $result->execute();
                  $result = $result->get_result();  

                  while($row = mysqli_fetch_assoc($result)){
                     $state = $row['state'];
                     $state_count = $row['state_count'];
                    ?>
                  
                  <a href='products.php?product_location=<?php echo htmlspecialchars($state); ?>' style='cursor:pointer;' class="state-pill text-caqpitalize text-dark text-decoration-none"><?php echo htmlspecialchars($state); ?> <span class="state-count">(<?php echo htmlspecialchars($state_count); ?>)</span></a>

                  <?php } ?>
               
                
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
