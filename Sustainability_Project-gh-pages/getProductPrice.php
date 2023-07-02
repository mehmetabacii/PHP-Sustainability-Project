<?php
session_start();
require "auth.php";
if (validSession()){
    if (isset($_GET['pid'])){
        $pid = filter_var($_GET['pid'], FILTER_VALIDATE_INT);
        if ($pid){
            $stmt = $db->prepare("select * from product where pid = ?");
            $stmt->execute([$pid]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($product){
                echo json_encode($product);
            }
        }
    }
}

?>