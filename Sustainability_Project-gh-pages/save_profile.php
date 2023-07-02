<?php
	session_start();
	require 'auth.php';
    if(isset($_POST['save']) && isset($_POST['name']) && isset($_POST['password_new']) && isset($_POST['password_new2']) && isset($_POST['city']) && isset($_POST['district']) && isset($_POST['address'])){
        $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = $_SESSION['user']['email'];
        $password_new = filter_var($_POST['password_new'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password_new2 = filter_var($_POST['password_new2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $district = filter_var($_POST['district'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($password_new !== $password_new2){
            $_SESSION['message'] = "Problem occured, recheck the passwords!!";
            header('location: edit_profile.php');
        }
        else if($district==""){
            $_SESSION['message'] = "Problem occured, recheck the district!!";
            header('location: edit_profile.php');
        }
        else if($city==""){
            $_SESSION['message'] = "Problem occured, recheck the city!!";
            header('location: edit_profile.php');
        }
        else if($name==""){
            $_SESSION['message'] = "Problem occured, recheck the name!!";
            header('location: edit_profile.php');
        }
        else if($address==""){
            $_SESSION['message'] = "Problem occured, recheck the address!!";
            header('location: edit_profile.php');
        }
        else{
            if ($password_new !== "")
                $password_new = password_hash($password_new, PASSWORD_BCRYPT);
            else
                $password_new = $_SESSION['user']['password'];
            
            if ($_SESSION['user_type'] === 'market') {
                $sql = "UPDATE market SET name='$name', password='$password_new', address='$address', city='$city', district='$district' WHERE email = '$email';";
            }
            else {
                $sql = "UPDATE consumer SET name='$name', password='$password_new', address='$address', city='$city', district='$district' WHERE email = '$email';";
            }
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $_SESSION['message'] = "succesfully edited".$stmt->rowCount();
            echo $stmt->rowCount();
            header('location: profile.php');
        }
    } 
?>