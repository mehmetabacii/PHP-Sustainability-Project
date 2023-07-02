<?php
if(count(get_included_files()) == ((version_compare(PHP_VERSION, '5.0.0', '>='))?1:0)) {
    exit('Restricted Access');
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
try {
    $db = new PDO("mysql:host=localhost;dbname=256proj;port=3306;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
    gotoError(500);
}

// authentication function that checks the login credentials
// if they are correct, it returns the user_type
// otherwise it returns false
function authenticateUser($email, $password, &$user = [])
{
    global $db;

    try {
        $stmt = $db->prepare("select * from market where email=?");
        $stmt->execute([$email]);
        if ($stmt->rowCount()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user["password"])) {
                return 'market';
            }
        }
        $stmt = $db->prepare("select * from consumer where email=?");
        $stmt->execute([$email]);
        if ($stmt->rowCount()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user["password"])) {
                return 'consumer';
            }
        }
    } catch (PDOException $e) {
        gotoError(500);
    }
    return false;
}

function validSession()
{
    return isset($_SESSION["user"]);
}

function getUser($email)
{
    global $db;
    try {
        $stmt = $db->prepare("select * from market where email=?");
        $stmt->execute([$email]);
        if ($stmt->rowCount()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $stmt = $db->prepare("select * from consumer where email=?");
        $stmt->execute([$email]);
        if ($stmt->rowCount()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        gotoError(500);
    }
    return false;
}

function gotoError($error)
{
    header("Location: error.php?error=$error");
    exit;
}

?>