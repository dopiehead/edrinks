<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ("components/links.php"); ?>
    <link rel="stylesheet" href="assets/css/contact.css">
    <title>Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class='bg-light'>

    <?php include("components/navbar.php"); ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Drop a Message <a href='mailto:info@edrinks.ng' class='text-sm text-warning'>(info@edrinks.ng)</a></h4>
                    </div>
                    <div class="card-body">
                        <form method="post" id="conv" enctype="multipart/form-data">

                            <?php if (!empty($_SESSION['name'])): ?>
                                 <input type="hidden" name="name" id="name" class="form-control" placeholder="&#xF007; Name" value="<?= $name; ?>">
                                 <input type="hidden" name="email" id="email" class="form-control" placeholder="&#xF1fa; Email" value="<?= $email; ?>">
                                 <input type="hidden" name="user_type" id="user_type" value="<?php echo !empty($user_role) ? $user_role : ''; ?>">

                             <?php else: ?>
                                 <input type="text" name="name" id="name" class="form-control" placeholder="&#xF007; Name">
                                 <input type="email" name="email" id="email" class="form-control mt-2" placeholder="&#xF1fa; Email">
                                 <input type="hidden" name="user_type" id="user_type" value="general">
                            <?php endif; ?>

                            <input type="text" name="subject" id="subject" class="form-control mt-3" placeholder="Subject">
                            
                            <textarea name="message" id="message" class="form-control mt-3" placeholder="...Write a message" rows="4"></textarea>
                            
                            <div class="text-center" class="mt-4">
                                <button type="button" id="submit2" class="btn btn-primary" style="color: white;"><span class='spinner-border text-warning'></span><span class='send-note'><i class='fa fa-paper-plane'></i> Send</span></button>
                            </div>
                        </form>

       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
         $(".spinner-border").hide();
         $('.numbering').load('engine/item-numbering.php');
         $('#submit2').on('click', function(e){
             e.preventDefault();

             $("#submit2").prop('disabled', true);
             $(".spinner-border").show();

             $.ajax({
                type: "POST",
                url: "engine/contact-process.php",
                data: $("#conv").serialize(),
                cache: false,
                contentType: "application/x-www-form-urlencoded",
                success: function(response) {
                    $("#submit2").prop('disabled', false);
                    $(".spinner-border").hide();
                    
                    if (response == 1) {
                        Swal.fire({
                            title: "Success !!",                        
                            text: "Message sent",
                            icon: "success"
                        });
                        $("#conv").find('input:text, textarea').val('');
                    } else {
                        Swal.fire({
                            title:"Notice",
                            text: response,
                            icon: "warning"
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    </script>

    <!-- Scroll button -->
    <a class="btn-down" onclick="topFunction()">&#8593;</a>
    <script src="assets/js/scroll.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
