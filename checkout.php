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
if (isset($_POST['order-btn'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn,'city' .$_POST['city'].','.$_POST['street']);
    $placed_on = date('D-M-Y');
    $cart_total=0;
    $cart_product[]='';
    $cart_query=mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');

    if(mysqli_num_rows($cart_query)> 0){
        while($cart_item=mysqli_fetch_assoc($cart_query)){
            $cart_product[]=$cart_item['name'].'('.$cart_item['quantity'].')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total+=$sub_total;
    }
}
         $total_products = implode(',',$cart_product);
         mysqli_query($conn, "INSERT INTO `order` (`user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`) 
         VALUES ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')");
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'");
          $message[]='order placed successfully';
          header('location:checkout.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equip="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!------------------------bootstrap icon link--------------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>Mimma - contact us page</title>
</head>
<body>

<?php include 'header.php';?>
<div class="banner">
    <div class="detail">
        <h1>Order</h1>
        <p>hand embroidered stuff</p>
        <a href="index.php">home</a><span>order</span>
    </div>
</div>
<div class="line"></div>
<div class="checkout-form">
    <h1 class="title">payment process</h1>
    <?php
    if(isset($message)){
        foreach ($message as $message){
            echo '
            <div class="message">
            <span>'.$message.'</span>
            <i class="bi bi-x-circle" onlick="this.parentElement.remove()"></i>
            </div>
            ';
        }
    }
    ?>
    <div class="display-order">
    <div class="box-container">
        <?php
        $select_cart=mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
        $total_amount_payable=0;
        $grand_total=0;
        if (mysqli_num_rows($select_cart)> 0){
            while($fetch_cart=mysqli_fetch_assoc($select_cart)){
                $price_num = intval($fetch_cart['price']);
                $quantity_num = intval($fetch_cart['quantity']);
                $sub_total = $price_num * $quantity_num; 
                $total_amount_payable += $sub_total; 
                ?>
                    <div class="box">
                        <img src="image/<?Php echo $fetch_cart['image'];?>">
                        <span><?php echo $fetch_cart['name']; ?>(<?php echo $fetch_cart['quantity']; ?>)</span>
            </div>
           
            <?php
            }
        }
        ?>
         </div>
         <span class="grand-total">Total Amount Payable: <?php echo $total_amount_payable; ?> NPR</span>
        <div>
            <form method="post">
                <div class="input-field">
                    <label>your name</label>
                    <input type="text" name="name" placeholder="enter your name">
    </div>
    <div class="input-field">
                    <label>your number</label>
                    <input type="text" name="number" placeholder="enter your number">
    </div>
    <div class="input-field">
                    <label>your email</label>
                    <input type="text" name="email" placeholder="enter your email">
    </div>
    <div class="input-field">
                    <label>select payment method</label>
                    <select name="method" id="payment-method">
                        <option selected disabled>select payment method</option>
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="esewa">esewa</option>
    </select>
    <div class="input-field">
                    <label>address</label>
                    <input type="text" name="city" placeholder="e.g street name">
    </div>
    <input type="submit" name="order-btn" class="btn" value="order now">
    </form>
    </div>
     <!-- Image to display Esewa image -->
     <div id="esewa-image" style="display: none;">
            <img src="image/esewa.jpg" alt="Esewa Image">
    </div>
    </div>
<?php include 'footer.php'; ?>
<script type="text/javascript" src="script.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var paymentMethod = document.getElementById("payment-method");
        var esewaImage = document.getElementById("esewa-image");

        paymentMethod.addEventListener("change", function() {
            if (paymentMethod.value === "esewa") {
                esewaImage.style.display = "block";
            } else {
                esewaImage.style.display = "none";
            }
        });
    });
</script>

</body>
</html>
