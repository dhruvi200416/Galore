<?php
session_start();
$con = mysqli_connect("localhost","root","","galore2026");

if(!$con){
    die("Database connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION['email'])){
    header("Location: co_login.php");
    exit;
}

$email = $_SESSION['email'];

if(isset($_POST['change_password_btn'])){
    $current = trim($_POST['current_password']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    $errors = [];

    // Fetch user current password from DB
    $res = mysqli_query($con, "SELECT password FROM ad_register WHERE email='$email'");
    if($res && mysqli_num_rows($res) > 0){
        $user = mysqli_fetch_assoc($res);

        // Check current password
        if($current !== $user['password']){
            $errors[] = "Current password is incorrect.";
        }

        // Check new password confirmation
        if($new !== $confirm){
            $errors[] = "New password and confirmation do not match.";
        }

        // Check if new password is same as old
        if($current === $new){
            $errors[] = "New password cannot be same as current password.";
        }

        if(empty($errors)){
            // Update password
            $update = mysqli_query($con, "UPDATE ad_register SET password='$new' WHERE email='$email'");
            if($update){
                // ✅ Set success message for profile page
                $_SESSION['success_msg'] = "Password updated successfully!";
                header("Location: co_profile.php");
                exit;
            } else {
                $_SESSION['msg'] = "Failed to update password. Try again.";
                header("Location: co_change_password.php");
                exit;
            }
        } else {
            $_SESSION['msg'] = implode("<br>", $errors);
            header("Location: co_change_password.php");
            exit;
        }
    } else {
        $_SESSION['msg'] = "User not found!";
        header("Location: co_change_password.php");
        exit;
    }
} else {
    header("Location: co_change_password.php");
    exit;
}
?><?php
session_start();
$con = mysqli_connect("localhost","root","","galore2026");

if(!$con){
    die("Database connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION['email'])){
    header("Location: co_login.php");
    exit;
}

$email = $_SESSION['email'];

if(isset($_POST['change_password_btn'])){
    $current = trim($_POST['current_password']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    $errors = [];

    // Fetch user current password from DB
    $res = mysqli_query($con, "SELECT password FROM ad_register WHERE email='$email'");
    if($res && mysqli_num_rows($res) > 0){
        $user = mysqli_fetch_assoc($res);

        // Check current password
        if($current !== $user['password']){
            $errors[] = "Current password is incorrect.";
        }

        // Check new password confirmation
        if($new !== $confirm){
            $errors[] = "New password and confirmation do not match.";
        }

        // Check if new password is same as old
        if($current === $new){
            $errors[] = "New password cannot be same as current password.";
        }

        if(empty($errors)){
            // Update password
            $update = mysqli_query($con, "UPDATE ad_register SET password='$new' WHERE email='$email'");
            if($update){
                // ✅ Set success message for profile page
                $_SESSION['success_msg'] = "Password updated successfully!";
                header("Location: co_profile.php");
                exit;
            } else {
                $_SESSION['msg'] = "Failed to update password. Try again.";
                header("Location: co_change_password.php");
                exit;
            }
        } else {
            $_SESSION['msg'] = implode("<br>", $errors);
            header("Location: co_change_password.php");
            exit;
        }
    } else {
        $_SESSION['msg'] = "User not found!";
        header("Location: co_change_password.php");
        exit;
    }
} else {
    header("Location: co_change_password.php");
    exit;
}
?>