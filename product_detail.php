<?php
session_start();
require 'check_if_added.php';

// Dummy product details (In practice, you should fetch these details from the database)
$products = [
    1 => ['name' => 'Cannon EOS', 'price' => 36000, 'description' => 'A great DSLR camera that offers high resolution and excellent color reproduction. Ideal for both professional and amateur photographers. Equipped with advanced features to ensure superior image quality. Lightweight and durable design for easy handling. Excellent battery life for extended shooting sessions.'],
    2 => ['name' => 'Sony DSLR', 'price' => 40000, 'description' => 'This Sony DSLR is designed for enthusiasts who want high-quality images. It features a fast autofocus system and a range of manual settings. The camera body is robust and ergonomic, providing comfort during long shoots. Its high ISO range allows for great performance in low light. Includes built-in Wi-Fi for easy sharing.'],
    3 => ['name' => 'Sony DSLR', 'price' => 50000, 'description' => 'A premium Sony DSLR that delivers stunning image clarity and versatility. Perfect for capturing fast-moving subjects with its rapid shooting mode. Comes with a range of customizable buttons for a personalized shooting experience. The weather-sealed body ensures protection in various environments. Exceptional video recording capabilities.'],
    4 => ['name' => 'Olympus DSLR', 'price' => 80000, 'description' => 'The Olympus DSLR offers superior image stabilization and a high-resolution sensor. Ideal for both still photography and videography. The compact design makes it easy to carry on any adventure. Features a touchscreen LCD for intuitive controls. Known for its excellent lens compatibility and high-speed performance.'],
    5 => ['name' => 'Titan Model #301', 'price' => 13000, 'description' => 'The Titan Model #301 is a stylish and reliable watch. Perfect for everyday wear with its classic design. Water-resistant and built to last. Features a clear and easy-to-read dial. The perfect accessory for both formal and casual occasions.'],
    6 => ['name' => 'Titan Model #201', 'price' => 3000, 'description' => 'A budget-friendly option from Titan, Model #201 offers excellent value. Simple yet elegant design. Durable construction ensures long-lasting use. Ideal for everyday wear. A great gift option for friends and family.'],
    7 => ['name' => 'HMT Milan', 'price' => 8000, 'description' => 'HMT Milan is a timeless piece with a vintage appeal. Known for its precision and reliability. The mechanical movement is a testament to traditional watchmaking. Elegant design suitable for all occasions. A collector\'s item for watch enthusiasts.'],
    8 => ['name' => 'Favre Leuba', 'price' => 18000, 'description' => 'Favre Leuba offers a blend of luxury and functionality. Swiss-made with high precision. Features a sophisticated design that stands out. Ideal for formal wear. A statement piece for those who appreciate fine craftsmanship.'],
    9 => ['name' => 'Raymond', 'price' => 1500, 'description' => 'Raymond shirts are known for their quality and style. Made from premium fabrics. Perfect for both formal and casual settings. Comfortable and breathable. A must-have in every wardrobe.'],
    10 => ['name' => 'Charles', 'price' => 1000, 'description' => 'Charles shirts offer great value for money. Stylish designs suitable for various occasions. Easy to maintain and durable. Made from soft, comfortable fabric. A versatile addition to your clothing collection.'],
    11 => ['name' => 'HXR', 'price' => 900, 'description' => 'HXR shirts are designed for the modern man. Affordable without compromising on quality. Trendy designs that keep you looking sharp. Perfect for daily wear. Comfortable and easy to care for.'],
    12 => ['name' => 'PINK', 'price' => 1200, 'description' => 'PINK shirts are vibrant and stylish. Made from high-quality materials. Ideal for making a fashion statement. Comfortable fit and feel. Great for both casual and semi-formal occasions.'],
];

// Get the product ID from the query string
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!array_key_exists($product_id, $products)) {
    die('Product not found.');
}

$product = $products[$product_id];
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/lifestyleStore.png" />
    <title><?php echo $product['name']; ?> - Lifestyle Store</title>
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
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="thumbnail">
                    <img src="img/<?php echo strtolower(str_replace(' ', '_', $product['name'])); ?>.jpg" alt="<?php echo $product['name']; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <h2><?php echo $product['name']; ?></h2>
                <p>Price: Rs. <?php echo number_format($product['price'], 2); ?></p>
                <p><?php echo $product['description']; ?></p>
                <form method="POST" action="cart_add.php">
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <select name="quantity" class="form-control" id="quantity">
                            <?php for($i=1; $i<=5; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <?php if(!isset($_SESSION['email'])){ ?>
                        <p><a href="login.php" role="button" class="btn btn-primary">Buy Now</a></p>
                    <?php } else {
                        if(check_if_added_to_cart($product_id)){
                            echo '<a href="#" class="btn btn-success disabled">Added to cart</a>';
                        } 
                    } ?>
                </form>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br>
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
