<?php
session_start();
require '../auth.php';
if (validSession()){
    header("Location: ../index.php");
}
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $entered_confirmation_code = filter_var($_POST["confirmation_code"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if ($entered_confirmation_code === $_SESSION["register"]["confirmation_code"]){
        if ($_SESSION["register"]["user_type"] === "market"){
            $stmt = $db->prepare("INSERT INTO market (email, password, name, city, district, address) VALUES (:email, :password, :name, :city, :district, :address)");
        }
        else {
            $stmt = $db->prepare("INSERT INTO consumer (email, password, name, city, district, address) VALUES (:email, :password, :name, :city, :district, :address)");
        }
        $stmt->bindParam(":email", $_SESSION["register"]["email"]);
        $stmt->bindParam(":password", $_SESSION["register"]["password"]);
        $stmt->bindParam(":name", $_SESSION["register"]["name"]);
        $stmt->bindParam(":city", $_SESSION["register"]["city"]);
        $stmt->bindParam(":address", $_SESSION["register"]["address"]);
        $stmt->bindParam(":district", $_SESSION["register"]["district"]);
        $stmt->execute();
        if ($stmt->rowCount() > 0){
            $_SESSION["message"] = "Account created successfully";
            mkdir("../images/".getUser($_SESSION["register"]["email"])["mid"]);
            unset($_SESSION["register"]);
            session_destroy();
            setcookie(session_name(), "", 1 , "/");
            header("Location: ../login.php");
            exit;
        }
        else {
            $_SESSION["message"] = "Account creation failed";
            header("Location: ../error.php?error=500");
        }
        exit;
    }
    else{
        $_SESSION["message"] = "Invalid confirmation code";
        header("Location: confirmation.php");
        exit;
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        form {
            display: flex;
            justify-content: center;
            margin: 40px auto;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="confirmation_code" placeholder="Confirmation Code">
        <button  type="submit">Confirm</button>
    </form>
</body>
</html>
