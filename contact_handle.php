<?php
session_start(); // Start session to access logged-in user data

// Enable error reporting temporarily for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize variables
$success_message = "";
$error_message = "";
$con = null;

// Initialize header data with defaults
$header_data = [
    'hero_title' => 'Contact Galore Team',
    'hero_subtitle' => 'We\'re here to help you with events & registration',
    'form_title' => '📩 Get in Touch',
    'form_subtitle' => 'Have any questions? Fill out the form below.',
    'footer_note' => 'Galore Team will respond within 24 hours.'
];

// Initialize POST variables
$name = '';
$email = '';
$phone = '';
$subject = '';
$message = '';

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (!$con) {
    $error_message = "Database connection failed: " . mysqli_connect_error();
} else {
    // Set charset
    mysqli_set_charset($con, "utf8mb4");

    // Fetch contact header data
    $header_query = "SELECT * FROM contact_header WHERE status = 'Active' LIMIT 1";
    $header_result = mysqli_query($con, $header_query);

    if ($header_result && mysqli_num_rows($header_result) > 0) {
        $fetched_data = mysqli_fetch_assoc($header_result);
        if ($fetched_data && is_array($fetched_data)) {
            $header_data = array_merge($header_data, $fetched_data);
        }
    }
}

// Check if user is logged in and fetch their information
$logged_in_user_data = null;
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $con) {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

    if ($user_id > 0) {
        // Determine which table to query based on role
        if ($user_role == 'Participant') {
            $query = "SELECT full_name, email, phone FROM registration WHERE id = ? LIMIT 1";
        } else {
            $query = "SELECT full_name, email, phone FROM ad_register WHERE id = ? LIMIT 1";
        }

        $stmt = mysqli_prepare($con, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $logged_in_user_data = mysqli_fetch_assoc($result);

                // Pre-fill name, email, and phone from logged-in user data
                if (isset($logged_in_user_data['full_name']) && !empty($logged_in_user_data['full_name'])) {
                    $name = $logged_in_user_data['full_name'];
                }

                if (isset($logged_in_user_data['email']) && !empty($logged_in_user_data['email'])) {
                    $email = $logged_in_user_data['email'];
                }

                if (isset($logged_in_user_data['phone']) && !empty($logged_in_user_data['phone'])) {
                    $phone = $logged_in_user_data['phone'];
                }
            }
            mysqli_stmt_close($stmt);
        }
    }

    // If database fetch failed but session has the data, use session data
    if (empty($name) && isset($_SESSION['full_name']) && !empty($_SESSION['full_name'])) {
        $name = $_SESSION['full_name'];
    }

    if (empty($email) && isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        $email = $_SESSION['email'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get POST data with defaults
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Please enter a valid 10-digit phone number";
    }
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    if (empty($message)) {
        $errors[] = "Message is required";
    }

    if (empty($errors) && $con) {
        // Insert into database
        $sql = "INSERT INTO contact_messages (full_name, email, phone, subject, message, status) 
                VALUES (?, ?, ?, ?, ?, 'Active')";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $subject, $message);

            if (mysqli_stmt_execute($stmt)) {
                // Set success message in session
                $_SESSION['contact_success'] = "Thank you! Your message has been sent successfully. We'll get back to you within 24 hours.";
                
                // Close statement
                mysqli_stmt_close($stmt);
                
                // Close connection
                mysqli_close($con);
                
                // Redirect to home page
                header("Location: home.php");
                exit();
            } else {
                $error_message = "Unable to send message. Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        } else {
            $error_message = "System error. Please try again later. Error: " . mysqli_error($con);
        }
    } elseif (!empty($errors)) {
        $error_message = implode("<br>", $errors);
    } elseif (!$con) {
        $error_message = "Database connection error. Please try again later.";
    }
}

// Function to safely get field value
function getFieldValue($field, $default = '') {
    global $name, $email, $phone, $subject, $message;

    // Check if POST data exists
    if (isset($_POST[$field]) && !empty($_POST[$field])) {
        return htmlspecialchars($_POST[$field], ENT_QUOTES, 'UTF-8');
    }

    // Return the pre-filled value from our variables
    switch ($field) {
        case 'name':
            return !empty($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : $default;
        case 'email':
            return !empty($email) ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : $default;
        case 'phone':
            return !empty($phone) ? htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') : $default;
        case 'subject':
            return !empty($subject) ? htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') : $default;
        case 'message':
            return !empty($message) ? htmlspecialchars($message, ENT_QUOTES, 'UTF-8') : $default;
        default:
            return $default;
    }
}

// Function to safely get header value
function getHeaderValue($data, $key, $default = '') {
    return isset($data[$key]) && !empty($data[$key]) ? htmlspecialchars($data[$key], ENT_QUOTES, 'UTF-8') : htmlspecialchars($default, ENT_QUOTES, 'UTF-8');
}

// Function to check if field should be readonly
function isFieldReadonly($field) {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        return false;
    }

    // Name and email are readonly for logged-in users
    if ($field == 'name' || $field == 'email') {
        return true;
    }

    return false;
}
?>