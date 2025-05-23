<?php
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!---------------bootsrap icon link---------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!---------------bootsrap css link---------------------->
    <!---------------bootsrap slider link---------------------->
    <link rel="stylesheet" type="text/css" href="slick.css" />
    <!---------------default css link---------------------->
    <link rel="stylesheet" href="main.css">
    <title>Mimma - Home page</title>
</head>
<body>
    <section class="popular-brands">
        <h2>Popular items</h2>
        <div class="controls">
            <i class="bi bi-chevron-left left"></i>
            <i class="bi bi-chevron-right right"></i>
        </div>
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
        <div class="popular-brands-content">
            <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                if(mysqli_num_rows($select_products) > 0){
                    while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
            <form method="post" class="card">
                <img src="image/<?php echo $fetch_products['image']; ?>">
                <div class="price">npr<?php echo $fetch_products['price'];?>/-</div>
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_quantity" value="1" min="1">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image'];?>">
                <div class="icon">
                    <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                </div>
            </form>
            <?php
                    }
                } else {
                    echo '<p class="empty">No products added yet!</p>';
                }
            ?>
        </div>
    </section>

    <script src="jquary.js"></script>
    <script src="slick.js"></script>
     
    <script type="text/javascript">
            $('.popular-brands-content').slick({
                lazyLoad: 'ondemand',
                slidesToShow: 4,
                slidesToScroll: 1,
                nextArrow: $('.right'),
                prevArrow: $('.left'),
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
    </script>
</body>
</html>
