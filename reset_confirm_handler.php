<?php
// reset_confirm_handler.php - Fixed for ad_register
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$token_valid = false;
$error_message = '';
$success_message = '';
$user_id = '';
$user_name = '';
$user_table = '';

// Check if token is provided
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = mysqli_real_escape_string($con, $_GET['token']);
    $user_type = isset($_GET['type']) ? mysqli_real_escape_string($con, $_GET['type']) : 'registration';
    
    // For ad_register, we need to be careful with datetime comparison
    if ($user_type == 'ad_register') {
        // First, get the token data without expiry check
        $check_query = "SELECT id, full_name, reset_token, token_expiry FROM ad_register WHERE reset_token = ?";
        $check_stmt = mysqli_prepare($con, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $token);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($check_result) > 0) {
            $user_data = mysqli_fetch_assoc($check_result);
            
            // Now check if token is expired
            $current_time = date('Y-m-d H:i:s');
            $token_expiry = $user_data['token_expiry'];
            
            if ($token_expiry && $token_expiry > $current_time) {
                $user_id = $user_data['id'];
                $user_name = $user_data['full_name'];
                $user_table = 'ad_register';
                $token_valid = true;
                error_log("Valid token for ad_register user ID: $user_id");
            } else {
                error_log("Token expired for ad_register. Expiry: $token_expiry, Current: $current_time");
                $error_message = "Your password reset link has expired. Please request a new one.";
            }
        } else {
            error_log("No token found in ad_register table: $token");
            $error_message = "Invalid password reset link. Please request a new one.";
        }
        mysqli_stmt_close($check_stmt);
    } else {
        // Handle registration table similarly
        $check_query = "SELECT id, full_name, reset_token, token_expiry FROM registration WHERE reset_token = ?";
        $check_stmt = mysqli_prepare($con, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $token);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($check_result) > 0) {
            $user_data = mysqli_fetch_assoc($check_result);
            $current_time = date('Y-m-d H:i:s');
            $token_expiry = $user_data['token_expiry'];
            
            if ($token_expiry && $token_expiry > $current_time) {
                $user_id = $user_data['id'];
                $user_name = $user_data['full_name'];
                $user_table = 'registration';
                $token_valid = true;
                error_log("Valid token for registration user ID: $user_id");
            } else {
                $error_message = "Your password reset link has expired. Please request a new one.";
            }
        } else {
            $error_message = "Invalid password reset link. Please request a new one.";
        }
        mysqli_stmt_close($check_stmt);
    }
}

// Process password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $user_table = mysqli_real_escape_string($con, $_POST['user_table']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate password
    if (strlen($new_password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password and clear reset token
        $update_query = "UPDATE $user_table SET password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?";
        $update_stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $user_id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            $success_message = "Your password has been successfully reset. You can now login with your new password.";
            $token_valid = false;
            
            // Get user email for confirmation
            $email_query = "SELECT email, full_name FROM $user_table WHERE id = ?";
            $email_stmt = mysqli_prepare($con, $email_query);
            mysqli_stmt_bind_param($email_stmt, "i", $user_id);
            mysqli_stmt_execute($email_stmt);
            $email_result = mysqli_stmt_get_result($email_stmt);
            
            if ($email_result && mysqli_num_rows($email_result) > 0) {
                $user_data = mysqli_fetch_assoc($email_result);
                $user_email = $user_data['email'];
                $user_fullname = $user_data['full_name'];
                
                // Send confirmation email
                require_once 'mailer.php';
                $subject = "Password Changed Successfully - RKU Galore 2026";
                $body = "
                <html>
                <body>
                    <h2>Password Changed Successfully</h2>
                    <p>Hello " . htmlspecialchars($user_fullname) . ",</p>
                    <p>Your password has been successfully changed. If you did not make this change, please contact support immediately.</p>
                    <p>You can now login using your new password.</p>
                    <p>Best regards,<br>Galore 2026 Team</p>
                </body>
                </html>
                ";
                sendEmail($user_email, $subject, $body);
            }
            mysqli_stmt_close($email_stmt);
        } else {
            $error_message = "Failed to reset password. Please try again.";
            error_log("Password reset error: " . mysqli_error($con));
        }
        mysqli_stmt_close($update_stmt);
    }
}

mysqli_close($con);
?>