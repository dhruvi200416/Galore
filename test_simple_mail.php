<?php
// test_simple_mail.php - Simple email test
include 'c_navbar.php';
include 'mailer.php';

$result = "";
$test_email = "your_personal_email@gmail.com"; // CHANGE THIS TO YOUR EMAIL

echo "<h2>Testing Email Configuration</h2>";

// Test 1: Check if PHPMailer exists
echo "<h3>Test 1: Checking PHPMailer</h3>";
if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    echo "✅ PHPMailer found<br>";
} else {
    echo "❌ PHPMailer not found! Check your include path.<br>";
}

// Test 2: Try to send a test email
echo "<h3>Test 2: Sending Test Email</h3>";
$subject = "Test Email from Galore 2026";
$body = "<h1>Test</h1><p>This is a test email sent at " . date('Y-m-d H:i:s') . "</p>";

$result = sendEmail($test_email, $subject, $body);

if ($result === true) {
    echo "✅ Test email sent successfully to $test_email!<br>";
} else {
    echo "❌ Failed to send: " . $result . "<br>";
}

// Test 3: Show PHP configuration
echo "<h3>Test 3: PHP Configuration</h3>";
echo "OpenSSL loaded: " . (extension_loaded('openssl') ? '✅ Yes' : '❌ No') . "<br>";
echo "allow_url_fopen: " . (ini_get('allow_url_fopen') ? '✅ On' : '❌ Off') . "<br>";
