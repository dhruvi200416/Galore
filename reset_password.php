<?php
// reset_password.php - Fixed specifically for ad_register
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'mailer.php';

$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $recovery_id = trim($_POST['recovery_id']);
    
    if (empty($recovery_id)) {
        header("Location: forgot_password.php?error=" . urlencode("Please enter your email or enrollment number."));
        exit();
    }
    
    $user = null;
    $table_name = '';
    
    // Check in registration table first
    $query_student = "SELECT id, email, full_name, 'student' as user_type FROM registration WHERE (email = ? OR enrollment_no = ?) AND status = 'Active' LIMIT 1";
    $stmt_student = mysqli_prepare($con, $query_student);
    mysqli_stmt_bind_param($stmt_student, "ss", $recovery_id, $recovery_id);
    mysqli_stmt_execute($stmt_student);
    $result_student = mysqli_stmt_get_result($stmt_student);
    
    if ($result_student && mysqli_num_rows($result_student) > 0) {
        $user = mysqli_fetch_assoc($result_student);
        $table_name = 'registration';
    } else {
        // Check in ad_register table - use email or phone
        $query_admin = "SELECT id, email, full_name, 'admin' as user_type FROM ad_register WHERE (email = ? OR phone = ?) AND status = 'Active' LIMIT 1";
        $stmt_admin = mysqli_prepare($con, $query_admin);
        mysqli_stmt_bind_param($stmt_admin, "ss", $recovery_id, $recovery_id);
        mysqli_stmt_execute($stmt_admin);
        $result_admin = mysqli_stmt_get_result($stmt_admin);
        
        if ($result_admin && mysqli_num_rows($result_admin) > 0) {
            $user = mysqli_fetch_assoc($result_admin);
            $table_name = 'ad_register';
        }
    }
    
    if ($user && !empty($table_name)) {
        $user_id = $user['id'];
        $user_email = $user['email'];
        $user_name = $user['full_name'];
        
        // Generate reset token
        $reset_token = bin2hex(random_bytes(32));
        $token_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // For ad_register, ensure we're using correct field types
        if ($table_name == 'ad_register') {
            // Explicitly cast to string for datetime
            $update_query = "UPDATE ad_register SET reset_token = ?, token_expiry = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($update_stmt, "ssi", $reset_token, $token_expiry, $user_id);
        } else {
            $update_query = "UPDATE registration SET reset_token = ?, token_expiry = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($update_stmt, "ssi", $reset_token, $token_expiry, $user_id);
        }
        
        if (mysqli_stmt_execute($update_stmt)) {
            // Verify token was stored
            $verify_query = "SELECT reset_token, token_expiry FROM $table_name WHERE id = ?";
            $verify_stmt = mysqli_prepare($con, $verify_query);
            mysqli_stmt_bind_param($verify_stmt, "i", $user_id);
            mysqli_stmt_execute($verify_stmt);
            $verify_result = mysqli_stmt_get_result($verify_stmt);
            $verify_data = mysqli_fetch_assoc($verify_result);
            
            // Debug - log this to a file instead of displaying
            error_log("Token stored for $table_name ID $user_id: " . $verify_data['reset_token']);
            error_log("Expiry: " . $verify_data['token_expiry']);
            
            if (empty($verify_data['reset_token'])) {
                header("Location: forgot_password.php?error=" . urlencode("Failed to store reset token. Please try again."));
                exit();
            }
            
            // Create reset link
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $reset_link = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/Galore/reset_confirm.php?token=" . urlencode($reset_token) . "&type=" . $table_name;
            
            $subject = "Password Reset Request - RKU Galore 2026";
            $body = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>Password Reset</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
                    .header { background: #dc3545; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                    .content { padding: 20px; }
                    .button { display: inline-block; background: #dc3545; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                    .footer { background: #f4f4f4; padding: 10px; text-align: center; font-size: 12px; }
                    .info { background: #e9ecef; padding: 10px; border-radius: 5px; margin: 10px 0; word-break: break-all; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>RKU Galore 2026</h2>
                    </div>
                    <div class='content'>
                        <h3>Hello " . htmlspecialchars($user_name) . ",</h3>
                        <p>We received a request to reset your password for your " . ($table_name == 'ad_register' ? 'Admin/Coordinator' : 'Student') . " account.</p>
                        <div style='text-align: center;'>
                            <a href='" . $reset_link . "' class='button'>Reset Password</a>
                        </div>
                        <p>Or copy this link:</p>
                        <div class='info'>" . $reset_link . "</div>
                        <p><strong>This link will expire in 1 hour.</strong></p>
                        <p>If you didn't request this, please ignore this email.</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2026 RKU Galore. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $email_result = sendEmail($user_email, $subject, $body);
            
            if ($email_result === true) {
                $success_msg = "Password reset instructions have been sent to: " . htmlspecialchars($user_email);
                header("Location: forgot_password.php?success=" . urlencode($success_msg));
                exit();
            } else {
                header("Location: forgot_password.php?error=" . urlencode("Failed to send email. Please try again."));
                exit();
            }
        } else {
            error_log("Update error: " . mysqli_error($con));
            header("Location: forgot_password.php?error=" . urlencode("Database error. Please try again."));
            exit();
        }
        mysqli_stmt_close($update_stmt);
    } else {
        header("Location: forgot_password.php?error=" . urlencode("No active account found with this email or enrollment number/phone."));
        exit();
    }
    
    if (isset($stmt_student)) mysqli_stmt_close($stmt_student);
    if (isset($stmt_admin)) mysqli_stmt_close($stmt_admin);
} else {
    header("Location: forgot_password.php");
    exit();
}

mysqli_close($con);
?>