<?php
session_start();
$errors = [
    400 => 'Bad Request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    408 => 'Request Timeout',
    500 => 'Internal Server Error'
];

$code = 0;
if (isset($_GET['error'])) {
    $code = filter_var($_GET['error'], FILTER_VALIDATE_INT);
    if (!$code) {
        $code = 405;
    }
}

if (isset($errors[$code])) {
    $message = $errors[$code];
} else {
    $message = 'Unknown Error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woops...</title>
</head>
<body>
    <h1>Woops...</h1>
    <h2>An error seems to have occurred!</h2>
    <p>ERROR: <?= $message ?></p>
    <p><?= $_SESSION['message'] ?? "" ?></p>
</body>
</html>