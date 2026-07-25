<?php
require_once 'admin_auth_check.php';

$con = mysqli_connect("localhost", "root", "");

// Create database if not exists (to avoid error if it already exists)
// $create_db = "CREATE DATABASE IF NOT EXISTS galore2026";
// if (mysqli_query($con, $create_db)) {
    //  echo "Database checked/created successfully<br>";
// } else {
//     echo "Database error: " . mysqli_error($con) . "<br>";
// }

// Select the database
mysqli_select_db($con, "galore2026");

// Create contact_messages table
$contact_messages_table = "CREATE TABLE IF NOT EXISTS contact_messages (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $contact_messages_table)) {
    // echo "Table 'contact_messages' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle form submission for contact messages
if (isset($_POST['submit'])) {

    // Get form data
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing message
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE contact_messages SET 
                        full_name = '$full_name',
                        email = '$email',
                        phone = '$phone',
                        subject = '$subject',
                        message = '$message'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating message: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new message
        $insert_query = "INSERT INTO contact_messages (full_name, email, phone, subject, message) 
                         VALUES ('$full_name', '$email', '$phone', '$subject', '$message')";

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

    $delete_query = "DELETE FROM contact_messages WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting message: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all messages from database for display
$contactMessagesData = [];
$select_query = "SELECT * FROM contact_messages ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $contactMessagesData[] = $row;
    }
}
?>