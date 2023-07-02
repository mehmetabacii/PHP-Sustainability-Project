<?php
session_start();
require "auth.php";
if (validSession()){
    for ($i = 0; $i < count($_SESSION['cart']); $i++){
        $stmt = $db->prepare("update product set stock = stock - ? where pid = ?")->execute([$_SESSION['cart'][$i]['cnt'], $_SESSION['cart'][$i]['pid']]);
        $stmt = $db->prepare("select * from product where pid = ?");
        $stmt->execute([$_SESSION['cart'][$i]['pid']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($product['stock'] <= 0){
            $db->prepare("delete from product where pid = ?")->execute([$_SESSION['cart'][$i]['pid']]);
        }
    }
    $_SESSION['cart'] = [];
}
header('location: index.php');
?>