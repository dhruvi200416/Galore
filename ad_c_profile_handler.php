<?php
require_once 'admin_auth_check.php';

$con = mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Create ad_register table specifically for coordinators
$coordinator_table = "CREATE TABLE IF NOT EXISTS ad_register (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    gender ENUM('Male','Female','Other') NOT NULL,
    branch VARCHAR(100) NOT NULL,
    school VARCHAR(100) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    role VARCHAR(50) NOT NULL DEFAULT 'Coordinator',
    profile_pic VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

mysqli_query($con, $coordinator_table);

// Create website directory if it doesn't exist
if (!file_exists('website')) {
    mkdir('website', 0777, true);
}

// Handle form submission for coordinators
if (isset($_POST['submit'])) {

    // Get form data
    $full_name = isset($_POST['full_name']) ? mysqli_real_escape_string($con, $_POST['full_name']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($con, $_POST['email']) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($con, $_POST['phone']) : '';
    $gender = isset($_POST['gender']) ? mysqli_real_escape_string($con, $_POST['gender']) : '';
    $branch = isset($_POST['branch']) ? mysqli_real_escape_string($con, $_POST['branch']) : '';
    $school = isset($_POST['school']) ? mysqli_real_escape_string($con, $_POST['school']) : '';
    $status = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : 'Active';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($con, $_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($con, $_POST['confirm_password']) : '';
    
    // Get edit_id if it exists
    $edit_id = isset($_POST['edit_id']) && !empty($_POST['edit_id']) ? mysqli_real_escape_string($con, $_POST['edit_id']) : '';

    // Handle file upload for profile image
    $profile_image = "";
    $upload_new_image = false;
    
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "website/";
        $original_filename = basename($_FILES["profile_image"]["name"]);
        $original_filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $original_filename);
        $target_file = $target_dir . $original_filename;
        
        $file_counter = 1;
        $file_pathinfo = pathinfo($target_file);
        $filename_without_ext = isset($file_pathinfo['filename']) ? $file_pathinfo['filename'] : '';
        $extension = isset($file_pathinfo['extension']) ? $file_pathinfo['extension'] : '';
        
        while (file_exists($target_file)) {
            $new_filename = $filename_without_ext . '_' . $file_counter . '.' . $extension;
            $target_file = $target_dir . $new_filename;
            $file_counter++;
        }

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $profile_image = $target_file;
            $upload_new_image = true;
        }
    }

    // Check if editing or adding
    if (!empty($edit_id)) {
        // UPDATE existing coordinator - Password not updated in edit mode
        $get_emp_query = "SELECT profile_pic FROM ad_register WHERE id = '$edit_id' AND role = 'Coordinator'";
        $emp_result = mysqli_query($con, $get_emp_query);
        
        if (mysqli_num_rows($emp_result) > 0) {
            $existing_data = mysqli_fetch_assoc($emp_result);

            $update_query = "UPDATE ad_register SET 
                            full_name = '$full_name',
                            email = '$email',
                            phone = '$phone',
                            gender = '$gender',
                            branch = '$branch',
                            school = '$school',
                            status = '$status'";
            
            if ($upload_new_image && !empty($profile_image)) {
                if (!empty($existing_data['profile_pic']) && file_exists($existing_data['profile_pic'])) {
                    unlink($existing_data['profile_pic']);
                }
                $update_query .= ", profile_pic = '$profile_image'";
            }
            
            $update_query .= " WHERE id = '$edit_id' AND role = 'Coordinator'";

            if (mysqli_query($con, $update_query)) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "<script>alert('Error updating coordinator: " . mysqli_error($con) . "');</script>";
            }
        }
    } else {
        // Check if email already exists
        $check_email = "SELECT id FROM ad_register WHERE email = '$email'";
        $email_result = mysqli_query($con, $check_email);
        
        if (mysqli_num_rows($email_result) > 0) {
            echo "<script>alert('Error: Email already exists. Please use a different email address.');</script>";
        } else {
            // Validate password and confirm password match
            if (empty($password)) {
                echo "<script>alert('Error: Password is required.');</script>";
            } elseif ($password !== $confirm_password) {
                echo "<script>alert('Error: Password and Confirm Password do not match.');</script>";
            } else {
                // INSERT new coordinator - STORE PASSWORD AS PLAIN TEXT (NO HASHING)
                $insert_query = "INSERT INTO ad_register (full_name, email, phone, gender, branch, school, profile_pic, status, role, password) 
                                 VALUES ('$full_name', '$email', '$phone', '$gender', '$branch', '$school', '$profile_image', '$status', 'Coordinator', '$password')";

                if (mysqli_query($con, $insert_query)) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
                }
            }
        }
    }
}

// Handle status toggle request
if (isset($_GET['toggle_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_id']);
    
    $toggle_query = "UPDATE ad_register SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id' AND role = 'Coordinator'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    
    $select_query = "SELECT profile_pic FROM ad_register WHERE id = '$delete_id' AND role = 'Coordinator'";
    $result = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row['profile_pic']) && file_exists($row['profile_pic'])) {
            unlink($row['profile_pic']);
        }
    }
    
    $delete_query = "DELETE FROM ad_register WHERE id = '$delete_id' AND role = 'Coordinator'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch ONLY THE LAST ADDED COORDINATOR from database
$coordinatorData = [];
$select_query = "SELECT *, profile_pic as profile_image, email as employee_id 
                FROM ad_register 
                WHERE role = 'Coordinator' 
                ORDER BY id DESC 
                LIMIT 1";

$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $coordinatorData[] = [
            'id' => $row['id'],
            'full_name' => $row['full_name'] ?? '',
            'email' => $row['email'] ?? '',
            'employee_id' => $row['email'] ?? '',
            'phone' => $row['phone'] ?? '',
            'gender' => $row['gender'] ?? '',
            'branch' => $row['branch'] ?? '',
            'school' => $row['school'] ?? '',
            'status' => $row['status'] ?? 'Active',
            'role' => $row['role'] ?? 'Coordinator',
            'profile_image' => $row['profile_pic'] ?? '',
            'profile_pic' => $row['profile_pic'] ?? '',
            'created_at' => $row['created_at'] ?? ''
        ];
    }
}

if (empty($coordinatorData)) {
    $coordinatorData = [];
}

$users = $coordinatorData;
?>