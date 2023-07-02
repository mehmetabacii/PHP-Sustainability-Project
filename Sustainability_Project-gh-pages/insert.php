<?php
    session_start();
    require_once "auth.php";
    require "Upload.php" ;

    if(validSession()){
        if($_SESSION["user_type"] === "market"){
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                extract($_POST);
                $title = filter_var($title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if (!$title) $error["title"] = true;
                $stock = filter_var($stock, FILTER_VALIDATE_INT);
                if (!$stock) $error["stock"] = true;
                $normal_price = filter_var($normal_price, FILTER_VALIDATE_FLOAT);
                if (!$normal_price) $error["normal_price"] = true;
                $discnt_price = filter_var($discnt_price, FILTER_VALIDATE_FLOAT);
                if (!$discnt_price) $error["discnt_price"] = true;
                if(!preg_match( '/^\d{4}-\d{2}-\d{2}$/' , $expr_date)){
                    $error["expr_date"] = true;
                }

                $product_img = new Upload("product_img", "images/{$_SESSION['user']['mid']}") ;
                $filename = $product_img->file() ?? "product.jpeg" ;

                if (!isset($error)){
                    $stmt = $db->prepare("insert into product (mid, title, stock, normal_price, discnt_price, expr_date, img) values (?, ?, ?, ?, ?, ?, ?)") ;
                    $stmt->execute([$_SESSION["user"]["mid"], $title, $stock, $normal_price, $discnt_price, $expr_date, $filename]) ;
                    header("Location: product.php");
                    exit;
                }
                    
            }
        }
           
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menuStyle.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Document</title>
    <style>
        table{
            font-size: 20px;
            margin: 40px auto;
            width: 700px;
            background: rgb(255, 255, 255);
            border-radius: 0.4em;
            box-shadow: 0.3em 0.3em 0.7em #00000015;
            transition: border 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: rgb(250, 250, 250) 0.2em solid;

        }
        table:hover {
            border: #006fff 0.2em solid;
        }
        form{
            margin: 70px auto;
        }
        
        input {
        line-height: 28px;
        font-weight: bold;
        border: 2px solid transparent;
        border-bottom-color: #777;
        padding: .2rem 0;
        outline: none;
        background-color: transparent;
        color: #0d0c22;
        transition: .3s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        input:focus, input:hover {
        outline: none;
        padding: .2rem 1rem;
        border-radius: 1rem;
        border-color: #7a9cc6;
        }

        input::placeholder {
        color: #777;
        }

        input:focus::placeholder {
        opacity: 0;
        transition: opacity .3s;
        }
        button {
        --primary-color: #645bff;
        --secondary-color: #fff;
        --hover-color: #111;
        --arrow-width: 10px;
        --arrow-stroke: 2px;
        box-sizing: border-box;
        border: 0;
        border-radius: 20px;
        color: var(--secondary-color);
        padding: 1em 1.8em;
        background: var(--primary-color);
        display: flex;
        transition: 0.2s background;
        align-items: center;
        gap: 0.6em;
        font-weight: bold;
        margin-top: 5px;
        }

        button .arrow-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: 10px;

        }

        button .arrow {
        margin-top: 1px;
        background: var(--primary-color);
        height: var(--arrow-stroke);
        position: relative;
        transition: 0.2s;
        }

        button .arrow::before {
        content: "";
        box-sizing: border-box;
        position: absolute;
        border: solid var(--secondary-color);
        border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
        display: inline-block;
        top: -3px;
        right: 3px;
        transition: 0.2s;
        padding: 3px;
        transform: rotate(-45deg);
        }

        button:hover {
        background-color: var(--hover-color);
        }

        button:hover .arrow {
        background: var(--secondary-color);
        }

        button:hover .arrow:before {
        right: 0;
        }
        input[type=file]::file-selector-button{
            background-color: white;
            border-color: white;
            border-radius: 10px;
        }
        input[type=file]::file-selector-button:hover{
            outline: 1px blue;
            border-color:  #006fff;
            background-color: white;
            border-radius: 10px;
        }
        .error{
            border-color: red;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php require 'menu_insert.php'; ?>
    <form action="" method="post"  enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <input type="text" name="title" placeholder="Title" <?= isset($error["title"]) ? "class = 'error'" : "" ?>value='<?= isset($title) ? $title : ""?>'>
                </td>
                <td>
                    <input type="text" name="stock" placeholder="Stock" <?= isset($error["stock"]) ? "class = 'error'" : "" ?>value='<?= isset($stock) ? $stock : ""?>'>
                </td>
                <td>
                    <input type="text" name="normal_price" placeholder="Normal Price" <?= isset($error["normal_price"]) ? "class = 'error'" : "" ?>value='<?= isset($normal_price) ? $normal_price : "" ?>'>
                </td>
                <td>
                    <input type="text" name="discnt_price" placeholder="Discount Price" <?= isset($error["discnt_price"]) ? "class = 'error'" : "" ?>value='<?= isset($discnt_price) ? $discnt_price : "" ?>'>
                </td>
                <td>
                    <input type="date" name="expr_date" placeholder="Expire Date" <?= isset($error["expr_date"]) ? "class = 'error'" : "" ?>value='<?= isset($expr_date) ? $expr_date : "" ?>'>
                </td>
                <td><input type="file" name = "product_img"></td>
                <td>
                    <button type="submit">INSERT</button>
                </td>
            </tr>
        </table>
        
    </form>
</body>
</html>