<?php
require_once 'admin_auth_check.php';

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// ==================== CREATE ADMIN PROFILE TABLE (ad_register) ====================
$c_profile_table = "CREATE TABLE IF NOT EXISTS ad_register (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    gender ENUM('Male','Female','Other') NOT NULL,
    role ENUM('Admin','Coordinator','Co-coordinator') NOT NULL DEFAULT 'Coordinator',
    school VARCHAR(50) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    profile_pic VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $c_profile_table)) {
    // Ensure role column has correct ENUM values
    $alter_table = "ALTER TABLE ad_register MODIFY COLUMN role ENUM('Admin','Coordinator','Co-coordinator') NOT NULL DEFAULT 'Coordinator'";
    mysqli_query($con, $alter_table);
}

// ==================== HANDLE CHANGE PASSWORD ====================
if (isset($_POST['update_password'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_new_password'];
    
    // Validate inputs
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['profile_error'] = "Please fill in all password fields!";
        header("Location: ad_profile.php");
        exit();
    }
    
    if ($new_password !== $confirm_password) {
        $_SESSION['profile_error'] = "New passwords do not match!";
        header("Location: ad_profile.php");
        exit();
    }
    
    if (strlen($new_password) < 4) {
        $_SESSION['profile_error'] = "Password must be at least 4 characters long!";
        header("Location: ad_profile.php");
        exit();
    }
    
    // Get current user's password from database
    $user_query = "SELECT password, role FROM ad_register WHERE id = '$user_id'";
    $user_result = mysqli_query($con, $user_query);
    
    if (mysqli_num_rows($user_result) == 0) {
        $_SESSION['profile_error'] = "User not found!";
        header("Location: ad_profile.php");
        exit();
    }
    
    $user_data = mysqli_fetch_assoc($user_result);
    $current_hashed_password = $user_data['password'];
    $user_role = $user_data['role'];
    
    // Verify old password
    if (!password_verify($old_password, $current_hashed_password)) {
        $_SESSION['profile_error'] = "Old password is incorrect!";
        header("Location: ad_profile.php");
        exit();
    }
    
    // Check if new password is same as old password
    if (password_verify($new_password, $current_hashed_password)) {
        $_SESSION['profile_error'] = "New password cannot be the same as old password!";
        header("Location: ad_profile.php");
        exit();
    }
    
    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update password in database
    $update_query = "UPDATE ad_register SET password = '$hashed_password', updated_at = NOW() WHERE id = '$user_id'";
    
    if (mysqli_query($con, $update_query)) {
        $_SESSION['profile_success'] = "Password changed successfully for " . ucfirst($user_role) . " account!";
        header("Location: ad_profile.php");
        exit();
    } else {
        $_SESSION['profile_error'] = "Error updating password: " . mysqli_error($con);
        header("Location: ad_profile.php");
        exit();
    }
}
// ==================== HANDLE FORM SUBMISSION ====================
if (isset($_POST['submit_c_profile'])) {
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $branch = mysqli_real_escape_string($con, $_POST['branch']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $school = mysqli_real_escape_string($con, $_POST['school']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    // Check if passwords match for new profile or password change
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // For edit, only validate if password fields are not empty
        if (!empty($password) || !empty($confirm_password)) {
            if ($password !== $confirm_password) {
                $_SESSION['profile_error'] = "Passwords do not match!";
                header("Location: ad_profile.php");
                exit();
            }
            if (strlen($password) < 4) {
                $_SESSION['profile_error'] = "Password must be at least 4 characters long!";
                header("Location: ad_profile.php");
                exit();
            }
        }
    } else {
        // For new profile, password is required
        if ($password !== $confirm_password) {
            $_SESSION['profile_error'] = "Passwords do not match!";
            header("Location: ad_profile.php");
            exit();
        }
        if (strlen($password) < 4) {
            $_SESSION['profile_error'] = "Password must be at least 4 characters long!";
            header("Location: ad_profile.php");
            exit();
        }
    }

    // Handle file upload for profile_pic - Save in website folder with original name
    $profile_pic = "";
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "website/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Get original filename
        $original_filename = basename($_FILES["profile_pic"]["name"]);
        // Clean filename to remove special characters but keep original name
        $original_filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $original_filename);

        $target_file = $target_dir . $original_filename;

        // Check if file already exists, if yes, add a number suffix
        $file_counter = 1;
        $file_pathinfo = pathinfo($target_file);
        $filename_without_ext = $file_pathinfo['filename'];
        $extension = isset($file_pathinfo['extension']) ? '.' . $file_pathinfo['extension'] : '';

        while (file_exists($target_file)) {
            $new_filename = $filename_without_ext . '_' . $file_counter . $extension;
            $target_file = $target_dir . $new_filename;
            $file_counter++;
        }

        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            $profile_pic = $target_file;
        }
    }

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);
        $update_query = "UPDATE ad_register SET 
                        full_name = '$full_name',
                        email = '$email',
                        phone = '$phone',
                        branch = '$branch',
                        gender = '$gender',
                        school = '$school',
                        status = '$status'";
        
        // Only update role if it's provided and it's not empty
        if (!empty($role)) {
            $update_query .= ", role = '$role'";
        }
        
        // Add password to update if provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_query .= ", password = '$hashed_password'";
        }
        
        if (!empty($profile_pic)) {
            // Get old image to delete
            $old_image_query = "SELECT profile_pic FROM ad_register WHERE id = '$edit_id'";
            $old_result = mysqli_query($con, $old_image_query);
            if (mysqli_num_rows($old_result) > 0) {
                $old_row = mysqli_fetch_assoc($old_result);
                if (!empty($old_row['profile_pic']) && file_exists($old_row['profile_pic'])) {
                    unlink($old_row['profile_pic']);
                }
            }
            $update_query .= ", profile_pic = '$profile_pic'";
        }
        $update_query .= " WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            $_SESSION['profile_success'] = "Profile updated successfully!";
            header("Location: ad_profile.php");
            exit();
        } else {
            $_SESSION['profile_error'] = "Error updating profile: " . mysqli_error($con);
            header("Location: ad_profile.php");
            exit();
        }
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO ad_register (full_name, email, phone, branch, gender, role, school, status, profile_pic, password) 
                         VALUES ('$full_name', '$email', '$phone', '$branch', '$gender', '$role', '$school', '$status', '$profile_pic', '$hashed_password')";
        if (mysqli_query($con, $insert_query)) {
            $_SESSION['profile_success'] = "Profile created successfully!";
            header("Location: ad_profile.php");
            exit();
        } else {
            $_SESSION['profile_error'] = "Error: " . mysqli_error($con);
            header("Location: ad_profile.php");
            exit();
        }
    }
}

// ==================== HANDLE STATUS TOGGLE ====================
if (isset($_GET['toggle_status_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_status_id']);
    
    // Get current status before toggling
    $status_query = "SELECT status FROM ad_register WHERE id = '$toggle_id'";
    $status_result = mysqli_query($con, $status_query);
    
    if (mysqli_num_rows($status_result) > 0) {
        $current_status = mysqli_fetch_assoc($status_result)['status'];
        
        // Toggle the status
        $toggle_query = "UPDATE ad_register SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
        
        if (mysqli_query($con, $toggle_query)) {
            // If status was Active and now becomes Inactive, redirect to login
            if ($current_status == 'Active') {
                // Clear session and redirect to login
                session_destroy();
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['profile_success'] = "Status updated successfully!";
                header("Location: ad_profile.php");
                exit();
            }
        } else {
            $_SESSION['profile_error'] = "Error toggling status: " . mysqli_error($con);
            header("Location: ad_profile.php");
            exit();
        }
    } else {
        $_SESSION['profile_error'] = "User not found!";
        header("Location: ad_profile.php");
        exit();
    }
}

// ==================== HANDLE DELETE REQUEST ====================
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $select_query = "SELECT profile_pic FROM ad_register WHERE id = '$delete_id'";
    $result = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row['profile_pic']) && file_exists($row['profile_pic'])) {
            unlink($row['profile_pic']);
        }
    }
    $delete_query = "DELETE FROM ad_register WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        $_SESSION['profile_success'] = "Profile deleted successfully!";
        header("Location: ad_profile.php");
        exit();
    } else {
        $_SESSION['profile_error'] = "Error deleting profile: " . mysqli_error($con);
        header("Location: ad_profile.php");
        exit();
    }
}

// ==================== FETCH PROFILE BASED ON ROLE ====================
// Get logged-in user's role from session
$logged_in_role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Admin';
$logged_in_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$latestProfile = null;

// Fetch profile based on role
if ($logged_in_role == 'Admin') {
    $select_query = "SELECT * FROM ad_register WHERE role = 'Admin' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $latestProfile = mysqli_fetch_assoc($result);
    }
} elseif ($logged_in_role == 'Coordinator') {
    if ($logged_in_id) {
        $select_query = "SELECT * FROM ad_register WHERE id = '$logged_in_id' AND role = 'Coordinator'";
        $result = mysqli_query($con, $select_query);
        if (mysqli_num_rows($result) > 0) {
            $latestProfile = mysqli_fetch_assoc($result);
        }
    }
} elseif ($logged_in_role == 'co-coordinator') {
    if ($logged_in_id) {
        $select_query = "SELECT * FROM ad_register WHERE id = '$logged_in_id' AND role = 'Co-cordinator'";
        $result = mysqli_query($con, $select_query);
        if (mysqli_num_rows($result) > 0) {
            $latestProfile = mysqli_fetch_assoc($result);
        }
    }
}

// If no profile found, try to get the latest profile for demo purposes
if (!$latestProfile && $logged_in_role == 'Admin') {
    $select_query = "SELECT * FROM ad_register ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $latestProfile = mysqli_fetch_assoc($result);
    }
}

// Ensure variables are always defined to prevent undefined variable warnings
if (!isset($latestProfile)) {
    $latestProfile = null;
}
if (!isset($logged_in_role)) {
    $logged_in_role = 'Admin';
}
?>