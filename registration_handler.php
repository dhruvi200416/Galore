<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

// Include mailer
require_once 'mailer.php';

// Initialize message variables
$success_message = "";
$error_message = "";

// Get the base URL dynamically
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . "://" . $host . "/Galore/";

// CHECK IF TABLE EXISTS, CREATE ONLY IF IT DOESN'T EXIST
$table_check = mysqli_query($con, "SHOW TABLES LIKE 'registration'");
if (mysqli_num_rows($table_check) == 0) {
  // Table doesn't exist, create it with proper structure
  $registration_table = "CREATE TABLE registration (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        enrollment_no VARCHAR(20) NOT NULL UNIQUE,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(15) NOT NULL,
        branch VARCHAR(50) NOT NULL,
        semester INT(2) NOT NULL,
        gender ENUM('Male','Female','Other') NOT NULL,
        role ENUM('Admin','Coordinator','Judge','Participant') NOT NULL DEFAULT 'Participant',
        school VARCHAR(50) NOT NULL,
        status ENUM('Active','Inactive','Pending') NOT NULL DEFAULT 'Pending',
        profile_pic VARCHAR(255),
        password VARCHAR(255) NOT NULL,
        verification_token VARCHAR(64),
        email_verified TINYINT(1) DEFAULT 0,
        registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

  if (mysqli_query($con, $registration_table)) {
    echo "<script>console.log('Table created successfully');</script>";
  } else {
    echo "<script>console.log('Error creating table: " . addslashes(mysqli_error($con)) . "');</script>";
  }
} else {
  // Check and modify status column to include 'Pending'
  $check_status = mysqli_query($con, "SHOW COLUMNS FROM registration LIKE 'status'");
  if ($check_status) {
    $status_info = mysqli_fetch_assoc($check_status);
    // Check if 'Pending' is in the enum values
    if (strpos($status_info['Type'], 'Pending') === false) {
      // Modify the status column to include 'Pending'
      $alter_query = "ALTER TABLE registration MODIFY COLUMN status ENUM('Active','Inactive','Pending') NOT NULL DEFAULT 'Pending'";
      mysqli_query($con, $alter_query);
    }
  }
  
  // Check if verification_token column exists, if not add it
  $check_column = mysqli_query($con, "SHOW COLUMNS FROM registration LIKE 'verification_token'");
  if (mysqli_num_rows($check_column) == 0) {
    mysqli_query($con, "ALTER TABLE registration ADD COLUMN verification_token VARCHAR(64)");
    mysqli_query($con, "ALTER TABLE registration ADD COLUMN email_verified TINYINT(1) DEFAULT 0");
  }
  
  echo "<script>console.log('Table already exists, keeping existing data');</script>";
}

// Process registration form
if (isset($_POST['reg_btn'])) {
  // Initialize errors array
  $errors = [];

  // Get and sanitize form data
  $enrollment_no = mysqli_real_escape_string($con, $_POST['enrollment_no']);
  $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($con, $_POST['lastName'] ?? '');
  $branch = mysqli_real_escape_string($con, $_POST['branch']);
  $semester = mysqli_real_escape_string($con, $_POST['semester']);
  $gender = mysqli_real_escape_string($con, $_POST['gender']);
  $school = mysqli_real_escape_string($con, $_POST['school']);
  $phone = mysqli_real_escape_string($con, $_POST['phone']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = $_POST['password'];
  $role = mysqli_real_escape_string($con, $_POST['role']);
  $confirm_password = $_POST['confirm_password'] ?? '';

  // Check if enrollment no already exists
  $check_enroll = mysqli_query($con, "SELECT id FROM registration WHERE enrollment_no = '$enrollment_no'");
  if (mysqli_num_rows($check_enroll) > 0) {
    $errors[] = "Enrollment number already registered!";
  }

  // Check if email already exists
  $check_email = mysqli_query($con, "SELECT id FROM registration WHERE email = '$email'");
  if (mysqli_num_rows($check_email) > 0) {
    $errors[] = "Email already registered!";
  }

  // Validate password match
  if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match!";
  }

  // Validate password length
  if (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters long!";
  }

  // Validate email domain
  if (!preg_match("/@rku\.ac\.in$/", $email)) {
    $errors[] = "Please use your RKU email address (@rku.ac.in)";
  }

  // Handle profile picture upload
  $profile_pic = "";
  if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
    $upload_dir = "uploads/profile_pics/";

    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES['profile_pic']['name']);
    $target_file = $upload_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['profile_pic']['tmp_name']);
    if ($check === false) {
      $errors[] = "File is not an image.";
    }

    if ($_FILES['profile_pic']['size'] > 2000000) {
      $errors[] = "File is too large. Maximum size is 2MB.";
    }

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
      $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }

    if (empty($errors)) {
      if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
        $profile_pic = $file_name;
      } else {
        $errors[] = "Error uploading file.";
      }
    }
  }

  // If no errors, proceed with registration
  if (empty($errors)) {
    $full_name = $firstName . " " . $lastName;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $verification_token = bin2hex(random_bytes(32));

    // Insert with status 'Inactive' and email_verified = 0
    $insert_query = "INSERT INTO registration 
                        (enrollment_no, full_name, email, password, gender, phone, branch, semester, role, school, profile_pic, status, verification_token, email_verified) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Inactive', ?, 0)";

    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param(
      $stmt,
      "ssssssssssss",
      $enrollment_no,
      $full_name,
      $email,
      $hashed_password,
      $gender,
      $phone,
      $branch,
      $semester,
      $role,
      $school,
      $profile_pic,
      $verification_token
    );

    if (mysqli_stmt_execute($stmt)) {
      // Send verification email
      $verification_link = $base_url . "verify.php?token=" . $verification_token . "&email=" . urlencode($email);
      $login_page_link = $base_url . "login.php";
      
      $email_subject = "Verify Your Email - Galore 2026 Registration";
      $email_body = "
      <!DOCTYPE html>
      <html>
      <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Email Verification</title>
          <style>
              body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0; }
              .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
              .header { background: linear-gradient(135deg, #dc3545, #b02a37); color: white; padding: 30px 20px; text-align: center; }
              .header h1 { margin: 0; font-size: 28px; }
              .content { padding: 30px; }
              .button { display: inline-block; padding: 12px 30px; color: white; text-decoration: none; border-radius: 5px; margin: 10px; font-weight: bold; transition: transform 0.3s ease; }
              .button:hover { transform: translateY(-2px); }
              .button-verify { background-color: #28a745; }
              .button-verify:hover { background-color: #218838; }
              .button-login { background-color: #dc3545; }
              .button-login:hover { background-color: #b02a37; }
              .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #666; }
              .info-box { background-color: #f8f9fa; border-left: 4px solid #dc3545; padding: 15px; margin: 20px 0; border-radius: 5px; }
              .button-container { text-align: center; margin: 30px 0; }
              .note { background-color: #fff3cd; border: 1px solid #ffc107; padding: 12px; border-radius: 5px; margin-top: 20px; font-size: 14px; color: #856404; }
          </style>
      </head>
      <body>
          <div class='container'>
              <div class='header'>
                  <h1>🎉 Welcome to Galore 2026!</h1>
              </div>
              <div class='content'>
                  <h2>Hello {$full_name},</h2>
                  <p>Thank you for registering for <strong>Galore 2026</strong>! We're excited to have you onboard.</p>
                  
                  <div class='info-box'>
                      <strong>📋 Registration Details:</strong><br>
                      📝 Enrollment No: {$enrollment_no}<br>
                      👤 Name: {$full_name}<br>
                      📧 Email: {$email}<br>
                      🎭 Role: {$role}
                  </div>
                  
                  <p><strong>IMPORTANT: Please verify your email address by clicking the button below to activate your account:</strong></p>
                  
                  <div class='button-container'>
                      <a href='{$verification_link}' class='button button-verify'>
                          ✅ Verify Email & Activate Account
                      </a>
                  </div>
                  
                  <div class='note'>
                      <strong>⚠️ Note:</strong> Your account will remain <strong>INACTIVE</strong> until you verify your email address.
                      After verification, you will be able to login using your credentials.
                  </div>
                  
                  <p>If the button doesn't work, copy and paste this link into your browser:</p>
                  <p style='word-break: break-all; font-size: 12px;'>
                      <a href='{$verification_link}'>{$verification_link}</a>
                  </p>
                  
                  <p>If you didn't create this account, please ignore this email.</p>
                  
                  <p>Best regards,<br>
                  <strong>Galore 2026 Team</strong><br>
                  RK University</p>
              </div>
              <div class='footer'>
                  <p>© 2026 Galore - RK University. All rights reserved.</p>
                  <p>This is an automated message, please do not reply to this email.</p>
              </div>
          </div>
      </body>
      </html>
      ";
      
      $email_sent = sendEmail($email, $email_subject, $email_body);
      
      if ($email_sent === true) {
        $success_message = "Registration successful! A verification link has been sent to your email. Please check your inbox and verify your email to activate your account.";
      } else {
        $success_message = "Registration successful but we couldn't send the verification email. Please contact support.";
      }
      
      $_POST = array();
    } else {
      $error_message = "Registration failed: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
  } else {
    $error_message = implode("<br>", $errors);
  }
}
?>