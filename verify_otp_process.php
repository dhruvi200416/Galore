<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'];

    // Check if OTP exists in session
    if (!isset($_SESSION['reset_otp']) || !isset($_SESSION['otp_expiry'])) {
        echo json_encode(['success' => false, 'message' => 'No OTP request found. Please request a new OTP.']);
        exit();
    }

    $stored_otp = $_SESSION['reset_otp'];
    $expiry = $_SESSION['otp_expiry'];
    $current_time = date('Y-m-d H:i:s');

    // Check if OTP is expired
    if ($current_time > $expiry) {
        // Clear expired OTP
        unset($_SESSION['reset_otp']);
        unset($_SESSION['otp_expiry']);
        echo json_encode(['success' => false, 'message' => 'OTP has expired. Please request a new one.']);
        exit();
    }

    // Verify OTP
    if ($entered_otp == $stored_otp) {
        // OTP verified successfully
        $_SESSION['otp_verified'] = true;
        echo json_encode(['success' => true, 'message' => 'OTP verified successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
