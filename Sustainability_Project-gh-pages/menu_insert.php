<?php
if (!validSession()){
    session_start();
}
?>
<ul id="menu">
            <li>
                <a href="index.php">
                    <div class="symbol"><i class="fas fa-house-chimney"></i></div>
                    <div class="symbol"><span data-val="Home">Home</span></div>
                </a>

            </li>
            <?php if ($_SESSION['user_type'] === "market") { ?>
            <li>
                <a href="product.php">
                    <div class="symbol"><i class="fa-solid fa-shop"></i></div>
                    <div class="symbol"><span data-val="Products">Products</span></div>
                </a>

            </li>
            <?php } else { ?>
            <li>
                <a href="cart.php">
                    <div class="symbol"><i class="fas fa-cart-shopping"></i></div>
                    <div class="symbol"><span data-val="Cart">Cart</span></div>
                </a>

            </li>
            <?php } ?>
            <li>
                <a href="profile.php">
                    <div class="symbol"><i class="fas fa-address-card"></i></div>
                    <div class="symbol"><span data-val="Profile">Profile</span></div>
                </a>

            </li>
            <li>
                <a href="logout.php">
                    <div class="symbol"><i class="fa-solid fa-right-from-bracket"></i></div>
                    <div class="symbol"><span data-val="logout">Logout</span></div>
                </a>

            </li>
        </ul>