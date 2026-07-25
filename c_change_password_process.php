<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "galore2026");

$email = $_SESSION['email'];
$result = mysqli_query($con, "SELECT * FROM ad_register WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

$current = $_POST['current_password'];
$new = $_POST['new_password'];
$confirm = $_POST['confirm_password'];

$errors = [];

// Validate current password
if($current != $user['password']){
    $errors['current'] = "Current password is incorrect!";
}

// Validate new password length
if(strlen($new) < 6){
    $errors['new'] = "Password must be at least 6 characters!";
}

// Validate confirm password
if($new != $confirm){
    $errors['confirm'] = "New password and confirm password do not match!";
}

// If errors exist, redirect back with errors
if(!empty($errors)){
    $_SESSION['change_password_errors'] = $errors;
    header("Location: c_change_password.php");
    exit();
}

// Update password
$sql = "UPDATE ad_register SET password='$new' WHERE email='$email'";
if(mysqli_query($con, $sql)){
    $_SESSION['change_password_success'] = "Password updated successfully!";
    header("Location: c_change_password.php");
    exit();
} else {
    $errors['current'] = "Error updating password!";
    $_SESSION['change_password_errors'] = $errors;
    header("Location: c_change_password.php");
    exit();
}
?>