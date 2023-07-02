<?php
    session_start();
    require '../auth.php';
    require_once './vendor/autoload.php' ;
    require_once './Mail.php' ;
    function generateConfirmationCode(){
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    if (validSession()) {
        header("Location: ../index.php");
        exit;
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        if (isset($_POST["email"]) && isset($_POST["password_confirmation"]) && isset($_POST["password"])) {
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            $password_confirmation = filter_var($_POST["password_confirmation"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(isset($_POST["userType"])){
                $userType = filter_var($_POST["userType"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }else{
                $userType = null;
                $error["user_type"] = "you did not select a user type";
            }
            $name = filter_var($_POST["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $city = filter_var($_POST["city"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $address = filter_var($_POST["address"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $district = filter_var($_POST["district"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$email){
                $error["email_chars"] = "invalid characters used in email";
            }
            if (!$password){
                $error["password_chars"] = "invalid characters used in password";
            }
            // regex for email
            if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
                $error["email_format"] = "invalid email format";
            }
            if (strlen($password) < 5) {
                $error["password_len"] = "Password must be at least 4 characters long";
            }
            if ($password !== $password_confirmation){
                $error["password_match"] = "Passwords do not match";
            }
            if ($userType !== "market" && $userType !== "consumer") {
                $error["user_type"] = "user type is invalid";
            }
            if (!isset($error)){
                $_SESSION["register"]["confirmation_code"] = generateConfirmationCode();
                $_SESSION["register"]["email"] = $email;
                $_SESSION["register"]["password"] = password_hash($password, PASSWORD_BCRYPT);
                $_SESSION["register"]["user_type"] = $userType;
                $_SESSION["register"]["name"] = $name;
                $_SESSION["register"]["city"] = $city;
                $_SESSION["register"]["district"] = $district;
                $_SESSION["register"]["address"] = $address;

                try {
                    $message = "<p>Your confirmation code is: <b>" . $_SESSION["register"]["confirmation_code"] . "</b></p>";
                    $_SESSION["message"] = $message;
                    Mail::send($email, "SustainabilityMarket: Email Confirmation", $message);
                } catch (Exception $e) {
                    $_SESSION["register"]["error"] = "Error sending email";
                }
                header("Location: confirmation.php");
                exit;
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abel&display=swap">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            font-family: Abel;
            background-color: #f5f5f5;
        }
        header{
            text-align: center;
            color: orange;
        }
        #main{
            display: flex;
            width: 500px;
            justify-content: center;
            margin: 0 auto;
        }
        form{
            width: 200px;
            text-align: center;
        }
        input, select{
            font-size: 20px;
            display: flex;
        }
        
        table{
            font-size: 20px;
            margin: 30px auto;
            color: red;
            font-style: italic;
            font-weight: bold;
        }

        input{
            margin-top: 10px;
            padding: 5px;
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
        margin-top: 10px;
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
        input {
        line-height: 28px;
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
        select{
            color: #60666d;
            border: none;
            color: blue;
        }
    </style>
</head>
<body>
    <header>
        <h1>Register</h1>
    </header>
    <div id="main">
        <form action="" method="post">
            <select name="userType">
                <option value="Select a type" disabled selected>Select a type</option>
                <option value="market">Market</option>
                <option value="consumer">Consumer</option>
            </select>
            <input type="text" name="email" placeholder="E-mail" <?= isset($email) ? "value='$email'" : "" ?>>
            <input type="password" name="password" placeholder="Password" <?= isset($password) ? "value='$password'" : "" ?>>
            <input type="password" name="password_confirmation" placeholder="Re-enter Password" <?= isset($password_confirmation) ? "value='$password_confirmation'" : "" ?>>
            <input type="text" name="name" placeholder="Name" <?= isset($name) ? "value='$name'" : "" ?>>
            <input type="text" name="city" placeholder="City" <?= isset($city) ? "value='$city'" : "" ?>>
            <input type="text" name="district" placeholder="District" <?= isset($district) ? "value='$district'" : "" ?>>
            <input type="text" name="address" placeholder="Address" <?= isset($address) ? "value='$address'" : "" ?>>
            <button type="submit">Submit 
            <div class="arrow-wrapper">
                <div class="arrow"></div>
            </div>
            </button>
        </form>
    </div>
    <?php
            if (isset($error)) {
                echo "<table>";
                foreach ($error as $key => $value) {
                    ?>
                    <tr class="error"><td>*</td><td><?= $value ?>*</td></tr>
                    <?php
                }
                echo "</table>";
            }
        ?>
</body>
</html>