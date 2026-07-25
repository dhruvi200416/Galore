<?php
session_start();

// DB connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("DB Error: " . mysqli_connect_error());
}

$login_error = "";

if (isset($_POST['login_btn'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ===================================================
    // 🔴 1. CHECK IN ad_register (Admin / Coordinator)
    // ===================================================
    $query1 = "SELECT * FROM ad_register WHERE email='$email' LIMIT 1";
    $result1 = mysqli_query($con, $query1);

    if ($result1 && mysqli_num_rows($result1) > 0) {

        $user = mysqli_fetch_assoc($result1);

        if ($user['status'] != 'Active') {
            $login_error = "Account not active! Please contact administrator.";
        } else {

            $dbPassword = $user['password'];
            $isValid = false;

            // HASH OR PLAIN CHECK
            if (strlen($dbPassword) > 20) {
                $isValid = password_verify($password, $dbPassword);
            } else {
                $isValid = ($password === $dbPassword);
            }

            if ($isValid) {

                // SESSION
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;

                // ROLE REDIRECT
                switch ($user['role']) {
                    case 'Admin':
                        header("Location: admin_dashboard.php");
                        break;
                    case 'Coordinator':
                        header("Location: c_dashboard.php");
                        break;
                    case 'Co-coordinator':
                        header("Location: co_dashboard.php");
                        break;
                    default:
                        echo "Invalid role!";
                }
                exit();
            } else {
                $login_error = "Wrong password!";
            }
        }
    } else {

        // ===================================================
        // 🔵 2. CHECK IN registration (Participant)
        // ===================================================
        $query2 = "SELECT * FROM registration WHERE email='$email' LIMIT 1";
        $result2 = mysqli_query($con, $query2);

        if ($result2 && mysqli_num_rows($result2) > 0) {

            $user = mysqli_fetch_assoc($result2);

            // IMPORTANT: Check email verification status
            if ($user['email_verified'] == 0) {
                $login_error = "Account not activated! Please check your email and click the verification link to activate your account.";
            } 
            elseif ($user['status'] != 'Active') {
                $login_error = "Your account is not active. Please contact support.";
            } 
            else {

                $dbPassword = $user['password'];
                $isValid = false;

                // HASH OR PLAIN CHECK
                if (strlen($dbPassword) > 20) {
                    $isValid = password_verify($password, $dbPassword);
                } else {
                    $isValid = ($password === $dbPassword);
                }

                if ($isValid) {

                    // SESSION
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['enrollment_no'] = $user['enrollment_no'];
                    $_SESSION['role'] = "Participant";
                    $_SESSION['logged_in'] = true;

                    header("Location: profile.php");
                    exit();
                } else {
                    $login_error = "Wrong password!";
                }
            }
        } else {
            $login_error = "Email not found! Please register first.";
        }
    }
}

// REMOVE THIS DUPLICATE CODE - IT'S CAUSING ERRORS
// The code below was outside the main logic and causing issues
// It was trying to use $email which might not be defined in some cases
// and was overwriting the login_error variable

/*
// After verifying username and password
$check_verification = "SELECT email_verified, status FROM registration WHERE email = '$email'";
$result = mysqli_query($con, $check_verification);
$user_data = mysqli_fetch_assoc($result);

if ($user_data['email_verified'] == 0) {
    $error_message = "Please verify your email address first. Check your inbox for the verification link.";
    // Optionally, add a button to resend verification email
} elseif ($user_data['status'] != 'Active') {
    $error_message = "Your account is not active. Please contact support.";
} else {
    // Allow login
    $_SESSION['user_email'] = $email;
    // ... rest of login logic
}
*/
?>