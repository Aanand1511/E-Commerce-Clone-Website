<?php
    session_start();
    require 'connection.php';
    
    // Redirect if user is not logged in
    if(!isset($_SESSION['email'])) {
        header('location: login.php');
    }
    
    $user_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/lifestyleStore.png" />
    <title>Lifestyle Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    <div>
        <?php require 'header.php'; ?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Cash on Delivery Details</div>
                        <div class="panel-body">
                            <form method="post" action="success.php?id=<?php echo $user_id ?>&payment_method=cod">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Confirm Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
           <div class="container">
               <center>
                   <p>Copyright &copy Lifestyle Store. All Rights Reserved. | Contact Us: +91 90000 00000</p>
                   <p>This website is developed by Ayush Anand</p>
               </center>
           </div>
        </footer>
    </div>
</body>
</html>
