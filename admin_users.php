<?php

include 'connection.php';
session_start();
$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
}

//delete messages from DB
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
   
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die ('query failed');
    $message[]='user removed successfully';
    header('location:admin_users.php');
}

?>
<style type= "text/css">
    <?php
    include 'style.css';
    ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!----box icon link---->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Admin Panel</title>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <?php
    if (isset($message)){
        foreach ($message as $message){
            echo '
            <div class="message">
            <span>'.$message.'</span>
            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
            </div>
            ';
        }
    }
    ?>
    <div class="line4"></div>
    <section class="message-container">
        <h1 class="title">total user account</h1>
        <div class="box-container">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            if (mysqli_num_rows($select_users) > 0) {
                while($fetch_users = mysqli_fetch_assoc($select_users)){
            ?>
            <div class="box">
                <p>user ID: <span><?php echo $fetch_users['id']; ?></span></p>
                <p>name: <span><?php echo $fetch_users['name']; ?></span></p>
                <p>email: <span><?php echo $fetch_users['email'];?></span></p>
                <p>user type : <span style="color: <?php if($fetch_users['user_type']=='admin'){ echo 'orange';}; ?>">
                <?php echo $fetch_users['user_type']; ?></span></p>             
                <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this message');">Delete</a>
            </div>
            <?php
                }
            } else {
                echo "<p>No messages found.</p>";
            }
            ?>
        </div>
    </section>
    <div class="line"></div>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
