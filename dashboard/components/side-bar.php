<!-- Sidebar -->     
<div class="sidebar pt-5 px-3">         
    <div class="pt-4">             
        <ul class="nav flex-column">                 
            <li class="nav-item">                     
                <a class="nav-link" href="../../index.php">
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
                <a class="nav-link active-products" href="<?php 
                    if($_SESSION['user_role']=='wholesaler'){                                                  
                        echo"wholesaler-products.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='distributor'){                                                  
                        echo"distributor-products.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='manufacturer'){                                                  
                        echo"manufacturer-products.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='importer'){                                                  
                        echo"importer-products.php";                                        
                    }                        
                    else{                                                   
                        echo"customer-products.php";                      
                    }
                ?>">
                    <i class="fas fa-building me-2"></i> Products
                </a>                 
            </li>                  
            <li class="nav-item">                     
                <a class="nav-link active-profile" href="<?php 
                    if($_SESSION['user_role']=='wholesaler'){                                                  
                        echo"wholesaler-profile.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='distributor'){                                                  
                        echo"distributor-profile.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='manufacturer'){                                                  
                        echo"manufacturer-profile.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='importer'){                                                  
                        echo"importer-profile.php";                                        
                    }                        
                    else{                                                   
                        echo"customer-profile.php";                      
                    }
                ?>">
                    <i class="fas fa-user-friends me-2"></i> Profile
                </a>                 
            </li>                  
            <li class="nav-item">                     
                <a class="nav-link active-customers" href="<?php 
                    if($_SESSION['user_role']=='wholesaler'){                                                  
                        echo"wholesaler-customers.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='distributor'){                                                  
                        echo"distributor-customers.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='manufacturer'){                                                  
                        echo"manufacturer-customers.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='importer'){                                                  
                        echo"importer-customers.php";                                        
                    }                        
                    else{                                                   
                        echo"#";                      
                    }
                ?>">
                    <i class="fas fa-file-alt me-2"></i> Customers
                </a>                 
            </li>                  
            <li class="nav-item">                     
                <a class="nav-link active-history" href="<?php 
                    if($_SESSION['user_role']=='wholesaler'){                                                  
                        echo"wholesaler-order-history.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='distributor'){                                                  
                        echo"distributor-order-history.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='manufacturer'){                                                  
                        echo"manufacturer-order-history.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='importer'){                                                  
                        echo"importer-order-history.php";                                        
                    }                        
                    else{                                                   
                        echo"customer-order-history.php";                      
                    }
                ?>">
                    <i class="fas fa-file-alt me-2"></i> Orders
                </a>                 
            </li>                               
            <li class="nav-item">                     
                <a class="nav-link active-inbox" href="<?php 
                    if($_SESSION['user_role']=='wholesaler'){                                                  
                        echo"wholesaler-inbox.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='distributor'){                                                  
                        echo"distributor-inbox.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='manufacturer'){                                                  
                        echo"manufacturer-inbox.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='importer'){                                                  
                        echo"importer-inbox.php";                                        
                    }                        
                    else{                                                   
                        echo"customer-inbox.php";                      
                    }
                ?>">
                    <i class="fas fa-inbox me-2"></i> Inbox
                </a>                 
            </li>                  
            <li class="nav-item">                     
                <a class="nav-link active-post" href="<?php 
                    if($_SESSION['user_role']=='wholesaler'){                                                  
                        echo"wholesaler-post.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='distributor'){                                                  
                        echo"distributor-post.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='manufacturer'){                                                  
                        echo"manufacturer-post.php";                                        
                    }                       
                    elseif($_SESSION['user_role']=='importer'){                                                  
                        echo"importer-post.php";                                        
                    }                        
                    else{                                                   
                        echo"customer-post.php";                      
                    }
                ?>">
                    <i class="fas fa-paper-plane me-2"></i> Post
                </a>                 
            </li>                                  
            <li class="nav-item">                     
                <a class="nav-link" href="../../logout.php">
                    <i class="fas fa-paper-plane me-2"></i> Logout
                </a>                 
            </li>              
        </ul>         
    </div>     
</div>