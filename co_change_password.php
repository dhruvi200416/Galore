<?php
session_start();
include 'c_navbar.php'; // include navbar

// DB connection
$con = mysqli_connect("localhost","root","","galore2026");
$email = $_SESSION['email'] ?? '';

// Redirect if user is not logged in
if(!$email){
    header("Location: co_login.php");
    exit;
}

// Display message if exists
$msg = $_SESSION['msg'] ?? '';
unset($_SESSION['msg']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password | Galore 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: "Segoe UI", sans-serif; background: linear-gradient(135deg, #ffffff, #f8f9fa); }
        .edit-card { max-width: 600px; margin: 60px auto; background: white; border-radius: 25px; padding: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); border-top: 6px solid #dc3545; }
        h3 { color: #dc3545; font-weight: 700; margin-bottom: 20px; text-align:center; }
        .input-box { background: #fff5f5; padding: 18px; border-radius: 12px; border-left: 5px solid #dc3545; margin-bottom: 20px; }
        .input-box label { font-size: 13px; color: gray; font-weight: 600; }
        .input-box input { border: none; background: transparent; font-weight: 600; margin-top: 5px; width: 100%; outline: none; }
        .btn-save { background: #dc3545; color: white; padding: 12px 30px; border-radius: 25px; border: none; font-weight: 600; width: 100%; }
        .btn-save:hover { background: #b02a37; }
        .error-msg { color: red; font-size: 13px; margin-top: 5px; }
        .success-msg { color: green; font-size: 14px; margin-bottom: 10px; text-align:center; }
    </style>
</head>
<body>
    <!-- HERO -->
<section class="hero">
    <h1>Chnage Password</h1>
    <p>View & manage your Galore participation</p>
</section>

<div class="container">
    <div class="edit-card">
        <h3>Change Password</h3>

        <?php if($msg): ?>
            <div class="success-msg"><?= $msg ?></div>
        <?php endif; ?>

        <form action="co_change_password_proccess.php" method="POST">
            <div class="input-box">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" required>
            </div>

            <div class="input-box">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" required>
            </div>

            <div class="input-box">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>

            <button type="submit" name="change_password_btn" class="btn-save">
                <i class="fas fa-key"></i> Update Password
            </button>
        </form>
    </div>
</div>
</body>
</html>