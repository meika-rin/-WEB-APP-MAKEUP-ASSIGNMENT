<?php
session_start();
require_once 'includes/connection.php';

$username = $_POST['User_Name'];
$password = $_POST['Password'];

$sql = $conn->prepare("SELECT * FROM users WHERE User_Name = ?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['Password'])) {
    $_SESSION['user'] = $user;
    if ($user['UserType'] == 'Super_User') {
        header("Location: dashboards/super_user_dashboard.php");
    } elseif ($user['UserType'] == 'Administrator') {
        header("Location: dashboards/admin_dashboard.php");
    } else {
        header("Location: dashboards/author_dashboard.php");
    }
} else {
    echo "Invalid login";
}
?>
