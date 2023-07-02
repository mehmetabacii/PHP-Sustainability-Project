<?php
	session_start();
    require 'auth.php';
    $user = getUser($_SESSION['user']['email']);
    if (!$user){
        gotoError(405);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abel&display=swap">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="menuStyle.css">
    <title>Profile</title>
    <style>
        * {
            font-family: Abel;
        }
        #edit * {
            background-color: #f5f5f5;
        }
        table#edit{
            font-size: 20px;
            padding: 5px;
            margin: 50px auto;
            width: 500px;
            height: 700px;
            background: rgb(255, 255, 255);
            border-radius: 0.4em;
            box-shadow: 0.3em 0.3em 0.7em #afafff;
            transition: border 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: rgb(250, 250, 250) 0.2em solid;

        }
        table#edit:hover {
            border: #006fff 0.2em solid;
            }
        a#tt{
            text-decoration: none;
            font-weight: bold;
        }
        p{
            margin-left: 10px;
        }
        span#username{
            color: orange;
        }
    </style>
</head>
<body>
<?php require 'menu_insert.php' ?>
<?php
			if(isset($_SESSION['message'])){
				?>
				<div class="alert alert-info text-center">
					<?php echo $_SESSION['message']; ?>
				</div>
				<?php
				unset($_SESSION['message']);
			}

			?>
    <table id="edit">
        <tr colspan="2"><td>Hello <span id="username"><?= $user["name"]?></span></td></th>
        <tr><td><p> <b>Email:</b> <?= $user["email"] ?></p></td></tr>
        <tr><td><p> <b>Name: </b><?= $user["name"] ?></p></td></tr>
        <tr><td><p> <b>City:</b> <?= $user["city"] ?> <br> <b>District: </b> <?= $user["district"] ?></p></td></tr>
        <tr><td><p> <b>Address: </b><?= $user["address"] ?></p></td></tr>
        <?php
        if(isset($user['mid'])){ ?>
            <tr><td><p><b>Your Market Id is: </b><?= $user['mid'] ?></p></td></tr>
        <?php } ?>
        <tr><td><a id="tt" href="edit_profile.php">Edit Profile</a></td></tr>
    </table>
</body>
</html>