<?php
session_start();
require 'auth.php';
function getProduct($pid)
{
    global $db;
    $sql = "SELECT * FROM product WHERE pid = ?;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$pid]);
    return $stmt->fetch();
}
if (!validSession()) {
    header('location: login.php');
    exit;
}
if ($_SESSION['user_type'] === 'market') {
    gotoError("403");
}
$cart = $_SESSION['cart'];
$totalQuantity = 0;
$totalPrice = 0;
foreach ($cart as $item) {
    $totalQuantity += $item['cnt'];
    $totalPrice += $item['cnt'] * getProduct($item['pid'])['discnt_price'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="menuStyle.css">
    <style>
        * {
            font-family: Abel;
        }

        div.btn:hover {
            cursor: pointer;
        }
    </style>
    <title>Cart</title>
</head>

<body>
    <?php require 'menu_insert.php' ?>
    <table id="cart">

        <tr>
            <td></td>
            <td>Title</td>
            <td>Normal Price</td>
            <td>Discount Price</td>
            <td>Expire Date</td>
            <td>Quantity</td>
        </tr>
        <script>
            function updateProductPrice(pid, d) {
                let p = 0;
                $.get("getProductPrice.php?pid=" + pid, function(data) {
                    // data
                    let o = JSON.parse(data);
                    console.log(o);
                    $("td#tq").text(parseInt($("td#tq").text()) + d);
                    $("td#tp").text(parseFloat(parseFloat($("td#tp").text()) + d * o["discnt_price"]).toFixed(2));
                });
            }

            function updateCart(pid, cnt) {
                let link = "add.php?pid=" + pid;
                let d = 1;
                if (cnt < 0) {
                    link += "&m=1";
                    d = -1;
                }
                cnt = Math.abs(cnt);
                for (let i = 0; i < cnt; i++) {
                    $.get(link, function(data) {
                        if (data <= "0")
                            $("tr#pid" + pid).remove();
                        else
                            $("tr#pid" + pid + " div#cnt").text(data.toString());
                        updateProductPrice(pid, d);
                    });
                }
            }
        </script>
        <?php foreach ($cart as $item) {
            $product = getProduct($item['pid']);
        ?>
            <tr class="item" id="pid<?= $item['pid'] ?>">
                <td><img src='./images/<?php if ($product["img"] !== "product.jpeg") echo $product["mid"], "/"; ?><?= $product["img"] ?>'></td>
                <td><?= $product['title'] ?></td>
                <td><?= $product['normal_price'] ?></td>
                <td><?= $product['discnt_price'] ?></td>
                <td><?= $product['expr_date'] ?></td>
                <td class="quantity">
                    <div class="btn" onclick="updateCart(<?= $product['pid'] ?>, 1)"><i class="fa-solid fa-plus"></i></div>
                    <div id="cnt"><?= $item['cnt'] ?></div>
                    <div class="btn" onclick="updateCart(<?= $product['pid'] ?>, -1)"><i class="fa-solid fa-minus"></i></div>
                </td>
            <?php } ?>

            <tr>
                <td colspan="5">Total Number Of Items</td>
                <td id="tq"><?= $totalQuantity ?></td>
            </tr>
            <tr>
                <td colspan="5">Total Price</td>
                <td id="tp"><?= $totalPrice ?></td>
            </tr>
    </table>
    <a href="purchase_cart.php">Purchase</a>
</body>

</html>