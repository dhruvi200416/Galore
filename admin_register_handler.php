<?php
require_once 'admin_auth_check.php';

$con = mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create table if not exists with correct structure (without role column)
$registration_table = "CREATE TABLE IF NOT EXISTS registration (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    enrollment_no VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    semester INT(2) NOT NULL,
    gender ENUM('Male','Female','Other') NOT NULL,
    school VARCHAR(50) NOT NULL,
    status ENUM('Active','Pending','Inactive') NOT NULL DEFAULT 'Pending',
    profile_pic VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

mysqli_query($con, $registration_table);

// Create website directory if it doesn't exist
if (!file_exists('website')) {
    mkdir('website', 0777, true);
}

// ==================== HANDLE STATUS TOGGLE ====================
if (isset($_GET['toggle_status_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_status_id']);
    
    $select_query = "SELECT status FROM registration WHERE id = '$toggle_id'";
    $result = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_status = $row['status'];
        
        $new_status = 'Active';
        if ($current_status == 'Active') {
            $new_status = 'Pending';
        } else if ($current_status == 'Pending') {
            $new_status = 'Inactive';
        } else if ($current_status == 'Inactive') {
            $new_status = 'Active';
        }
        
        $toggle_query = "UPDATE registration SET status = '$new_status' WHERE id = '$toggle_id'";
        if (mysqli_query($con, $toggle_query)) {
            header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
            exit();
        }
    }
}

// Handle form submission
if (isset($_POST['submit'])) {
    $enrollment_no = mysqli_real_escape_string($con, $_POST['enrollment_no']);
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $branch = mysqli_real_escape_string($con, $_POST['branch']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $school = mysqli_real_escape_string($con, $_POST['school']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $profile_pic = "";
    $upload_new_image = false;
    
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "website/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION));
        $unique_filename = time() . '_' . uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $unique_filename;
        
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_extension, $allowed_types)) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $profile_pic = $target_file;
                $upload_new_image = true;
            }
        }
    }

    $password = password_hash("Welcome@123", PASSWORD_DEFAULT);

    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);
        
        $update_query = "UPDATE registration SET 
                        enrollment_no = '$enrollment_no',
                        full_name = '$full_name',
                        email = '$email',
                        phone = '$phone',
                        branch = '$branch',
                        semester = '$semester',
                        gender = '$gender',
                        school = '$school',
                        status = '$status'";
        
        if ($upload_new_image && !empty($profile_pic)) {
            $old_image_query = "SELECT profile_pic FROM registration WHERE id = '$edit_id'";
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
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        $insert_query = "INSERT INTO registration (enrollment_no, full_name, email, phone, branch, semester, gender, school, status, profile_pic, password) 
                         VALUES ('$enrollment_no', '$full_name', '$email', '$phone', '$branch', '$semester', '$gender', '$school', '$status', '$profile_pic', '$password')";

        if (mysqli_query($con, $insert_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    
    $select_query = "SELECT profile_pic FROM registration WHERE id = '$delete_id'";
    $result = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row['profile_pic']) && file_exists($row['profile_pic'])) {
            unlink($row['profile_pic']);
        }
    }
    
    $delete_query = "DELETE FROM registration WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch all users from registration table
$users = [];
$select_query = "SELECT * FROM registration ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
?>