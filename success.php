<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['email'])) {
    header('location:index.php');
    exit(); // Add exit() after redirection to stop further execution
}

$user_id = $_GET['id'];
$payment_method = isset($_GET['payment_method']) ? $_GET['payment_method'] : 'none';

if ($payment_method == 'cod' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);

    // Insert order details into the orders table
    $order_query = "INSERT INTO orders (user_id, name, address, phone, payment_method, status) 
                    VALUES ('$user_id', '$name', '$address', '$phone', 'Cash on Delivery', 'Confirmed')";
    mysqli_query($con, $order_query) or die(mysqli_error($con));

    // Retrieve the last inserted order ID
    $order_id = mysqli_insert_id($con);

} elseif ($payment_method == 'upi') {
    // Similar logic for UPI payments, if needed
    $order_query = "INSERT INTO orders (user_id, payment_method, status) 
                    VALUES ('$user_id', 'UPI', 'Confirmed')";
    mysqli_query($con, $order_query) or die(mysqli_error($con));

    $order_id = mysqli_insert_id($con);

  
}

// Retrieve order details to display
$order_details_query = "SELECT * FROM orders WHERE id='$order_id'";
$order_details_result = mysqli_query($con, $order_details_query) or die(mysqli_error($con));
$order_details = mysqli_fetch_assoc($order_details_result);

// Calculate the total amount
$user_products_query = "SELECT it.id, it.name, it.price FROM users_items ut 
                       INNER JOIN items it ON it.id = ut.item_id 
                       WHERE ut.user_id='$user_id' AND ut.status='Confirmed'";
$user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
$sum = 0;
while ($row = mysqli_fetch_array($user_products_result)) {
    $sum = $sum + $row['price'];
}
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
                    <div class="panel-heading">Order Confirmation</div>
                    <div class="panel-body">
                        <p>Your order is confirmed with <?php echo $order_details['payment_method']; ?>.</p>
                        <p>Thank you for shopping with us. Here are your order details:</p>
                        <ul>
                            <li><strong>Order ID:</strong> <?php echo $order_details['id']; ?></li>
                            <?php if ($payment_method == 'cod') { ?>
                                <li><strong>Name:</strong> <?php echo $order_details['name']; ?></li>
                                <li><strong>Address:</strong> <?php echo $order_details['address']; ?></li>
                                <li><strong>Phone:</strong> <?php echo $order_details['phone']; ?></li>
                            <?php } ?>
                            <li><strong>Payment Method:</strong> <?php echo $order_details['payment_method']; ?></li>
                            <li><strong>Status:</strong> <?php echo $order_details['status']; ?></li>
                            <li><strong>Total Amount:</strong> Rs <?php echo $sum; ?>/-</li>
                        </ul>
                        <p><a href="products.php">Click here</a> to purchase any other item.</p>
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
