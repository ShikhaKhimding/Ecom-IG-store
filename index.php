<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
}

//adding product in wishlist
if(isset($_POST['add_to_wishlist'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'")
        or die('query failed');
    $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'")
        or die('query failed');

    if(mysqli_num_rows($wishlist_number)>0) {
        $message[] = 'Product already exist in wishlist';
    } else if (mysqli_num_rows($cart_num) > 0) {
        $message[] = 'Product already exists in cart';
    } else {
        mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`,`pid`,`name`, `price`, `image`) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')");
        $message[] = 'Product successfully added to your wishlist';
    }
}
//adding product in cart
if(isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'")
        or die('query failed');
        if (mysqli_num_rows($cart_num) > 0) {
        $message[] = 'Product already exists in cart';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(`user_id`,`pid`,`name`, `price`, `quantity`, `image`) VALUES('$user_id', '$product_id', '$product_name', '$product_price',' $product_quantity ', '$product_image')");
        $message[] = 'Product successfully added to your cart';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        .slider-container {
            position: relative;
            width: 100%;
            display: flex;
        }

        .slider-caption {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #fff;
            z-index: 1;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .slider-caption h1, .slider-caption p {
            margin: 0;
        }

        .slider-caption .btn {
            display: block;
            margin-top: 10px;
        }

        .slider-image {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .slider-image img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>
<body>

<?php include 'header.php';?>

<div class="container">
    <!------------------------home Slider --------------------------->
    <div class="slider-container">
        <div class="slider-image">
            <img src="image/slider.jpg" alt="Slider Image">
        </div>
        <div class="slider-caption">
            <span>Quality</span>
            <h1>Handmade Embroidered<br>Products</h1>
            <p>Gift for your loved ones<br> Handmade with love</p>
            <a href="shop.php" class="btn">Shop Now</a>
        </div>
    </div>
</div>

<div class="line"></div>
    <div class="story">
        <div class="row">
            <div class="box">
                <span> our story</span>
                <h1>Since 2022</h1>
                <p> "Mimma," a term meaning "Sweetheart" in the Limbu language, 
                    encapsulates the essence of affection and endearment. 
                    Since the year 2022, our store has been dedicated to serving our cherished customers with utmost care and devotion.
                     We specialize in crafting exquisite canvas embroidery and socks embroidery, 
                     infused with love and passion, to bring joy and warmth to those who adorn them. At Mimma, every stitch is woven with tender affection, ensuring that each creation is not just a product,
                      but a heartfelt expression of love and craftsmanship.</p>
                    </div>
                    <div class="box">
                        <img src="image/starry.jpg">
          </div>
      </div>
</div>
<div class="line"></div>
<?php include 'homeshop.php';?>
<?php include 'footer.php';?>
<script src="jquary.js"></script>
<script src="slick.js"></script>

 <!------------------------Slick Slider link--------------------------->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script type="text/javascript" src="script2.js"></script>
</body>
</html>