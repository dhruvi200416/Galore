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

// Create contact_header table
$contact_header_table = "CREATE TABLE IF NOT EXISTS contact_header (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    hero_title VARCHAR(255) NOT NULL,
    hero_subtitle VARCHAR(255) NOT NULL,
    form_title VARCHAR(255) NOT NULL,
    form_subtitle VARCHAR(255) NOT NULL,
    footer_note VARCHAR(255) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $contact_header_table)) {
    // echo "Table 'contact_header' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle form submission for contact header
if (isset($_POST['submit'])) {

    // Get form data
    $hero_title = mysqli_real_escape_string($con, $_POST['hero_title']);
    $hero_subtitle = mysqli_real_escape_string($con, $_POST['hero_subtitle']);
    $form_title = mysqli_real_escape_string($con, $_POST['form_title']);
    $form_subtitle = mysqli_real_escape_string($con, $_POST['form_subtitle']);
    $footer_note = mysqli_real_escape_string($con, $_POST['footer_note']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing header
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE contact_header SET 
                        hero_title = '$hero_title',
                        hero_subtitle = '$hero_subtitle',
                        form_title = '$form_title',
                        form_subtitle = '$form_subtitle',
                        footer_note = '$footer_note'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating header: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new header
        $insert_query = "INSERT INTO contact_header (hero_title, hero_subtitle, form_title, form_subtitle, footer_note) 
                         VALUES ('$hero_title', '$hero_subtitle', '$form_title', '$form_subtitle', '$footer_note')";

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

    $delete_query = "DELETE FROM contact_header WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting header: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all headers from database for display
$contactHeaderData = [];
$select_query = "SELECT * FROM contact_header ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $contactHeaderData[] = $row;
    }
}
?>