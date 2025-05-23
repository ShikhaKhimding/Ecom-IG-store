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
        <h1>about us</h1>
        <p>hand embroidered stuff</p>
        <a href="index.php"> home</a><span> about us</span>
</div>
</div>
<div class="line"></div>
    <!------------------------about us-------------------------->
<div class="about-us">
    <div class="row">
        <div class="title">
            <span> ABOUT OUR ONLINE STORE</span>
            <h1> Hello, we are establishes on 2022</h1>
            <p> "Mimma," a term meaning "Sweetheart" in the Limbu language, encapsulates the essence of affection and endearment. Since the year 2022, our store has been dedicated to serving our cherished customers with utmost care and devotion. We specialize in crafting exquisite canvas embroidery and socks embroidery, infused with love and passion, to bring joy and warmth to those who adorn them. At Mimma, every stitch is woven with tender affection, ensuring that each creation is not just a product, but a heartfelt expression of love and craftsmanship.</p>
        </div>
    </div>
</div>
<div class="line3"></div>
    <!------------------------about us end-------------------------->
 
<?php include 'footer.php'; ?>
<script type="text/javascript" src="script.js"></script>
</body>
</html>