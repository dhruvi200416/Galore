<?php
session_start();
include 'mailer.php';

$to = "your_email@gmail.com"; // Change to your email
$subject = "Test Email";
$body = "<h1>Test</h1><p>This is a test email.</p>";

$result = sendEmail($to, $subject, $body);

if ($result === true) {
    echo "✅ Email sent successfully!";
} else {
    echo "❌ Failed: " . $result;
}
