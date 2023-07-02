<?php
session_start();
require 'auth.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Project</title>
</head>
<body>
        <ul>
            <li>
                <a href="index.php">
                    <div class="symbol"><i class="fas fa-house-chimney"></i></div>
                    
                    
                    <div class="name"><span data-val="Home">Home</span></div>
                </a>

            </li>
            <?php if ($_SESSION['user_type'] === "market") { ?>
            <li>
                <a href="product.php">
                    <div class="symbol"><i class="fa-solid fa-shop"></i></div>
                  
                    
                    <div class="name"><span data-val="Products">Products</span></div>
                </a>

            </li>
            <?php } else { ?>
            <li>
                <a href="cart.php">
                    <div class="symbol"><i class="fas fa-cart-shopping"></i></div>
                    
                    
                    <div class="name"><span data-val="Cart">Cart</span></div>
                </a>

            </li>
            <?php } ?>
            <li>
                <a href="profile/profile.php">
                    <div class="symbol"><i class="fas fa-address-card"></i></div>
                    <div class="name"><span data-val="Profile">Profile</span></div>
                </a>

            </li>
        </ul>



</body>
</html>