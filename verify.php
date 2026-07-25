<?php
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the base URL dynamically
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . "://" . $host . "/Galore/";

$token = isset($_GET['token']) ? mysqli_real_escape_string($con, $_GET['token']) : '';
$email = isset($_GET['email']) ? mysqli_real_escape_string($con, urldecode($_GET['email'])) : '';

$message = '';
$message_type = '';

if (!empty($token) && !empty($email)) {
    // Check if token exists and is valid
    $check_query = "SELECT id, full_name, email_verified, status FROM registration 
                    WHERE verification_token = '$token' AND email = '$email'";
    $result = mysqli_query($con, $check_query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Check if already verified
        if ($user['email_verified'] == 1) {
            $message = "Your email has already been verified. Your account is active.";
            $message_type = "info";
        } else {
            // IMPORTANT: Update user status to Active and set email_verified to 1
            $update_query = "UPDATE registration 
                            SET email_verified = 1, 
                                status = 'Active',
                                verification_token = NULL 
                            WHERE verification_token = '$token' AND email = '$email'";
            
            if (mysqli_query($con, $update_query)) {
                $message = "Congratulations! Your email has been verified and your account is now ACTIVE.";
                $message_type = "success";
                
                // Send welcome email with login button
                $welcome_subject = "Welcome to Galore 2026 - Account Activated!";
                $login_page_link = $base_url . "login.php";
                $welcome_body = "
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .container { max-width: 600px; margin: auto; padding: 20px; }
                        .header { background: linear-gradient(135deg, #28a745, #218838); color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                        .content { padding: 30px; background: #f9f9f9; }
                        .button { display: inline-block; padding: 12px 30px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; font-weight: bold; }
                        .button:hover { background: #b02a37; }
                        .footer { background: #f1f1f1; padding: 15px; text-align: center; font-size: 12px; border-radius: 0 0 10px 10px; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>Account Activated! 🎉</h1>
                        </div>
                        <div class='content'>
                            <h2>Hello {$user['full_name']},</h2>
                            <p>Congratulations! Your email has been successfully verified and your account is now <strong style='color: #28a745;'>ACTIVE</strong>.</p>
                            <p>You can now login to your account and start participating in Galore 2026 events.</p>
                            <div style='text-align: center;'>
                                <a href='{$login_page_link}' class='button'>🔐 Click Here to Login</a>
                            </div>
                            <p>If the button doesn't work, copy and paste this link into your browser:</p>
                            <p><a href='{$login_page_link}'>{$login_page_link}</a></p>
                            <p>We look forward to seeing you at Galore 2026!</p>
                            <p>Best regards,<br><strong>Galore 2026 Team</strong><br>RK University</p>
                        </div>
                        <div class='footer'>
                            <p>© 2026 Galore - RK University. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>
                ";
                
                require_once 'mailer.php';
                sendEmail($email, $welcome_subject, $welcome_body);
            } else {
                $message = "Error verifying email. Please try again or contact support.";
                $message_type = "danger";
            }
        }
    } else {
        $message = "Invalid verification link. Please check your email or request a new verification link.";
        $message_type = "danger";
    }
} else {
    $message = "Invalid verification request.";
    $message_type = "danger";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - RKU Galore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .verification-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .icon-success { color: #28a745; }
        .icon-danger { color: #dc3545; }
        .icon-info { color: #17a2b8; }
        
        .btn-login {
            background: linear-gradient(135deg, #dc3545, #b02a37);
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: transform 0.3s ease;
            font-weight: bold;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            color: white;
        }
        
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        
        .message {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin-bottom: 20px;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: transform 0.3s ease;
            font-weight: bold;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
    <div class="verification-card">
        <?php if ($message_type == "success"): ?>
            <div class="icon icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Email Verified Successfully!</h2>
            <div class="message"><?php echo $message; ?></div>
            <p>Your account is now <strong class="text-success">ACTIVE</strong>. Click the button below to login:</p>
            <a href="<?php echo $base_url; ?>login.php" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login to Your Account
            </a>
        <?php elseif ($message_type == "info"): ?>
            <div class="icon icon-info">
                <i class="fas fa-info-circle"></i>
            </div>
            <h2>Already Verified</h2>
            <div class="message"><?php echo $message; ?></div>
            <a href="<?php echo $base_url; ?>login.php" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login to Your Account
            </a>
        <?php else: ?>
            <div class="icon icon-danger">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h2>Verification Failed</h2>
            <div class="message"><?php echo $message; ?></div>
            <a href="<?php echo $base_url; ?>registration.php" class="btn-register">
                <i class="fas fa-user-plus me-2"></i>Register Again
            </a>
        <?php endif; ?>
        
        <hr class="my-4">
        <p class="text-muted small mb-0">
            <i class="fas fa-question-circle me-1"></i>Need help? Contact Galore support
        </p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>