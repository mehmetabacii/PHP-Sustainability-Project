<?php
    session_start();
    require 'auth.php';
    if (validSession()) {
        // there are no restrictions on this page.
        // but the pages display will change if there is a 
        // consumer logged in.
        if($_SESSION["user_type"] !== "consumer"){
            header("Location: product.php");
            exit;
        }
    }else{
        header("Location: login.php");
        exit;
    }

    $products = $db->query("select * from product")->fetchAll(PDO::FETCH_ASSOC) ;
    $arname = "products";
    $sort = $_GET["sort"] ?? "expr_date" ; // default sort is country name
     if ( $sort === "expr_date") {
       usort($products, function($a, $b) {
         return $a["expr_date"] > $b["expr_date"] ;
       }) ;
     } else if ( $sort === "title") {
       usort($products, function($a, $b) {
         return $a["title"] > $b["title"] ;
       }) ;
     }else if ( $sort === "normal_price") {
        usort($products, function($a, $b) {
          return $a["normal_price"] > $b["normal_price"] ;
        }) ;
     }else if ( $sort === "discnt_price") {
        usort($products, function($a, $b) {
          return $a["discnt_price"] > $b["discnt_price"] ;
        }) ;
    }else if ( $sort === "stock") {
        usort($products, function($a, $b) {
          return $a["stock"] > $b["stock"] ;
        }) ;
      }

      if(isset($_GET["q"])){
            $q = filter_var($_GET["q"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $qa = explode(' ', $q);
            $search_string = "SELECT * FROM product WHERE ";;
            foreach($qa as $keyword){
                $search_string .= "title like '%".$keyword."%' OR " ;
            }
            $search_string .= "1=2;";
            $qproducts = $db->query($search_string)->fetchAll(PDO::FETCH_ASSOC) ;
            $arname = "qproducts";
      }
      
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css');
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="menuStyle.css">
</head>
<body>
    <?php require 'menu_insert.php' ?>
    <header>
        <form action="" method="get">
            <div class="q">
                <input type="text" name="q" value="<?= $q ?? "" ?>"> <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
        <div class="btn">
        <a href="cart.php">
            Shopping Cart
        </a>    
        </div>
        
    </header>
    <h1>PRODUCTS</h1>
    <table> 
        <tr>
            <td>IMAGE</td>
            <td <?= $sort === "title" ? "class='sortField'" :""?>><a href="?sort=title<?= isset($q) ? "&q=$q":"" ?>">TITLE</a></td>
            <td <?= $sort === "stock" ? "class='sortField'" :""?>><a href="?sort=stock<?= isset($q) ? "&q=$q":"" ?>">STOCK</a></td>
            <td <?= $sort === "normal_price" ? "class='sortField'" :""?>><a href="?sort=normal_price<?= isset($q) ? "&q=$q":"" ?>">NORMAL PRICE</a></td>
            <td <?= $sort === "discnt_price" ? "class='sortField'" :""?>><a href="?sort=discnt_price<?= isset($q) ? "&q=$q":"" ?>">DISCOUNT PRICE</a></td>
            <td <?= $sort === "expr_date" ? "class='sortField'" :""?>><a href="?sort=expr_date<?= isset($q) ? "&q=$q":"" ?>">EXPIRE DATE</a></td>
        </tr>
        <script>
            function addToCart(pid){
                let url = "add.php?pid=";
                url += pid;
                $.get(url, function(result){
                    return false;
                });
            }
        </script>
        <?php foreach( $$arname as $product ) : ?>
            <tr>
                <td> <img src='./images/<?php if ($product["img"] !== "product.jpeg") echo $product["mid"], "/"; ?><?=$product["img"]?>'></td>
                <td><?=$product["title"]?></td>
                <td><?=$product["stock"]?></td>
                <td><?=$product["normal_price"]?></td>
                <td><?=$product["discnt_price"]?></td>
                <td><?=$product["expr_date"]?></td>
                <td><a onclick="addToCart(<?= $product["pid"]?>)"><i class="fa-solid fa-cart-plus"></i></a></td>
            </tr>
        <?php endforeach ; ?>
    </table>
</body>
</html>