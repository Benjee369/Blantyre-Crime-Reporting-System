<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'DatabaseConn.php';
$Email_Address = $_POST["useremail"];
$userPassword = $_POST["userpassword"];

// if (isset($_SESSION["locked"])) {
//     $difference = time() - $_SESSION["locked"];
//     if ($difference <= 30) {
//         $_SESSION['login_error_message'] = "Login failed. Please try again.";
//         header("Location: Login.php");
//         exit();
//     } else {
//         unset($_SESSION["locked"]);
//         unset($_SESSION["login_attempts"]);
//     }
// }

$stmt = $conn->prepare("SELECT ID, Password FROM userdetails WHERE Email_Address=?");
$stmt->bind_param("s", $Email_Address);
$stmt->execute();
$stmt->bind_result($userId, $storedHashedPassword);
$stmt->fetch();

if ($stmt->errno) {
    die("Execute error: " . $stmt->error);
}

if ($storedHashedPassword !== null && password_verify($userPassword, $storedHashedPassword)) {
    $_SESSION["user_id"] = $userId;
    $_SESSION["isloggedin"] = true;
    $_SESSION["invalidCredentials"] = false;
    header("Location: Index.php");
    exit();
} else {
    if (!isset($_SESSION["login_attempts"])) {
        $_SESSION["login_attempts"] = 1;
    } else {
        $_SESSION["login_attempts"]++;
    }

    if ($_SESSION["login_attempts"] > 2) {
        $_SESSION["locked"] = time();
        header("Location: Login.php");
        exit();
    }
    $_SESSION['login_error_message'] = "Login failed. Please try again.";

    header("Location: Login.php");
    exit();
}
?>
