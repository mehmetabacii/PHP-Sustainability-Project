<?php
    session_start();
    require 'auth.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $_SESSION['user_type'] = authenticateUser($email, $password, $_SESSION['user']);
        $_SESSION['cart']=[];
        if ($_SESSION['user_type'] !== false) {
            header("Location: index.php");
        } else {
            header("Location: login.php?error=1");
        }
        exit;
    }
    else {
        if (isset($_GET['error'])){
            $error = filter_var($_GET['error'], FILTER_VALIDATE_INT);
            if (!$error) {
                gotoError(405);
            }
            else {
                $errors = [
                    1 => 'Incorrect email or password'
                ];
                $error = $errors[$error];
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
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Login</title>
    <style>
        body{
            background: radial-gradient(100% 90%, white, lightgoldenrodyellow);
        }
        h1{
            color: orange;
        }
        .container {
            font-family: Abel;
            text-align: center;
            width: 800px;
            margin: 200px auto;
            font-size: 30px;
        }

        button {
        padding: 0.8em 1.8em;
        border: 2px solid #17C3B2;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        background-color: transparent;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 15px;
        transition: .3s;
        z-index: 1;
        font-family: inherit;
        color: #17C3B2;
        }

        button::before {
        content: '';
        width: 0;
        height: 300%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(45deg);
        background: #17C3B2;
        transition: .5s ease;
        display: block;
        z-index: -1;
        }

        button:hover::before {
        width: 105%;
        }

        button:hover {
        color: #111;
        }

        input{
            padding: 5px;
            border-radius: 10px;
            border-color: black;
            margin-left: 10px;
            font-size: 20px;
        }
        .error{
            color:red;
            font-style: italic;
        }
        form {
            display: flex;
        }
        form div{
            padding-right: 20px;
        }
        i{color: #17C3B2;}

        input {
        border: none;
        border-radius: 15px;
        padding: 15px;
        background-color: #e8e8e8;
        box-shadow: 6px 6px 12px #ffffff,
                    -6px -6px 12px #c5c5c5;
        font-size: medium;
        font-weight: bold;
        max-width: 200px;
        }

        input:focus {
        outline-color: white;
        place-content: "Enter your message!";
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="" method="post">
            <div>
                <input type="text" name="email" placeholder="E-mail" >
                <input type="password" name="password" placeholder="Password" >
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
            <div>
                <a href="register/register.php"><i class="fa-solid fa-user-plus"></i></a>
            </div>
        </form>
        <div>
            <?php if(isset($error)) :?>
                <p class="error"> *<?= $error ?>*</p>
            <?php endif ; ?>
        </div>
    </div>
</body>
</html>