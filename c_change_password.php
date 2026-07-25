<?php
session_start();
include 'co_navbar.php';

$con = mysqli_connect("localhost", "root", "", "galore2026");
$email = $_SESSION['email'];

// Initialize error variables
$current_error = $new_error = $confirm_error = "";
$success_msg = "";

// Check if errors are passed via session
if(isset($_SESSION['change_password_errors'])){
    $errors = $_SESSION['change_password_errors'];
    $current_error = $errors['current'] ?? '';
    $new_error = $errors['new'] ?? '';
    $confirm_error = $errors['confirm'] ?? '';
    unset($_SESSION['change_password_errors']);
}

if(isset($_SESSION['change_password_success'])){
    $success_msg = $_SESSION['change_password_success'];
    unset($_SESSION['change_password_success']);
}
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

    <?php if($success_msg != ""): ?>
        <!-- Redirect to profile page after 3 seconds -->
        <meta http-equiv="refresh" content="3;url=c_profile.php">
    <?php endif; ?>
</head>
<body>
    <section class="hero">
    <h1>Change Password</h1>
    <p>View & manage your Galore participation</p>
</section>

<div class="edit-card">
    <h3>Change Password</h3>

    <?php if($success_msg != ""): ?>
        <div class="success-msg"><?php echo $success_msg; ?><br>Redirecting to profile...</div>
    <?php endif; ?>

    <form action="c_change_password_process.php" method="POST">

        <div class="input-box">
            <label>Current Password *</label>
            <input type="password" name="current_password" required>
            <?php if($current_error != ""): ?>
                <div class="error-msg"><?php echo $current_error; ?></div>
            <?php endif; ?>
        </div>

        <div class="input-box">
            <label>New Password *</label>
            <input type="password" name="new_password" required>
            <?php if($new_error != ""): ?>
                <div class="error-msg"><?php echo $new_error; ?></div>
            <?php endif; ?>
        </div>

        <div class="input-box">
            <label>Confirm New Password *</label>
            <input type="password" name="confirm_password" required>
            <?php if($confirm_error != ""): ?>
                <div class="error-msg"><?php echo $confirm_error; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-save">Update Password</button>

    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>