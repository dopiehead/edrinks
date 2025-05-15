<!-- Sidebar -->     
<div class="sidebar pt-5 px-3">         
    <div class="pt-4">             
        <ul class="nav flex-column">                 
            <li class="nav-item">                     
                <a class="nav-link" href="../index.php">
                    <i class="fas fa-home me-2"></i> Home
                </a>                 
            </li>                 
            <li class="nav-item">                     
                <a class="nav-link active-dashboard" href="<?php                                           
                    if($_SESSION['user_role']=='wholesaler'){                                                  
                        echo"wholesaler-dashboard.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='distributor'){                                                  
                        echo"distributor-dashboard.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='manufacturer'){                                                  
                        echo"manufacturer-dashboard.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='importer'){                                                  
                        echo"importer-dashboard.php";                                        
                    }                        
                    else{                                                   
                        echo"customer-dashboard.php";                      
                    }                                     
                ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>                 
            </li>                                     
                
            <li class="nav-item">                     
                <a class="nav-link active-profile" href="../dashboard/profile.php">
                    <i class="fas fa-user me-2"></i> Profile
                </a>                 
            </li>   
            <?php if($_SESSION['user_role']!=='customer'):?>       
            <li class="nav-item">                     
                <a class="nav-link active-customers" href="../dashboard/customers.php">
                    <i class="fas fa-user-friends me-2"></i> Customers
                </a>                 
            </li>                  
                           
               
            <li class="nav-item">                     
                <a class="nav-link" href="../dashboard/products.php">
                    <i class="fas fa-home me-2"></i> Products
                </a>                 
            </li>  
                    
            
            <li class="nav-item">                     
                <a class="nav-link" href="../dashboard/post.php">
                    <i class="fas fa-paper-plane me-2"></i> Posts
                </a>                 
            </li>  

            
            <li class="nav-item">                     
                <a class="nav-link" href="../dashboard/sold-history.php">
                    <i class="fas fa-file me-2"></i> Sold history
                </a>                 
            </li>     

                       
            <?php endif; ?>  
            
            
                        
            <li class="nav-item">                     
                <a class="nav-link" href="../dashboard/order-history.php">
                    <i class="fas fa-file me-2"></i> Order history
                </a>                 
            </li>   
            
            <li class="nav-item">                     
                <a class="nav-link" href="../dashboard/inbox.php">
                    <i class="fas fa-envelope me-2"></i> Inbox
                </a>                 
            </li>  
            

            <li class="nav-item">                     
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-sign-out me-2"></i> Logout
                </a>                 
            </li>              
        </ul>         
    </div>     
</div>