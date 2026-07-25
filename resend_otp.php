<?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['reset_email'];

    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Session expired. Please try again.']);
        exit();
    }

    // Get user details
    $query = "SELECT id, full_name FROM registration WHERE email = '$email' AND status = 'Active'";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Generate new OTP
        $otp = rand(100000, 999999);
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Update session
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['otp_expiry'] = $expiry;

        // Send new OTP via email
        // For production, implement actual email sending here

        // Log OTP for testing
        $log_file = fopen("otp_log.txt", "a");
        fwrite($log_file, date('Y-m-d H:i:s') . " - RESENT - Email: $email, OTP: $otp\n");
        fclose($log_file);

        echo json_encode(['success' => true, 'message' => 'New OTP sent successfully to ' . $email]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
