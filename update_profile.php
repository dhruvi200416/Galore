<?php
// update_profile.php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update_profile'])) {

    // Get form data
    $enrollment_no = mysqli_real_escape_string($con, $_POST['enrollment_no']);
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $branch = mysqli_real_escape_string($con, $_POST['branch']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $school = mysqli_real_escape_string($con, $_POST['school']);

    // Initialize errors array
    $errors = [];

    // Validation
    if (empty($full_name)) $errors[] = "Full name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($branch)) $errors[] = "Branch is required";
    if (empty($semester)) $errors[] = "Semester is required";
    if (empty($gender)) $errors[] = "Gender is required";
    if (empty($school)) $errors[] = "School is required";

    // Validate phone number (10 digits)
    if (!empty($phone) && !preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Phone number must be 10 digits";
    }

    // Validate email
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Handle profile picture upload
    $profile_pic = "";
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $upload_dir = "uploads/profile_pics/";

        // Create directory if not exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        $profile_pic = $enrollment_no . '_' . time() . '.' . $file_extension;
        $target_file = $upload_dir . $profile_pic;

        // Check file size (max 2MB)
        if ($_FILES['profile_pic']['size'] > 2097152) {
            $errors[] = "File size must be less than 2MB";
        }

        // Allow certain file formats
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_extension, $allowed_types)) {
            $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed";
        }

        // If no errors, upload file
        if (empty($errors)) {
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
                // File uploaded successfully
            } else {
                $errors[] = "Error uploading file";
            }
        }
    }

    // If no errors, proceed with update
    if (empty($errors)) {

        // Build update query
        if (!empty($profile_pic)) {
            // Update with new profile picture
            $sql = "UPDATE registration SET 
                    full_name = '$full_name',
                    email = '$email',
                    phone = '$phone',
                    branch = '$branch',
                    semester = '$semester',
                    gender = '$gender',
                    school = '$school',
                    profile_pic = '$profile_pic'
                    WHERE enrollment_no = '$enrollment_no'";
        } else {
            // Update without profile picture
            $sql = "UPDATE registration SET 
                    full_name = '$full_name',
                    email = '$email',
                    phone = '$phone',
                    branch = '$branch',
                    semester = '$semester',
                    gender = '$gender',
                    school = '$school'
                    WHERE enrollment_no = '$enrollment_no'";
        }

        // Execute query
        if (mysqli_query($con, $sql)) {
            // Update session with new name
            $_SESSION['full_name'] = $full_name;

            // Redirect to profile page with success message
            header("Location: profile.php?success=1");
            exit();
        } else {
            $error_msg = "Update failed: " . mysqli_error($con);
            header("Location: edit_profile.php?error=" . urlencode($error_msg));
            exit();
        }
    } else {
        // If there are errors, redirect back with error messages
        $error_msg = implode(", ", $errors);
        header("Location: edit_profile.php?error=" . urlencode($error_msg));
        exit();
    }
} else {
    // If someone tries to access this page directly without form submission
    header("Location: profile.php");
    exit();
}

$con->close();
