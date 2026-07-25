<?php
session_start();
$con = mysqli_connect("localhost", "root", "");

// Create database if not exists (to avoid error if it already exists)
$create_db = "CREATE DATABASE IF NOT EXISTS galore2026";
if (mysqli_query($con, $create_db)) {
    //  echo "Database checked/created successfully<br>";
} else {
    echo "Database error: " . mysqli_error($con) . "<br>";
}

// Select the database
mysqli_select_db($con, "galore2026");

// Create c_school table with all required fields
$school_table = "CREATE TABLE IF NOT EXISTS c_school (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    icon1 VARCHAR(50) NOT NULL,
    username VARCHAR(100) NOT NULL,
    school_name VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    icon2 VARCHAR(50) NOT NULL,
    icon3 VARCHAR(50) NOT NULL,
    student_count INT(11) NOT NULL DEFAULT 0,
    event_count INT(11) NOT NULL DEFAULT 0,
    registered_count INT(11) NOT NULL DEFAULT 0,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $school_table)) {
    // echo "Table 'c_school' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle form submission for school
if (isset($_POST['submit'])) {

    // Get form data
    $icon1 = mysqli_real_escape_string($con, $_POST['icon1']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $school_name = mysqli_real_escape_string($con, $_POST['school_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $icon2 = mysqli_real_escape_string($con, $_POST['icon2']);
    $icon3 = mysqli_real_escape_string($con, $_POST['icon3']);
    $student_count = mysqli_real_escape_string($con, $_POST['student_count']);
    $event_count = mysqli_real_escape_string($con, $_POST['event_count']);
    $registered_count = mysqli_real_escape_string($con, $_POST['registered_count']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing school
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE c_school SET 
                        icon1 = '$icon1',
                        username = '$username',
                        school_name = '$school_name',
                        email = '$email',
                        icon2 = '$icon2',
                        icon3 = '$icon3',
                        student_count = '$student_count',
                        event_count = '$event_count',
                        registered_count = '$registered_count'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating school: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new school
        $insert_query = "INSERT INTO c_school (icon1, username, school_name, email, icon2, icon3, student_count, event_count, registered_count) 
                         VALUES ('$icon1', '$username', '$school_name', '$email', '$icon2', '$icon3', '$student_count', '$event_count', '$registered_count')";

        if (mysqli_query($con, $insert_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);

    $delete_query = "DELETE FROM c_school WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting school: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all schools from database for display
$schoolData = [];
$select_query = "SELECT * FROM c_school ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $schoolData[] = $row;
    }
}
?>