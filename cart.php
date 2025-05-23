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
 

//delete product from cart
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die ('query failed');
    header('location:cart.php');
}
//delete product from cart
if(isset($_GET['delete_all'])){
   
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die ('query failed');

    header('location:cart.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!------------------------bootstrap icon link--------------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>Mimma home page</title>
</head>
<body>

<?php include 'header.php';?>
<div class="banner">
    <div class="detail">
        <h1>My cart</h1>
        <p>hand embroidered stuff</p>
        <a href="index.php">home</a><span> cart</span>
    </div>
</div>
<div class="line"></div>
<!------------------------about us-------------------------->
<section class="shop">
    <h1 class ="title">products added in cart</h1>
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
    <div class="box-container">
        <?php
        $grand_total=0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
        if(mysqli_num_rows($select_cart)>0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){

                ?>
                <div class="box">
                    <img src="image/<?php echo $fetch_cart['image']; ?>">
                    <div class="price">npr<?php echo $fetch_cart[ 'price'];?>/-</div>
                    <div class="name"><?php echo $fetch_cart['name']; ?></div>
                    <form method="post">
                    <input type="hidden" name="update_qty_id" value="<?php echo $fetch_cart['id']; ?>">
                    <div class="qty"> 
                    <div class="icon">
                        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="bi bi-x" onclick="return confirm('Do you want to delete item from your cart?')"></a>
                        <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                    </div>
                       
            </div>
            </form>
            <?php
            $price_num = intval($fetch_cart['price']);
            $quantity_num = intval($fetch_cart['quantity']);
            ?>
            <?php echo $total_amt = $price_num * $quantity_num?>

                    <div class="total-amt">
                        Total Amount : <span><?php echo $total_amt?></span>
            </div>
            </div>
                <?php
                $grand_total+=$total_amt;
            }
        }else{
            echo '<p class="empty"> no products added yet!</p>';
        }
        ?>
    </div>
    <div class="dlt">
        <a href="cart.php?delete_all" class="btn2" onclick="return 
        confirm('Do you want to delete all items in your wishlist?')">Delete All</a>
    <div class="wishlist_total">
        <p>total amount payable : <span>npr<?php echo $grand_total; ?>/-</span></p>
        <a href="shop.php" class="btn">continue shopping</a>
        <a href="checkout.php" class="btn <?php echo ($grand_total>1) ? '' : 'disabled'?>" onclick="return 
        confirm('Do you want to delete all items in your wishlist?')">proceed to check out</a>

    </div>
</section>

<?php include 'footer.php'; ?>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
