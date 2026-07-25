<?php
require_once 'admin_auth_check.php';
$con = mysqli_connect("localhost", "root", "");

// Create database if not exists
$create_db = "CREATE DATABASE IF NOT EXISTS galore2026";
if (mysqli_query($con, $create_db)) {
    // echo "Database checked/created successfully<br>";
} else {
    echo "Database error: " . mysqli_error($con) . "<br>";
}
mysqli_select_db($con, "galore2026");

// ==================== CREATE CO-COORDINATOR PROFILE TABLE (ad_register) ====================
$c_profile_table = "CREATE TABLE IF NOT EXISTS ad_register (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    gender ENUM('Male','Female','Other') NOT NULL,
    role ENUM('Admin','Coordinator','Co-coordinator') NOT NULL DEFAULT 'Co-coordinator',
    school VARCHAR(100) NOT NULL,
    coordinator_role VARCHAR(100) NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    profile_pic VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $c_profile_table)) {
    // Fix any existing records with 'Co-cordinator' to 'Co-coordinator'
    $fix_records = "UPDATE ad_register SET role = 'Co-coordinator' WHERE role = 'Co-cordinator'";
    mysqli_query($con, $fix_records);
    
    // Ensure the ENUM has the correct values
    $alter_table = "ALTER TABLE ad_register MODIFY COLUMN role ENUM('Admin','Coordinator','Co-coordinator') NOT NULL DEFAULT 'Co-coordinator'";
    mysqli_query($con, $alter_table);
}

// Check if coordinator_role column exists, if not add it
$check_column = mysqli_query($con, "SHOW COLUMNS FROM ad_register LIKE 'coordinator_role'");
if (mysqli_num_rows($check_column) == 0) {
    $alter_query = "ALTER TABLE ad_register ADD COLUMN coordinator_role VARCHAR(100) NULL AFTER school";
    mysqli_query($con, $alter_query);
}

// ==================== HANDLE FORM SUBMISSION ====================
if (isset($_POST['submit_c_profile'])) {
    // Check if it's edit or add
    $edit_id = isset($_POST['edit_id']) && !empty($_POST['edit_id']) ? mysqli_real_escape_string($con, $_POST['edit_id']) : '';
    
    // Get form data with proper isset checks
    $full_name = isset($_POST['full_name']) ? mysqli_real_escape_string($con, trim($_POST['full_name'])) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($con, trim($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($con, trim($_POST['phone'])) : '';
    $branch = isset($_POST['branch']) ? mysqli_real_escape_string($con, trim($_POST['branch'])) : '';
    $gender = isset($_POST['gender']) ? mysqli_real_escape_string($con, $_POST['gender']) : '';
    
    // Fix role: Convert 'Co-cordinator' to 'Co-coordinator' if needed
    $role = isset($_POST['role']) ? mysqli_real_escape_string($con, $_POST['role']) : 'Co-coordinator';
    if ($role == 'Co-cordinator') {
        $role = 'Co-coordinator';
    }
    
    $school = isset($_POST['school']) ? mysqli_real_escape_string($con, $_POST['school']) : '';
    $coordinator_role = isset($_POST['coordinator_role']) && !empty($_POST['coordinator_role']) ? mysqli_real_escape_string($con, $_POST['coordinator_role']) : null;
    $status = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : 'Active';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($con, $_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($con, $_POST['confirm_password']) : '';

    // If role is Admin or Coordinator, set coordinator_role to NULL
    if ($role == 'Admin' || $role == 'Coordinator') {
        $coordinator_role = NULL;
    }

    // Handle file upload for profile_pic
    $profile_pic = "";
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "website/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $original_filename = basename($_FILES["profile_pic"]["name"]);
        $original_filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $original_filename);
        $target_file = $target_dir . $original_filename;

        $file_counter = 1;
        $file_pathinfo = pathinfo($target_file);
        $filename_without_ext = isset($file_pathinfo['filename']) ? $file_pathinfo['filename'] : '';
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
    if (!empty($edit_id)) {
        // UPDATE existing profile
        $update_query = "UPDATE ad_register SET 
                        full_name = '$full_name',
                        email = '$email',
                        phone = '$phone',
                        branch = '$branch',
                        gender = '$gender',
                        role = '$role',
                        school = '$school',
                        coordinator_role = " . ($coordinator_role !== NULL ? "'$coordinator_role'" : "NULL") . ",
                        status = '$status'";
        
        // Add password to update if provided
        if (!empty($password)) {
            $update_query .= ", password = '$password'";
        }
        
        if (!empty($profile_pic)) {
            // Get old image to delete
            $old_image_query = "SELECT profile_pic FROM ad_register WHERE id = '$edit_id'";
            $old_result = mysqli_query($con, $old_image_query);
            if ($old_result && mysqli_num_rows($old_result) > 0) {
                $old_row = mysqli_fetch_assoc($old_result);
                if (!empty($old_row['profile_pic']) && file_exists($old_row['profile_pic'])) {
                    unlink($old_row['profile_pic']);
                }
            }
            $update_query .= ", profile_pic = '$profile_pic'";
        }
        $update_query .= " WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating profile: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Check if email already exists
        $check_email = "SELECT id FROM ad_register WHERE email = '$email'";
        $email_result = mysqli_query($con, $check_email);
        
        if ($email_result && mysqli_num_rows($email_result) > 0) {
            echo "<script>alert('Error: Email already exists. Please use a different email address.');</script>";
        } else {
            // Check if passwords match for new entry
            if (empty($password)) {
                echo "<script>alert('Password is required!');</script>";
                exit();
            }
            
            if ($password !== $confirm_password) {
                echo "<script>alert('Passwords do not match!');</script>";
                exit();
            }
            
            // Insert new record
            $insert_query = "INSERT INTO ad_register (full_name, email, phone, branch, gender, role, school, coordinator_role, status, profile_pic, password) 
                             VALUES ('$full_name', '$email', '$phone', '$branch', '$gender', '$role', '$school', " . ($coordinator_role !== NULL ? "'$coordinator_role'" : "NULL") . ", '$status', '$profile_pic', '$password')";
            
            if (mysqli_query($con, $insert_query)) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        }
    }
}

// ==================== HANDLE STATUS TOGGLE ====================
if (isset($_GET['toggle_status_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_status_id']);
    
    // Get current status
    $select_query = "SELECT status FROM ad_register WHERE id = '$toggle_id'";
    $result = mysqli_query($con, $select_query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_status = $row['status'];
        
        // Toggle between Active and Inactive
        $new_status = ($current_status == 'Active') ? 'Inactive' : 'Active';
        
        $toggle_query = "UPDATE ad_register SET status = '$new_status' WHERE id = '$toggle_id'";
        if (mysqli_query($con, $toggle_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== HANDLE DELETE REQUEST ====================
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $select_query = "SELECT profile_pic FROM ad_register WHERE id = '$delete_id'";
    $result = mysqli_query($con, $select_query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row['profile_pic']) && file_exists($row['profile_pic'])) {
            unlink($row['profile_pic']);
        }
    }
    $delete_query = "DELETE FROM ad_register WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting profile: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== FETCH ALL CO-COORDINATOR PROFILES ====================
$allProfiles = [];
$select_query = "SELECT * FROM ad_register WHERE role = 'Co-coordinator'";
$result = mysqli_query($con, $select_query);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $allProfiles[] = $row;
    }
}
?>