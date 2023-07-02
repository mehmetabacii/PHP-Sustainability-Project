<?php
    session_start();
    require "auth.php";
    // change return document type to json
    header('Content-Type: application/json');
    $pid = filter_var($_GET["pid"], FILTER_VALIDATE_INT);
    if ($pid) {
    $flag = false;
    foreach ($_SESSION["cart"] as $i => $item){
        if($_SESSION["cart"][$i]["pid"] === $pid){
            if (isset($_GET['m']))
            $_SESSION["cart"][$i]["cnt"]--;
            else
            $_SESSION["cart"][$i]["cnt"]++;
            if ($_SESSION["cart"][$i]["cnt"] === 0){
                unset($_SESSION["cart"][$i]);
                echo "0";
            }
            else {
                echo $_SESSION["cart"][$i]["cnt"];
            }
            $flag = true;
        }
    }
    if (!$flag && !isset($_GET['m'])) {
        $_SESSION['cart'][] = ["pid" => $pid,
                            "cnt" => 1];
    }
    }
?>